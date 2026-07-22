<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customerinfocontroller extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->helper('form');
	}

	private function ensure_po_simplified_table()
	{
		$this->db->query("
			CREATE TABLE IF NOT EXISTS po_simplified (
				id INT(11) NOT NULL AUTO_INCREMENT,
				client_id INT(11) NOT NULL,
				po_file VARCHAR(255) NOT NULL DEFAULT '',
				po_date DATE NULL,
				po_status VARCHAR(50) NOT NULL DEFAULT 'Uploaded',
				PRIMARY KEY (id),
				KEY client_id (client_id)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
		");
	}

	private function ensure_student_application_programs_table()
	{
		$this->db->query("
			CREATE TABLE IF NOT EXISTS student_application_programs (
				id INT(11) NOT NULL AUTO_INCREMENT,
				studentapp_id INT(11) NOT NULL,
				spid INT(11) NOT NULL,
				programtype VARCHAR(255) NOT NULL DEFAULT '',
				date_created DATETIME NOT NULL,
				PRIMARY KEY (id),
				UNIQUE KEY studentapp_program (studentapp_id, spid),
				KEY studentapp_id (studentapp_id),
				KEY spid (spid)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
		");

		$this->db->query("
			INSERT IGNORE INTO student_application_programs (studentapp_id, spid, programtype, date_created)
			SELECT sa.studentapp_id, sp.spid, COALESCE(sp.programtype, ''), NOW()
			FROM student_application sa
			INNER JOIN schoolprograms sp ON sp.spid = sa.studentapp_course_name
			WHERE sa.studentapp_course_name REGEXP '^[0-9]+$'
		");
	}

	private function student_google_drive_table_exists()
	{
		return $this->db->table_exists('student_google_drive');
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

	private function ensure_po_link_for_drive_file($client_id, $student_google_drive_id)
	{
		$this->ensure_po_links_table();

		$link = $this->po_acceptance_link($student_google_drive_id);
		$this->db->where('client_id', $client_id);
		$this->db->where('link', $link);
		$existing = $this->db->get('po_links', 1)->row();
		if ($existing) {
			return $existing;
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

	private function is_program_options_drive_file($file)
	{
		return isset($file->record_type, $file->document_purpose, $file->document_type)
			&& $file->record_type == 'file'
			&& $file->document_purpose == 'Counselling'
			&& $file->document_type == 'Program Options';
	}

	private function json_response($payload, $status_code = 200)
	{
		$this->output
			->set_status_header($status_code)
			->set_content_type('application/json')
			->set_output(json_encode($payload));
	}

	private function get_client_row($client_id)
	{
		$this->db->where('client_id', $client_id);
		$query = $this->db->get('client');
		return $query->row();
	}

	private function student_drive_folder_name($client)
	{
		$parts = array();
		if (isset($client->client_surname) && trim($client->client_surname) != '') {
			$parts[] = trim($client->client_surname);
		}
		if (isset($client->client_firstname) && trim($client->client_firstname) != '') {
			$parts[] = trim($client->client_firstname);
		}
		if (isset($client->client_middlename) && trim($client->client_middlename) != '') {
			$parts[] = trim($client->client_middlename);
		}

		$name = trim(implode(', ', array_slice($parts, 0, 1)) . (count($parts) > 1 ? ' ' . implode(' ', array_slice($parts, 1)) : ''));
		if ($name == '') {
			$name = 'Student';
		}

		$name = preg_replace('/[\\\\\/:*?"<>|]+/', '-', $name);
		return $client->client_id . ' - ' . $name;
	}

	private function get_student_drive_folder($client_id)
	{
		if (!$this->student_google_drive_table_exists()) {
			return null;
		}

		$this->db->where('client_id', $client_id);
		$this->db->where('record_type', 'folder');
		$this->db->where('is_active', 1);
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get('student_google_drive', 1);
		return $query->row();
	}

	private function ensure_student_drive_folder($client_id)
	{
		if (!$this->student_google_drive_table_exists()) {
			throw new Exception('The student_google_drive table does not exist yet. Please run the schema in phpMyAdmin.');
		}

		$existing = $this->get_student_drive_folder($client_id);
		if ($existing) {
			return $existing;
		}

		$client = $this->get_client_row($client_id);
		if (!$client) {
			throw new Exception('Client record was not found.');
		}

		$parent_folder_id = $this->config->item('google_drive_parent_folder_id');
		if ($parent_folder_id == '') {
			$parent_folder_id = $this->config->item('google_drive_folder_id');
		}
		if ($parent_folder_id == '') {
			throw new Exception('Google Drive parent folder ID is not configured.');
		}

		$shared_drive_id = $this->config->item('google_shared_drive_id');
		$folder_name = $this->student_drive_folder_name($client);

		$this->load->library('google_drive_service');
		$folder = $this->google_drive_service->create_folder($folder_name, $parent_folder_id, $shared_drive_id);

		$data = array(
			'client_id' => $client_id,
			'record_type' => 'folder',
			'shared_drive_id' => $shared_drive_id,
			'parent_folder_id' => $parent_folder_id,
			'student_folder_id' => $folder['id'],
			'drive_file_id' => $folder['id'],
			'drive_file_name' => $folder_name,
			'drive_web_view_link' => isset($folder['webViewLink']) ? $folder['webViewLink'] : '',
			'uploaded_by_id' => isset($this->session->officer_id) ? $this->session->officer_id : null,
			'uploaded_by_name' => isset($this->session->officer_name) ? $this->session->officer_name : 'SMIC CRM',
			'created_at' => date('Y-m-d H:i:s')
		);

		$this->db->insert('student_google_drive', $data);
		$data['id'] = $this->db->insert_id();

		return (object) $data;
	}

	public function index()
	{
		$this->ensure_student_application_programs_table();

		$sql = "SELECT *,
		        c.client_id AS ctclientid,
		        COALESCE(sap.programs, CASE 
                    WHEN sa.studentapp_course_name REGEXP '^[0-9]+(\.[0-9]+)?$' THEN spro.program
                    ELSE sa.studentapp_course_name 
                END) AS course_actual_name
		        FROM client c 
		        LEFT JOIN student_application sa ON c.client_id = sa.client_id 
		        LEFT JOIN education_provider ep ON sa.provider_id = ep.provider_id 
		        LEFT JOIN programoptions po ON po.application_id = sa.studentapp_id 
		        LEFT JOIN officer o ON c.client_officer_id = o.officer_id
		        LEFT JOIN (
    	           SELECT spid,program FROM schoolprograms
    	        ) spro ON spro.spid = sa.studentapp_course_name
		        LEFT JOIN (
		           SELECT sap.studentapp_id, GROUP_CONCAT(sp.program ORDER BY sap.id SEPARATOR ', ') AS programs
		           FROM student_application_programs sap
		           INNER JOIN schoolprograms sp ON sp.spid = sap.spid
		           GROUP BY sap.studentapp_id
		        ) sap ON sap.studentapp_id = sa.studentapp_id
		        WHERE client_flag = 'active' 
		        ORDER BY c.client_id DESC";
        $query = $this->db->query($sql);
        $result = $query->result();

        $sql2 = "SELECT * FROM officer";
        $query2 = $this->db->query($sql2);
        $result2 = $query2->result();

        $asset_url = base_url()."assets/";
		$data['title'] = "Client Information";
		$data['asset_url'] = $asset_url;
		$data['clients'] = $result;
		$data['officer'] = $result2;

		if($this->session->officer_role == "regional manager" || $this->session->officer_role == "admin") {
			$officer_id_check = $this->session->officer_id;
			$sql11 = "SELECT * FROM notifications WHERE seen = 0 ORDER BY notif_id DESC LIMIT 20";
			$query11 = $this->db->query($sql11);
			$notifnum = $query11->num_rows();

			$sql12 = "SELECT * FROM notifications ORDER BY notif_id DESC LIMIT 20";
			$query12 = $this->db->query($sql12);
			$notif = $query12->result();
		} else {
			$officer_id_check = $this->session->officer_id;
			$sql11 = "SELECT * FROM notifications WHERE seen = 0 AND officer_id = '$officer_id_check' ORDER BY notif_id DESC LIMIT 20";
			$query11 = $this->db->query($sql11);
			$notifnum = $query11->num_rows();

			$sql12 = "SELECT * FROM notifications WHERE officer_id = '$officer_id_check' ORDER BY notif_id DESC LIMIT 20";
			$query12 = $this->db->query($sql12);
			$notif = $query12->result();
		}

		$data['notifnum'] = $notifnum;
		$data['notif'] = $notif;

		$this->db->where('privilege_id', $this->session->officer_role_id);
        $query3 = $this->db->get('privilege');

		foreach ($query3->result() as $row3)
		{
		        $data['privilege_manage_clients'] = $row3->privilege_manage_clients;
		        $data['privilege_view_fees'] = $row3->privilege_view_fees;
		        $data['privilege_manage_providers'] = $row3->privilege_manage_providers;
		        $data['privilege_manage_reporting'] = $row3->privilege_manage_reporting;
		        $data['privilege_manage_studentapps'] = $row3->privilege_manage_studentapps;
		}

		if(isset($this->session->officer_name)) {
			$this->load->view('customerinfo/index', $data);
		} else {
			redirect(base_url()."?error3=1");
		}

	}

	public function editclientinfo($client_id) 
	{
		$this->ensure_student_application_programs_table();

		$sql1 = "SELECT * FROM client WHERE client_id = '$client_id'";
        $query1 = $this->db->query($sql1);
        $client = $query1->result();

        $sql2 = "SELECT * FROM offices";
        $query2 = $this->db->query($sql2);
        $offices = $query2->result();

        $sql3 = "SELECT * FROM events";
        $query3 = $this->db->query($sql3);
        $events = $query3->result();

        $sql4 = "SELECT sa.*, s.*, c.*, COALESCE(sap.programs, sp.program, sa.studentapp_course_name) AS program FROM student_application sa inner join education_provider s on sa.provider_id = s.provider_id inner join client c on c.client_id = sa.client_id left join schoolprograms sp on sa.studentapp_course_name = sp.spid LEFT JOIN (SELECT sap.studentapp_id, GROUP_CONCAT(sp2.program ORDER BY sap.id SEPARATOR ', ') AS programs FROM student_application_programs sap INNER JOIN schoolprograms sp2 ON sp2.spid = sap.spid GROUP BY sap.studentapp_id) sap ON sap.studentapp_id = sa.studentapp_id where sa.client_id = $client_id";
        $query4 = $this->db->query($sql4);
        $student_application = $query4->result();

        $sql5 = "SELECT * FROM clientscholarship cs inner join client c on c.client_id = cs.clientid inner join scholarships s on s.scholarshipid = cs.scholarshipid";
	    $query5 = $this->db->query($sql5);
	    $clientscholarship = $query5->result();

	    $sql6 = "SELECT * FROM programoptions po inner join education_provider s on po.provider_id = s.provider_id inner join schoolprograms sp on sp.spid = po.sp_id where po.client_id = '$client_id'";
        $query6 = $this->db->query($sql6);
        $programoptions = $query6->result();
        
        $sql7 = "SELECT * FROM interview client_id = $client_id";
        $query7 = $this->db->query($sql7);
        $interviews = $query7->result();

        $data['client'] = $client;
        $data['offices'] = $offices;
		$data['events'] = $events;
		$data['student_application'] = $student_application;
		$data['clientscholarship'] = $clientscholarship;
		$data['programoptions'] = $programoptions;
		$data['interviews'] = $interviews;

		$asset_url = base_url()."assets/";
		$data['title'] = "Edit/View Client Information";
		$data['asset_url'] = $asset_url;

		if($this->session->officer_role == "") {
			redirect(base_url()."index.php/messages");
		} else {
			if(isset($this->session->officer_name)) {
				$this->load->view('customerinfo/editclientinfo', $data);
			} else {
				redirect(base_url()."?error3=1");
			}
		}
	}

	public function enterclientinfo($inquiry_id) {
	    
		$sql1 = "SELECT client_id FROM client WHERE client_inquiries_id = '$inquiry_id'";
		$query1 = $this->db->query($sql1);

		foreach($query1->result() as $row) {
			redirect(base_url()."index.php/editclientinfo2/".$row->client_id);
		}

	}

	public function editclientinfo2($client_id, $active_client_page = 'marketing')
	{
		$this->ensure_student_application_programs_table();
		$client_page_aliases = array(
			'clientinfo' => 'marketing',
			'marketing' => 'marketing',
			'documents' => 'counselling',
			'counselling' => 'counselling',
			'counseling' => 'counselling',
			'admission' => 'admission',
			'file-manager' => 'file-manager',
			'file_manager' => 'file-manager',
			'visa' => 'file-manager',
			'visa-documentation' => 'file-manager',
			'finalization' => 'file-manager',
			'result' => 'result'
		);
		$active_client_page = strtolower(trim($active_client_page));
		$active_client_page = isset($client_page_aliases[$active_client_page]) ? $client_page_aliases[$active_client_page] : 'marketing';

		$sql1 = "SELECT * FROM client WHERE client_id = '$client_id'";
        $query1 = $this->db->query($sql1);
        $client = $query1->result();

        $sql2 = "SELECT * FROM offices";
        $query2 = $this->db->query($sql2);
        $offices = $query2->result();

        $sql3 = "SELECT * FROM events";
        $query3 = $this->db->query($sql3);
        $events = $query3->result();

        $sql4 = "SELECT sa.*, s.*, c.*, sa.intake AS saintake, COALESCE(sap.programs, sp.program, sa.studentapp_course_name) AS program FROM student_application sa inner join education_provider s on sa.provider_id = s.provider_id inner join client c on c.client_id = sa.client_id left join schoolprograms sp on sa.studentapp_course_name = sp.spid LEFT JOIN (SELECT sap.studentapp_id, GROUP_CONCAT(sp2.program ORDER BY sap.id SEPARATOR ', ') AS programs FROM student_application_programs sap INNER JOIN schoolprograms sp2 ON sp2.spid = sap.spid GROUP BY sap.studentapp_id) sap ON sap.studentapp_id = sa.studentapp_id where sa.client_id = $client_id";
        $query4 = $this->db->query($sql4);
        $student_application = $query4->result();

        $sql5 = "SELECT * FROM clientscholarship cs inner join client c on c.client_id = cs.clientid inner join scholarships s on s.scholarshipid = cs.scholarshipid where cs.clientid = '$client_id' and cs.bactive = 1";
	    $query5 = $this->db->query($sql5);
	    $clientscholarship = $query5->result();

	    $sql6 = "SELECT * FROM visa_application va inner join client c on va.client_id = c.client_id where va.client_id = $client_id";
	    $query6 = $this->db->query($sql6);
	    $visa_application = $query6->result();

	    $sql7 = "SELECT * FROM expression_of_interest eoi inner join client c on eoi.client_id = c.client_id where eoi.client_id = $client_id";
	    $query7 = $this->db->query($sql7);
	    $eoi = $query7->result();

	    $sql8 = "SELECT * FROM visa_accounts vac inner join visa_application vap on vac.client_visa_id = vap.client_visa_id inner join client c on vap.client_id = c.client_id where vap.client_id = $client_id";
	    $query8 = $this->db->query($sql8);
	    $visa_accounts = $query8->result();

	    $sql9 = "SELECT * from payments p inner join client c on p.payee = c.client_id inner join officer o on o.officer_id = p.processedby inner join mastersetting m on p.paymenttype = m.id where p.barchived = 0 and p.payee = $client_id";
	    $query9 = $this->db->query($sql9);
	    $payments = $query9->result();

	    $this->ensure_po_simplified_table();
	    $sql10 = "SELECT * FROM po_simplified WHERE client_id = '$client_id' ORDER BY po_date DESC, id DESC";
        $query10 = $this->db->query($sql10);
        $programoptions = $query10->result();

        $sql11 = "SELECT * FROM officer";
        $query11 = $this->db->query($sql11);
        $officer = $query11->result();
        
        $sql12 = "SELECT * FROM interviews WHERE client_id = $client_id";
        $query12 = $this->db->query($sql12);
        $interviews = $query12->result();
        
        $sql13 = "SELECT * FROM fee_receipts WHERE client_id = $client_id";
        $query13 = $this->db->query($sql13);
        $fees = $query13->result();
        
        $sql14 = "SELECT * FROM firebasefiles WHERE client_id = $client_id";
        $query14 = $this->db->query($sql14);
        $client_files = $query14->result();

        $student_drive_folder = null;
        $student_drive_files = array();
        if ($this->student_google_drive_table_exists()) {
            $this->db->where('client_id', $client_id);
            $this->db->where('record_type', 'folder');
            $this->db->where('is_active', 1);
            $this->db->order_by('id', 'DESC');
            $student_drive_folder = $this->db->get('student_google_drive', 1)->row();

            $this->db->where('client_id', $client_id);
            $this->db->where('record_type', 'file');
            $this->db->where('is_active', 1);
            $this->db->order_by('created_at', 'DESC');
            $student_drive_files = $this->db->get('student_google_drive')->result();
        }

        foreach ($student_drive_files as $drive_file_row) {
            if ($this->is_program_options_drive_file($drive_file_row)) {
                $this->ensure_po_link_for_drive_file($client_id, $drive_file_row->id);
            }
        }

        $this->ensure_po_links_table();
        $this->db->where('client_id', $client_id);
        $this->db->order_by('date_created', 'DESC');
        $po_links = $this->db->get('po_links')->result();
        
        $sql15 = "SELECT * FROM admissionofferletter WHERE client_id = $client_id";
        $query15 = $this->db->query($sql15);
        $admissionofferletter = $query15->result();
        
        $sql16 = "SELECT * FROM result WHERE client_id = $client_id";
        $query16 = $this->db->query($sql16);
        $result = $query16->result();

        $this->db->where('privilege_id', $this->session->officer_role_id);
        $query3 = $this->db->get('privilege');

		foreach ($query3->result() as $row3)
		{
		        $data['privilege_view_fees'] = $row3->privilege_view_fees;
		        $data['privilege_manage_clients'] = $row3->privilege_manage_clients;
		        $data['privilege_manage_studentapps'] = $row3->privilege_manage_studentapps;
		        $data['privilege_manage_studentdocs'] = $row3->privilege_manage_studentdocs;
		        $data['privilege_manage_prapps'] = $row3->privilege_manage_prapps;
		        $data['privilege_manage_prdocs'] = $row3->privilege_manage_prdocs;
		        $data['privilege_manage_prfeereceived'] = $row3->privilege_manage_prfeereceived;
		        $data['privilege_manage_prfeepaid'] = $row3->privilege_manage_prfeepaid;
		        $data['privilege_manage_providers'] = $row3->privilege_manage_providers;
		        $data['privilege_manage_reporting'] = $row3->privilege_manage_reporting;
		}

        //id=2018&name=De%20Leon%20Abigail_PRApplication_127%20-2018&gdrive_id=150guQ5rBvbqw4Vo7HsAZAJJhUl6w6T3B&exist=exist

	    $data['client_id'] = $client_id;
	    $data['active_client_page'] = $active_client_page;
        $data['client'] = $client;
        $data['offices'] = $offices;
        $data['officer'] = $officer;
		$data['events'] = $events;
		$data['student_application'] = $student_application;
		$data['clientscholarship'] = $clientscholarship;
		$data['visa_application'] = $visa_application;
		$data['visa_accounts'] = $visa_accounts;
		$data['eoi'] = $eoi;
		$data['payments'] = $payments;
		$data['programoptions'] = $programoptions;
        $data['interviews'] = $interviews;
        $data['fees'] = $fees;
        $data['client_files'] = $client_files;
        $data['firebasefiles'] = $client_files;
        $data['student_drive_folder'] = $student_drive_folder;
        $data['student_drive_files'] = $student_drive_files;
        $data['po_links'] = $po_links;
        $data['admissionofferletter'] = $admissionofferletter;
        $data['result'] = $result;

		$data['exist'] = 'exist';

		$asset_url = base_url()."assets/";
		$data['title'] = "Edit/View Client Information";
		$data['asset_url'] = $asset_url;

		if($this->session->officer_role == "regional manager" || $this->session->officer_role == "admin") {
			$officer_id_check = $this->session->officer_id;
			$sql11 = "SELECT * FROM notifications WHERE seen = 0 ORDER BY notif_id DESC LIMIT 20";
			$query11 = $this->db->query($sql11);
			$notifnum = $query11->num_rows();

			$sql12 = "SELECT * FROM notifications ORDER BY notif_id DESC LIMIT 20";
			$query12 = $this->db->query($sql12);
			$notif = $query12->result();
		} else {
			$officer_id_check = $this->session->officer_id;
			$sql11 = "SELECT * FROM notifications WHERE seen = 0 AND officer_id = '$officer_id_check' ORDER BY notif_id DESC LIMIT 20";
			$query11 = $this->db->query($sql11);
			$notifnum = $query11->num_rows();

			$sql12 = "SELECT * FROM notifications WHERE officer_id = '$officer_id_check' ORDER BY notif_id DESC LIMIT 20";
			$query12 = $this->db->query($sql12);
			$notif = $query12->result();
		}

		$data['notifnum'] = $notifnum;
		$data['notif'] = $notif;

		if($this->session->officer_role == "") {
			redirect(base_url()."index.php/messages");
		} else {
			if(isset($this->session->officer_name)) {
				$this->load->view('customerinfo/editclientinfo2', $data);
			} else {
				redirect(base_url()."?error3=1");
			}
		}
	}
	
	public function updateclientinfo()
	{
		$birthdate = DateTime::createFromFormat("Y-m-d", $this->input->post('birthdate'));
    	$birthyear = $birthdate->format("Y");
    	$birthmonth = $birthdate->format("m");
    	$birthday = $birthdate->format("d");

    	$vedate = DateTime::createFromFormat("Y-m-d", $this->input->post('vedate'));
    	$veyear = $vedate->format("Y");
    	$vemonth = $vedate->format("m");
    	$veday = $vedate->format("d");

    	if($this->input->post('selectevent') != "") {
    		$selectevent = $this->input->post('selectevent');
    	} else {
    		$selectevent = 0;
    	}

    	if($this->input->post('selectoffice') != "") {
    		$selectoffice = $this->input->post('selectoffice');
    	} else {
    		$selectoffice = 0;
    	}

    	if($this->input->post('selectofficer') != "") {
    		$selectofficer = $this->input->post('selectofficer');
    	} else {
    		$selectofficer = 0;
    	}

    	if($this->input->post('selectflag') != "") {
    		$selectflag = $this->input->post('selectflag');
    	} else {
    		$selectflag = "";
    	}

    	echo $selectofficer;

		$this->db->set('client_surname', $this->input->post('lastname'));
		$this->db->set('client_firstname', $this->input->post('firstname'));
		$this->db->set('client_middlename', $this->input->post('middlename'));
		$this->db->set('client_dob_day', $birthday);
		$this->db->set('client_dob_month', $birthmonth);
		$this->db->set('client_dob_year', $birthyear);
		$this->db->set('client_phoneno', $this->input->post('phoneno'));
		$this->db->set('client_mobileno', $this->input->post('mobileno'));
		$this->db->set('client_overseas_mobileno', $this->input->post('Overseasmobileno'));
		$this->db->set('client_email', $this->input->post('email'));
		$this->db->set('client_address', $this->input->post('clientaddress'));
		$this->db->set('client_suburb', $this->input->post('suburb'));
		$this->db->set('client_state', $this->input->post('state'));
		$this->db->set('client_postcode', $this->input->post('postcode'));
		$this->db->set('client_overseas_address', $this->input->post('overseasaddress'));
		$this->db->set('client_flag', $selectflag);
		$this->db->set('locked_by_id', '');
		$this->db->set('client_comments', $this->input->post('comment'));
		$this->db->set('client_qualifications', $this->input->post('qualifications'));
		$this->db->set('client_photo', '');
		$this->db->set('client_office_id', $selectoffice);
		$this->db->set('client_officer_id', $selectofficer);
		$this->db->set('client_ve_day', $veday);
		$this->db->set('client_ve_month', $vemonth);
		$this->db->set('client_ve_year', $veyear);
		$this->db->set('client_event_id', $selectevent);
		$this->db->set('client_password', $this->input->post('password'));
		$this->db->set('client_noofchildren', $this->input->post('noofchildren'));
		$this->db->set('client_civilstatus', $this->input->post('civilstatus'));
		$this->db->set('client_nationality', $this->input->post('nationality'));
		$this->db->set('client_country', $this->input->post('country'));
		$this->db->set('client_notes', $this->input->post('notes'));
		
		$this->db->set('proposeddateofinterview', $this->input->post('pdateofinterview'));
		$this->db->set('isonshore', $this->input->post('isonshore'));

		$this->db->where('client_id', $this->input->post('clientid'));
		$this->db->update('client');

		redirect(base_url()."index.php/editclientinfo2/".$this->input->post('clientid'));
	}

	public function do_upload()
        {
                
                $config['upload_path']          = './assets/images/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 10000;
                $config['max_width']            = 10000;
                $config['max_height']           = 10000;

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('userfile'))
                {
                	$birthdate = DateTime::createFromFormat("Y-m-d", $this->input->post('birthdate'));
			    	$birthyear = $birthdate->format("Y");
			    	$birthmonth = $birthdate->format("m");
			    	$birthday = $birthdate->format("d");
                    
                    if($this->input->post('vedate')) {
                        $vedate = DateTime::createFromFormat("Y-m-d", $this->input->post('vedate'));
    			    	$veyear = $vedate->format("Y");
    			    	$vemonth = $vedate->format("m");
    			    	$veday = $vedate->format("d");
                    } else {
                        $veyear = "0000";
    			    	$vemonth = "00";
    			    	$veday = "00";
                    }

			    	if($this->input->post('selectevent') != "") {
			    		$this->db->set('client_event_id', $this->input->post('selectevent'));
			    	}

			    	if($this->input->post('selectoffice') != "") {
			    		$this->db->set('client_office_id', $this->input->post('selectoffice'));
			    	}

			    	if($this->input->post('selectflag') != "" ) {
			    		$this->db->set('client_flag', $this->input->post('selectflag'));
			    	}

			    	if($this->input->post('selectofficer') != "") {
			    		$this->db->set('client_officer_id', $this->input->post('selectofficer'));
			    	}

					$this->db->set('client_surname', $this->input->post('lastname'));
					$this->db->set('client_firstname', $this->input->post('firstname'));
					$this->db->set('client_middlename', $this->input->post('middlename'));
					$this->db->set('client_dob_day', $birthday);
					$this->db->set('client_dob_month', $birthmonth);
					$this->db->set('client_dob_year', $birthyear);
					$this->db->set('client_phoneno', $this->input->post('phoneno'));
					$this->db->set('client_mobileno', $this->input->post('mobileno'));
					$this->db->set('client_overseas_mobileno', $this->input->post('Overseasmobileno'));
					$this->db->set('client_email', $this->input->post('email'));
					$this->db->set('client_address', $this->input->post('clientaddress'));
					$this->db->set('client_suburb', $this->input->post('suburb'));
					$this->db->set('client_state', $this->input->post('state'));
					$this->db->set('client_postcode', $this->input->post('postcode'));
					$this->db->set('client_overseas_address', $this->input->post('overseasaddress'));
					
					$this->db->set('locked_by_id', '');
					$this->db->set('client_comments', $this->input->post('comment'));
					$this->db->set('client_qualifications', $this->input->post('qualification'));
					
					$this->db->set('client_ve_day', $veday);
					$this->db->set('client_ve_month', $vemonth);
					$this->db->set('client_ve_year', $veyear);
					
					if($this->input->post('pdateofinterview') == '') {
			            $pdateofinterview = '0000-00-00';
			        } else {
			            $pdateofinterview = $this->input->post('pdateofinterview');
			        }
					
					$this->db->set('proposeddateofinterview', $pdateofinterview);
            		$this->db->set('isonshore', $this->input->post('isonshore'));
					
					$this->db->where('client_id', $this->input->post('clientid'));
					$this->db->update('client');

                    redirect(base_url().'index.php/editclientinfo2/'.$this->input->post('clientid'));
                }
                else
                {
                	$upload_data = $this->upload->data();
					$file_name = $upload_data['file_name'];

                	$birthdate = DateTime::createFromFormat("Y-m-d", $this->input->post('birthdate'));
			    	$birthyear = $birthdate->format("Y");
			    	$birthmonth = $birthdate->format("m");
			    	$birthday = $birthdate->format("d");

			    	$vedate = DateTime::createFromFormat("Y-m-d", $this->input->post('vedate'));
			    	$veyear = $vedate->format("Y");
			    	$vemonth = $vedate->format("m");
			    	$veday = $vedate->format("d");

			    	if($this->input->post('selectevent') != "") {
			    		$this->db->set('client_event_id', $this->input->post('selectevent'));
			    	}

			    	if($this->input->post('selectoffice') != "") {
			    		$this->db->set('client_office_id', $this->input->post('selectoffice'));
			    	}

			    	if($this->input->post('selectflag') != "" ) {
			    		$this->db->set('client_flag', $this->input->post('selectflag'));
			    	}

			    	if($this->input->post('selectofficer') != "") {
			    		$this->db->set('client_officer_id', $this->input->post('selectofficer'));
			    	}

					$this->db->set('client_surname', $this->input->post('lastname'));
					$this->db->set('client_firstname', $this->input->post('firstname'));
					$this->db->set('client_middlename', $this->input->post('middlename'));
					$this->db->set('client_dob_day', $birthday);
					$this->db->set('client_dob_month', $birthmonth);
					$this->db->set('client_dob_year', $birthyear);
					$this->db->set('client_phoneno', $this->input->post('phoneno'));
					$this->db->set('client_mobileno', $this->input->post('mobileno'));
					$this->db->set('client_overseas_mobileno', $this->input->post('Overseasmobileno'));
					$this->db->set('client_email', $this->input->post('email'));
					$this->db->set('client_address', $this->input->post('clientaddress'));
					$this->db->set('client_suburb', $this->input->post('suburb'));
					$this->db->set('client_state', $this->input->post('state'));
					$this->db->set('client_postcode', $this->input->post('postcode'));
					$this->db->set('client_overseas_address', $this->input->post('overseasaddress'));
					
					$this->db->set('locked_by_id', '');
					$this->db->set('client_comments', $this->input->post('comment'));
					$this->db->set('client_qualifications', $this->input->post('qualification'));
					$this->db->set('client_photo', $file_name);
					
					$this->db->set('client_ve_day', $veday);
					$this->db->set('client_ve_month', $vemonth);
					$this->db->set('client_ve_year', $veyear);
			
			        if($this->input->post('pdateofinterview') == '') {
			            $pdateofinterview = '0000-00-00';
			        } else {
			            $pdateofinterview = $this->input->post('pdateofinterview');
			        }
			
			        $this->db->set('proposeddateofinterview', $pdateofinterview);
            		$this->db->set('isonshore', $this->input->post('isonshore'));
					
					$this->db->where('client_id', $this->input->post('clientid'));
					$this->db->update('client');

                    redirect(base_url().'index.php/editclientinfo2/'.$this->input->post('clientid'));
                }
                
        }

    public function savefirebasefile() {
    	$date = date("Y-m-d");
    	$client_id = $_GET['clientid'];
    	$url =  $_GET['url'];

    	$data = array(
			'client_id' => $client_id,
			'document_type' => $row->inquiries_firstname,
			'document_link' => $url,
			'date_uploaded' => $date
		);
		$this->db->insert('firebasefiles', $data);
		echo json_encode("Successfully saved documents!");
    }

	public function create_student_gdrive_folder()
	{
		if (!isset($this->session->officer_name)) {
			return $this->json_response(array('success' => false, 'message' => 'Session expired. Please sign in again.'), 401);
		}

		$client_id = (int) $this->input->post('client_id');
		if ($client_id <= 0) {
			return $this->json_response(array('success' => false, 'message' => 'Client ID is required.'), 422);
		}

		try {
			$folder = $this->ensure_student_drive_folder($client_id);
			return $this->json_response(array(
				'success' => true,
				'message' => 'Student Google Drive folder is ready.',
				'folder' => $folder
			));
		} catch (Exception $e) {
			return $this->json_response(array('success' => false, 'message' => $e->getMessage()), 500);
		}
	}

	public function upload_student_gdrive_file()
	{
		if (!isset($this->session->officer_name)) {
			return $this->json_response(array('success' => false, 'message' => 'Session expired. Please sign in again.'), 401);
		}

		$client_id = (int) $this->input->post('client_id');
		$document_purpose = trim((string) $this->input->post('document_purpose'));
		$document_type = trim((string) $this->input->post('document_type'));
		$document_specific = trim((string) $this->input->post('document_specific'));
		$document_alias = trim((string) $this->input->post('document_alias'));
		$remarks = trim((string) $this->input->post('remarks'));

		if ($client_id <= 0 || $document_purpose == '' || $document_type == '' || $document_specific == '') {
			return $this->json_response(array('success' => false, 'message' => 'Client, purpose, document type, and document specific are required.'), 422);
		}

		if (empty($_FILES['document_file']) || $_FILES['document_file']['error'] != UPLOAD_ERR_OK) {
			return $this->json_response(array('success' => false, 'message' => 'Please choose a valid file to upload.'), 422);
		}

		try {
			$folder = $this->ensure_student_drive_folder($client_id);
			$shared_drive_id = $this->config->item('google_shared_drive_id');

			$original_name = basename($_FILES['document_file']['name']);
			$mime_type = isset($_FILES['document_file']['type']) ? $_FILES['document_file']['type'] : 'application/octet-stream';
			$file_size = isset($_FILES['document_file']['size']) ? (int) $_FILES['document_file']['size'] : 0;

			$this->load->library('google_drive_service');
			$drive_file = $this->google_drive_service->upload_file(
				$_FILES['document_file']['tmp_name'],
				$original_name,
				$mime_type,
				$folder->student_folder_id,
				$shared_drive_id
			);

			$data = array(
				'client_id' => $client_id,
				'record_type' => 'file',
				'shared_drive_id' => $shared_drive_id,
				'parent_folder_id' => $folder->student_folder_id,
				'student_folder_id' => $folder->student_folder_id,
				'drive_file_id' => $drive_file['id'],
				'drive_file_name' => isset($drive_file['name']) ? $drive_file['name'] : $original_name,
				'drive_web_view_link' => isset($drive_file['webViewLink']) ? $drive_file['webViewLink'] : '',
				'drive_web_content_link' => isset($drive_file['webContentLink']) ? $drive_file['webContentLink'] : '',
				'document_purpose' => $document_purpose,
				'document_type' => $document_type,
				'document_specific' => $document_specific,
				'document_alias' => $document_alias,
				'remarks' => $remarks,
				'mime_type' => isset($drive_file['mimeType']) ? $drive_file['mimeType'] : $mime_type,
				'file_size' => isset($drive_file['size']) ? (int) $drive_file['size'] : $file_size,
				'uploaded_by_id' => isset($this->session->officer_id) ? $this->session->officer_id : null,
				'uploaded_by_name' => isset($this->session->officer_name) ? $this->session->officer_name : 'SMIC CRM',
				'created_at' => date('Y-m-d H:i:s')
			);

			$this->db->insert('student_google_drive', $data);
			$data['id'] = $this->db->insert_id();

			$po_link = null;
			if ($document_purpose == 'Counselling' && $document_type == 'Program Options') {
				$po_link = $this->ensure_po_link_for_drive_file($client_id, $data['id']);
			}

			return $this->json_response(array(
				'success' => true,
				'message' => 'File uploaded to Google Drive.',
				'file' => $data,
				'po_link' => $po_link
			));
		} catch (Exception $e) {
			return $this->json_response(array('success' => false, 'message' => $e->getMessage()), 500);
		}
	}

	public function send_po_link_email()
	{
		if (!isset($this->session->officer_name)) {
			return $this->json_response(array('success' => false, 'message' => 'Session expired. Please sign in again.'), 401);
		}

		$this->ensure_po_links_table();

		$po_link_id = (int) $this->input->post('po_link_id');
		$client_id = (int) $this->input->post('client_id');
		if ($po_link_id <= 0 || $client_id <= 0) {
			return $this->json_response(array('success' => false, 'message' => 'PO link and client are required.'), 422);
		}

		$this->db->where('id', $po_link_id);
		$this->db->where('client_id', $client_id);
		$po_link = $this->db->get('po_links', 1)->row();
		if (!$po_link) {
			return $this->json_response(array('success' => false, 'message' => 'PO link was not found.'), 404);
		}

		$client = $this->get_client_row($client_id);
		if (!$client || trim((string) $client->client_email) == '') {
			return $this->json_response(array('success' => false, 'message' => 'This client has no email address on file.'), 422);
		}

		try {
			$client_name = trim($client->client_firstname . ' ' . $client->client_surname);
			if ($client_name == '') {
				$client_name = 'Student';
			}

			$message = "<p>Dear " . htmlspecialchars($client_name, ENT_QUOTES, 'UTF-8') . ",</p>";
			$message .= "<p>We are requesting you to review the Program Options prepared for you. Please open the link below, review the details carefully, and accept the offer if it suits your study plans.</p>";
			$message .= "<p><a href='" . htmlspecialchars($po_link->link, ENT_QUOTES, 'UTF-8') . "'>" . htmlspecialchars($po_link->link, ENT_QUOTES, 'UTF-8') . "</a></p>";
			$message .= "<p>This link is for one-time access only. Please complete your review once the page is opened.</p>";
			$message .= "<p>Thank you,<br>SMIC CRM</p>";

			$this->load->library('phpmailer_lib');
			$mail = $this->phpmailer_lib->load();
			$mail->isSMTP();
			$mail->Host = 'sxb1plzcpnl505550.prod.sxb1.secureserver.net';
			$mail->SMTPAuth = false;
			$mail->SMTPAutoTLS = false;
			$mail->Port = 25;
			$mail->setFrom('no-reply@smic.education', 'SMIC CRM');
			$mail->addAddress($client->client_email, $client_name);
			$mail->Subject = 'Program Options Review and Acceptance';
			$mail->isHTML(true);
			$mail->Body = $message;
			$mail->AltBody = "Dear " . $client_name . ",\n\nWe are requesting you to review the Program Options prepared for you. Please open the link below, review the details carefully, and accept the offer if it suits your study plans.\n\n" . $po_link->link . "\n\nThis link is for one-time access only. Please complete your review once the page is opened.\n\nThank you,\nSMIC CRM";
			$mail->send();

			return $this->json_response(array('success' => true, 'message' => 'Program Options link was emailed to ' . $client->client_email . '.'));
		} catch (Exception $e) {
			return $this->json_response(array('success' => false, 'message' => 'Unable to send email: ' . $e->getMessage()), 500);
		}
	}

    public function assignofficer()
	{
		$this->db->set('client_officer_id', $this->input->post('officer'));
		$this->db->where('client_id', $this->input->post('clientid'));
		$this->db->update('client');

		$officerthreadid = $this->input->post('officer');
		$clientthreadid = $this->input->post('clientid');
		$threadsql = "SELECT * FROM thread WHERE sender_id = '$officerthreadid' and receiver_id = '$clientthreadid'";
		$threadquery = $this->db->query($threadsql);
		$threadrows = $threadquery->num_rows();

		if ($threadrows == 0) {
			$data = array(
					'sender_id' => $this->input->post('officer'),
					'receiver_id' => $this->input->post('clientid'),
					'created_date' => date("Y-m-d"),
					'status' => 'active',
					'chattype' => 'managerclient'
					);
			$this->db->insert('thread', $data);
		}

		redirect(base_url()."index.php/customerinfo?success1=1");
	}

	public function resetphoto($client_id)
	{
		$this->db->set('client_photo', 'avatar5.png');
		$this->db->where('client_id', $client_id);
		$this->db->update('client');
		//echo json_encode("Successfully done reset!");
		redirect(base_url()."index.php/editclientinfo2/".$client_id);
	}

	public function deactivateclient($client_id)
	{
		$this->db->set('client_flag', 'inactive');
		$this->db->where('client_id', $client_id);
		$this->db->update('client');
		//echo json_encode("Successfully done reset!");
		redirect(base_url()."index.php/customerinfo");
	}

    public function profile($client_id)
	{
		$sql1 = "SELECT * FROM client WHERE client_id = '$client_id'";
	        $query1 = $this->db->query($sql1);
	        $client = $query1->result();

	        $sql2 = "SELECT * FROM offices";
	        $query2 = $this->db->query($sql2);
	        $offices = $query2->result();

	        $sql3 = "SELECT * FROM events";
	        $query3 = $this->db->query($sql3);
	        $events = $query3->result();

	        $sql4 = "SELECT * FROM student_application sa inner join education_provider s on sa.provider_id = s.provider_id inner join client c on c.client_id = sa.client_id where sa.client_id = $client_id";
	        $query4 = $this->db->query($sql4);
	        $student_application = $query4->result();

	        $sql5 = "SELECT * FROM clientscholarship cs inner join client c on c.client_id = cs.clientid inner join scholarships s on s.scholarshipid = cs.scholarshipid";
		    $query5 = $this->db->query($sql5);
		    $clientscholarship = $query5->result();

		    $sql6 = "SELECT * FROM programoptions po inner join education_provider s on po.provider_id = s.provider_id inner join schoolprograms sp on sp.spid = po.sp_id where po.client_id = '$client_id'";
	        $query6 = $this->db->query($sql6);
	        $programoptions = $query6->result();

	        $data['client'] = $client;
	        $data['offices'] = $offices;
		$data['events'] = $events;
		$data['student_application'] = $student_application;
		$data['clientscholarship'] = $clientscholarship;
		$data['programoptions'] = $programoptions;
		$fullname = "";

		foreach($client as $row) {
			$fullname = $row->client_firstname."".$row->client_surname;
		}

		$asset_url = base_url()."assets/";
		$data['title'] = $fullname;
		$data['asset_url'] = $asset_url;

		$this->load->view('customerinfo/profile', $data);
	}
	
	public function saveresult() {
    	$date = date("Y-m-d");
    	$client_id = $this->input->post('resultclientid');
    	$url =  $_GET['url'];

    	$data = array(
			'client_id' => $client_id,
			'stage' => $this->input->post('stagemarketing'),
			'status' => $this->input->post('statusmarketing'),
			'remarks' => $this->input->post('remarksmarketing')
		);
		$this->db->insert('result', $data);
		
		$data = array(
			'client_id' => $client_id,
			'stage' => $this->input->post('stagecounselling'),
			'status' => $this->input->post('statuscounselling'),
			'remarks' => $this->input->post('remarkscounselling')
		);
		$this->db->insert('result', $data);
		
		$data = array(
			'client_id' => $client_id,
			'stage' => $this->input->post('stageadmission'),
			'status' => $this->input->post('statusadmission'),
			'remarks' => $this->input->post('remarksadmission')
		);
		$this->db->insert('result', $data);
		
		$data = array(
			'client_id' => $client_id,
			'stage' => $this->input->post('stagevisaadmission'),
			'status' => $this->input->post('statusvisaadmission'),
			'remarks' => $this->input->post('remarksvisaadmission')
		);
		$this->db->insert('result', $data);
		
		$data = array(
			'client_id' => $client_id,
			'stage' => $this->input->post('stagefinalization'),
			'status' => $this->input->post('statusfinalization'),
			'remarks' => $this->input->post('remarksfinalization')
		);
		$this->db->insert('result', $data);
		
		redirect(base_url()."index.php/editclientinfo2/".$this->input->post('resultclientid'));
    }
    
    public function updateresult() {
    	$date = date("Y-m-d");
    	$client_id = $this->input->post('resultclientid');
    	$url =  $_GET['url'];
    	
		$this->db->set('status', $this->input->post('statusmarketing'));
		$this->db->set('remarks', $this->input->post('remarksmarketing'));
		$this->db->where('client_id', $client_id);
		$this->db->where('stage', "Marketing");
		$this->db->update('result');
		
		$this->db->set('status', $this->input->post('statuscounselling'));
		$this->db->set('remarks', $this->input->post('remarkscounselling'));
		$this->db->where('client_id', $client_id);
		$this->db->where('stage', "Counselling");
		$this->db->update('result');
		
		$this->db->set('status', $this->input->post('statusadmission'));
		$this->db->set('remarks', $this->input->post('remarksadmission'));
		$this->db->where('client_id', $client_id);
		$this->db->where('stage', "Admission");
		$this->db->update('result');
		
		$this->db->set('status', $this->input->post('statusvisaadmission'));
		$this->db->set('remarks', $this->input->post('remarksvisaadmission'));
		$this->db->where('client_id', $client_id);
		$this->db->where('stage', "Visa Documentation");
		$this->db->update('result');
		
		$this->db->set('status', $this->input->post('statusfinalization'));
		$this->db->set('remarks', $this->input->post('remarksfinalization'));
		$this->db->where('client_id', $client_id);
		$this->db->where('stage', "Finalization");
		$this->db->update('result');
		
		redirect(base_url()."index.php/editclientinfo2/".$this->input->post('resultclientid')."/result");
    }
    
    public function editfile() {
        $type = $_GET["type"];
        $id = $_GET["id"];
        $client = $_GET["client"];
        
        if($type == "admissionofferletter") {
            
            $sql = "SELECT * FROM admissionofferletter WHERE id = $id";
            $query = $this->db->query($sql);
            $admissionofferletter = $query->result();
            
            $data['admissionofferletter'] = $admissionofferletter;
            
        } elseif($type == "fee") {
            
            $sql = "SELECT * FROM fee_receipts WHERE id = $id";
            $query = $this->db->query($sql);
            $fee = $query->result();
            
            $data['fee'] = $fee;
            
        } elseif($type == "programoption") {
            
            $this->ensure_po_simplified_table();
            $sql = "SELECT * FROM po_simplified WHERE id = $id";
            $query = $this->db->query($sql);
            $programoption = $query->result();
            
            $data['programoption'] = $programoption;
            
        } elseif($type == "interviews") {
            
            $sql = "SELECT * FROM interviews WHERE id = $id";
            $query = $this->db->query($sql);
            $interviews = $query->result();
            
            $data['interviews'] = $interviews;
            
        }
        
        $data['type'] = $type;
        $data['id'] = $id;
        $data['client'] = $client;
            
        $asset_url = base_url()."assets/";
    	$data['title'] = "Edit File";
    	$data['asset_url'] = $asset_url;
    		
    		if($this->session->officer_role == "regional manager" || $this->session->officer_role == "admin") {
    			$officer_id_check = $this->session->officer_id;
    			$sql11 = "SELECT * FROM notifications WHERE seen = 0 ORDER BY notif_id DESC LIMIT 20";
    			$query11 = $this->db->query($sql11);
    			$notifnum = $query11->num_rows();
    
    			$sql12 = "SELECT * FROM notifications ORDER BY notif_id DESC LIMIT 20";
    			$query12 = $this->db->query($sql12);
    			$notif = $query12->result();
    		} else {
    			$officer_id_check = $this->session->officer_id;
    			$sql11 = "SELECT * FROM notifications WHERE seen = 0 AND officer_id = '$officer_id_check' ORDER BY notif_id DESC LIMIT 20";
    			$query11 = $this->db->query($sql11);
    			$notifnum = $query11->num_rows();
    
    			$sql12 = "SELECT * FROM notifications WHERE officer_id = '$officer_id_check' ORDER BY notif_id DESC LIMIT 20";
    			$query12 = $this->db->query($sql12);
    			$notif = $query12->result();
    		}
    
    		$data['notifnum'] = $notifnum;
    		$data['notif'] = $notif;
            
            $this->db->where('privilege_id', $this->session->officer_role_id);
            $query3 = $this->db->get('privilege');
    
    		foreach ($query3->result() as $row3)
    		{
    		        $data['privilege_manage_clients'] = $row3->privilege_manage_clients;
    		        $data['privilege_view_fees'] = $row3->privilege_view_fees;
    		        $data['privilege_manage_providers'] = $row3->privilege_manage_providers;
    		        $data['privilege_manage_reporting'] = $row3->privilege_manage_reporting;
    		        $data['privilege_manage_studentapps'] = $row3->privilege_manage_studentapps;
    		}
            
            $this->load->view('customerinfo/editfile', $data);

    }
    
    public function editfirebasefile() {
        $id = $_GET["id"];
        $client = $_GET["client"];
        
        $sql = "SELECT * FROM firebasefiles WHERE fbid = $id";
        $query = $this->db->query($sql);
        $firebasefiles = $query->result();
            
        $data['firebasefiles'] = $firebasefiles;
        
        $data['id'] = $id;
        $data['client'] = $client;
            
        $asset_url = base_url()."assets/";
    	$data['title'] = "Edit File";
    	$data['asset_url'] = $asset_url;
    		
    		if($this->session->officer_role == "regional manager" || $this->session->officer_role == "admin") {
    			$officer_id_check = $this->session->officer_id;
    			$sql11 = "SELECT * FROM notifications WHERE seen = 0 ORDER BY notif_id DESC LIMIT 20";
    			$query11 = $this->db->query($sql11);
    			$notifnum = $query11->num_rows();
    
    			$sql12 = "SELECT * FROM notifications ORDER BY notif_id DESC LIMIT 20";
    			$query12 = $this->db->query($sql12);
    			$notif = $query12->result();
    		} else {
    			$officer_id_check = $this->session->officer_id;
    			$sql11 = "SELECT * FROM notifications WHERE seen = 0 AND officer_id = '$officer_id_check' ORDER BY notif_id DESC LIMIT 20";
    			$query11 = $this->db->query($sql11);
    			$notifnum = $query11->num_rows();
    
    			$sql12 = "SELECT * FROM notifications WHERE officer_id = '$officer_id_check' ORDER BY notif_id DESC LIMIT 20";
    			$query12 = $this->db->query($sql12);
    			$notif = $query12->result();
    		}
    
    		$data['notifnum'] = $notifnum;
    		$data['notif'] = $notif;
            
            $this->db->where('privilege_id', $this->session->officer_role_id);
            $query3 = $this->db->get('privilege');
    
    		foreach ($query3->result() as $row3)
    		{
    		        $data['privilege_manage_clients'] = $row3->privilege_manage_clients;
    		        $data['privilege_view_fees'] = $row3->privilege_view_fees;
    		        $data['privilege_manage_providers'] = $row3->privilege_manage_providers;
    		        $data['privilege_manage_reporting'] = $row3->privilege_manage_reporting;
    		        $data['privilege_manage_studentapps'] = $row3->privilege_manage_studentapps;
    		}
            
            $this->load->view('customerinfo/editfirebasefile', $data);
        
    }
    
    public function deletefile()
	{
	    
	    $type = $_GET["type"];
        $id = $_GET["id"];
        $client = $_GET["client"];
        
        if($type == "admissionofferletter") {
            $this->db->where('id', $id);
    		$this->db->delete('admissionofferletter');
    		redirect(base_url()."index.php/editclientinfo2/".$client);
        } elseif($type == "fee") {
            $this->db->where('id', $id);
    		$this->db->delete('fee_receipts');
    		redirect(base_url()."index.php/editclientinfo2/".$client);
        } elseif($type == "programoption") {
            $this->ensure_po_simplified_table();
            $this->db->where('id', $id);
    		$this->db->delete('po_simplified');
    		redirect(base_url()."index.php/editclientinfo2/".$client."/counselling");
        } elseif($type == "interviews") {
            $this->db->where('id', $id);
    		$this->db->delete('interviews');
    		redirect(base_url()."index.php/editclientinfo2/".$client);
        }
		
	}
	
	public function deletefirebasefile() {
	    
	    $id = $_GET["id"];
        $client = $_GET["client"];
        
	    $this->db->where('fbid', $id);
    	$this->db->delete('firebasefiles');
    	redirect(base_url()."index.php/editclientinfo2/".$client);
	    
	}
	
	public function clientmonitoring() {
		$this->ensure_student_application_programs_table();

	    $sql = "SELECT *,
				c.client_id AS monitoring_client_id,
				c.client_surname AS monitoring_client_surname,
				c.client_firstname AS monitoring_client_firstname,
				c.client_middlename AS monitoring_client_middlename,
				c.client_email AS monitoring_client_email,
				c.client_phoneno AS monitoring_client_phone,
				c.client_mobileno AS monitoring_client_mobile,
				o.officer_name AS monitoring_officer_name,
				ep.provider_name AS monitoring_provider_name,
				COALESCE(sap.programs, sp.program, sa.studentapp_course_name) AS monitoring_program,
				sa.vevo_expiry_date AS sa_vevo_expiry_date,
				po.location AS polocation,
				po.intake AS pointake,
				po.englishrequirement AS poenglishrequirement,
				po.prepdate AS poprepdate,
				po.followupdate AS pofollowupdate,
				po.remarks AS poremarks,
				po.status AS postatus,
				po.processstatus AS poprocessstatus,
				sa.studentapp_record_created_date AS sacreateddate,
				sa.intake AS saintake,
				vap.status AS vastatus,
				adf.total_amount AS adminfeeamount,
				rf.total_amount AS refusalfeeamount,
				tf.total_amount AS tuitionfeeamount,
				pf.total_amount AS processingfeeamount,
				osch.total_amount AS oschfeeamount,
				vaf.total_amount AS visaapplicationfeeamount
	        FROM `client` c 
	        LEFT JOIN `programoptions` po ON c.client_id = po.client_id 
	        LEFT JOIN `visa_application` vap ON c.client_id = vap.client_id 
	        LEFT JOIN `student_application` sa ON po.application_id = sa.studentapp_id
			LEFT JOIN education_provider ep ON sa.provider_id = ep.provider_id
			LEFT JOIN schoolprograms sp ON sa.studentapp_course_name = sp.spid
			LEFT JOIN (
				SELECT sap.studentapp_id, GROUP_CONCAT(sp2.program ORDER BY sap.id SEPARATOR ', ') AS programs
				FROM student_application_programs sap
				INNER JOIN schoolprograms sp2 ON sp2.spid = sap.spid
				GROUP BY sap.studentapp_id
			) sap ON sap.studentapp_id = sa.studentapp_id
	        LEFT JOIN officer o ON c.client_officer_id = o.officer_id
	        LEFT JOIN (
	            SELECT client_id, FORMAT(SUM(fee_amount), 2) AS total_amount
                FROM fee_receipts
                WHERE fee_description = 'Admin Fee'
                GROUP BY client_id
	        ) adf ON adf.client_id = c.client_id
	        LEFT JOIN (
	            SELECT client_id, FORMAT(SUM(fee_amount), 2) AS total_amount
                FROM fee_receipts
                WHERE fee_description = 'Refusal Fee'
                GROUP BY client_id
	        ) rf ON rf.client_id = c.client_id
	        LEFT JOIN (
	            SELECT client_id, FORMAT(SUM(fee_amount), 2) AS total_amount
                FROM fee_receipts
                WHERE fee_description = 'Tuition Fee'
                GROUP BY client_id
	        ) tf ON tf.client_id = c.client_id
	        LEFT JOIN (
	            SELECT client_id, FORMAT(SUM(fee_amount), 2) AS total_amount
                FROM fee_receipts
                WHERE fee_description = 'Processing Fee'
                GROUP BY client_id
	        ) pf ON pf.client_id = c.client_id
	        LEFT JOIN (
	            SELECT client_id, FORMAT(SUM(fee_amount), 2) AS total_amount
                FROM fee_receipts
                WHERE fee_description = 'OSCH'
                GROUP BY client_id
	        ) osch ON osch.client_id = c.client_id
	        LEFT JOIN (
	            SELECT client_id, FORMAT(SUM(fee_amount), 2) AS total_amount
                FROM fee_receipts
                WHERE fee_description = 'Visa Application Fee'
                GROUP BY client_id
	        ) vaf ON vaf.client_id = c.client_id
	        WHERE c.client_flag = 'active'
	        ORDER BY c.client_id DESC";
        $query = $this->db->query($sql);
        $result = $query->result();

		$clients_by_id = array();
		$client_ids = array();
		$today = strtotime(date('Y-m-d'));

		$days_until = function($date_value) use ($today) {
			if ($date_value == "" || $date_value == null || $date_value == "0000-00-00" || $date_value == "1900-01-01") {
				return null;
			}
			$timestamp = strtotime($date_value);
			if (!$timestamp) {
				return null;
			}
			return (int) floor(($timestamp - $today) / 86400);
		};

		$add_reason = function(&$client, $score, $label, $type = 'warning') {
			if (!isset($client['reason_index'][$label])) {
				$client['critical_score'] += $score;
				$client['critical_reasons'][] = array(
					'label' => $label,
					'type' => $type,
					'score' => $score
				);
				$client['reason_index'][$label] = true;
			}
		};

		$set_latest = function(&$target, $key, $value) {
			if ($value !== null && $value !== "" && (!isset($target[$key]) || $target[$key] == "")) {
				$target[$key] = $value;
			}
		};

		foreach ($result as $row) {
			$client_id = (int) $row->monitoring_client_id;
			if ($client_id <= 0) {
				continue;
			}

			if (!isset($clients_by_id[$client_id])) {
				$client_ids[] = $client_id;
				$name_parts = array($row->monitoring_client_surname, $row->monitoring_client_firstname, $row->monitoring_client_middlename);
				$name_parts = array_filter($name_parts, function($part) { return $part !== null && $part !== ""; });
				$clients_by_id[$client_id] = array(
					'client_id' => $client_id,
					'name' => implode(', ', array_slice($name_parts, 0, 1)) . (count($name_parts) > 1 ? ', ' . implode(' ', array_slice($name_parts, 1)) : ''),
					'email' => isset($row->monitoring_client_email) ? $row->monitoring_client_email : '',
					'phone' => isset($row->monitoring_client_mobile) && $row->monitoring_client_mobile != "" ? $row->monitoring_client_mobile : (isset($row->monitoring_client_phone) ? $row->monitoring_client_phone : ''),
					'officer' => isset($row->monitoring_officer_name) ? $row->monitoring_officer_name : '',
					'edit_url' => base_url().'index.php/editclientinfo2/'.$client_id,
					'critical_score' => 0,
					'critical_reasons' => array(),
					'reason_index' => array(),
					'summary' => array(
						'po_status' => '',
						'po_process' => '',
						'followup' => '',
						'admission_status' => '',
						'vevo_expiry' => '',
						'visa_status' => '',
						'visa_expiry' => '',
						'date_payment' => ''
					),
					'program_options' => array(),
					'admissions' => array(),
					'visa_applications' => array(),
					'fees' => array(
						'tuition' => isset($row->tuitionfeeamount) ? $row->tuitionfeeamount : '',
						'visa_application' => isset($row->visaapplicationfeeamount) ? $row->visaapplicationfeeamount : '',
						'oshc' => isset($row->oschfeeamount) ? $row->oschfeeamount : '',
						'admin' => isset($row->adminfeeamount) ? $row->adminfeeamount : '',
						'refusal' => isset($row->refusalfeeamount) ? $row->refusalfeeamount : '',
						'processing' => isset($row->processingfeeamount) ? $row->processingfeeamount : ''
					),
					'fee_receipts' => array(),
					'payments' => array(),
					'files' => array()
				);
			}

			$client =& $clients_by_id[$client_id];
			$set_latest($client['summary'], 'po_status', isset($row->postatus) ? $row->postatus : '');
			$set_latest($client['summary'], 'po_process', isset($row->poprocessstatus) ? $row->poprocessstatus : '');
			$set_latest($client['summary'], 'followup', isset($row->pofollowupdate) ? $row->pofollowupdate : '');
			$set_latest($client['summary'], 'admission_status', isset($row->studentapp_flag) ? $row->studentapp_flag : '');
			$set_latest($client['summary'], 'vevo_expiry', isset($row->sa_vevo_expiry_date) ? $row->sa_vevo_expiry_date : '');
			$set_latest($client['summary'], 'visa_status', isset($row->vastatus) ? $row->vastatus : '');
			$set_latest($client['summary'], 'date_payment', isset($row->dateofpayment) ? $row->dateofpayment : '');

			if (isset($row->visa_expiry_year) && $row->visa_expiry_year != "" && $row->visa_expiry_year != "1900") {
				$visa_expiry = $row->visa_expiry_year.'-'.$row->visa_expiry_month.'-'.$row->visa_expiry_day;
				$set_latest($client['summary'], 'visa_expiry', $visa_expiry);
			}

			$program_key = isset($row->poid) && $row->poid != "" ? 'po'.$row->poid : md5($client_id.'|'.(isset($row->poprepdate) ? $row->poprepdate : '').'|'.(isset($row->poremarks) ? $row->poremarks : '').'|'.(isset($row->pointake) ? $row->pointake : ''));
			if ((isset($row->poid) && $row->poid != "") || (isset($row->poprepdate) && $row->poprepdate != "") || (isset($row->poprocessstatus) && $row->poprocessstatus != "")) {
				$client['program_options'][$program_key] = array(
					'date_created' => isset($row->poprepdate) ? $row->poprepdate : '',
					'remarks' => isset($row->poremarks) ? $row->poremarks : '',
					'acceptance_status' => isset($row->postatus) ? $row->postatus : '',
					'process_status' => isset($row->poprocessstatus) ? $row->poprocessstatus : '',
					'followup' => isset($row->pofollowupdate) ? $row->pofollowupdate : '',
					'location' => isset($row->polocation) ? $row->polocation : '',
					'intake' => isset($row->pointake) ? $row->pointake : '',
					'english' => isset($row->poenglishrequirement) ? $row->poenglishrequirement : ''
				);
			}

			$admission_key = isset($row->studentapp_id) && $row->studentapp_id != "" ? 'sa'.$row->studentapp_id : md5($client_id.'|'.(isset($row->sacreateddate) ? $row->sacreateddate : '').'|'.(isset($row->studentapp_flag) ? $row->studentapp_flag : ''));
			if ((isset($row->studentapp_id) && $row->studentapp_id != "") || (isset($row->sacreateddate) && $row->sacreateddate != "") || (isset($row->studentapp_flag) && $row->studentapp_flag != "")) {
				$client['admissions'][$admission_key] = array(
					'date' => isset($row->sacreateddate) ? $row->sacreateddate : '',
					'status' => isset($row->studentapp_flag) ? $row->studentapp_flag : '',
					'vevo_expiry' => isset($row->sa_vevo_expiry_date) ? $row->sa_vevo_expiry_date : '',
					'intake' => isset($row->saintake) ? $row->saintake : '',
					'provider' => isset($row->monitoring_provider_name) ? $row->monitoring_provider_name : '',
					'course' => isset($row->monitoring_program) ? $row->monitoring_program : ''
				);
			}

			$visa_key = isset($row->client_visa_id) && $row->client_visa_id != "" ? 'va'.$row->client_visa_id : md5($client_id.'|'.(isset($row->vastatus) ? $row->vastatus : '').'|'.(isset($row->visadateofsubmission) ? $row->visadateofsubmission : ''));
			if ((isset($row->client_visa_id) && $row->client_visa_id != "") || (isset($row->vastatus) && $row->vastatus != "")) {
				$visa_expiry = '';
				if (isset($row->visa_expiry_year) && $row->visa_expiry_year != "" && $row->visa_expiry_year != "1900") {
					$visa_expiry = $row->visa_expiry_year.'-'.$row->visa_expiry_month.'-'.$row->visa_expiry_day;
				}
				$client['visa_applications'][$visa_key] = array(
					'status' => isset($row->vastatus) ? $row->vastatus : '',
					'submission_date' => isset($row->visadateofsubmission) ? $row->visadateofsubmission : '',
					'result_release' => isset($row->visaresultreleasedate) ? $row->visaresultreleasedate : '',
					'intake' => isset($row->visa_intake) ? $row->visa_intake : '',
					'expiry' => $visa_expiry
				);
			}

			$vevo_days = $days_until(isset($row->sa_vevo_expiry_date) ? $row->sa_vevo_expiry_date : '');
			if ($vevo_days !== null) {
				if ($vevo_days < 0) {
					$add_reason($client, 140, 'VEVO expired '.abs($vevo_days).' day(s) ago', 'danger');
				} elseif ($vevo_days <= 30) {
					$add_reason($client, 120, 'VEVO expires in '.$vevo_days.' day(s)', 'danger');
				} elseif ($vevo_days <= 90) {
					$add_reason($client, 80, 'VEVO expires within 90 days', 'warning');
				}
			}

			$visa_expiry_days = $days_until($client['summary']['visa_expiry']);
			if ($visa_expiry_days !== null) {
				if ($visa_expiry_days < 0) {
					$add_reason($client, 130, 'Visa expired '.abs($visa_expiry_days).' day(s) ago', 'danger');
				} elseif ($visa_expiry_days <= 30) {
					$add_reason($client, 110, 'Visa expires in '.$visa_expiry_days.' day(s)', 'danger');
				} elseif ($visa_expiry_days <= 90) {
					$add_reason($client, 70, 'Visa expires within 90 days', 'warning');
				}
			}

			$followup_days = $days_until(isset($row->pofollowupdate) ? $row->pofollowupdate : '');
			if ($followup_days !== null) {
				if ($followup_days < 0) {
					$add_reason($client, 60, 'Follow-up overdue', 'danger');
				} elseif ($followup_days <= 7) {
					$add_reason($client, 35, 'Follow-up due soon', 'warning');
				}
			}

			$po_process = strtolower(isset($row->poprocessstatus) ? $row->poprocessstatus : '');
			if ($po_process == 'on-hold') {
				$add_reason($client, 70, 'Program option on hold', 'danger');
			} elseif ($po_process == 'withdrawn') {
				$add_reason($client, 85, 'Program option withdrawn', 'danger');
			} elseif ($po_process == 'waiting') {
				$add_reason($client, 35, 'Program option waiting', 'warning');
			}

			$student_status = strtolower(isset($row->studentapp_flag) ? $row->studentapp_flag : '');
			if ($student_status == 'refused') {
				$add_reason($client, 95, 'Admission refused', 'danger');
			} elseif ($student_status == 'withdrawn') {
				$add_reason($client, 80, 'Admission withdrawn', 'danger');
			} elseif ($student_status == 'conditional offer letter') {
				$add_reason($client, 30, 'Conditional offer needs attention', 'warning');
			}

			$visa_status = strtolower(isset($row->vastatus) ? $row->vastatus : '');
			if ($visa_status == 'refused') {
				$add_reason($client, 100, 'Visa refused', 'danger');
			} elseif ($visa_status == 'lodged') {
				$add_reason($client, 30, 'Visa lodged, monitor result', 'info');
			}
			unset($client);
		}

		if (count($client_ids) > 0) {
			if ($this->student_google_drive_table_exists()) {
				$this->db->where_in('client_id', $client_ids);
				$this->db->where('record_type', 'file');
				$this->db->where('is_active', 1);
				$this->db->order_by('created_at', 'DESC');
				$drive_files = $this->db->get('student_google_drive')->result();
				foreach ($drive_files as $file) {
					$file_client_id = (int) $file->client_id;
					if (isset($clients_by_id[$file_client_id])) {
						$clients_by_id[$file_client_id]['files'][] = array(
							'type' => isset($file->document_type) ? $file->document_type : '',
							'date' => isset($file->created_at) ? $file->created_at : '',
							'remarks' => isset($file->drive_file_name) ? $file->drive_file_name : '',
							'link' => isset($file->drive_web_view_link) ? $file->drive_web_view_link : '',
							'source' => 'Google Drive'
						);
					}
				}
			}

			if ($this->db->table_exists('fee_receipts')) {
				$this->db->where_in('client_id', $client_ids);
				$this->db->order_by('fee_date', 'DESC');
				$fee_receipts = $this->db->get('fee_receipts')->result();
				foreach ($fee_receipts as $fee) {
					$fee_client_id = (int) $fee->client_id;
					if (isset($clients_by_id[$fee_client_id])) {
						$clients_by_id[$fee_client_id]['fee_receipts'][] = array(
							'description' => isset($fee->fee_description) ? $fee->fee_description : '',
							'amount' => isset($fee->fee_amount) ? $fee->fee_amount : '',
							'date' => isset($fee->fee_date) ? $fee->fee_date : '',
							'receipt' => isset($fee->fee_receipt) ? $fee->fee_receipt : ''
						);
					}
				}
			}

			if ($this->db->table_exists('payments')) {
				$this->db->select('p.*, m.identity, o.officer_name');
				$this->db->from('payments p');
				$this->db->join('mastersetting m', 'p.paymenttype = m.id', 'left');
				$this->db->join('officer o', 'o.officer_id = p.processedby', 'left');
				$this->db->where_in('p.payee', $client_ids);
				$this->db->where('p.barchived', 0);
				$this->db->order_by('p.paymentdate', 'DESC');
				$payments = $this->db->get()->result();
				foreach ($payments as $payment) {
					$payment_client_id = (int) $payment->payee;
					if (isset($clients_by_id[$payment_client_id])) {
						$clients_by_id[$payment_client_id]['payments'][] = array(
							'type' => isset($payment->identity) ? $payment->identity : '',
							'reference' => isset($payment->referencenumber) ? $payment->referencenumber : '',
							'description' => isset($payment->paymentdescription) ? $payment->paymentdescription : '',
							'amount' => (isset($payment->currency) ? $payment->currency.' ' : '').(isset($payment->amount) ? $payment->amount : ''),
							'date' => isset($payment->paymentdate) ? $payment->paymentdate : '',
							'processed_by' => isset($payment->officer_name) ? $payment->officer_name : ''
						);
					}
				}
			}
		}

		foreach ($clients_by_id as &$client) {
			if (count($client['files']) == 0) {
				$add_reason($client, 10, 'No uploaded files found', 'info');
			}
			if (count($client['critical_reasons']) == 0) {
				$client['critical_reasons'][] = array(
					'label' => 'No critical item detected',
					'type' => 'success',
					'score' => 0
				);
			}
			$client['program_options'] = array_values($client['program_options']);
			$client['admissions'] = array_values($client['admissions']);
			$client['visa_applications'] = array_values($client['visa_applications']);
			unset($client['reason_index']);
		}
		unset($client);

		$monitoring_clients = array_values($clients_by_id);
		usort($monitoring_clients, function($a, $b) {
			if ($a['critical_score'] == $b['critical_score']) {
				return strcmp($a['name'], $b['name']);
			}
			return $b['critical_score'] - $a['critical_score'];
		});

        $sql2 = "SELECT * FROM officer";
        $query2 = $this->db->query($sql2);
        $result2 = $query2->result();

        $asset_url = base_url()."assets/";
		$data['title'] = "Client Monitoring";
		$data['asset_url'] = $asset_url;
		$data['clients'] = $monitoring_clients;
		$data['officer'] = $result2;

		if($this->session->officer_role == "regional manager" || $this->session->officer_role == "admin") {
			$officer_id_check = $this->session->officer_id;
			$sql11 = "SELECT * FROM notifications WHERE seen = 0 ORDER BY notif_id DESC LIMIT 20";
			$query11 = $this->db->query($sql11);
			$notifnum = $query11->num_rows();

			$sql12 = "SELECT * FROM notifications ORDER BY notif_id DESC LIMIT 20";
			$query12 = $this->db->query($sql12);
			$notif = $query12->result();
		} else {
			$officer_id_check = $this->session->officer_id;
			$sql11 = "SELECT * FROM notifications WHERE seen = 0 AND officer_id = '$officer_id_check' ORDER BY notif_id DESC LIMIT 20";
			$query11 = $this->db->query($sql11);
			$notifnum = $query11->num_rows();

			$sql12 = "SELECT * FROM notifications WHERE officer_id = '$officer_id_check' ORDER BY notif_id DESC LIMIT 20";
			$query12 = $this->db->query($sql12);
			$notif = $query12->result();
		}

		$data['notifnum'] = $notifnum;
		$data['notif'] = $notif;

		$this->db->where('privilege_id', $this->session->officer_role_id);
        $query3 = $this->db->get('privilege');

		foreach ($query3->result() as $row3)
		{
		        $data['privilege_manage_clients'] = $row3->privilege_manage_clients;
		        $data['privilege_view_fees'] = $row3->privilege_view_fees;
		        $data['privilege_manage_providers'] = $row3->privilege_manage_providers;
		        $data['privilege_manage_reporting'] = $row3->privilege_manage_reporting;
		        $data['privilege_manage_studentapps'] = $row3->privilege_manage_studentapps;
		}

		if(isset($this->session->officer_name)) {
			$this->load->view('customerinfo/clientmonitoring', $data);
		} else {
			redirect(base_url()."?error3=1");
		}
	    
	}

}
