<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Formscontroller extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->library('email');
	}

	private function ensure_po_links_table()
	{
		$this->db->query("
			CREATE TABLE IF NOT EXISTS po_links (
				id INT(11) NOT NULL AUTO_INCREMENT,
				client_id INT(11) NOT NULL,
				link TEXT NOT NULL,
				date_created DATETIME NOT NULL,
				date_approved DATETIME NULL,
				accessed TINYINT(1) NOT NULL DEFAULT 0,
				approved TINYINT(1) NOT NULL DEFAULT 0 COMMENT '1=approved, 0=pending, -1=rejected',
				PRIMARY KEY (id),
				KEY client_id (client_id),
				KEY accessed (accessed),
				KEY approved (approved)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
		");
	}

	private function po_acceptance_link($student_google_drive_id)
	{
		return base_url() . 'index.php/programoptionform/' . (int) $student_google_drive_id;
	}

	private function get_po_link_for_drive_file($student_google_drive_id, $client_id)
	{
		$this->ensure_po_links_table();

		$link = $this->po_acceptance_link($student_google_drive_id);
		$query = $this->db->query(
			"SELECT * FROM po_links WHERE client_id = ? AND (link = ? OR link LIKE ?) ORDER BY id DESC LIMIT 1",
			array($client_id, $link, '%/programoptionform/' . (int) $student_google_drive_id)
		);
		$po_link = $query->row();
		if ($po_link) {
			return $po_link;
		}

		$data = array(
			'client_id' => $client_id,
			'link' => $link,
			'date_created' => date('Y-m-d H:i:s'),
			'accessed' => 0,
			'approved' => 0
		);
		$this->db->insert('po_links', $data);
		$data['id'] = $this->db->insert_id();

		return (object) $data;
	}

	private function show_po_link_unavailable($message)
	{
		$asset_url = base_url() . 'assets/';
		$data = array(
			'title' => 'Program Options Link',
			'asset_url' => $asset_url,
			'message' => $message
		);
		$this->load->view('forms/po_link_unavailable', $data);
	}

	public function clientform()
	{
		$sql = "SELECT nationality,en_short_name FROM countries";
	    $query = $this->db->query($sql);
	    $nationality = $query->result();

	    $sql2 = "SELECT value FROM qualifications";
	    $query2 = $this->db->query($sql2);
	    $qualifications = $query2->result();

	    $sql3 = "SELECT value FROM civilstatus";
	    $query3 = $this->db->query($sql3);
	    $civilstat = $query3->result();


        $asset_url = base_url()."assets/";
		$data['title'] = "Client Form";
		$data['asset_url'] = $asset_url;
		
		$data['nationality'] = $nationality;
		$data['qualifications'] = $qualifications;
		$data['civilstatus'] = $civilstat;

		$this->load->view('forms/clientform', $data);
	}

	public function programoptionform($student_google_drive_id)
	{
		$student_google_drive_id = (int) $student_google_drive_id;
		if ($student_google_drive_id <= 0) {
			return $this->show_po_link_unavailable('This Program Options link is invalid.');
		}

		$this->db->where('id', $student_google_drive_id);
		$this->db->where('record_type', 'file');
		$this->db->where('document_purpose', 'Counselling');
		$this->db->where('document_type', 'Program Options');
		$file = $this->db->get('student_google_drive', 1)->row();
		if (!$file) {
			return $this->show_po_link_unavailable('This Program Options file could not be found.');
		}

		$this->db->where('client_id', $file->client_id);
		$client = $this->db->get('client', 1)->row();
		if (!$client) {
			return $this->show_po_link_unavailable('The client record for this Program Options link could not be found.');
		}

		$po_link = $this->get_po_link_for_drive_file($student_google_drive_id, $file->client_id);
		if ((int) $po_link->approved === 1) {
			return $this->show_po_link_unavailable('This Program Options link was already approved.');
		}
		if ((int) $po_link->approved === -1) {
			return $this->show_po_link_unavailable('This Program Options link was already rejected.');
		}
		if ((int) $po_link->accessed === 1) {
			return $this->show_po_link_unavailable('This Program Options link has already been accessed and is no longer available.');
		}

		$this->db->set('accessed', 1);
		$this->db->where('id', $po_link->id);
		$this->db->update('po_links');
		$po_link->accessed = 1;

		$preview_token = bin2hex(random_bytes(16));
		$this->session->set_userdata('po_link_preview_' . $po_link->id, $preview_token);

		$data = array(
			'title' => 'Program Options Review',
			'asset_url' => base_url() . 'assets/',
			'client' => $client,
			'file' => $file,
			'po_link' => $po_link,
			'preview_url' => base_url() . 'index.php/po_link_preview/' . $student_google_drive_id . '/' . $po_link->id . '?token=' . $preview_token
		);
		$this->load->view('forms/programoptionlinkform', $data);
	}

	public function po_link_preview($student_google_drive_id, $po_link_id)
	{
		$student_google_drive_id = (int) $student_google_drive_id;
		$po_link_id = (int) $po_link_id;
		if ($student_google_drive_id <= 0 || $po_link_id <= 0) {
			show_error('Invalid Program Options preview link.', 404);
			return;
		}

		$token = (string) $this->input->get('token');
		$session_token = (string) $this->session->userdata('po_link_preview_' . $po_link_id);
		if ($token == '' || $session_token == '' || !hash_equals($session_token, $token)) {
			show_error('Program Options preview is no longer available.', 403);
			return;
		}

		$this->db->where('id', $student_google_drive_id);
		$this->db->where('record_type', 'file');
		$file = $this->db->get('student_google_drive', 1)->row();
		if (!$file) {
			show_error('Program Options file was not found.', 404);
			return;
		}

		$this->ensure_po_links_table();
		$this->db->where('id', $po_link_id);
		$this->db->where('client_id', $file->client_id);
		$this->db->where('approved', 0);
		$this->db->where('accessed', 1);
		$po_link = $this->db->get('po_links', 1)->row();
		if (!$po_link) {
			show_error('Program Options preview is no longer available.', 403);
			return;
		}

		$file_name = isset($file->drive_file_name) ? $file->drive_file_name : '';
		$extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
		if ($extension !== 'pdf' && $file->mime_type !== 'application/pdf') {
			show_error('Only PDF Program Options files can be previewed on this page.', 415);
			return;
		}

		try {
			$this->load->library('google_drive_service');
			$content = $this->google_drive_service->download_file($file->drive_file_id);
			$this->output
				->set_header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0')
				->set_header('Pragma: no-cache')
				->set_header('X-Content-Type-Options: nosniff')
				->set_header('Content-Disposition: inline; filename="program-options.pdf"')
				->set_content_type('application/pdf')
				->set_output($content);
		} catch (Exception $e) {
			show_error($e->getMessage(), 500);
		}
	}

	public function accept_po_link()
	{
		$this->respond_to_po_link(1);
	}

	public function reject_po_link()
	{
		$this->respond_to_po_link(-1);
	}

	private function respond_to_po_link($approved)
	{
		$po_link_id = (int) $this->input->post('po_link_id');
		$student_google_drive_id = (int) $this->input->post('student_google_drive_id');
		if ($po_link_id <= 0 || $student_google_drive_id <= 0) {
			return $this->show_po_link_unavailable('This Program Options response is invalid.');
		}

		$this->db->where('id', $student_google_drive_id);
		$this->db->where('record_type', 'file');
		$file = $this->db->get('student_google_drive', 1)->row();
		if (!$file) {
			return $this->show_po_link_unavailable('This Program Options file could not be found.');
		}

		$this->ensure_po_links_table();
		$this->db->where('id', $po_link_id);
		$this->db->where('client_id', $file->client_id);
		$this->db->where('approved', 0);
		$po_link = $this->db->get('po_links', 1)->row();
		if (!$po_link) {
			return $this->show_po_link_unavailable('This Program Options link has already been completed or is no longer available.');
		}

		$this->db->set('approved', $approved);
		$this->db->set('date_approved', date('Y-m-d H:i:s'));
		$this->db->where('id', $po_link_id);
		$this->db->update('po_links');
		$this->session->unset_userdata('po_link_preview_' . $po_link_id);

		$data = array(
			'title' => 'Program Options Response',
			'asset_url' => base_url() . 'assets/',
			'status' => $approved === 1 ? 'accepted' : 'rejected'
		);
		$this->load->view('forms/po_link_success', $data);
	}

	public function programoptionform2($poid)
	{
		$sql6 = "SELECT * FROM programoptions po inner join education_provider s on po.provider_id = s.provider_id inner join schoolprograms sp on sp.spid = po.sp_id inner join client c on po.client_id = c.client_id where po.poid = '$poid'";
        $query6 = $this->db->query($sql6);
        $programoptions = $query6->result();

        $sql7 = "SELECT * FROM programoptionsdetails pod where poid = '$poid'";
        $query7 = $this->db->query($sql7);
        $programoptionsdetails = $query7->result();

        $sql8 = "SELECT * FROM programoptions po inner join client c on po.client_id = c.client_id inner join clientscholarship csc on c.client_id = csc.clientid inner join scholarships s on s.scholarshipid = csc.scholarshipid inner join mastersetting m on s.paymenttype = m.id where po.poid = '$poid'";
        $query8 = $this->db->query($sql8);
        $scholarships = $query8->result();

        $sql9 = "SELECT * FROM programoptionscostbasisvariables";
        $query9 = $this->db->query($sql9);
        $programoptionscostbasisvariables = $query9->result();

        $sql9 = "SELECT * FROM programoptionsdetaileipwithdependent where poid = '$poid'";
        $query9 = $this->db->query($sql9);
        $programoptionsdetaileipwithdependent = $query9->result();

        $sql9 = "SELECT * FROM programoptionsdetaileipwithoutdependent where poid = '$poid'";
        $query9 = $this->db->query($sql9);
        $programoptionsdetaileipwithoutdependent = $query9->result();

        $sql9 = "SELECT * FROM programoptionsdetailwithdependent where poid = '$poid'";
        $query9 = $this->db->query($sql9);
        $programoptionsdetailwithdependent = $query9->result();

        $sql9 = "SELECT * FROM programoptionsdetailwithoutdependent where poid = '$poid'";
        $query9 = $this->db->query($sql9);
        $programoptionsdetailwithoutdependent = $query9->result();
        
        $sql9 = "SELECT * FROM newprogramoptionsdetails where poid = '$poid'";
        $query9 = $this->db->query($sql9);
        $newprogramoptionsdetails = $query9->result();

        $data['programoptions'] = $programoptions;
        $data['programoptionsdetails'] = $programoptionsdetails;
        $data['scholarships'] = $scholarships;        
        $data['poid'] = $poid; 
        $data['programoptionscostbasisvariables'] = $programoptionscostbasisvariables;
        $data['programoptionsdetaileipwithdependent'] = $programoptionsdetaileipwithdependent;
        $data['programoptionsdetaileipwithoutdependent'] = $programoptionsdetaileipwithoutdependent;
        $data['programoptionsdetailwithdependent'] = $programoptionsdetailwithdependent;
        $data['programoptionsdetailwithoutdependent'] = $programoptionsdetailwithoutdependent; 
        $data['newprogramoptionsdetails'] = $newprogramoptionsdetails;
        
        $asset_url = base_url()."assets/";
		$data['title'] = "Program Options Form";
		$data['asset_url'] = $asset_url;

// 		$this->load->view('forms/programoptionform', $data);
        if(isset($this->session->officer_name)) {
			$this->load->view('forms/programoptionform', $data);
		} else {
			redirect(base_url()."index.php/clientloginpo?type=po&value=".base_url()."index.php/programoptionform2/".$poid);
		}
	}

	public function do_upload() 
	{
		$message = "";
		$birthdate = DateTime::createFromFormat("Y-m-d", $this->input->post('birthdate'));
    	$birthyear = $birthdate->format("Y");
    	$birthmonth = $birthdate->format("m");
    	$birthday = $birthdate->format("d");

    	if($this->input->post('confirm2') !== "") {
    		$confirm2 = 'on';
    	} else {
    		$confirm2 = 'off';
    	}

    	if($this->input->post('confirm1') !== "") {
    		$confirm1 = 'on';
    	} else {
    		$confirm1 = 'off';
    	}

    	$config['upload_path']          = './assets/resume/';
        $config['allowed_types']        = 'jpg|png|pdf|docx';
        $config['max_size']             = 10000;
        $config['max_width']            = 10000;
        $config['max_height']           = 10000;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('resume'))
        {
        	if ($this->input->post('password') == $this->input->post('password2')) {
        		if ($this->input->post('visaexpdate') == "") {
        			$visaexpdate = "1900-01-01";
        		}
	    		$data = array(
							'inquiries_surname' => $this->input->post('lastname'),
							'inquiries_firstname' => $this->input->post('firstname'),
							'inquiries_middlename' => $this->input->post('middlename'),
							'inquiries_dob_day' => $birthday,
							'inquiries_dob_month' => $birthmonth,
							'inquiries_dob_year' => $birthyear,
							'inquiries_phoneno' => '',
							'inquiries_mobileno' => $this->input->post('mobile'),
							'inquiries_email' => $this->input->post('email'),
							'inquiries_address' => $this->input->post('city'),
							'inquiries_qualifications' => $this->input->post('qualifications'),
							'inquiries_password' => $this->input->post('password'),
							'inquiries_dependents' => '',
							'inquiries_civilstatus' => $this->input->post('civilstatus'),
							'inquiries_country' => $this->input->post('country'),
							'inquiries_nationality' => $this->input->post('nationality'),
							'inquiries_city' => $this->input->post('city'),
							'inquiries_notes' => $this->input->post('notes'),
							'inquiries_privacy_consent' => $confirm1,
							'inquiries_info_receiving_consent' => $confirm2,
							'inquiries_status' => 'Created',
							'inquiries_resume' => '',
							'inquiries_visaexpdate' => $visaexpdate,
							'inquiries_visaheld' => $this->input->post('visaheld')
						);
				$this->db->insert('inquiries', $data);

				$message = "";
				$emailquery = $this->db->query("SELECT * FROM `emailcontents`");
				$iaremailheader = $emailquery->row()->iaremailheader;
				$iaremailbody = $emailquery->row()->iaremailbody;
				$iaremailfooter = $emailquery->row()->iaremailfooter;

				$message .= "<!DOCTYPE html>
							<html>
							<head>
								<title>PSC Auto-response</title>
							</head>
							<body style='background-color: #ECECEC;'>
							<div style='background-image: url('https://crm.progress-study.com/assets/images/pscemailbackground.jpg'); background-size: 650px; background-repeat: no-repeat; margin-left: 250px; margin-right:250px; height: 1200px;'>
								<br><br><br>
								<div style='margin-left: 80px; margin-right: 80px;'>
									<p style='text-align: right; font-size: 14px;'><a href='http://www.progress-study.com.au'>www.progress-study.com.au</a></p>";
			    $message .= $iaremailheader;
				$message .= $iaremailbody;
				$message .= $iaremailfooter;
				$message .= "</div>
							</div>
							</body>
							</html>
							";
				$sender = "ramirezkyl@gmail.com";
			
				$this->load->library('phpmailer_lib');
		        $mail = $this->phpmailer_lib->load();
	  
			    //$mail->SMTPDebug = 1;
			    /*
			    $mail->isSMTP();
			    $mail->Host       = 'mail.progress-study.com';            
			    $mail->SMTPAuth   = true;                                
			    $mail->Username   = 'no-reply@progress-study.com';            
			    $mail->Password   = 'Welcome2PSC!';                     
			    $mail->SMTPSecure = 'tls';      
			    $mail->Port       = 587;   
				*/
			    
			    $mail->isSMTP();
				$mail->Host = 'sxb1plzcpnl505550.prod.sxb1.secureserver.net';
				$mail->SMTPAuth = false;
				$mail->SMTPAutoTLS = false; 
				$mail->Port = 25;
				$mail->Username   = 'no-reply@smic.education';            
			    $mail->Password   = 'P@ssw0rd@CRM2025'; 
			 
			 //   $mail->SMTPDebug = 1;
			 //   $mail->isSMTP();
			 //   $mail->Host       = 'ssl://smtp.gmail.com';            
			 //   $mail->SMTPAuth   = true;                                
			 //   $mail->Username   = 'smiccrm.noreply@gmail.com';            
			 //   $mail->Password   = 'tpqkwfhvvqgwkiko';                     
			 //   $mail->SMTPSecure = 'ssl';      
			 //   $mail->Port       = 465;
				
		        $mail->setFrom("no-reply@smic.education");
		        //$mail->addReplyTo($sender, $this->session->userdata('companyname'));
		        $mail->addAddress($this->input->post('email'));
		        $mail->Subject = 'New Inquiries';
		        $mail->isHTML(true);
		        $mailContent = $message;
		        $mail->Body = $mailContent;
		        $mail->send();

		        //redirect('success');
				//$this->load->view('forms/success');
				$asset_url = base_url()."assets/";
				$data['title'] = "Client Form";
				$data['asset_url'] = $asset_url;

				$this->load->view('forms/success', $data);
				
	    	} else {
	    		echo "<script>alert('Passwords are not matched!');</script>";
	    	}
        } else {
        	$upload_data = $this->upload->data();
			$file_name = $upload_data['file_name'];

        	if ($this->input->post('password') == $this->input->post('password2')) {
        		if ($this->input->post('visaexpdate') == "") {
        			$visaexpdate = "1900-01-01";
        		}
	    		$data = array(
							'inquiries_surname' => $this->input->post('lastname'),
							'inquiries_firstname' => $this->input->post('firstname'),
							'inquiries_middlename' => $this->input->post('middlename'),
							'inquiries_dob_day' => $birthday,
							'inquiries_dob_month' => $birthmonth,
							'inquiries_dob_year' => $birthyear,
							'inquiries_phoneno' => '',
							'inquiries_mobileno' => $this->input->post('mobile'),
							'inquiries_email' => $this->input->post('email'),
							'inquiries_address' => $this->input->post('city'),
							'inquiries_qualifications' => $this->input->post('qualifications'),
							'inquiries_password' => $this->input->post('password'),
							'inquiries_dependents' => '',
							'inquiries_civilstatus' => $this->input->post('civilstatus'),
							'inquiries_country' => $this->input->post('country'),
							'inquiries_nationality' => $this->input->post('nationality'),
							'inquiries_city' => $this->input->post('city'),
							'inquiries_notes' => $this->input->post('notes'),
							'inquiries_privacy_consent' => $confirm1,
							'inquiries_info_receiving_consent' => $confirm2,
							'inquiries_status' => 'Created',
							'inquiries_resume' => $file_name,
							'inquiries_visaexpdate' => $visaexpdate,
							'inquiries_visaheld' => $this->input->post('visaheld')
						);
				$this->db->insert('inquiries', $data);

				$message = "";
				$emailquery = $this->db->query("SELECT * FROM `emailcontents`");
				$iaremailheader = $emailquery->row()->iaremailheader;
				$iaremailbody = $emailquery->row()->iaremailbody;
				$iaremailfooter = $emailquery->row()->iaremailfooter;

				$message .= "<!DOCTYPE html>
							<html>
							<head>
								<title>PSC Auto-response</title>
							</head>
							<body style='background-color: #ECECEC;'>
							<div style='background-image: url('https://crm.progress-study.com/assets/images/pscemailbackground.jpg'); background-size: 650px; background-repeat: no-repeat; margin-left: 250px; margin-right:250px; height: 1200px;'>
								<br><br><br>
								<div style='margin-left: 80px; margin-right: 80px;'>
									<p style='text-align: right; font-size: 14px;'><a href='http://www.progress-study.com.au'>www.progress-study.com.au</a></p>";
			    $message .= $iaremailheader;
				$message .= $iaremailbody;
				$message .= $iaremailfooter;
				$message .= "</div>
							</div>
							</body>
							</html>
							";
				$sender = "no-reply@smic.education";
			
				$this->load->library('phpmailer_lib');
		        $mail = $this->phpmailer_lib->load();
	    
	  			/*
			    //$mail->SMTPDebug = 1;
			    $mail->isSMTP();
			    $mail->Host       = 'mail.progress-study.com';            
			    $mail->SMTPAuth   = true;                                
			    $mail->Username   = 'no-reply@progress-study.com';            
			    $mail->Password   = 'Welcome2PSC!';                     
			    $mail->SMTPSecure = 'tls';      
			    $mail->Port       = 587;    
				*/ 
				//$mail->SMTPDebug = 1;
			 
			    $mail->isSMTP();
				$mail->Host = 'sxb1plzcpnl505550.prod.sxb1.secureserver.net';
				$mail->SMTPAuth = false;
				$mail->SMTPAutoTLS = false; 
				$mail->Port = 25;
				$mail->Username   = 'no-reply@smic.education';            
			    $mail->Password   = 'P@ssw0rd@CRM2025'; 
  				
		  //      $mail->SMTPDebug = SMTP::DEBUG_SERVER;
			 //   $mail->isSMTP();
			 //   $mail->Host       = 'ssl://smtp.gmail.com';            
			 //   $mail->SMTPAuth   = true;                                
			 //   $mail->Username   = 'smiccrm.noreply@gmail.com';            
			 //   $mail->Password   = 'tpqkwfhvvqgwkiko';                     
			 //   $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;      
			 //   $mail->Port       = 465;
		     
		        $mail->setFrom("no-reply@smic.education");
		        //$mail->addReplyTo($sender, $this->session->userdata('companyname'));
		        $mail->addAddress($this->input->post('email'));
		        $mail->Subject = 'New Inquiries';
		        $mail->isHTML(true);
		        $mailContent = $message;
		        $mail->Body = $mailContent;
		        $mail->send();

		        //redirect('success');
				//$this->load->view('forms/success');
				$asset_url = base_url()."assets/";
				$data['title'] = "Client Form";
				$data['asset_url'] = $asset_url;

				$this->load->view('forms/success', $data);

	    	} else {
	    		echo "<script>alert('Passwords are not matched!');</script>";
	    	}
        }

    	
	}

	public function saveclientform() 
	{
		$birthdate = DateTime::createFromFormat("Y-m-d", $this->input->post('birthdate'));
    	$birthyear = $birthdate->format("Y");
    	$birthmonth = $birthdate->format("m");
    	$birthday = $birthdate->format("d");

    	if ($this->input->post('password') == $this->input->post('password2')) {
    		$data = array(
						'client_surname' => $this->input->post('lastname'),
						'client_firstname' => $this->input->post('firstname'),
						'client_middlename' => $this->input->post('middlename'),
						'client_dob_day' => $birthday,
						'client_dob_month' => $birthmonth,
						'client_dob_year' => $birthyear,
						'client_phoneno' => '',
						'client_mobileno' => $this->input->post('mobile'),
						'client_overseas_mobileno' => '',
						'client_email' => $this->input->post('email'),
						'client_address' => '',
						'client_suburb' => '',
						'client_state' => '',
						'client_postcode' => '',
						'client_overseas_address' => '',
						'client_flag' => 'active',
						'locked_by_id' => '',
						'client_comments' => '',
						'client_qualifications' => $this->input->post('qualifications'),
						'client_photo' => '',
						'client_office_id' => '',
						'client_ve_day' => '',
						'client_ve_month' => '',
						'client_ve_year' => '',
						'client_event_id' => 0,
						'client_password' => $this->input->post('password'),
						'client_noofchildren' => $this->input->post('noofchildren'),
						'client_civilstatus' => $this->input->post('civilstatus'),
						'client_nationality' => $this->input->post('nationality'),
						'client_country' => $this->input->post('country'),
						'client_notes' => $this->input->post('notes')
					);
			$this->db->insert('client', $data);
			$this->load->view('forms/success');
    	} else {
    		echo "<script>alert('Passwords are not matched!');</script>";
    	}
	}

	public function clientinformation()
	{
		$this->load->view('forms/clientinformation');
	}

	public function success()
	{
		$asset_url = base_url()."assets/";
		$data['title'] = "Client Form";
		$data['asset_url'] = $asset_url;

		$this->load->view('forms/success', $data);
	}

	public function sendemail()
	{
		$message = "";

		$emailquery = $this->db->query("SELECT * FROM `emailcontents`");
				$iaremailheader = $emailquery->row()->iaremailheader;
				$iaremailbody = $emailquery->row()->iaremailbody;
				$iaremailfooter = $emailquery->row()->iaremailfooter;

				$message .= "<!DOCTYPE html>
							<html>
							<head>
								<title>PSC Auto-response</title>
							</head>
							<body style='background-color: #ECECEC;'>
							<div style='background-image: url('https://crm.progress-study.com/assets/images/pscemailbackground.jpg'); background-size: 650px; background-repeat: no-repeat; margin-left: 250px; margin-right:250px; height: 1200px;'>
								<br><br><br>
								<div style='margin-left: 80px; margin-right: 80px;'>
									<p style='text-align: right; font-size: 14px;'><a href='http://www.progress-study.com.au'>www.progress-study.com.au</a></p>";
			    $message .= $iaremailheader;
				$message .= $iaremailbody;
				$message .= $iaremailfooter;
				$message .= "</div>
							</div>
							</body>
							</html>
							";
				$sender = "ramirezkyl@gmail.com";
			
				$this->load->library('phpmailer_lib');
		        $mail = $this->phpmailer_lib->load();
	    
	    /*
			    $mail->SMTPDebug = 1;
			    $mail->isSMTP();
			    $mail->Host       = 'mail.progress-study.com';            
			    $mail->SMTPAuth   = true;                                
			    $mail->Username   = 'no-reply@progress-study.com';            
			    $mail->Password   = 'Welcome2PSC!';                     
			    $mail->SMTPSecure = 'tls';      
			    $mail->Port       = 587;   
		*/
				$mail->SMTPDebug = 1;
			    $mail->isSMTP();
				$mail->Host = 'localhost';
				$mail->SMTPAuth = false;
				$mail->SMTPAutoTLS = false; 
				$mail->Port = 25;
				$mail->Username   = 'no-reply@progress-study.com';            
			    $mail->Password   = 'Welcome2PSC!'; 
   		
		        $mail->setFrom("no-reply@progress-study.com", "Progress Study Consultancy");
		        //$mail->addReplyTo($sender, $this->session->userdata('companyname'));
		        $mail->addAddress("ramirezkyl@gmail.com");
		        $mail->Subject = 'New Inquiries';
		        $mail->isHTML(true);
		        $mailContent = $message;
		        $mail->Body = $mailContent;
		        $mail->send();
		        echo "Successfully sent email";
	}

	public function checkexistingemail($email) {
		$sql3 = "SELECT * FROM client c WHERE c.client_email = '$email'";
	    $query3 = $this->db->query($sql3);
	    $client = $query3->result();

	    $sql4 = "SELECT * FROM inquiries i WHERE i.inquiries_email = '$email'";
	    $query4 = $this->db->query($sql4);
	    $inquiries = $query4->result();

	    $array = array($client, $inquiries);

	    echo json_encode($array);
	}

}
