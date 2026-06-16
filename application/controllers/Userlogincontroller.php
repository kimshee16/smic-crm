<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserLoginController extends CI_Controller {
    public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->helper('form');
	}


	public function index()
	{
		$asset_url = base_url()."assets/";
		$data['title'] = "User Login";
		$data['asset_url'] = $asset_url;
		$this->load->view('userlogin/index',$data);
	}

	public function logintypical() {
		$email = $this->input->post('email');
		$password = $this->input->post('password');

		$this->db->select('*');
        $this->db->from('officer');
        $this->db->where('email', $email);
        $query = $this->db->get();
        $row = $query->row();
	    
	    if ($password == $row->officer_password) {
	    	if ($row->officer_status == "active") {
	    		if($row->officer_role == "admin"){
                  $roleid = "1";
                }
                elseif($row->officer_role == "manager"){
                  $roleid = "2";
                }
                elseif($row->officer_role == "staff"){
                  $roleid = "3";
                }
                elseif($row->officer_role == "account"){
                  $roleid = "4";
                }
                elseif($row->officer_role == "regional manager"){
                  $roleid = "5";
                }

	    		$session_data = array(
				   	'officer_name' => $row->officer_name,
					'officer_role' => $row->officer_role,
					'officer_role_id' => $roleid,
				   	'officer_status' => $row->officer_status,
					'officer_id' => $row->officer_id,
					'officer_photo' => $row->officer_photo,
					'email' => $email
				);
				$this->session->set_userdata($session_data);
				redirect('dashboard');
	    	} else {
	    		redirect(base_url()."?error2=1");
	    		//$this->returntologin();
	    	}
		} else {
			redirect(base_url()."?error1=1");
			//$this->returntologin();
		}
	}

	/*public function logingoogle () {

	}*/

	public function returntologin() {
		$asset_url = base_url()."assets/";
		$data['title'] = "User Login";
		$data['asset_url'] = $asset_url;
		$this->load->view('userlogin/index',$data);
	}

	public function signout() {
		$this->session->unset_userdata('officer_name','officer_role','officer_status','officer_id','email');
		redirect(base_url());
	}
	
	public function privacypolicy() {
		$asset_url = base_url()."assets/";
		$data['title'] = "Privacy Policy";
		$data['asset_url'] = $asset_url;
		$this->load->view('userlogin/privacypolicy',$data);
	}

}