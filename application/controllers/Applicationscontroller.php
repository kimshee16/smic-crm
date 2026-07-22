<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Applicationscontroller extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->helper('form');
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

	private function normalize_program_ids($programs)
	{
		if (!is_array($programs)) {
			$programs = array($programs);
		}

		$program_ids = array();
		foreach ($programs as $program) {
			$program = trim($program);
			if ($program !== '' && !in_array($program, $program_ids)) {
				$program_ids[] = $program;
			}
		}

		return $program_ids;
	}

	private function get_primary_program($program_ids)
	{
		if (count($program_ids) == 0) {
			return array('spid' => '', 'programtype' => '');
		}

		$this->db->where('spid', $program_ids[0]);
		$query = $this->db->get('schoolprograms', 1);
		$program = $query->row();

		if (!$program) {
			return array('spid' => '', 'programtype' => '');
		}

		return array('spid' => $program->spid, 'programtype' => $program->programtype == null ? '' : $program->programtype);
	}

	private function save_student_application_programs($studentapp_id, $program_ids)
	{
		$this->ensure_student_application_programs_table();

		$this->db->where('studentapp_id', $studentapp_id);
		$this->db->delete('student_application_programs');

		if (count($program_ids) == 0) {
			return;
		}

		$this->db->where_in('spid', $program_ids);
		$query = $this->db->get('schoolprograms');
		$programs = array();
		foreach ($query->result() as $program) {
			$programs[$program->spid] = $program;
		}

		foreach ($program_ids as $program_id) {
			if (!isset($programs[$program_id])) {
				continue;
			}

			$this->db->insert('student_application_programs', array(
				'studentapp_id' => $studentapp_id,
				'spid' => $program_id,
				'programtype' => $programs[$program_id]->programtype == null ? '' : $programs[$program_id]->programtype,
				'date_created' => date('Y-m-d H:i:s')
			));
		}
	}

	private function get_student_application_program_ids($studentapp_id)
	{
		$this->ensure_student_application_programs_table();

		$this->db->select('spid');
		$this->db->where('studentapp_id', $studentapp_id);
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get('student_application_programs');
		$program_ids = array();
		foreach ($query->result() as $row) {
			$program_ids[] = $row->spid;
		}

		return $program_ids;
	}

	public function index()
	{
		$this->ensure_student_application_programs_table();

		$sql = "SELECT sa.*, s.*, c.*, sa.intake AS saintake, COALESCE(sap.programs, sp.program, sa.studentapp_course_name) AS program FROM student_application sa inner join education_provider s on sa.provider_id = s.provider_id inner join client c on c.client_id = sa.client_id left join schoolprograms sp on sa.studentapp_course_name = sp.spid LEFT JOIN (SELECT sap.studentapp_id, GROUP_CONCAT(sp2.program ORDER BY sap.id SEPARATOR ', ') AS programs FROM student_application_programs sap INNER JOIN schoolprograms sp2 ON sp2.spid = sap.spid GROUP BY sap.studentapp_id) sap ON sap.studentapp_id = sa.studentapp_id ORDER BY sa.studentapp_id DESC";
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
		$this->ensure_student_application_programs_table();

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
		$data['selected_program_ids'] = $this->get_student_application_program_ids($appid);
		if (count($data['selected_program_ids']) == 0) {
			foreach ($application as $row4) {
				if ($row4->studentapp_course_name != '') {
					$data['selected_program_ids'][] = $row4->studentapp_course_name;
				}
			}
		}

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

		$program_ids = $this->normalize_program_ids($this->input->post('program'));
		$primary_program = $this->get_primary_program($program_ids);
		$programname = $primary_program['spid'];
		$programtype = $primary_program['programtype'];

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
		$this->db->trans_start();
		$this->db->insert('student_application', $data);
		$this->save_student_application_programs($this->db->insert_id(), $program_ids);
		$this->db->trans_complete();

		redirect('editclientinfo2/'.$this->input->post('clientid')."/admission");
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

		$program_ids = $this->normalize_program_ids($this->input->post('program'));
		$primary_program = $this->get_primary_program($program_ids);
		$programname = $primary_program['spid'];
		$programtype = $primary_program['programtype'];

		$this->db->trans_start();
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
		$this->save_student_application_programs($this->input->post('studentapp_id'), $program_ids);
		$this->db->trans_complete();

		redirect('editclientinfo2/'.$this->input->post('clientid')."/admission");
	}

	public function deleteapplication($app_id)
	{
		$this->ensure_student_application_programs_table();
		$this->db->where('studentapp_id', $app_id);
		$this->db->delete('student_application_programs');

		$this->db->where('studentapp_id', $app_id);
		$this->db->delete('student_application');
		
		redirect('applications');
	}

	public function deleteapplicationfromcinfo($app_id, $client_id)
	{
		$this->ensure_student_application_programs_table();
		$this->db->where('studentapp_id', $app_id);
		$this->db->delete('student_application_programs');

		$this->db->where('studentapp_id', $app_id);
		$this->db->delete('student_application');
		
		redirect('editclientinfo2/'.$client_id);
	}

}
