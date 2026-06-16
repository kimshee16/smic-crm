<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboardcontroller extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->helper('form');
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
		$sql7 = "SELECT * FROM tasklist where officer_id = '$officerid' and (status = 'Created' OR status = 'Done')";
		$query7 = $this->db->query($sql7);
		$tasklist = $query7->result();

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