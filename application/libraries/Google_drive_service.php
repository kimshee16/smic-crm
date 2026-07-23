<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Google_drive_service
{
    private $ci;
    private $access_token;
    private $token_expires_at = 0;

    public function __construct()
    {
        $this->ci =& get_instance();
        $this->ci->load->config('config');
    }

    public function create_folder($name, $parent_id, $shared_drive_id = '')
    {
        $metadata = array(
            'name' => $name,
            'mimeType' => 'application/vnd.google-apps.folder'
        );

        if ($parent_id != '') {
            $metadata['parents'] = array($parent_id);
        }

        $url = 'https://www.googleapis.com/drive/v3/files?supportsAllDrives=true&fields=id,name,webViewLink';

        return $this->request('POST', $url, json_encode($metadata), array('Content-Type: application/json'));
    }

    public function upload_file($file_path, $file_name, $mime_type, $parent_id, $shared_drive_id = '')
    {
        if (!is_readable($file_path)) {
            throw new Exception('Upload file is not readable.');
        }

        $file_size = filesize($file_path);
        if ($file_size === false) {
            throw new Exception('Unable to read upload file size.');
        }

        if ($mime_type == '') {
            $mime_type = 'application/octet-stream';
        }

        $metadata = array(
            'name' => $file_name,
            'parents' => array($parent_id)
        );

        $url = 'https://www.googleapis.com/upload/drive/v3/files?uploadType=resumable&supportsAllDrives=true&fields=id,name,webViewLink,webContentLink,mimeType,size';
        $response = $this->request_with_headers('POST', $url, json_encode($metadata), array(
            'Content-Type: application/json; charset=UTF-8',
            'X-Upload-Content-Type: ' . $mime_type,
            'X-Upload-Content-Length: ' . $file_size
        ));

        $upload_url = $this->header_value($response['headers'], 'Location');
        if ($upload_url == '') {
            throw new Exception('Google Drive did not return a resumable upload URL.');
        }

        return $this->upload_resumable_file($upload_url, $file_path, $file_size, $mime_type);
    }

    public function download_file($file_id)
    {
        if ($file_id == '') {
            throw new Exception('Google Drive file ID is required.');
        }

        $url = 'https://www.googleapis.com/drive/v3/files/' . rawurlencode($file_id) . '?alt=media&supportsAllDrives=true';
        $headers = array('Authorization: Bearer ' . $this->access_token());

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $raw = curl_exec($ch);
        $error = curl_error($ch);
        $status = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        curl_close($ch);

        if ($raw === false) {
            throw new Exception('Google Drive download failed: ' . $error);
        }

        if ($status < 200 || $status >= 300) {
            $decoded = json_decode($raw, true);
            $message = isset($decoded['error']['message']) ? $decoded['error']['message'] : $raw;
            throw new Exception('Google Drive API error: ' . $message);
        }

        return $raw;
    }

    private function access_token()
    {
        if ($this->access_token && time() < $this->token_expires_at - 60) {
            return $this->access_token;
        }

        $credentials_path = $this->ci->config->item('google_service_account_json_path');
        if (!$credentials_path || !is_readable($credentials_path)) {
            throw new Exception('Google service account JSON is not readable. Check google_service_account_json_path.');
        }

        $credentials = json_decode(file_get_contents($credentials_path), true);
        if (!is_array($credentials) || empty($credentials['client_email']) || empty($credentials['private_key'])) {
            throw new Exception('Google service account JSON is invalid.');
        }

        $now = time();
        $claims = array(
            'iss' => $credentials['client_email'],
            'scope' => 'https://www.googleapis.com/auth/drive',
            'aud' => isset($credentials['token_uri']) ? $credentials['token_uri'] : 'https://oauth2.googleapis.com/token',
            'iat' => $now,
            'exp' => $now + 3600
        );

        $impersonate = $this->ci->config->item('google_workspace_impersonate_email');
        if ($impersonate != '') {
            $claims['sub'] = $impersonate;
        }

        $jwt = $this->base64url(json_encode(array('alg' => 'RS256', 'typ' => 'JWT'))) . '.';
        $jwt .= $this->base64url(json_encode($claims));

        $signature = '';
        if (!openssl_sign($jwt, $signature, $credentials['private_key'], 'sha256WithRSAEncryption')) {
            throw new Exception('Unable to sign Google service account JWT.');
        }

        $jwt .= '.' . $this->base64url($signature);

        $response = $this->curl(
            'POST',
            isset($credentials['token_uri']) ? $credentials['token_uri'] : 'https://oauth2.googleapis.com/token',
            http_build_query(array(
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $jwt
            )),
            array('Content-Type: application/x-www-form-urlencoded')
        );

        if (empty($response['access_token'])) {
            throw new Exception('Google OAuth did not return an access token.');
        }

        $this->access_token = $response['access_token'];
        $this->token_expires_at = $now + (isset($response['expires_in']) ? (int) $response['expires_in'] : 3600);

        return $this->access_token;
    }

    private function request($method, $url, $body = null, $headers = array())
    {
        $headers[] = 'Authorization: Bearer ' . $this->access_token();
        return $this->curl($method, $url, $body, $headers);
    }

    private function request_with_headers($method, $url, $body = null, $headers = array())
    {
        $headers[] = 'Authorization: Bearer ' . $this->access_token();
        return $this->curl_with_headers($method, $url, $body, $headers);
    }

    private function curl($method, $url, $body = null, $headers = array())
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);

        if ($body !== null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        }

        $raw = curl_exec($ch);
        $error = curl_error($ch);
        $status = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        curl_close($ch);

        if ($raw === false) {
            throw new Exception('Google Drive request failed: ' . $error);
        }

        $decoded = json_decode($raw, true);
        if ($status < 200 || $status >= 300) {
            $message = isset($decoded['error']['message']) ? $decoded['error']['message'] : $raw;
            throw new Exception('Google Drive API error: ' . $message);
        }

        return is_array($decoded) ? $decoded : array();
    }

    private function curl_with_headers($method, $url, $body = null, $headers = array())
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);

        if ($body !== null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        }

        $raw = curl_exec($ch);
        $error = curl_error($ch);
        $status = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        curl_close($ch);

        if ($raw === false) {
            throw new Exception('Google Drive request failed: ' . $error);
        }

        $raw_headers = substr($raw, 0, $header_size);
        $raw_body = substr($raw, $header_size);
        $decoded = json_decode($raw_body, true);

        if ($status < 200 || $status >= 300) {
            $message = isset($decoded['error']['message']) ? $decoded['error']['message'] : $raw_body;
            throw new Exception('Google Drive API error: ' . $message);
        }

        return array(
            'headers' => $raw_headers,
            'body' => is_array($decoded) ? $decoded : array()
        );
    }

    private function upload_resumable_file($upload_url, $file_path, $file_size, $mime_type)
    {
        $handle = fopen($file_path, 'rb');
        if (!$handle) {
            throw new Exception('Unable to open upload file for streaming.');
        }

        $ch = curl_init($upload_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_UPLOAD, true);
        curl_setopt($ch, CURLOPT_INFILE, $handle);
        curl_setopt($ch, CURLOPT_INFILESIZE, $file_size);
        $content_range = $file_size > 0 ? 'bytes 0-' . ($file_size - 1) . '/' . $file_size : 'bytes */0';

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: ' . $mime_type,
            'Content-Length: ' . $file_size,
            'Content-Range: ' . $content_range
        ));
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);

        $raw = curl_exec($ch);
        $error = curl_error($ch);
        $status = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        curl_close($ch);
        fclose($handle);

        if ($raw === false) {
            throw new Exception('Google Drive upload failed: ' . $error);
        }

        $decoded = json_decode($raw, true);
        if ($status < 200 || $status >= 300) {
            $message = isset($decoded['error']['message']) ? $decoded['error']['message'] : $raw;
            throw new Exception('Google Drive API error: ' . $message);
        }

        return is_array($decoded) ? $decoded : array();
    }

    private function header_value($headers, $name)
    {
        foreach (preg_split("/\r\n|\n|\r/", $headers) as $header) {
            if (stripos($header, $name . ':') === 0) {
                return trim(substr($header, strlen($name) + 1));
            }
        }

        return '';
    }

    private function base64url($value)
    {
        return rtrim(strtr(base64_encode($value), '+/', '-_'), '=');
    }
}
