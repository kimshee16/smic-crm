<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ClientLoginController extends CI_Controller {
    public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->helper('form');
	}

	public function index()
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

	    $data['nationality'] = $nationality;
		$data['qualifications'] = $qualifications;
		$data['civilstatus'] = $civilstat;

		$asset_url = base_url()."assets/";
		$data['title'] = "Client Login";
		$data['asset_url'] = $asset_url;
		$this->load->view('clientlogin/index',$data);
	}
	
	public function clientloginpo()
	{
		$asset_url = base_url()."assets/";
		$data['title'] = "Client Login";
		$data['asset_url'] = $asset_url;
		$this->load->view('clientlogin/clientloginpo', $data);
	}
	
	public function clientlogintypical() {
		$email = $this->input->post('email');
		$password = $this->input->post('password');

        $this->db->select('*');
        $this->db->from('client');
        $this->db->where('client_email', $email);
        $query = $this->db->get();
        $clientrow = $query->row();
	    
	    if ($password == $clientrow->client_password) {
	    	if ($clientrow->client_flag == "active") {
	    		$session_data = array(
				   	'officer_name' => $clientrow->client_firstname." ".$clientrow->client_surname,
					'officer_role' => '',
					'officer_role_id' => '',
				   	'officer_status' => $clientrow->client_flag,
					'officer_id' => $clientrow->client_id,
					'email' => $clientrow_client_email
				);
				$this->session->set_userdata($session_data);
				redirect($this->input->post('gotopage'));
	    	} else {
	    		redirect(base_url()."index.php/clientloginpo?type=po&value=".$this->input->post('gotopage')."&error2=1");
	    		//$this->returntologin();
	    	}
		} else {
			redirect(base_url()."index.php/clientloginpo");
			//$this->returntologin();
		}

	}

	public function clientsignout() {
		$this->session->unset_userdata('officer_name','officer_role','officer_status','officer_id','email');
		redirect(base_url()."index.php/clientlogin");
	}

	public function clientforgotpassword() {
		$asset_url = base_url()."assets/";
		$data['title'] = "Client Forgot Password";
		$data['asset_url'] = $asset_url;
		$this->load->view('clientlogin/clientforgotpassword',$data);
	}

	public function clientforgotpasswordsend() {
		$email = $this->input->post('email');
		$password1 = $this->input->post('password1');
		$password2 = $this->input->post('password2');

		if($password1 == $password2) {
			$this->db->select('*');
	        $this->db->from('client');
	        $this->db->where('client_email', $email);
	        $query = $this->db->get();
	        $row = $query->row();

	        $this->db->set('client_password', $password1);
			$this->db->where('client_id', $row->client_id);
			$this->db->update('client');

	        redirect(base_url()."index.php/clientlogin?success1=1");

		} else {
			redirect(base_url()."index.php/clientlogin??error4=1");
		}

	}

}