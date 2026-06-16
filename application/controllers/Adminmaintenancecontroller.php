<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Adminmaintenancecontroller extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->helper('form');
	}

	public function index()
	{
		$sql1 = "SELECT * FROM region";
	    $query1 = $this->db->query($sql1);
	    $region = $query1->result();

	    $sql2 = "SELECT * FROM events";
	    $query2 = $this->db->query($sql2);
	    $events = $query2->result();

	    $sql2 = "SELECT * FROM officer";
	    $query2 = $this->db->query($sql2);
	    $officer = $query2->result();
	    
	    $sql2 = "SELECT *, oo.officer_name, r.region_name 
         FROM offices o 
         left JOIN officer oo ON o.offices_manager = oo.officer_id 
         left JOIN region r ON o.offices_region = r.region_id";
	    $query2 = $this->db->query($sql2);
	    $offices = $query2->result();

	    $sql3 = "SELECT * FROM officerassignment oa left join officer o on oa.officer_id = o.officer_id left join region r on oa.region_id = r.region_id WHERE bactive = 1";
	    $query3 = $this->db->query($sql3);
	    $officerassignment = $query3->result();

	    $sql2 = "SELECT * FROM emailcontents LIMIT 1";
	    $query2 = $this->db->query($sql2);
	    $emailcontents = $query2->result();

	    $sql2 = "SELECT * FROM parameters LIMIT 1";
	    $query2 = $this->db->query($sql2);
	    $parameters = $query2->result();

	    $sql2 = "SELECT * FROM privilege";
	    $query2 = $this->db->query($sql2);
	    $privilege = $query2->result();

	    $this->db->where('privilege_id', $this->session->officer_role_id);
        $query3 = $this->db->get('privilege');

		foreach ($query3->result() as $row3)
		{
		        $data['privilege_manage_clients'] = $row3->privilege_manage_clients;
		        $data['privilege_view_fees'] = $row3->privilege_view_fees;
		        
		        $data['privilege_manage_officers'] = $row3->privilege_manage_officers;
		        $data['privilege_manage_offices'] = $row3->privilege_manage_offices;
		        $data['privilege_manage_commissions'] = $row3->privilege_manage_commissions;
		        $data['privilege_manage_channel'] = $row3->privilege_manage_channel;
		        $data['privilege_manage_parameters'] = $row3->privilege_manage_parameters;
		        $data['privilege_manage_privilege'] = $row3->privilege_manage_privilege;
		        $data['privilege_manage_database'] = $row3->privilege_manage_database;
		        $data['privilege_manage_offices'] = $row3->privilege_manage_offices;
		        $data['privilege_staff_bonus'] = $row3->privilege_staff_bonus;
		        $data['privilege_manage_events'] = $row3->privilege_manage_events;
		        $data['privilege_manage_providers'] = $row3->privilege_manage_providers;
		        $data['privilege_manage_reporting'] = $row3->privilege_manage_reporting;
		        $data['privilege_manage_studentapps'] = $row3->privilege_manage_studentapps;
		}

        $asset_url = base_url()."assets/";
		$data['title'] = "Admin Maintenance";
		$data['asset_url'] = $asset_url;
		
		$data['region'] = $region;
		$data['officer'] = $officer;
		$data['offices'] = $offices;
		$data['officerassignment'] = $officerassignment;
		$data['emailcontents'] = $emailcontents;
		$data['parameters'] = $parameters;
		$data['privilege'] = $privilege;
		$data['events'] = $events;

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
			$this->load->view('maintenance/index', $data);
			} else {
				redirect(base_url()."?error3=1");
			}
		}
		
	}
	
	public function newoffice()
	{
		$asset_url = base_url()."assets/";
		$data['title'] = "New Office";
		$data['asset_url'] = $asset_url;
		
		$sql2 = "SELECT * FROM officer";
	    $query2 = $this->db->query($sql2);
	    $officer = $query2->result();
	    
	    $sql2 = "SELECT * FROM region";
	    $query2 = $this->db->query($sql2);
	    $region = $query2->result();

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
		$data['officer'] = $officer;
		$data['region'] = $region;

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
			$this->load->view('maintenance/newoffice', $data);
			} else {
				redirect(base_url()."?error3=1");
			}
		}
	}
	
	public function saveoffice()
	{
		$data = array(
					'offices_code' => $this->input->post('offices_code'),
					'offices_address1' => $this->input->post('offices_address1'),
					'offices_address2' => $this->input->post('offices_address2'),
					'offices_phoneno' => $this->input->post('offices_phoneno'),
					'offices_faxno' => $this->input->post('offices_faxno'),
					'offices_email' => $this->input->post('offices_email'),
					'offices_flag' => $this->input->post('offices_flag'),
					'offices_manager' => $this->input->post('offices_manager'),
					'offices_region' => $this->input->post('offices_region'),
					'offices_notes' => $this->input->post('offices_notes')
				);
		$this->db->insert('offices', $data);
		redirect('adminmaintenance');
	}
	
	public function editoffice($id)
	{
		$asset_url = base_url()."assets/";
		$data['title'] = "Edit Office";
		$data['asset_url'] = $asset_url;
		
		$sql2 = "SELECT * FROM offices WHERE offices_id = $id";
	    $query2 = $this->db->query($sql2);
	    $offices = $query2->result();
		
		$sql2 = "SELECT * FROM officer";
	    $query2 = $this->db->query($sql2);
	    $officer = $query2->result();
	    
	    $sql2 = "SELECT * FROM region";
	    $query2 = $this->db->query($sql2);
	    $region = $query2->result();

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
		$data['officer'] = $officer;
		$data['region'] = $region;
		$data['offices'] = $offices;

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
			$this->load->view('maintenance/editoffice', $data);
			} else {
				redirect(base_url()."?error3=1");
			}
		}
	}
	
	public function updateoffice()
	{
		$this->db->set('offices_code', $this->input->post('offices_code'));
		$this->db->set('offices_address1', $this->input->post('offices_address1'));
		$this->db->set('offices_address2', $this->input->post('offices_address2'));
		$this->db->set('offices_phoneno', $this->input->post('offices_phoneno'));
		$this->db->set('offices_faxno', $this->input->post('offices_faxno'));
		$this->db->set('offices_email', $this->input->post('offices_email'));
		$this->db->set('offices_flag', $this->input->post('offices_flag'));
		$this->db->set('offices_manager', $this->input->post('offices_manager'));
		$this->db->set('offices_region', $this->input->post('offices_region'));
		$this->db->set('offices_notes', $this->input->post('offices_notes'));
		$this->db->where('offices_id', $this->input->post('offices_id'));
		$this->db->update('offices');
		redirect('adminmaintenance');
	}
    
    public function deleteoffice($id)
	{
		$this->db->where('offices_id', $id);
		$this->db->delete('offices');
		redirect(base_url()."index.php/adminmaintenance");
	}
    
	public function newregion()
	{
		$asset_url = base_url()."assets/";
		$data['title'] = "New Region";
		$data['asset_url'] = $asset_url;

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
			$this->load->view('maintenance/newregion', $data);
			} else {
				redirect(base_url()."?error3=1");
			}
		}
	}

	public function saveregion()
	{

		$data = array(
					'region_name' => $this->input->post('regionname'),
					'region_description' => $this->input->post('regiondescription')
				);
		$this->db->insert('region', $data);
		redirect('adminmaintenance');
	}

	public function newofficer()
	{
		$asset_url = base_url()."assets/";
		$data['title'] = "New Officer";
		$data['asset_url'] = $asset_url;

		$sql1 = "SELECT * FROM offices";
	    $query1 = $this->db->query($sql1);
	    $offices = $query1->result();

	    $sql2 = "SELECT * FROM region";
	    $query2 = $this->db->query($sql2);
	    $region = $query2->result();

	    $sql3 = "SELECT * FROM mastersetting where details = 'for roles'";
	    $query3 = $this->db->query($sql3);
	    $mastersetting = $query3->result();

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

	    $data['offices'] = $offices;
	    $data['region'] = $region;
	    $data['mastersetting'] = $mastersetting;

		if($this->session->officer_role == "") {
			redirect(base_url()."index.php/messages");
		} else {
			if(isset($this->session->officer_name)) {
				$this->load->view('maintenance/newofficer', $data);
			} else {
				redirect(base_url()."?error3=1");
			}
		}
	}

	public function saveofficer()
	{

		$data = array(
					'region_name' => $this->input->post('regionname'),
					'region_description' => $this->input->post('regiondescription')
				);
		$this->db->insert('region', $data);
		redirect('adminmaintenance');
	}

	public function do_upload()
        {
                
                $config['upload_path']          = './assets/images/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 100;
                $config['max_width']            = 1024;
                $config['max_height']           = 768;

                $this->load->library('upload', $config);

                if($this->input->post('indicator') == "add") {
                	if ( ! $this->upload->do_upload('userfile'))
	                {
	                    $data = array(
									'officer_login_name' => $this->input->post('loginname'),
				                	'officer_name' => $this->input->post('name'),
				                	'officer_last_logged_date' => date("Y-m-d"),
				                	'officer_password' => $this->input->post('password'),
				                	'officer_role' => $this->input->post('roletext'),
				                	'officer_status' => 'active',
				                	'officer_photo' => '',
				                	'officer_office_id' => $this->input->post('office'),
				                	'email' => $this->input->post('email'),
				                	'officer_region' => $this->input->post('region'),
				                	'user_role_id' => $this->input->post('role')
								);

						$this->db->insert('officer', $data);
	                    redirect('adminmaintenance');
	                }
	                else
	                {
	                	$upload_data = $this->upload->data();
						$file_name = $upload_data['file_name'];

	                	$data = array(
									'officer_login_name' => $this->input->post('loginname'),
				                	'officer_name' => $this->input->post('name'),
				                	'officer_last_logged_date' => date("Y-m-d"),
				                	'officer_password' => $this->input->post('password'),
				                	'officer_role' => $this->input->post('roletext'),
				                	'officer_status' => 'active',
				                	'officer_photo' => $file_name,
				                	'officer_office_id' => $this->input->post('office'),
				                	'email' => $this->input->post('email'),
				                	'officer_region' => $this->input->post('region'),
				                	'user_role_id' => $this->input->post('role')
								);

						$this->db->insert('officer', $data);
	                    redirect('adminmaintenance');
	                }
                } else {
					if ( ! $this->upload->do_upload('userfile'))
	                {
						$this->db->set('officer_login_name', $this->input->post('loginname'));
						$this->db->set('officer_name', $this->input->post('name'));
						$this->db->set('officer_password', $this->input->post('password'));
						$this->db->set('officer_role', $this->input->post('role'));
						$this->db->set('officer_photo', '');
						$this->db->set('officer_office_id', $this->input->post('office'));
						$this->db->set('email', $this->input->post('email'));
						$this->db->set('officer_region', $this->input->post('region'));
						$this->db->where('officer_id', $this->input->post('officerid'));
						$this->db->update('officer');

	                    redirect('adminmaintenance');
	                }
	                else
	                {
	                    $upload_data = $this->upload->data();
						$file_name = $upload_data['file_name'];
						
	                	$this->db->set('officer_login_name', $this->input->post('loginname'));
						$this->db->set('officer_name', $this->input->post('name'));
						$this->db->set('officer_password', $this->input->post('password'));
						$this->db->set('officer_role', $this->input->post('role'));
						$this->db->set('officer_photo', $file_name);
						$this->db->set('officer_office_id', $this->input->post('office'));
						$this->db->set('email', $this->input->post('email'));
						$this->db->set('officer_region', $this->input->post('region'));
						$this->db->where('officer_id', $this->input->post('officerid'));
						$this->db->update('officer');
						
	                    redirect('adminmaintenance');
	                }
                }
        }

    public function newassignment()
	{
		$asset_url = base_url()."assets/";
		$data['title'] = "New Region Assignment";
		$data['asset_url'] = $asset_url;

		$sql1 = "SELECT * FROM officer";
	    $query1 = $this->db->query($sql1);
	    $officer = $query1->result();

	    $sql2 = "SELECT * FROM region";
	    $query2 = $this->db->query($sql2);
	    $region = $query2->result();

	    $data['officer'] = $officer;
	    $data['region'] = $region;

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
				$this->load->view('maintenance/newassignment', $data);
			} else {
				redirect(base_url()."?error3=1");
			}
		}
	}

	public function saveassignment()
	{
		$data = array(
					'officer_id' => $this->input->post('officer'),
					'region_id' => $this->input->post('region'),
					'city' => $this->input->post('city'),
					'datecreated' => date("Y-m-d"),
					'bactive' => 1
				);
		$this->db->insert('officerassignment', $data);
		redirect('adminmaintenance');
	}

	public function editassignment($oaid)
	{
		$asset_url = base_url()."assets/";
		$data['title'] = "Edit Region Assignment";
		$data['asset_url'] = $asset_url;

		$sql1 = "SELECT * FROM officer";
	    $query1 = $this->db->query($sql1);
	    $officer = $query1->result();

	    $sql2 = "SELECT * FROM region";
	    $query2 = $this->db->query($sql2);
	    $region = $query2->result();

	    $data['officer'] = $officer;
	    $data['region'] = $region;

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

		$sql4 = "SELECT * FROM officerassignment oa INNER JOIN officer o ON oa.oaid = o.officer_id INNER JOIN region r ON oa.region_id = r.region_id WHERE oa.oaid = $oaid";
	    $query4 = $this->db->query($sql4);
	    $officerassignment = $query4->result();

	    $data['officerassignment'] = $officerassignment;

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
				$this->load->view('maintenance/editassignment', $data);
			} else {
				redirect(base_url()."?error3=1");
			}
		}
	}

	public function saveemailcontent()
	{
		$this->db->set('iaremailheader', $this->input->post('iaremailheader'));
		$this->db->set('iaremailbody', $this->input->post('iaremailbody'));
		$this->db->set('iaremailfooter', $this->input->post('iaremailfooter'));
		$this->db->set('memailheader', $this->input->post('memailheader'));
		$this->db->set('memailbody', $this->input->post('memailbody'));
		$this->db->set('memailfooter', $this->input->post('memailfooter'));
		$this->db->set('remailheader', $this->input->post('remailheader'));
		$this->db->set('remailbody', $this->input->post('remailbody'));
		$this->db->set('remailfooter', $this->input->post('remailfooter'));
		$this->db->update('emailcontents');
		redirect('adminmaintenance');
	}

	public function saveparameters()
	{
		$this->db->set('account_name', $this->input->post('account_name'));
		$this->db->set('bank_name', $this->input->post('bank_name'));
		$this->db->set('branch_name', $this->input->post('branch_name'));
		$this->db->set('bsb_no', $this->input->post('bsb_no'));
		$this->db->set('account_no', $this->input->post('account_no'));
		$this->db->set('invoice_due_day', $this->input->post('invoice_due_day'));
		$this->db->set('invoice_prefix', $this->input->post('invoice_prefix'));
		$this->db->set('address', $this->input->post('address'));
		$this->db->set('phoneno', $this->input->post('phoneno'));
		$this->db->set('faxno', $this->input->post('faxno'));
		$this->db->set('email', $this->input->post('email'));
		$this->db->set('abn', $this->input->post('abn'));
		$this->db->set('redeemable_point', $this->input->post('redeemable_point'));
		$this->db->update('parameters');
		redirect('adminmaintenance');
	}

	public function updatepriviledge()
	{
		$this->db->set('privilege_manage_clients', $this->input->post('privilege_manage_clients'));
		$this->db->set('privilege_manage_officers', $this->input->post('privilege_manage_officers'));
		$this->db->set('privilege_manage_providers', $this->input->post('privilege_manage_providers'));
		$this->db->set('privilege_manage_studentapps', $this->input->post('privilege_manage_studentapps'));
		$this->db->set('privilege_manage_studentdocs', $this->input->post('privilege_manage_studentdocs'));
		$this->db->set('privilege_manage_commissions', $this->input->post('privilege_manage_commissions'));
		$this->db->set('privilege_manage_prapps', $this->input->post('privilege_manage_prapps'));
		$this->db->set('privilege_manage_prdocs', $this->input->post('privilege_manage_prdocs'));
		$this->db->set('privilege_manage_prfeereceived', $this->input->post('privilege_manage_prfeereceived'));
		$this->db->set('privilege_manage_prfeepaid', $this->input->post('privilege_manage_prfeepaid'));
		$this->db->set('privilege_manage_reporting', $this->input->post('privilege_manage_reporting'));
		$this->db->set('privilege_manage_channel', $this->input->post('privilege_manage_channel'));
		$this->db->set('privilege_manage_parameters', $this->input->post('privilege_manage_parameters'));
		$this->db->set('privilege_manage_privilege', $this->input->post('privilege_manage_privilege'));
		$this->db->set('privilege_manage_database', $this->input->post('privilege_manage_database'));
		$this->db->set('privilege_manage_offices', $this->input->post('privilege_manage_offices'));
		$this->db->set('privilege_view_fees', $this->input->post('privilege_view_fees'));
		$this->db->set('privilege_staff_bonus', $this->input->post('privilege_staff_bonus'));
		$this->db->set('privilege_manage_events', $this->input->post('privilege_manage_events'));
		$this->db->where('privilege_id', $this->input->post('privilege_id'));
		$this->db->update('privilege');
		//redirect('adminmaintenance');
		echo json_encode("Success");
	}

	public function editofficer($officer_id) {
		$asset_url = base_url()."assets/";
		$data['title'] = "Edit Officer";
		$data['asset_url'] = $asset_url;

		$sql1 = "SELECT * FROM offices";
	    $query1 = $this->db->query($sql1);
	    $offices = $query1->result();

	    $sql2 = "SELECT * FROM region";
	    $query2 = $this->db->query($sql2);
	    $region = $query2->result();

	    $sql3 = "SELECT * FROM mastersetting where details = 'for roles'";
	    $query3 = $this->db->query($sql3);
	    $mastersetting = $query3->result();

	    $sql4 = "SELECT * FROM officer ofr LEFT JOIN offices ofs ON ofr.officer_office_id = ofs.offices_id LEFT JOIN region r ON ofr.officer_region = r.region_id where officer_id = '$officer_id'";
	    $query4 = $this->db->query($sql4);
	    $officer = $query4->result();

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

	    $data['offices'] = $offices;
	    $data['region'] = $region;
	    $data['mastersetting'] = $mastersetting;
	    $data['officerid'] = $officer_id;
	    $data['officer'] = $officer;

		if($this->session->officer_role == "") {
			redirect(base_url()."index.php/messages");
		} else {
			if(isset($this->session->officer_name)) {
				$this->load->view('maintenance/editofficer', $data);
			} else {
				redirect(base_url()."?error3=1");
			}
		}
	}

	public function editregion($region_id)
	{
		$asset_url = base_url()."assets/";
		$data['title'] = "Edit Region";
		$data['asset_url'] = $asset_url;

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

		$sql4 = "SELECT * FROM region WHERE region_id = '$region_id'";
		$query4 = $this->db->query($sql4);
		$region = $query4->result();

		$data['region'] = $region;

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
			$this->load->view('maintenance/editregion', $data);
			} else {
				redirect(base_url()."?error3=1");
			}
		}
	}

	public function updateregion()
	{
		$this->db->set('region_name', $this->input->post('regionname'));
		$this->db->set('region_description', $this->input->post('regiondescription'));
		$this->db->where('region_id', $this->input->post('regionid'));
		$this->db->update('region');
		redirect('adminmaintenance');
	}

	public function updateassignment()
	{
		$this->db->set('officer_id', $this->input->post('officer'));
		$this->db->set('region_id', $this->input->post('region'));
		$this->db->set('city', $this->input->post('city'));
		$this->db->where('oaid', $this->input->post('oaid'));
		$this->db->update('officerassignment');
		redirect('adminmaintenance');
	}

	public function deactivateofficer($officer_id)
	{
		$this->db->set('officer_status', 'inactive');
		$this->db->where('officer_id', $officer_id);
		$this->db->update('officer');
		//echo json_encode("Successfully done reset!");
		redirect(base_url()."index.php/adminmaintenance");
	}

	public function deactivateassignment($assignment_id)
	{
		$this->db->set('bactive', '0');
		$this->db->where('oaid', $assignment_id);
		$this->db->update('officerassignment');
		//echo json_encode("Successfully done reset!");
		redirect(base_url()."index.php/adminmaintenance");
	}

	public function deleteregion($region_id)
	{
		$this->db->where('region_id', $region_id);
		$this->db->delete('region');
		//echo json_encode("Successfully done reset!");
		redirect(base_url()."index.php/adminmaintenance");
	}

	public function deleteevent($event_id)
	{
		$this->db->where('event_id', $event_id);
		$this->db->delete('events');
		//echo json_encode("Successfully done reset!");
		redirect(base_url()."index.php/adminmaintenance");
	}

}