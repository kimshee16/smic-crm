<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Schoolsprogramscontroller extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->helper('form');
	}

	public function schools()
	{
		$sql = "SELECT * FROM education_provider ORDER by provider_id DESC";
        $query = $this->db->query($sql);
        $result = $query->result();

        $asset_url = base_url()."assets/";
		$data['title'] = "Schools";
		$data['asset_url'] = $asset_url;
		$data['schools'] = $result;

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
				$this->load->view('schoolsprograms/schools', $data);
			} else {
				redirect(base_url()."?error3=1");
			}
		}
	}

	public function newschool()
	{
        $asset_url = base_url()."assets/";
		$data['title'] = "New School";
		$data['asset_url'] = $asset_url;

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
				$this->load->view('schoolsprograms/newschool', $data);
			} else {
				redirect(base_url()."?error3=1");
			}
		}
	}

	public function saveschool()
	{
		$data = array(
					'provider_name' => $this->input->post('schoolname'),
					'provider_marketing_contact_name' => $this->input->post('marketingname'),
					'provider_marketing_contact_phoneno' => $this->input->post('marketingphone'),
					'provider_marketing_mobileno' => $this->input->post('marketingmobile'),
					'provider_admin_contact_name' => $this->input->post('adminname'),
					'provider_admin_contact_phoneno' => $this->input->post('adminphone'),
					'provider_finance_contact_name' => $this->input->post('financename'),
					'provider_finance_contact_phoneno' => $this->input->post('financephone'),
					'provider_faxno' => $this->input->post('faxno'),
					'provider_mailing_address' => $this->input->post('mailingaddress'),
					'provider_suburb' => $this->input->post('suburb'),
					'provider_state' => $this->input->post('state'),
					'provider_postcode' => $this->input->post('postcode'),
					'provider_finance_mailing_address1' => $this->input->post('financemailing1'),
					'provider_finance_suburb1' => $this->input->post('financesuburb'),
					'provider_finance_state1' => $this->input->post('financestate'),
					'provider_finance_postcode1' => $this->input->post('financepostcode'),
					'provider_finance_mailing_address2' => $this->input->post('financemailing2'),
					'provider_notes' => $this->input->post('notes')
				);
		$this->db->insert('education_provider', $data);
		redirect('schools');
	}

	public function programs()
	{

		$sql = "SELECT sp.spid, sp.program, ep.provider_name, sp.programtype, sp.applicationfee, sp.tuition, sp.costofliving, sp.intake, sp.campuslocation,sp.currency, GROUP_CONCAT(CONCAT(s.scholarshipid, '[===]', s.description) ORDER BY s.description SEPARATOR '[=====]') AS scholarships FROM schoolprograms sp LEFT JOIN education_provider ep ON ep.provider_id = sp.provider_id LEFT JOIN scholarships s ON sp.spid = s.scholarshipid GROUP BY sp.spid,sp.program,ep.provider_name,sp.programtype,sp.applicationfee,sp.tuition,sp.costofliving,sp.intake,sp.campuslocation,sp.currency ORDER by spid DESC;";
        $query = $this->db->query($sql);
        $result = $query->result();

        $asset_url = base_url()."assets/";
		$data['title'] = "Programs";
		$data['asset_url'] = $asset_url;
		$data['programs'] = $result;

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
				$this->load->view('schoolsprograms/programs', $data);
			} else {
				redirect(base_url()."?error3=1");
			}
		}
	}

	public function newprogram()
	{
        $asset_url = base_url()."assets/";
		$data['title'] = "New Program";
		$data['asset_url'] = $asset_url;

		$sql = "SELECT * FROM education_provider";
        $query = $this->db->query($sql);
        $education_provider = $query->result();

		$sql = "SELECT * FROM qualifications";
        $query = $this->db->query($sql);
        $qualifications = $query->result();

        $sql = "SELECT * FROM currency";
        $query = $this->db->query($sql);
        $currency = $query->result();

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

        $data['qualifications'] = $qualifications; 
        $data['education_provider'] = $education_provider;
        $data['currency'] = $currency;

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
				$this->load->view('schoolsprograms/newprogram', $data);
			} else {
				redirect(base_url()."?error3=1");
			}
		}
	}

	public function saveprogram()
	{
		$data = array(
					'program' => $this->input->post('program'),
					'applicationfee' => $this->input->post('applicationfee'),
					'programtype' => $this->input->post('programlevel'),
					'commission' => '0',
					'provider_id' => $this->input->post('school'),
					'description' => $this->input->post('description'),
					'tuition' => $this->input->post('tuitionfee'),
					'costofliving' => $this->input->post('costofliving'),
					'currency' => $this->input->post('currency'),
					'campuslocation' => $this->input->post('campuslocation'),
					'intake' => $this->input->post('intake')
				);
		$this->db->insert('schoolprograms', $data);
		redirect('programs');
	}

	public function editschool($schoolid)
	{
        $asset_url = base_url()."assets/";
		$data['title'] = "Update School";
		$data['asset_url'] = $asset_url;

		$sql1 = "SELECT * FROM education_provider where provider_id = $schoolid";
	    $query1 = $this->db->query($sql1);
	    $education_provider = $query1->result();

	    $data['education_provider'] = $education_provider;

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
				$this->load->view('schoolsprograms/editschool', $data);
			} else {
				redirect(base_url()."?error3=1");
			}
		}
	}

	public function editprogram($spid)
	{
        $asset_url = base_url()."assets/";
		$data['title'] = "Update Program";
		$data['asset_url'] = $asset_url;

		$sql1 = "SELECT * FROM schoolprograms sp inner join education_provider ep on sp.provider_id = ep.provider_id where sp.spid = $spid";
	    $query1 = $this->db->query($sql1);
	    $schoolprograms = $query1->result();

	    $sql2 = "SELECT * FROM education_provider";
	    $query2 = $this->db->query($sql2);
	    $education_provider = $query2->result();

	    $sql3 = "SELECT * FROM qualifications";
        $query3 = $this->db->query($sql3);
        $qualifications = $query3->result();

        $sql4 = "SELECT * FROM currency";
        $query4 = $this->db->query($sql4);
        $currency = $query4->result();

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

        $data['qualifications'] = $qualifications; 
        $data['education_provider'] = $education_provider;
        $data['currency'] = $currency;
	    $data['schoolprograms'] = $schoolprograms;

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
				$this->load->view('schoolsprograms/editprogram', $data);
			} else {
				redirect(base_url()."?error3=1");
			}
		}
	}

	public function updateschool()
	{

		$this->db->set('provider_name', $this->input->post('schoolname'));
		$this->db->set('provider_marketing_contact_name', $this->input->post('marketingname'));
		$this->db->set('provider_marketing_contact_phoneno', $this->input->post('marketingphone'));
		$this->db->set('provider_marketing_mobileno', $this->input->post('marketingmobile'));
		$this->db->set('provider_admin_contact_name', $this->input->post('adminname'));
		$this->db->set('provider_admin_contact_phoneno', $this->input->post('adminphone'));
		$this->db->set('provider_finance_contact_name', $this->input->post('financename'));
		$this->db->set('provider_finance_contact_phoneno', $this->input->post('financephone'));
		$this->db->set('provider_faxno', $this->input->post('faxno'));
		$this->db->set('provider_mailing_address', $this->input->post('mailingaddress'));
		$this->db->set('provider_suburb', $this->input->post('suburb'));
		$this->db->set('provider_state', $this->input->post('state'));
		$this->db->set('provider_postcode', $this->input->post('postcode'));
		$this->db->set('provider_finance_mailing_address1', $this->input->post('financemailing1'));
		$this->db->set('provider_finance_suburb1', $this->input->post('financesuburb'));
		$this->db->set('provider_finance_state1', $this->input->post('financestate'));
		$this->db->set('provider_finance_postcode1', $this->input->post('financepostcode'));
		$this->db->set('provider_finance_mailing_address2', $this->input->post('financemailing2'));
		$this->db->set('provider_notes', $this->input->post('notes'));

		$this->db->where('provider_id', $this->input->post('provider_id'));
		$this->db->update('education_provider');

		redirect('schools');
	}

	public function updateprogram()
	{
		$this->db->set('program', $this->input->post('program'));
		$this->db->set('applicationfee', $this->input->post('applicationfee'));
		$this->db->set('programtype', $this->input->post('programlevel'));
		$this->db->set('commission', '0');
		$this->db->set('provider_id', $this->input->post('school'));
		$this->db->set('description', $this->input->post('description'));
		$this->db->set('tuition', $this->input->post('tuitionfee'));
		$this->db->set('costofliving', $this->input->post('costofliving'));
		$this->db->set('currency', $this->input->post('currency'));
		$this->db->set('campuslocation', $this->input->post('campuslocation'));
		$this->db->set('intake', $this->input->post('intake'));
		$this->db->where('spid', $this->input->post('spid'));
		$this->db->update('schoolprograms');

		redirect('programs');
	}

	public function deleteschool($sid)
	{
		$this->db->where('provider_id', $sid);
		$this->db->delete('education_provider');
		//echo json_encode("Successfully done reset!");
		redirect("schools");
	}

	public function deleteprogram($spid)
	{
		$this->db->where('spid', $spid);
		$this->db->delete('schoolprograms');
		//echo json_encode("Successfully done reset!");
		redirect("programs");
	}

}