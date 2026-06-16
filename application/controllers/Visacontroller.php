<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Visacontroller extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->helper('form');
	}

	public function newvisaapplication($id) {
		$asset_url = base_url()."assets/";
		$data['title'] = "New Visa Application";
		$data['asset_url'] = $asset_url;

	    $sql3 = "SELECT * FROM client where client_id = '$id'";
	    $query3 = $this->db->query($sql3);
	    $singleclient = $query3->result();

	    $data['singleclient'] = $singleclient;

	    $this->db->where('privilege_id', $this->session->officer_role_id);
        $query3 = $this->db->get('privilege');

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

		foreach ($query3->result() as $row3)
		{
		        $data['privilege_manage_clients'] = $row3->privilege_manage_clients;
		        $data['privilege_view_fees'] = $row3->privilege_view_fees;
		        $data['privilege_manage_providers'] = $row3->privilege_manage_providers;
		        $data['privilege_manage_reporting'] = $row3->privilege_manage_reporting;
		        $data['privilege_manage_studentapps'] = $row3->privilege_manage_studentapps;
		}

		if($this->session->officer_role == "") {
			redirect(base_url()."index.php/messages");
		} else {
			if(isset($this->session->officer_name)) {
				$this->load->view('visa/newvisaapplication', $data);
			} else {
				redirect(base_url()."?error3=1");
			}
		}

	}

	public function newvisaeoi($id) {
		$asset_url = base_url()."assets/";
		$data['title'] = "New Visa EOI";
		$data['asset_url'] = $asset_url;

	    $sql3 = "SELECT * FROM client where client_id = '$id'";
	    $query3 = $this->db->query($sql3);
	    $singleclient = $query3->result();

	    $data['singleclient'] = $singleclient;

	    $this->db->where('privilege_id', $this->session->officer_role_id);
        $query3 = $this->db->get('privilege');

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

		foreach ($query3->result() as $row3)
		{
		        $data['privilege_manage_clients'] = $row3->privilege_manage_clients;
		        $data['privilege_view_fees'] = $row3->privilege_view_fees;
		        $data['privilege_manage_providers'] = $row3->privilege_manage_providers;
		        $data['privilege_manage_reporting'] = $row3->privilege_manage_reporting;
		        $data['privilege_manage_studentapps'] = $row3->privilege_manage_studentapps;
		}

		if($this->session->officer_role == "") {
			redirect(base_url()."index.php/messages");
		} else {
			if(isset($this->session->officer_name)) {
				$this->load->view('visa/newvisaeoi', $data);
			} else {
				redirect(base_url()."?error3=1");
			}
		}

	}

	public function newvisaaccount($client_id) {
		$asset_url = base_url()."assets/";
		$data['title'] = "New Visa Account";
		$data['asset_url'] = $asset_url;

	   // $data['client_visa_id'] = $id;
	    $data['client_id'] = $client_id;
	    
	    $sql3 = "SELECT * FROM visa_application where client_id = '$client_id'";
	    $query3 = $this->db->query($sql3);
	    $visa_application = $query3->result();

	    $this->db->where('privilege_id', $this->session->officer_role_id);
        $query3 = $this->db->get('privilege');

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
		$data['visa_application'] = $visa_application;

		foreach ($query3->result() as $row3)
		{
		        $data['privilege_manage_clients'] = $row3->privilege_manage_clients;
		        $data['privilege_view_fees'] = $row3->privilege_view_fees;
		        $data['privilege_manage_providers'] = $row3->privilege_manage_providers;
		        $data['privilege_manage_reporting'] = $row3->privilege_manage_reporting;
		        $data['privilege_manage_studentapps'] = $row3->privilege_manage_studentapps;
		}

		if($this->session->officer_role == "") {
			redirect(base_url()."index.php/messages");
		} else {
			if(isset($this->session->officer_name)) {
				$this->load->view('visa/newvisaaccount', $data);
			} else {
				redirect(base_url()."?error3=1");
			}
		}
	}

	public function savevisaapplication()
	{
		if($this->input->post('visaexpirydate') == "") {
			$visaexpirydateyear = "1900";
	    	$visaexpirydatemonth = "01";
	    	$visaexpirydateday = "01";
		} else {
			$visaexpirydate = DateTime::createFromFormat("Y-m-d", $this->input->post('visaexpirydate'));
	    	$visaexpirydateyear = $visaexpirydate->format("Y");
	    	$visaexpirydatemonth = $visaexpirydate->format("m");
	    	$visaexpirydateday = $visaexpirydate->format("d");
		}
		
		if($this->input->post('visaexpirydate') == "") {
			$visaafplodgeddateyear = "1900";
	    	$visaafplodgeddatemonth = "01";
	    	$visaafplodgeddateday = "01";
		} else {
			$visaafplodgeddate = DateTime::createFromFormat("Y-m-d", $this->input->post('visaafplodgeddate'));
	    	$visaafplodgeddateyear = $visaafplodgeddate->format("Y");
	    	$visaafplodgeddatemonth = $visaafplodgeddate->format("m");
	    	$visaafplodgeddateday = $visaafplodgeddate->format("d");
		}
    	
    	if($this->input->post('visaexpirydate') == "") {
			$visalodgeddateyear = "1900";
	    	$visalodgeddatemonth = "01";
	    	$visalodgeddateday = "01";
		} else {
			$visalodgeddate = DateTime::createFromFormat("Y-m-d", $this->input->post('visalodgeddate'));
	    	$visalodgeddateyear = $visalodgeddate->format("Y");
	    	$visalodgeddatemonth = $visalodgeddate->format("m");
	    	$visalodgeddateday = $visalodgeddate->format("d");
		}
    	
    	if($this->input->post('visaexpirydate') == "") {
			$visacriticaldateyear = "1900";
	    	$visacriticaldatemonth = "01";
	    	$visacriticaldateday = "01";
		} else {
			$visacriticaldate = DateTime::createFromFormat("Y-m-d", $this->input->post('visacriticaldate'));
	    	$visacriticaldateyear = $visacriticaldate->format("Y");
	    	$visacriticaldatemonth = $visacriticaldate->format("m");
	    	$visacriticaldateday = $visacriticaldate->format("d");
		}

    	if($this->input->post('visaexpirydate') == "") {
			$skillassessmentlodgeddateyear = "1900";
	    	$skillassessmentlodgeddatemonth = "01";
	    	$skillassessmentlodgeddateday = "01";
		} else {
			$skillassessmentlodgeddate = DateTime::createFromFormat("Y-m-d", $this->input->post('skillassessmentlodgeddate'));
	    	$skillassessmentlodgeddateyear = $skillassessmentlodgeddate->format("Y");
	    	$skillassessmentlodgeddatemonth = $skillassessmentlodgeddate->format("m");
	    	$skillassessmentlodgeddateday = $skillassessmentlodgeddate->format("d");
		}

    	if($this->input->post('visaexpirydate') == "") {
			$englishtestdateyear = "1900";
	    	$englishtestdatemonth = "01";
	    	$englishtestdateday = "01";
		} else {
			$englishtestdate = DateTime::createFromFormat("Y-m-d", $this->input->post('englishtestdate'));
	    	$englishtestdateyear = $englishtestdate->format("Y");
	    	$englishtestdatemonth = $englishtestdate->format("m");
	    	$englishtestdateday = $englishtestdate->format("d");
		}

    	if($this->input->post('visaexpirydate') == "") {
			$visadecisiondateyear = "1900";
	    	$visadecisiondatemonth = "01";
	    	$visadecisiondateday = "01";
		} else {
			$visadecisiondate = DateTime::createFromFormat("Y-m-d", $this->input->post('visadecisiondate'));
	    	$visadecisiondateyear = $visadecisiondate->format("Y");
	    	$visadecisiondatemonth = $visadecisiondate->format("m");
	    	$visadecisiondateday = $visadecisiondate->format("d");
		}
    	
		$data = array(
					'client_id' => $this->input->post('clientid'),
					'new_Visa_subclass' => $this->input->post('visasubclass'),
					'visa_expiry_day' => $visaexpirydateday,
					'visa_expiry_month' => $visaexpirydatemonth,
					'visa_expiry_year' => $visaexpirydateyear,
					'visa_afp_lodged_day' => $visaafplodgeddateday,
					'visa_afp_lodged_month' => $visaafplodgeddatemonth,
					'visa_afp_lodged_year' => $visaafplodgeddateyear,
					'visa_lodged_day' => $visalodgeddateday,
					'visa_lodged_month' => $visalodgeddatemonth,
					'visa_lodged_year' => $visalodgeddateyear,
					'visa_critical_day' => $visacriticaldateday,
					'visa_critical_month' => $visacriticaldatemonth,
					'visa_critical_year' => $visacriticaldateyear,
					'current_visa_subclass_held' => $this->input->post('visasubclassheld'),
					'visa_description' => $this->input->post('description'),
					'name_of_dependents' => $this->input->post('nameofdependents'),
					'costs_agreement_issued' => $this->input->post('costagreementissued'),
					'costs_agreement_signed' => $this->input->post('costagreementsigned'),
					'skills_assessment_lodged_day' => $skillassessmentlodgeddateday,
					'skills_assessment_lodged_month' => $skillassessmentlodgeddatemonth,
					'skills_assessment_lodged_year' => $skillassessmentlodgeddateyear,
					'english_test_day' => $englishtestdateday,
					'english_test_month' => $englishtestdatemonth,
					'english_test_year' => $englishtestdateyear,
					'visa_decision_day' => $visadecisiondateday,
					'visa_decision_month' => $visadecisiondatemonth,
					'visa_decision_year' => $visadecisiondateyear,
					'status' => $this->input->post('flag'),
					'visa_other_notes' => $this->input->post('notes'),
					'visadateofsubmission' => $this->input->post('visadateofsubmission'),
					'visaresultreleasedate' => $this->input->post('visaresultreleasedate'),
					'visa_intake' => $this->input->post('visa_intake')
				);
		$this->db->insert('visa_application', $data);
		redirect('editclientinfo2/'.$this->input->post('clientid')."#finalization");
	}

	public function savevisaeoi()
	{
		if($this->input->post('preferreddate') == "") {
			$preferreddate = "1900-01-01";
		} else {
			$preferreddate = $this->input->post('preferreddate');
		}

		if($this->input->post('skillassessmentdate') == "") {
			$skillassessmentdate = "1900-01-01";
		} else {
			$skillassessmentdate = $this->input->post('skillassessmentdate');
		}

		if($this->input->post('pycompletiondate') == "") {
			$pycompletiondate = "1900-01-01";
		} else {
			$pycompletiondate = $this->input->post('pycompletiondate');
		}

		if($this->input->post('englishcompetencytestdate') == "") {
			$englishcompetencytestdate = "1900-01-01";
		} else {
			$englishcompetencytestdate = $this->input->post('englishcompetencytestdate');
		}

		$data = array(
					'client_id' => $this->input->post('clientid'),
					'eoi_number' => $this->input->post('eoinumber'),
					'nominated_occupation' => $this->input->post('occupation'),
					'visa_subclasses' => $this->input->post('visasubclass'),
					'eoi_created_date' => date("Y-m-d"),
					'eoi_submitted_date' => date("Y-m-d"),
					'preferred_date' => $preferreddate,
					'skill_assessment_date' => $skillassessmentdate,
					'py_completion_date' => $pycompletiondate,
					'english_competency_test_date' => $englishcompetencytestdate,
					'english_competency_level' => $this->input->post('englishcompetencylevel'),
					'notes' => $this->input->post('notes'),
					'flag' => $this->input->post('flag')
				);
		$this->db->insert('expression_of_interest', $data);
		redirect('editclientinfo2/'.$this->input->post('clientid')."#finalization");
	}

	public function savevisaaccount()
	{
		if($this->input->post('receiveddate') == "") {
			$receiveddate = "1900-01-01";
		} else {
			$receiveddate = $this->input->post('receiveddate');
		}

		if($this->input->post('disburseddate') == "") {
			$disburseddate = "1900-01-01";
		} else {
			$disburseddate = $this->input->post('disburseddate');
		}

		$data = array(
					'client_visa_id' => $this->input->post('clientvisaid'),
					'description' => $this->input->post('description'),
					'received_date' => $receiveddate,
					'received_amount_ex_gst' => $this->input->post('receivedamountexgst'),
					'received_gst' => $this->input->post('receivedgst'),
					'disbursed_date' => $disburseddate,
					'disbursed_amount_ex_gst' => $this->input->post('disbursedamountexgst'),
					'disbursed_gst' => $this->input->post('dispursedgst')
				);
		$this->db->insert('visa_accounts', $data);
		redirect('editclientinfo2/'.$this->input->post('clientid')."#finalization");
	}

	public function editvisaapplication($id) {
		$asset_url = base_url()."assets/";
		$data['title'] = "Edit Visa Application";
		$data['asset_url'] = $asset_url;

	    $sql1 = "SELECT * FROM visa_application vap inner join client c on vap.client_id = c.client_id where vap.client_visa_id = '$id'";
	    $query1 = $this->db->query($sql1);
	    $visa_application = $query1->result();

	    $data['visa_application'] = $visa_application;

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

		if($this->session->officer_role == "") {
			redirect(base_url()."index.php/messages");
		} else {
			if(isset($this->session->officer_name)) {
				$this->load->view('visa/editvisaapplication', $data);
			} else {
				redirect(base_url()."?error3=1");
			}
		}
	}

	public function editvisaeoi($id) {
		$asset_url = base_url()."assets/";
		$data['title'] = "Edit Visa EOI";
		$data['asset_url'] = $asset_url;

	    $sql1 = "SELECT * FROM expression_of_interest eoi inner join client c on eoi.client_id = c.client_id where eoi.eoi_id = '$id'";
	    $query1 = $this->db->query($sql1);
	    $eoi = $query1->result();

	    $data['eoi'] = $eoi;

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

		if($this->session->officer_role == "") {
			redirect(base_url()."index.php/messages");
		} else {
			if(isset($this->session->officer_name)) {
				$this->load->view('visa/editvisaeoi', $data);
			} else {
				redirect(base_url()."?error3=1");
			}
		}
	}

	public function editvisaaccount($id, $client_id) {
		$asset_url = base_url()."assets/";
		$data['title'] = "Edit Visa Account";
		$data['asset_url'] = $asset_url;

	    $sql1 = "SELECT * FROM visa_accounts WHERE visa_account_id = '$id'";
	    $query1 = $this->db->query($sql1);
	    $visa_accounts = $query1->result();
	    
	    $sql3 = "SELECT * FROM visa_application where client_id = '$client_id'";
	    $query3 = $this->db->query($sql3);
	    $visa_application = $query3->result();

	    $data['visa_accounts'] = $visa_accounts;
	    $data['client_id'] = $client_id;

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
		$data['visa_application'] = $visa_application;

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

		if($this->session->officer_role == "") {
			redirect(base_url()."index.php/messages");
		} else {
			if(isset($this->session->officer_name)) {
				$this->load->view('visa/editvisaaccount', $data);
			} else {
				redirect(base_url()."?error3=1");
			}
		}
	}

	public function updatevisaapplication()
	{
		$visaexpirydate = DateTime::createFromFormat("Y-m-d", $this->input->post('visaexpirydate'));
    	$visaexpirydateyear = $visaexpirydate->format("Y");
    	$visaexpirydatemonth = $visaexpirydate->format("m");
    	$visaexpirydateday = $visaexpirydate->format("d");

    	$visaafplodgeddate = DateTime::createFromFormat("Y-m-d", $this->input->post('visaafplodgeddate'));
    	$visaafplodgeddateyear = $visaafplodgeddate->format("Y");
    	$visaafplodgeddatemonth = $visaafplodgeddate->format("m");
    	$visaafplodgeddateday = $visaafplodgeddate->format("d");

    	$visalodgeddate = DateTime::createFromFormat("Y-m-d", $this->input->post('visalodgeddate'));
    	$visalodgeddateyear = $visalodgeddate->format("Y");
    	$visalodgeddatemonth = $visalodgeddate->format("m");
    	$visalodgeddateday = $visalodgeddate->format("d");

    	$visacriticaldate = DateTime::createFromFormat("Y-m-d", $this->input->post('visacriticaldate'));
    	$visacriticaldateyear = $visacriticaldate->format("Y");
    	$visacriticaldatemonth = $visacriticaldate->format("m");
    	$visacriticaldateday = $visacriticaldate->format("d");

    	$skillassessmentlodgeddate = DateTime::createFromFormat("Y-m-d", $this->input->post('skillassessmentlodgeddate'));
    	$skillassessmentlodgeddateyear = $skillassessmentlodgeddate->format("Y");
    	$skillassessmentlodgeddatemonth = $skillassessmentlodgeddate->format("m");
    	$skillassessmentlodgeddateday = $skillassessmentlodgeddate->format("d");

    	$englishtestdate = DateTime::createFromFormat("Y-m-d", $this->input->post('englishtestdate'));
    	$englishtestdateyear = $englishtestdate->format("Y");
    	$englishtestdatemonth = $englishtestdate->format("m");
    	$englishtestdateday = $englishtestdate->format("d");

    	$visadecisiondate = DateTime::createFromFormat("Y-m-d", $this->input->post('visadecisiondate'));
    	$visadecisiondateyear = $visadecisiondate->format("Y");
    	$visadecisiondatemonth = $visadecisiondate->format("m");
    	$visadecisiondateday = $visadecisiondate->format("d");

		$this->db->set('new_Visa_subclass', $this->input->post('visasubclass'));
		$this->db->set('visa_expiry_day', $visaexpirydateday);
		$this->db->set('visa_expiry_month', $visaexpirydatemonth);
		$this->db->set('visa_expiry_year', $visaexpirydateyear);
		$this->db->set('visa_afp_lodged_day', $visaafplodgeddateday);
		$this->db->set('visa_afp_lodged_month', $visaafplodgeddatemonth);
		$this->db->set('visa_afp_lodged_year', $visaafplodgeddateyear);
		$this->db->set('visa_lodged_day', $visalodgeddateday);
		$this->db->set('visa_lodged_month', $visalodgeddatemonth);
		$this->db->set('visa_lodged_year', $visalodgeddateyear);
		$this->db->set('visa_critical_day', $visacriticaldateday);
		$this->db->set('visa_critical_month', $visacriticaldatemonth);
		$this->db->set('visa_critical_year', $visacriticaldateyear);
		$this->db->set('current_visa_subclass_held', $this->input->post('visasubclassheld'));
		$this->db->set('visa_description', $this->input->post('description'));
		$this->db->set('name_of_dependents', $this->input->post('nameofdependents'));
		$this->db->set('costs_agreement_issued', $this->input->post('costagreementissued'));
		$this->db->set('costs_agreement_signed', $this->input->post('costagreementsigned'));
		$this->db->set('skills_assessment_lodged_day', $skillassessmentlodgeddateday);
		$this->db->set('skills_assessment_lodged_month', $skillassessmentlodgeddatemonth);
		$this->db->set('skills_assessment_lodged_year', $skillassessmentlodgeddateyear);
		$this->db->set('english_test_day', $englishtestdateday);
		$this->db->set('english_test_month', $englishtestdatemonth);
		$this->db->set('english_test_year', $englishtestdateyear);
		$this->db->set('visa_decision_day', $visadecisiondateday);
		$this->db->set('visa_decision_month', $visadecisiondatemonth);
		$this->db->set('visa_decision_year', $visadecisiondateyear);
		$this->db->set('status', $this->input->post('flag'));
		$this->db->set('visa_other_notes', $this->input->post('notes'));
		$this->db->set('visadateofsubmission', $this->input->post('visadateofsubmission'));
		$this->db->set('visaresultreleasedate', $this->input->post('visaresultreleasedate'));
		$this->db->set('visa_intake', $this->input->post('visa_intake'));
		$this->db->where('client_visa_id', $this->input->post('clientvisaid'));
		$this->db->update('visa_application');

		redirect('editclientinfo2/'.$this->input->post('clientid')."#finalization");
	}

	public function updatevisaeoi()
	{

		$this->db->set('eoi_number', $this->input->post('eoinumber'));
		$this->db->set('nominated_occupation', $this->input->post('occupation'));
		$this->db->set('visa_subclasses', $this->input->post('visasubclass'));
		$this->db->set('preferred_date', $this->input->post('preferreddate'));
		$this->db->set('skill_assessment_date', $this->input->post('skillassessmentdate'));
		$this->db->set('py_completion_date', $this->input->post('pycompletiondate'));
		$this->db->set('english_competency_test_date', $this->input->post('englishcompetencytestdate'));
		$this->db->set('english_competency_level', $this->input->post('englishcompetencylevel'));
		$this->db->set('notes', $this->input->post('notes'));
		$this->db->set('flag', $this->input->post('flag'));
		$this->db->where('eoi_id', $this->input->post('eoiid'));
		$this->db->update('expression_of_interest');

		redirect('editclientinfo2/'.$this->input->post('clientid')."#finalization");
	}

	public function updatevisaaccount()
	{

		$this->db->set('description', $this->input->post('description'));
		$this->db->set('received_date', $this->input->post('receiveddate'));
		$this->db->set('received_amount_ex_gst', $this->input->post('receivedamountexgst'));
		$this->db->set('received_gst', $this->input->post('receivedgst'));
		$this->db->set('disbursed_date', $this->input->post('disburseddate'));
		$this->db->set('disbursed_amount_ex_gst', $this->input->post('disbursedamountexgst'));
		$this->db->set('disbursed_gst', $this->input->post('dispursedgst'));
		$this->db->where('visa_account_id', $this->input->post('visaaccountid'));
		$this->db->update('visa_accounts');

		redirect('editclientinfo2/'.$this->input->post('clientid')."#result");
	}

	public function deletevisaapplication($vapid, $client_id)
	{
		$this->db->where('client_visa_id', $vapid);
		$this->db->delete('visa_application');
		//echo json_encode("Successfully done reset!");
		redirect(base_url()."index.php/editclientinfo2/".$client_id);
	}

	public function deletevisaeoi($eoiid, $client_id)
	{
		$this->db->where('eoi_id', $eoiid);
		$this->db->delete('expression_of_interest');
		//echo json_encode("Successfully done reset!");
		redirect(base_url()."index.php/editclientinfo2/".$client_id);
	}

	public function deletevisaaccount($vacid, $client_id)
	{
		$this->db->where('visa_account_id', $vacid);
		$this->db->delete('visa_accounts');
		//echo json_encode("Successfully done reset!");
		redirect(base_url()."index.php/editclientinfo2/".$client_id);
	}


}