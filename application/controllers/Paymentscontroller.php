<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paymentscontroller extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->helper('form');
	}

	public function index()
	{
		$officer_id = $this->session->userdata('officer_id');

// 		if($this->session->userdata('officer_role') == 'regional manager' || $this->session->userdata('officer_role') == 'manager') {
// 			$sql = "SELECT paymentid,m.identity,referencenumber,c.client_surname,c.client_firstname,paymentdate,o.officer_name,paymentdescription,paymentschedule,paymentattachment,p.amount,p.currency from payments p inner join client c on p.payee = c.client_id inner join officer o on o.officer_id = p.processedby inner join mastersetting m on p.paymenttype = m.id where p.barchived = 0";
// 	        $query = $this->db->query($sql);
// 	        $result = $query->result();
// 		} else {
// 			$sql = "SELECT paymentid,m.identity,referencenumber,c.client_surname,c.client_firstname,paymentdate,o.officer_name,paymentdescription,paymentschedule,paymentattachment,p.amount,p.currency from payments p inner join client c on p.payee = c.client_id inner join officer o on o.officer_id = p.processedby inner join mastersetting m on p.paymenttype = m.id where p.barchived = 0 and p.processedby = $officer_id";
// 	        $query = $this->db->query($sql);
// 	        $result = $query->result();
// 		}
		
		$sql = "
		    SELECT
		    np.id,
		    np.paymenttype,
		    np.reference,
		    np.description,
		    npc.schedule,
		    np.totalprice,
		    npp.payorname,
		    np.paymentdate,
		    o.officer_name
		    FROM newpayments np
		    LEFT JOIN newpayments_company npc
		    ON np.id = npc.newpayments_id
		    LEFT JOIN newpayments_payor npp
		    ON np.id = npp.newpayments_id
		    LEFT JOIN officer o
		    ON np.createdby = o.officer_id
		";
	    $query = $this->db->query($sql);
	    $result = $query->result();

        $asset_url = base_url()."assets/";
		$data['title'] = "Payments";
		$data['asset_url'] = $asset_url;
		$data['payments'] = $result;

		$this->db->where('privilege_id', $this->session->officer_role_id);
        $query3 = $this->db->get('privilege');

        if($this->session->officer_role == "regional manager" || $this->session->officer_role == "admin") {
			$officer_id_check = $this->session->officer_id;
			$sql11 = "SELECT * FROM notifications WHERE seen = 0 ORDER BY notif_id DESC LIMIT 20";
			$query11 = $this->db->query($sql11);
			$notifnum = $query11->num_rows();

			$sql12 = "SELECT * FROM notifications WHERE seen = 0 ORDER BY notif_id DESC LIMIT 20";
			$query12 = $this->db->query($sql12);
			$notif = $query12->result();
		} else {
			$officer_id_check = $this->session->officer_id;
			$sql11 = "SELECT * FROM notifications WHERE seen = 0 AND officer_id = '$officer_id_check' ORDER BY notif_id DESC LIMIT 20";
			$query11 = $this->db->query($sql11);
			$notifnum = $query11->num_rows();

			$sql12 = "SELECT * FROM notifications WHERE seen = 0 AND officer_id = '$officer_id_check' ORDER BY notif_id DESC LIMIT 20";
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
				$this->load->view('payments/index', $data);
			} else {
				redirect(base_url()."?error3=1");
			}
		}
	}
	
	public function viewpayment_commission($id)
	{
		$officer_id = $this->session->userdata('officer_id');

		$sql = "
		    SELECT
		    *
		    FROM newpayments np
		    LEFT JOIN newpayments_company npc
		    ON np.id = npc.newpayments_id
		    LEFT JOIN newpayments_payor npp
		    ON np.id = npp.newpayments_id
		    LEFT JOIN officer o
		    ON np.createdby = o.officer_id
		    where np.id = $id
		";
	    $query = $this->db->query($sql);
	    $result = $query->result();
	    
	    $sql = "
		    SELECT
		    *
		    FROM newpayments_details
		    where newpayments_id = $id
		";
	    $query = $this->db->query($sql);
	    $result2 = $query->result();

        $asset_url = base_url()."assets/";
		$data['title'] = "Commission";
		$data['asset_url'] = $asset_url;
		$data['payments'] = $result;
		$data['payments_details'] = $result2;

		$this->db->where('privilege_id', $this->session->officer_role_id);
        $query3 = $this->db->get('privilege');

        if($this->session->officer_role == "regional manager" || $this->session->officer_role == "admin") {
			$officer_id_check = $this->session->officer_id;
			$sql11 = "SELECT * FROM notifications WHERE seen = 0 ORDER BY notif_id DESC LIMIT 20";
			$query11 = $this->db->query($sql11);
			$notifnum = $query11->num_rows();

			$sql12 = "SELECT * FROM notifications WHERE seen = 0 ORDER BY notif_id DESC LIMIT 20";
			$query12 = $this->db->query($sql12);
			$notif = $query12->result();
		} else {
			$officer_id_check = $this->session->officer_id;
			$sql11 = "SELECT * FROM notifications WHERE seen = 0 AND officer_id = '$officer_id_check' ORDER BY notif_id DESC LIMIT 20";
			$query11 = $this->db->query($sql11);
			$notifnum = $query11->num_rows();

			$sql12 = "SELECT * FROM notifications WHERE seen = 0 AND officer_id = '$officer_id_check' ORDER BY notif_id DESC LIMIT 20";
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
				$this->load->view('payments/viewpayment_commission', $data);
			} else {
				redirect(base_url()."?error3=1");
			}
		}
	}
	
	public function viewpayment_invoice($id)
	{
		$officer_id = $this->session->userdata('officer_id');

		$sql = "
		    SELECT
		    *, np.description as npdescription
		    FROM newpayments np
		    LEFT JOIN newpayments_company npc
		    ON np.id = npc.newpayments_id
		    LEFT JOIN newpayments_payor npp
		    ON np.id = npp.newpayments_id
		    LEFT JOIN officer o
		    ON np.createdby = o.officer_id
		    where np.id = $id
		";
	    $query = $this->db->query($sql);
	    $result = $query->result();
	    
	    $sql = "
		    SELECT
		    *
		    FROM newpayments_details
		    where newpayments_id = $id
		";
	    $query = $this->db->query($sql);
	    $result2 = $query->result();

        $asset_url = base_url()."assets/";
		$data['title'] = "Payments";
		$data['asset_url'] = $asset_url;
		$data['payments'] = $result;
		$data['payments_details'] = $result2;

		$this->db->where('privilege_id', $this->session->officer_role_id);
        $query3 = $this->db->get('privilege');

        if($this->session->officer_role == "regional manager" || $this->session->officer_role == "admin") {
			$officer_id_check = $this->session->officer_id;
			$sql11 = "SELECT * FROM notifications WHERE seen = 0 ORDER BY notif_id DESC LIMIT 20";
			$query11 = $this->db->query($sql11);
			$notifnum = $query11->num_rows();

			$sql12 = "SELECT * FROM notifications WHERE seen = 0 ORDER BY notif_id DESC LIMIT 20";
			$query12 = $this->db->query($sql12);
			$notif = $query12->result();
		} else {
			$officer_id_check = $this->session->officer_id;
			$sql11 = "SELECT * FROM notifications WHERE seen = 0 AND officer_id = '$officer_id_check' ORDER BY notif_id DESC LIMIT 20";
			$query11 = $this->db->query($sql11);
			$notifnum = $query11->num_rows();

			$sql12 = "SELECT * FROM notifications WHERE seen = 0 AND officer_id = '$officer_id_check' ORDER BY notif_id DESC LIMIT 20";
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
				$this->load->view('payments/viewpayment_invoice', $data);
			} else {
				redirect(base_url()."?error3=1");
			}
		}
	}
	
	public function viewpayment_paymentreceipt($id)
	{
		$officer_id = $this->session->userdata('officer_id');

		$sql = "
		    SELECT
		    *
		    FROM newpayments np
		    LEFT JOIN newpayments_company npc
		    ON np.id = npc.newpayments_id
		    LEFT JOIN newpayments_payor npp
		    ON np.id = npp.newpayments_id
		    LEFT JOIN officer o
		    ON np.createdby = o.officer_id
		    where np.id = $id
		";
	    $query = $this->db->query($sql);
	    $result = $query->result();
	    
	    $sql = "
		    SELECT
		    *
		    FROM newpayments_details
		    where newpayments_id = $id
		";
	    $query = $this->db->query($sql);
	    $result2 = $query->result();

        $asset_url = base_url()."assets/";
		$data['title'] = "Payments";
		$data['asset_url'] = $asset_url;
		$data['payments'] = $result;
		$data['payments_details'] = $result2;

		$this->db->where('privilege_id', $this->session->officer_role_id);
        $query3 = $this->db->get('privilege');

        if($this->session->officer_role == "regional manager" || $this->session->officer_role == "admin") {
			$officer_id_check = $this->session->officer_id;
			$sql11 = "SELECT * FROM notifications WHERE seen = 0 ORDER BY notif_id DESC LIMIT 20";
			$query11 = $this->db->query($sql11);
			$notifnum = $query11->num_rows();

			$sql12 = "SELECT * FROM notifications WHERE seen = 0 ORDER BY notif_id DESC LIMIT 20";
			$query12 = $this->db->query($sql12);
			$notif = $query12->result();
		} else {
			$officer_id_check = $this->session->officer_id;
			$sql11 = "SELECT * FROM notifications WHERE seen = 0 AND officer_id = '$officer_id_check' ORDER BY notif_id DESC LIMIT 20";
			$query11 = $this->db->query($sql11);
			$notifnum = $query11->num_rows();

			$sql12 = "SELECT * FROM notifications WHERE seen = 0 AND officer_id = '$officer_id_check' ORDER BY notif_id DESC LIMIT 20";
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
				$this->load->view('payments/viewpayment_paymentreceipt', $data);
			} else {
				redirect(base_url()."?error3=1");
			}
		}
	}
	
	public function viewpayment_acknowledgementreceipt($id)
	{

		$sql = "
		    SELECT
		    *
		    FROM newpayments np
		    LEFT JOIN newpayments_company npc
		    ON np.id = npc.newpayments_id
		    LEFT JOIN newpayments_payor npp
		    ON np.id = npp.newpayments_id
		    LEFT JOIN officer o
		    ON np.createdby = o.officer_id
		    where np.id = $id
		";
	    $query = $this->db->query($sql);
	    $result1 = $query->result();

        $asset_url = base_url()."assets/";
		$data['title'] = "Payments";
		$data['asset_url'] = $asset_url;
		$data['payments'] = $result1;

		$this->db->where('privilege_id', $this->session->officer_role_id);
        $query3 = $this->db->get('privilege');

        if($this->session->officer_role == "regional manager" || $this->session->officer_role == "admin") {
			$officer_id_check = $this->session->officer_id;
			$sql11 = "SELECT * FROM notifications WHERE seen = 0 ORDER BY notif_id DESC LIMIT 20";
			$query11 = $this->db->query($sql11);
			$notifnum = $query11->num_rows();

			$sql12 = "SELECT * FROM notifications WHERE seen = 0 ORDER BY notif_id DESC LIMIT 20";
			$query12 = $this->db->query($sql12);
			$notif = $query12->result();
		} else {
			$officer_id_check = $this->session->officer_id;
			$sql11 = "SELECT * FROM notifications WHERE seen = 0 AND officer_id = '$officer_id_check' ORDER BY notif_id DESC LIMIT 20";
			$query11 = $this->db->query($sql11);
			$notifnum = $query11->num_rows();

			$sql12 = "SELECT * FROM notifications WHERE seen = 0 AND officer_id = '$officer_id_check' ORDER BY notif_id DESC LIMIT 20";
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
				$this->load->view('payments/viewpayment_acknowledgementreceipt', $data);
			} else {
				redirect(base_url()."?error3=1");
			}
		}
	}

	public function newpayment()
	{
		$sql = "SELECT client_id,client_surname,client_firstname,client_middlename FROM client";
        $query = $this->db->query($sql);
        $result = $query->result();
        
        // $sql = "SELECT * FROM client WHERE client_id = $client_id";
        // $query = $this->db->query($sql);
        // $client = $query->result();

        $sql2 = "SELECT id,identity FROM mastersetting WHERE type = 'paymenttype' and bactive = 1";
        $query2 = $this->db->query($sql2);
        $result2 = $query2->result();
        
        $sql2 = "SELECT LPAD(MAX(paymentid) + 1, 7, '0') AS next_invoice_number FROM payments";
        $query2 = $this->db->query($sql2);
        $result2 = $query2->result();
        
        $next_invoice_number = $result2[0]->next_invoice_number;

        $data['clients'] = $result;
        $data['mastersetting'] = $result2;
		$asset_url = base_url()."assets/";
		$data['title'] = "New Payment Entry";
		$data['asset_url'] = $asset_url;
		$data['next_invoice_number'] = $next_invoice_number;
		
		if($this->session->officer_role == "regional manager" || $this->session->officer_role == "admin") {
			$officer_id_check = $this->session->officer_id;
			$sql11 = "SELECT * FROM notifications WHERE seen = 0 ORDER BY notif_id DESC LIMIT 20";
			$query11 = $this->db->query($sql11);
			$notifnum = $query11->num_rows();

			$sql12 = "SELECT * FROM notifications WHERE seen = 0 ORDER BY notif_id DESC LIMIT 20";
			$query12 = $this->db->query($sql12);
			$notif = $query12->result();
		} else {
			$officer_id_check = $this->session->officer_id;
			$sql11 = "SELECT * FROM notifications WHERE seen = 0 AND officer_id = '$officer_id_check' ORDER BY notif_id DESC LIMIT 20";
			$query11 = $this->db->query($sql11);
			$notifnum = $query11->num_rows();

			$sql12 = "SELECT * FROM notifications WHERE seen = 0 AND officer_id = '$officer_id_check' ORDER BY notif_id DESC LIMIT 20";
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
				$this->load->view('payments/newpayment', $data);
			} else {
				redirect(base_url()."?error3=1");
			}
		}
	}

	public function savepayment()
	{
		$data = array(
					'paymenttype' => $this->input->post('paymenttype'),
					'referencenumber' => $this->input->post('referencenumber'),
					'payee' => $this->input->post('payee'),
					'paymentdate' => $this->input->post('paymentdate'),
					'processedby' => $this->session->userdata('officer_id'),
					'barchived' => 0
				);
		$this->db->insert('payments', $data);
// 		redirect('payments');
        redirect('editclientinfo2/'.$this->input->post('payee').'#payments');
	}

	public function archivepayment($id) {
	    
	    $this->db->where('id', $id);
		$this->db->delete('newpayments');
		
		$this->db->where('newpayments_id', $id);
		$this->db->delete('newpayments_details');
		
		$this->db->where('newpayments_id', $id);
		$this->db->delete('newpayments_company');
		
		$this->db->where('newpayments_id', $id);
		$this->db->delete('newpayments_payor');
		
		redirect('payments');
        
	}
	
	public function editpayment($id)
	{
		$sql = "SELECT client_id,client_surname,client_firstname,client_middlename FROM client";
        $query = $this->db->query($sql);
        $result = $query->result();

        $sql2 = "SELECT id,identity FROM mastersetting WHERE type = 'paymenttype' and bactive = 1";
        $query2 = $this->db->query($sql2);
        $result2 = $query2->result();
        
        $sql3 = "SELECT
		    *
		    FROM newpayments np
		    LEFT JOIN newpayments_company npc
		    ON np.id = npc.newpayments_id
		    LEFT JOIN newpayments_payor npp
		    ON np.id = npp.newpayments_id
		    LEFT JOIN officer o
		    ON np.createdby = o.officer_id
		    where np.id = $id";
        $query3 = $this->db->query($sql3);
        $result3 = $query3->result();
        
        $sql3 = "SELECT * FROM newpayments_details WHERE newpayments_id = $id";
        $query3 = $this->db->query($sql3);
        $result4 = $query3->result();

        $data['clients'] = $result;
        $data['mastersetting'] = $result2;
        $data['payment'] = $result3;
        $data['paymentdetails'] = $result4;
		$asset_url = base_url()."assets/";
		$data['title'] = "Edit Payment Entry";
		$data['asset_url'] = $asset_url;

		if($this->session->officer_role == "regional manager" || $this->session->officer_role == "admin") {
			$officer_id_check = $this->session->officer_id;
			$sql11 = "SELECT * FROM notifications WHERE seen = 0 ORDER BY notif_id DESC LIMIT 20";
			$query11 = $this->db->query($sql11);
			$notifnum = $query11->num_rows();

			$sql12 = "SELECT * FROM notifications WHERE seen = 0 ORDER BY notif_id DESC LIMIT 20";
			$query12 = $this->db->query($sql12);
			$notif = $query12->result();
		} else {
			$officer_id_check = $this->session->officer_id;
			$sql11 = "SELECT * FROM notifications WHERE seen = 0 AND officer_id = '$officer_id_check' ORDER BY notif_id DESC LIMIT 20";
			$query11 = $this->db->query($sql11);
			$notifnum = $query11->num_rows();

			$sql12 = "SELECT * FROM notifications WHERE seen = 0 AND officer_id = '$officer_id_check' ORDER BY notif_id DESC LIMIT 20";
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
				$this->load->view('payments/editpayment', $data);
			} else {
				redirect(base_url()."?error3=1");
			}
		}
	}
	
	public function new_payment_getclientdetails($client_id) {
		$sql3 = "SELECT * FROM client where client_id = $client_id";
	    $query3 = $this->db->query($sql3);
	    $program = $query3->result();
	    echo json_encode($program);
	}

}