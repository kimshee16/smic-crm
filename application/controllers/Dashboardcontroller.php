<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboardcontroller extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->helper('form');
	}

	private function officer_can_view_all_tasks()
	{
		return $this->session->officer_role == "regional manager" || $this->session->officer_role == "admin";
	}

	private function clean_client_name($row)
	{
		$name = trim((isset($row->client_firstname) ? $row->client_firstname : '').' '.(isset($row->client_middlename) ? $row->client_middlename : '').' '.(isset($row->client_surname) ? $row->client_surname : ''));
		$name = preg_replace('/\s+/', ' ', $name);
		return $name != '' ? $name : 'Client #'.$row->client_id;
	}

	private function valid_db_date($date)
	{
		if ($date == '' || $date == null || $date == '0000-00-00' || $date == '0001-01-01') {
			return false;
		}

		return strtotime($date) !== false && strtotime($date) > strtotime('1900-01-01');
	}

	private function date_from_parts($year, $month, $day)
	{
		$year = (int) $year;
		$month = (int) $month;
		$day = (int) $day;

		if ($year <= 1900 || $month < 1 || $day < 1 || !checkdate($month, $day, $year)) {
			return '';
		}

		return sprintf('%04d-%02d-%02d', $year, $month, $day);
	}

	private function days_from_today($date)
	{
		$today = strtotime(date('Y-m-d'));
		$target = strtotime($date);
		return (int) floor(($target - $today) / 86400);
	}

	private function done_task_keys($officer_id)
	{
		$this->db->select('module, associated_id');
		$this->db->from('tasklist');
		$this->db->where_in('status', array('Done', 'Archived'));

		if (!$this->officer_can_view_all_tasks()) {
			$this->db->where('officer_id', $officer_id);
		}

		$rows = $this->db->get()->result();
		$keys = array();
		foreach ($rows as $row) {
			$keys[$row->module.'|'.$row->associated_id] = true;
		}
		return $keys;
	}

	private function add_priority_task(&$tasks, $done_keys, $task)
	{
		$key = $task['module'].'|'.$task['associated_id'];
		if (isset($done_keys[$key])) {
			return;
		}

		$tasks[] = $task;
	}

	private function todays_priority_tasks($officer_id)
	{
		$tasks = array();
		$done_keys = $this->done_task_keys($officer_id);
		$can_view_all = $this->officer_can_view_all_tasks();

		$this->db->select('sa.studentapp_id, sa.client_id, sa.officer_id, sa.studentapp_flag, sa.studentapp_visa_status, sa.studentapp_documents_pending, sa.studentapp_course_name, sa.vevo_expiry_date, c.client_firstname, c.client_middlename, c.client_surname, c.client_officer_id');
		$this->db->from('student_application sa');
		$this->db->join('client c', 'c.client_id = sa.client_id', 'left');
		$this->db->where('c.client_id IS NOT NULL', null, false);
		if (!$can_view_all) {
			$this->db->group_start();
			$this->db->where('c.client_officer_id', $officer_id);
			$this->db->or_where('sa.officer_id', $officer_id);
			$this->db->group_end();
		}
		$student_apps = $this->db->get()->result();

		foreach ($student_apps as $row) {
			$client_name = $this->clean_client_name($row);
			$owner_id = $row->client_officer_id != '' ? $row->client_officer_id : $row->officer_id;

			if ($this->valid_db_date($row->vevo_expiry_date)) {
				$days = $this->days_from_today($row->vevo_expiry_date);
				if ($days <= 90) {
					$priority = $days < 0 ? 1100 + abs($days) : ($days <= 14 ? 1000 - $days : ($days <= 30 ? 850 - $days : 650 - $days));
					$label = $days < 0 ? 'Critical' : ($days <= 14 ? 'Critical' : ($days <= 30 ? 'High' : 'Watch'));
					$when = $days < 0 ? 'expired '.abs($days).' day(s) ago' : $days.' day(s) left';
					$this->add_priority_task($tasks, $done_keys, array(
						'priority' => $priority,
						'priority_label' => $label,
						'client_id' => $row->client_id,
						'officer_id' => $owner_id,
						'client_name' => $client_name,
						'details' => 'Review VEVO expiry for '.$client_name.' - '.$when.' ('.date('d/m/Y', strtotime($row->vevo_expiry_date)).').',
						'module' => 'Dashboard VEVO Expiry',
						'associated_id' => $row->studentapp_id,
						'due_text' => $when,
						'url' => base_url().'index.php/editapplication/'.$row->studentapp_id
					));
				}
			}

			if (strtolower((string) $row->studentapp_flag) == 'wip') {
				$course = trim((string) $row->studentapp_course_name);
				$this->add_priority_task($tasks, $done_keys, array(
					'priority' => 430,
					'priority_label' => 'High',
					'client_id' => $row->client_id,
					'officer_id' => $owner_id,
					'client_name' => $client_name,
					'details' => 'Follow up student application for '.$client_name.($course != '' ? ' - '.$course : '').'.',
					'module' => 'Dashboard Student Application',
					'associated_id' => $row->studentapp_id,
					'due_text' => 'Student application WIP',
					'url' => base_url().'index.php/editapplication/'.$row->studentapp_id
				));
			}
		}

		$this->db->select('va.client_visa_id, va.client_id, va.status, va.visa_critical_day, va.visa_critical_month, va.visa_critical_year, c.client_firstname, c.client_middlename, c.client_surname, c.client_officer_id');
		$this->db->from('visa_application va');
		$this->db->join('client c', 'c.client_id = va.client_id', 'left');
		$this->db->where('c.client_id IS NOT NULL', null, false);
		if (!$can_view_all) {
			$this->db->where('c.client_officer_id', $officer_id);
		}
		$visa_apps = $this->db->get()->result();

		foreach ($visa_apps as $row) {
			$client_name = $this->clean_client_name($row);
			$critical_date = $this->date_from_parts($row->visa_critical_year, $row->visa_critical_month, $row->visa_critical_day);

			if ($critical_date != '') {
				$days = $this->days_from_today($critical_date);
				if ($days <= 90) {
					$priority = $days < 0 ? 1050 + abs($days) : ($days <= 14 ? 940 - $days : ($days <= 30 ? 780 - $days : 560 - $days));
					$label = $days < 0 ? 'Critical' : ($days <= 14 ? 'Critical' : ($days <= 30 ? 'High' : 'Watch'));
					$when = $days < 0 ? 'overdue by '.abs($days).' day(s)' : $days.' day(s) left';
					$this->add_priority_task($tasks, $done_keys, array(
						'priority' => $priority,
						'priority_label' => $label,
						'client_id' => $row->client_id,
						'officer_id' => $row->client_officer_id,
						'client_name' => $client_name,
						'details' => 'Review visa critical date for '.$client_name.' - '.$when.' ('.date('d/m/Y', strtotime($critical_date)).').',
						'module' => 'Dashboard Visa Critical',
						'associated_id' => $row->client_visa_id,
						'due_text' => $when,
						'url' => base_url().'index.php/editvisaapplication/'.$row->client_visa_id
					));
				}
			}

			if (strtolower((string) $row->status) == 'wip') {
				$this->add_priority_task($tasks, $done_keys, array(
					'priority' => 470,
					'priority_label' => 'High',
					'client_id' => $row->client_id,
					'officer_id' => $row->client_officer_id,
					'client_name' => $client_name,
					'details' => 'Follow up visa application for '.$client_name.'.',
					'module' => 'Dashboard Visa Application',
					'associated_id' => $row->client_visa_id,
					'due_text' => 'Visa application WIP',
					'url' => base_url().'index.php/editvisaapplication/'.$row->client_visa_id
				));
			}
		}

		usort($tasks, function($a, $b) {
			if ($a['priority'] == $b['priority']) {
				return strcmp($a['client_name'], $b['client_name']);
			}
			return $a['priority'] < $b['priority'] ? 1 : -1;
		});

		return array_slice($tasks, 0, 25);
	}

	public function index()
	{
		$asset_url = base_url()."assets/";
		
		$sql1 = "SELECT * FROM client WHERE client_flag = 'active'";
		$query1 = $this->db->query($sql1);
		$activeclients = $query1->num_rows();

		$sql2 = "SELECT * FROM student_application WHERE studentapp_flag = 'WIP'";
		$query2 = $this->db->query($sql2);
		$student_application = $query2->num_rows();

		$sql3 = "SELECT * FROM visa_application WHERE status = 'WIP'";
		$query3 = $this->db->query($sql3);
		$pr_application = $query3->num_rows();

		$sql4 = "SELECT * FROM education_provider";
		$query4 = $this->db->query($sql4);
		$education_provider = $query4->num_rows();

		$sql5 = "SELECT c.client_surname, c.client_firstname, c.client_middlename, c.client_inquiries_id, i.inquiries_id, sa.studentapp_id, vap.client_visa_id, p.paymentid, o.officer_name, (SELECT COUNT(fbid) FROM firebasefiles WHERE client_id = c.client_id) as doccount FROM client c LEFT JOIN inquiries i on i.inquiries_id = c.client_inquiries_id LEFT JOIN visa_application vap on vap.client_id = c.client_id LEFT JOIN student_application sa on sa.client_id = c.client_id LEFT JOIN officer o on o.officer_id = c.client_officer_id LEFT JOIN payments p on p.payee = c.client_id";
        $query5 = $this->db->query($sql5);
        $client = $query5->result();

        $sql6 = "SELECT * FROM inquiries where inquiries_status = 'Created' ORDER BY inquiries_id DESC";
		$query6 = $this->db->query($sql6);
		$inquiries = $query6->result();

		$officerid = $this->session->officer_id;
		$tasklist = $this->todays_priority_tasks($officerid);

		$sql8 = "SELECT * FROM visa_application va INNER JOIN client c on c.client_id = va.client_id";
		$query8 = $this->db->query($sql8);
		$prapplicationforchecking = $query8->result();

		// Dashboard card data
		$sql9 = "SELECT * FROM student_application sa LEFT JOIN client c ON sa.client_id = c.client_id WHERE studentapp_flag = 'WIP'";
		$query9 = $this->db->query($sql9);
		$safordashboarddata = $query9->result();

		$sql10 = "SELECT * FROM visa_application va INNER JOIN client c ON va.client_id = c.client_id WHERE status = 'WIP'";
		$query10 = $this->db->query($sql10);
		$vafordashboarddata = $query10->result();

		$sql13 = "SELECT sa.studentapp_id, sa.client_id, sa.studentapp_flag, sa.vevo_expiry_date, c.client_firstname, c.client_middlename, c.client_surname, DATEDIFF(sa.vevo_expiry_date, CURDATE()) AS days_until_expiry FROM student_application sa LEFT JOIN client c ON c.client_id = sa.client_id WHERE sa.vevo_expiry_date IS NOT NULL AND sa.vevo_expiry_date > '1900-01-01' AND sa.vevo_expiry_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 90 DAY) ORDER BY sa.vevo_expiry_date ASC, sa.studentapp_id ASC LIMIT 10";
		$query13 = $this->db->query($sql13);
		$critical_student_visa_expiry = $query13->result();

		$sql14 = "SELECT SUM(CASE WHEN vevo_expiry_date < CURDATE() THEN 1 ELSE 0 END) AS expired_count, SUM(CASE WHEN vevo_expiry_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY) THEN 1 ELSE 0 END) AS next_30_count, SUM(CASE WHEN vevo_expiry_date BETWEEN DATE_ADD(CURDATE(), INTERVAL 31 DAY) AND DATE_ADD(CURDATE(), INTERVAL 90 DAY) THEN 1 ELSE 0 END) AS next_90_count FROM student_application WHERE vevo_expiry_date IS NOT NULL AND vevo_expiry_date > '1900-01-01'";
		$query14 = $this->db->query($sql14);
		$student_visa_expiry_summary = $query14->row();

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
		

		$data['title'] = "Dashboard";
		$data['asset_url'] = $asset_url;

		$data['activeclients'] = $activeclients;
		$data['student_application'] = $student_application;
		$data['pr_application'] = $pr_application;
		$data['education_provider'] = $education_provider;
		$data['clients'] = $client;
		$data['inquiries'] = $inquiries;
		$data['tasklist'] = $tasklist;
		$data['prapplicationforchecking'] = $prapplicationforchecking;
		$data['safordashboarddata'] = $safordashboarddata;
		$data['vafordashboarddata'] = $vafordashboarddata;
		$data['critical_student_visa_expiry'] = $critical_student_visa_expiry;
		$data['student_visa_expiry_summary'] = $student_visa_expiry_summary;
		
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
				$this->load->view('dashboard/index', $data);
			} else {
				redirect(base_url()."?error3=1");
			}
		}
		
	}

	public function archivetasklist($tlid) {
		$this->db->set('status', 'Archived');
		$this->db->where('tlid', $tlid);
		$this->db->update('tasklist');
		echo json_encode("Successfully archived the task!");
	}

	public function donetasklist($tlid) {
		$this->db->set('status', 'Done');
		$this->db->where('tlid', $tlid);
		$this->db->update('tasklist');
		echo json_encode("Successfully done the task!");
	}

	public function completetodaystask() {
		if (!isset($this->session->officer_name) || !isset($this->session->officer_id)) {
			$this->output->set_status_header(401);
			echo json_encode(array('success' => false, 'message' => 'Session expired. Please sign in again.'));
			return;
		}

		$client_id = (int) $this->input->post('client_id');
		$associated_id = (int) $this->input->post('associated_id');
		$module = trim((string) $this->input->post('module'));
		$details = trim((string) $this->input->post('details'));
		$officer_id = (int) $this->session->officer_id;

		if ($client_id <= 0 || $associated_id <= 0 || $module == '' || $details == '') {
			echo json_encode(array('success' => false, 'message' => 'Task data is incomplete.'));
			return;
		}

		$this->db->where('officer_id', $officer_id);
		$this->db->where('module', $module);
		$this->db->where('associated_id', $associated_id);
		$existing = $this->db->get('tasklist', 1)->row();

		$data = array(
			'details' => $details,
			'client_id' => $client_id,
			'officer_id' => $officer_id,
			'datetime_created' => date("Y-m-d H:i:s"),
			'status' => 'Done',
			'module' => $module,
			'associated_id' => $associated_id
		);

		if ($existing) {
			$this->db->where('tlid', $existing->tlid);
			$this->db->update('tasklist', $data);
		} else {
			$this->db->insert('tasklist', $data);
		}

		echo json_encode(array('success' => true, 'message' => 'Task saved as done.'));
	}

	public function markasread() {
		if($this->session->officer_role == "regional manager" || $this->session->officer_role == "admin") {
			$this->db->set('seen', '1');
			$this->db->update('notifications');
		} else {
			$this->db->set('seen', '1');
			$this->db->where('officer_id', $officer_id_check);
			$this->db->update('notifications');
		}
		echo json_encode("Successfully done marking as read!");
	}

}
