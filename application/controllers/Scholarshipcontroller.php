<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Scholarshipcontroller extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->helper('form');
	}

	public function index()
	{
		$sql1 = "SELECT *,cs.remarks as csremarks FROM clientscholarship cs inner join client c on c.client_id = cs.clientid inner join scholarships s on s.scholarshipid = cs.scholarshipid WHERE cs.bactive = 1";
	    $query1 = $this->db->query($sql1);
	    $clientscholarship = $query1->result();

	    $sql2 = "SELECT s.scholarshipid,s.description,s.type,m.identity,s.amount,s.datecreated,ep.provider_name,sp.program,s.bactive, s.valid_from, s.valid_to FROM scholarships s inner join mastersetting m on s.paymenttype = m.id inner join education_provider ep on s.school = ep.provider_id inner join schoolprograms sp on s.program = sp.spid WHERE s.bactive = 1";
	    $query2 = $this->db->query($sql2);
	    $scholarships = $query2->result();

	    $sql3 = "SELECT * FROM client";
	    $query3 = $this->db->query($sql3);
	    $client = $query3->result();

        $asset_url = base_url()."assets/";
		$data['title'] = "Scholarships";
		$data['asset_url'] = $asset_url;
		
		$data['clientscholarship'] = $clientscholarship;
		$data['scholarships'] = $scholarships;
		$data['client'] = $client;

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
				$this->load->view('scholarship/index', $data);
			} else {
				redirect(base_url()."?error3=1");
			}
		}
	}

	public function newscholarshipfile()
	{

        $asset_url = base_url()."assets/";
		$data['title'] = "New Scholarship File";
		$data['asset_url'] = $asset_url;


	    $sql3 = "SELECT * FROM education_provider";
	    $query3 = $this->db->query($sql3);
	    $education_provider = $query3->result();

	    $sql3 = "SELECT * FROM schoolprograms";
	    $query3 = $this->db->query($sql3);
	    $schoolprograms = $query3->result();

		$sql2 = "SELECT * FROM mastersetting WHERE details = 'For scholarship payment type'";
	    $query2 = $this->db->query($sql2);
	    $mastersetting = $query2->result();

	    $data['mastersetting'] = $mastersetting;
	    $data['education_provider'] = $education_provider;
		$data['schoolprograms'] = $schoolprograms;

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
				$this->load->view('scholarship/newscholarshipfile', $data);
			} else {
				redirect(base_url()."?error3=1");
			}
		}
	}

	public function editscholarshipfile($scholarshipid)
	{

        $asset_url = base_url()."assets/";
		$data['title'] = "Edit Scholarship File";
		$data['asset_url'] = $asset_url;

		$sql3 = "SELECT s.scholarshipid, s.paymenttype, s.amount, s.type, s.description, s.program AS programid, s.school, s.valid_from, s.valid_to FROM scholarships s INNER JOIN education_provider ep ON s.school = ep.provider_id INNER JOIN schoolprograms sp ON s.program = sp.spid INNER JOIN mastersetting m on s.paymenttype = m.id WHERE scholarshipid = '$scholarshipid'";
	    $query3 = $this->db->query($sql3);
	    $scholarships = $query3->result();

	    $sql3 = "SELECT * FROM education_provider";
	    $query3 = $this->db->query($sql3);
	    $education_provider = $query3->result();

	    $sql3 = "SELECT * FROM schoolprograms";
	    $query3 = $this->db->query($sql3);
	    $schoolprograms = $query3->result();

		$sql2 = "SELECT * FROM mastersetting WHERE details = 'For scholarship payment type'";
	    $query2 = $this->db->query($sql2);
	    $mastersetting = $query2->result();

	    $data['mastersetting'] = $mastersetting;
	    $data['education_provider'] = $education_provider;
		$data['schoolprograms'] = $schoolprograms;
		$data['scholarships'] = $scholarships;

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
				$this->load->view('scholarship/editscholarshipfile', $data);
			} else {
				redirect(base_url()."?error3=1");
			}
            // print_r($scholarships);
		}
	}

	public function savescholarshipfile()
	{
	    
	    if($this->input->post('valid_from') == "") {
		    $valid_from = "0000-00-00";
		} else {
		    $valid_from = $this->input->post('valid_from');
		}
		
		if($this->input->post('valid_to') == "") {
		    $valid_to = "0000-00-00";
		} else {
		    $valid_to = $this->input->post('valid_to');
		}
		
		$data = array(
					'description' => $this->input->post('description'),
					'type' => $this->input->post('scholarshiptype'),
					'paymenttype' => $this->input->post('paymenttype'),
					'amount' => $this->input->post('amount'),
					'datecreated' => date('Y-m-d'),
					'school' => $this->input->post('school'),
					'program' => $this->input->post('program'),
					'valid_from' => $valid_from,
					'valid_to' => $valid_to,
					'bactive' => 1
				);
		$this->db->insert('scholarships', $data);
		redirect('scholarships');
	}

	public function updatescholarshipfile()
	{

		$this->db->set('description', $this->input->post('description'));
		$this->db->set('type', $this->input->post('scholarshiptype'));
		$this->db->set('paymenttype', $this->input->post('paymenttype'));
		$this->db->set('amount', $this->input->post('amount'));
		$this->db->set('school', $this->input->post('school'));
		$this->db->set('program', $this->input->post('program'));
		
		if($this->input->post('valid_from') == "") {
		    $valid_from = "0000-00-00";
		} else {
		    $valid_from = $this->input->post('valid_from');
		}
		
		if($this->input->post('valid_to') == "") {
		    $valid_to = "0000-00-00";
		} else {
		    $valid_to = $this->input->post('valid_to');
		}
		
		$this->db->set('valid_from', $valid_from);
		$this->db->set('valid_to', $valid_to);
		$this->db->where('scholarshipid', $this->input->post('scholarshipid'));
		$this->db->update('scholarships');

		redirect('scholarships');
	}

	public function newscholarshipallocation()
	{

        $asset_url = base_url()."assets/";
		$data['title'] = "New Scholarship Allocation";
		$data['asset_url'] = $asset_url;

		$sql2 = "SELECT * FROM scholarships where bactive = 1";
	    $query2 = $this->db->query($sql2);
	    $scholarships = $query2->result();

		$sql3 = "SELECT * FROM client";
	    $query3 = $this->db->query($sql3);
	    $client = $query3->result();

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

	    $data['client'] = $client;
	    $data['scholarships'] = $scholarships;

		if($this->session->officer_role == "") {
			redirect(base_url()."index.php/messages");
		} else {
			if(isset($this->session->officer_name)) {
				$this->load->view('scholarship/newscholarshipallocation', $data);
			} else {
				redirect(base_url()."?error3=1");
			}
		}
	}

	public function savescholarshipallocation()
	{

		$data = array(
					'clientid' => $this->input->post('client'),
					'scholarshipid' => $this->input->post('scholarship'),
					'remarks' => $this->input->post('remarks'),
					'bactive' => 1
				);
		$this->db->insert('clientscholarship', $data);
		redirect('scholarships');
	}

	public function deactivateschofile($scholarship_id)
	{
		$this->db->set('bactive', '0');
		$this->db->where('scholarshipid', $scholarship_id);
		$this->db->update('scholarships');
		//echo json_encode("Successfully done reset!");
		redirect(base_url()."index.php/scholarships");
	}

	public function deactivateschoallo($clientscholarship_id)
	{
		$this->db->set('bactive', '0');
		$this->db->where('csid', $clientscholarship_id);
		$this->db->update('clientscholarship');
		//echo json_encode("Successfully done reset!");
		redirect(base_url()."index.php/scholarships");
	}

}