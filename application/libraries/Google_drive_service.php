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

        $metadata = array(
            'name' => $file_name,
            'parents' => array($parent_id)
        );

        $boundary = 'smic_drive_' . bin2hex(random_bytes(12));
        $body = "--{$boundary}\r\n";
        $body .= "Content-Type: application/json; charset=UTF-8\r\n\r\n";
        $body .= json_encode($metadata) . "\r\n";
        $body .= "--{$boundary}\r\n";
        $body .= "Content-Type: " . ($mime_type != '' ? $mime_type : 'application/octet-stream') . "\r\n\r\n";
        $body .= file_get_contents($file_path) . "\r\n";
        $body .= "--{$boundary}--";

        $url = 'https://www.googleapis.com/upload/drive/v3/files?uploadType=multipart&supportsAllDrives=true&fields=id,name,webViewLink,webContentLink,mimeType,size';

        return $this->request('POST', $url, $body, array('Content-Type: multipart/related; boundary=' . $boundary));
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

    private function curl($method, $url, $body = null, $headers = array())
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

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

    private function base64url($value)
    {
        return rtrim(strtr(base64_encode($value), '+/', '-_'), '=');
    }
}
