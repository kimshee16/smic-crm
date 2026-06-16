<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Applicationscontroller extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->helper('form');
	}

	public function index()
	{

		$sql = "SELECT *, sa.intake AS saintake FROM student_application sa inner join education_provider s on sa.provider_id = s.provider_id inner join client c on c.client_id = sa.client_id left join schoolprograms sp on sa.studentapp_course_name = sp.spid ORDER BY studentapp_id DESC";
        $query = $this->db->query($sql);
        $result = $query->result();

        $asset_url = base_url()."assets/";
		$data['title'] = "Applications";
		$data['asset_url'] = $asset_url;
		$data['applications'] = $result;

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
				$this->load->view('applications/index', $data);
			} else {
				redirect(base_url()."?error3=1");
			}
		}
	}

	public function newapplication($id) {
		$asset_url = base_url()."assets/";
		$data['title'] = "New Application";
		$data['asset_url'] = $asset_url;

	    $sql2 = "SELECT * FROM education_provider";
	    $query2 = $this->db->query($sql2);
	    $schools = $query2->result();

	    $sql3 = "SELECT * FROM client where client_id = '$id'";
	    $query3 = $this->db->query($sql3);
	    $singleclient = $query3->result();
	    
	    $data['singleclient'] = $singleclient;
		$data['schools'] = $schools;

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
				$this->load->view('applications/newapplication', $data);
			} else {
				redirect(base_url()."?error3=1");
			}
		}
	}

	public function editapplication($appid) {
		$asset_url = base_url()."assets/";
		$data['title'] = "Edit Application";
		$data['asset_url'] = $asset_url;

	    $sql2 = "SELECT * FROM education_provider";
	    $query2 = $this->db->query($sql2);
	    $schools = $query2->result();

	    $sql3 = "SELECT * FROM student_application sa inner join client c on sa.client_id = c.client_id inner join education_provider s on s.provider_id = sa.provider_id where sa.studentapp_id = '$appid'";
	    $query3 = $this->db->query($sql3);
	    $application = $query3->result();
	    
	    foreach($application as $row4) {
	        $providerid = $row4->provider_id;
	        $sql4 = "SELECT * FROM schoolprograms sp where sp.provider_id = '$providerid'";
    	    $query4 = $this->db->query($sql4);
    	    $programs = $query4->result();
	    }

	    $data['application'] = $application;
		$data['schools'] = $schools;
		$data['programs'] = $programs;

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
				$this->load->view('applications/editapplication', $data);
			} else {
				redirect(base_url()."?error3=1");
			}
		}
	}

	public function getprogramfromschool($schoolid) {
		$sql3 = "SELECT * FROM schoolprograms where provider_id = $schoolid";
	    $query3 = $this->db->query($sql3);
	    $program = $query3->result();
	    echo json_encode($program);
	}

	public function saveapplication()
	{
		$startdate = $this->input->post('startdate');
		$time1 = strtotime($startdate);
		$month1 = date("m",$time1);
		$year1 = date("Y",$time1);
		$day1 = date("d",$time1);

		$enddate = $this->input->post('enddate');
		$time2 = strtotime($enddate);
		$month2 = date("m",$time2);
		$year2 = date("Y",$time2);
		$day2 = date("d",$time2);

		$coedate = $this->input->post('coedate');
		$time3 = strtotime($coedate);
		$month3 = date("m",$time3);
		$year3 = date("Y",$time3);
		$day3 = date("d",$time3);

		$program = $this->input->post('program');
		$sql = "SELECT * FROM schoolprograms WHERE spid = '$program'";
        $query = $this->db->query($sql);
        $programs = $query->result();

        foreach($programs as $programrows) {
        	$programname = $programrows->spid;
        	$programtype = $programrows->programtype;
        }

		$data = array(
					'client_id' => $this->input->post('clientid'),
					'officer_id' => $this->session->userdata('officer_id'),
					'provider_id' => $this->input->post('school'),
					'studentapp_record_created_date' => date('Y-m-d'),
					'studentapp_course_starting_day' => $day1,
					'studentapp_course_starting_month' => $month1,
					'studentapp_course_starting_year' => $year1,
					'studentapp_course_end_day' => $day2,
					'studentapp_course_end_month' => $month2,
					'studentapp_course_end_year' => $year2,
					'studentapp_course_name' => $programname,
					'studentapp_course_level' => $programtype,
					'studentapp_coe_day' => $day3,
					'studentapp_coe_month' => $month3,
					'studentapp_coe_year' => $year3,
					'studentapp_visa_lodged_day' => '',
					'studentapp_visa_lodged_month' => '',
					'studentapp_visa_lodged_year' => '',
					'studentapp_visa_status' => '',
					'studentapp_documents_pending' => '',
					'studentapp_comments' => '',
					'studentapp_flag' => 'Submitted',
					'studentapp_invoice_processed_flag' => '',
					'studentapp_student_no' => '',
					'course_starting_date' => $this->input->post('startdate'),
					'course_ending_date' => $this->input->post('enddate'),
					'offices_id' => 0,
					'subagent_id' => 0,
					'staff_invoice_no' => '',
					'staff_invoice_no2' => '',
					'studentapp_event_id' => 0,
					'intake' => $this->input->post('intake'),
					'remarks' => $this->input->post('remarks'),
					'campus' => $this->input->post('campus')
				);
		$this->db->insert('student_application', $data);

		redirect('editclientinfo2/'.$this->input->post('clientid')."#admission");
	}
    
	public function updateapplication()
	{
		$startdate = $this->input->post('startdate');
		$time1 = strtotime($startdate);
		$month1 = date("m",$time1);
		$year1 = date("Y",$time1);
		$day1 = date("d",$time1);

		$enddate = $this->input->post('enddate');
		$time2 = strtotime($enddate);
		$month2 = date("m",$time2);
		$year2 = date("Y",$time2);
		$day2 = date("d",$time2);

		$coedate = $this->input->post('coedate');
		$time3 = strtotime($coedate);
		$month3 = date("m",$time3);
		$year3 = date("Y",$time3);
		$day3 = date("d",$time3);

		$program = $this->input->post('program');
		$sql = "SELECT * FROM schoolprograms WHERE spid = '$program'";
        $query = $this->db->query($sql);
        $programs = $query->result();

        foreach($programs as $programrows) {
        	$programname = $programrows->spid;
        	$programtype = $programrows->programtype;
        }

		$this->db->set('provider_id', $this->input->post('school'));
		$this->db->set('studentapp_course_starting_day', $day1);
		$this->db->set('studentapp_course_starting_month', $month1);
		$this->db->set('studentapp_course_starting_year', $year1);
		$this->db->set('studentapp_course_end_day', $day2);
		$this->db->set('studentapp_course_end_month', $month2);
		$this->db->set('studentapp_course_end_year', $year2);
		$this->db->set('studentapp_course_name', $programname);
		$this->db->set('studentapp_course_level', $programtype);
		$this->db->set('studentapp_coe_day', $day3);
		$this->db->set('studentapp_coe_month', $month3);
		$this->db->set('studentapp_coe_year',$year3);
		$this->db->set('studentapp_flag', $this->input->post('flag'));
		$this->db->set('course_starting_date', $this->input->post('state'));
		$this->db->set('course_ending_date', $this->input->post('startdate'));
		$this->db->set('intake', $this->input->post('intake'));
		$this->db->set('remarks', $this->input->post('remarks'));
		$this->db->set('campus', $this->input->post('campus'));
		$this->db->where('studentapp_id', $this->input->post('studentapp_id'));
		$this->db->update('student_application');

		redirect('editclientinfo2/'.$this->input->post('clientid')."#admission");
	}

	public function deleteapplication($app_id)
	{
		$this->db->where('studentapp_id', $app_id);
		$this->db->delete('student_application');
		
		redirect('applications');
	}

	public function deleteapplicationfromcinfo($app_id, $client_id)
	{
		$this->db->where('studentapp_id', $app_id);
		$this->db->delete('student_application');
		
		redirect('editclientinfo2/'.$client_id);
	}

}