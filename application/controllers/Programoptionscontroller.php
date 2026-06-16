<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Programoptionscontroller extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->helper('form');
	}
	
	public function newprogramoption($client_id)
	{
		$asset_url = base_url()."assets/";
		$data['title'] = "Program Options";
		$data['asset_url'] = $asset_url;
		$data['client_id'] = $client_id;

		//$poidnew = 0;

		$sql = "SELECT * FROM education_provider";
	    $query = $this->db->query($sql);
	    $schools = $query->result();
	    
	    $sql = "SELECT * FROM scholarships";
	    $query = $this->db->query($sql);
	    $scholarships = $query->result();
	    
	    $sql4 = "SELECT * FROM student_application sp INNER JOIN education_provider ep ON sp.provider_id = ep.provider_id where client_id = '$client_id'";
	    $query4 = $this->db->query($sql4);
	    $applications = $query4->result();

	    $data['schools'] = $schools;
	    $data['applications'] = $applications;
	    $data['scholarships'] = $scholarships;

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
				$this->load->view('programoptions/newprogramoptions', $data);
			} else {
				redirect(base_url()."?error3=1");
			}
		}
	}

// 	public function saveprogramoptions() {
// // 		if($this->input->post('birthday') == "") {
// // 			$birthday = NULL;
// // 		} else {
// // 			$birthday = $this->input->post('birthday');
// // 		}

// 		$data = array(
// 					'provider_id' => $this->input->post('provider_id'),
// 					'sp_id' => $this->input->post('sp_id'),
// 					'indicativeannualcost' => str_replace(",","", str_replace(" ","",$this->input->post('indicativeannualcost'))),
// 					'duration' => $this->input->post('duration'),
// 					'location' => $this->input->post('location'),
// 					'englishrequirement' => $this->input->post('englishrequirement'),
// 					'intake' => $this->input->post('intake'),
// 				// 	'importanttoconsider' => $this->input->post('importanttoconsider'),
// 				// 	'migrationpathway' => $this->input->post('migrationpathway'),
// 					'prepby' => $this->session->officer_id,
// 					'prepdate' => date("Y-m-d"),
// 					'client_id' => $this->input->post('client_id'),
// 					'status' => 'Created',
// 					'others' => $this->input->post('others'),
// 					'clientfeedback' => '',
// 				// 	'birthday' => $birthday,
// 					'programlink' => $this->input->post('programlink'),
// 					'cricoscode' => $this->input->post('cricoscode'),
// 				// 	'englishtestresult' => $this->input->post('englishtestresult'),
// 					'application_id' => $this->input->post('application_id'),
// 					'remarks' => $this->input->post('remarks'),
// 					'followupdate' => $this->input->post('followupdate'),
// 					'processstatus' => 'Waiting',
// 					'dateofpayment' => $this->input->post('dateofpayment'),
// 					'numberofdependent' => $this->input->post('numberofdependent') !== '' ? $this->input->post('numberofdependent') : 0,
// 					'schoollink' => $this->input->post('schoollink'),
// 					'scholarship_id' => $this->input->post('scholarship_id'),
// 					'campuslocation' => $this->input->post('campuslocation')
// 				);
// 		$this->db->insert('programoptions', $data);
// 		redirect('editclientinfo2/'.$this->input->post('client_id')."#counselling");
// 	}

    public function saveprogramoptions() {
        // File upload configuration
        $config['upload_path']   = './assets/pofiles/'; // Make sure this folder exists and is writable
        $config['allowed_types'] = 'jpg|jpeg|png|pdf|doc|docx';
        $config['max_size']      = 99999; // 
        $config['encrypt_name'] = true;
    
        $this->load->library('upload', $config);
    
        $pofile_name = null;
    
        if (!empty($_FILES['pofile']['name'])) {
            if (!$this->upload->do_upload('pofile')) {
                // Upload failed
                $error = $this->upload->display_errors();
                $this->session->set_flashdata('error', $error);
                // redirect($_SERVER['HTTP_REFERER']);
                echo $error;
                return;
            } else {
                // Upload success
                $upload_data = $this->upload->data();
                $pofile_name = $upload_data['file_name'];
            }
        }
    
        // Prepare data for insert
        $data = array(
            'provider_id'         => $this->input->post('provider_id'),
            'sp_id'               => $this->input->post('sp_id'),
            'indicativeannualcost'=> str_replace(",", "", str_replace(" ", "", $this->input->post('indicativeannualcost'))),
            'duration'            => $this->input->post('duration'),
            'location'            => $this->input->post('location'),
            'englishrequirement'  => $this->input->post('englishrequirement'),
            'intake'              => $this->input->post('intake'),
            'prepby'              => $this->session->officer_id,
            'prepdate'            => date("Y-m-d"),
            'client_id'           => $this->input->post('client_id'),
            'status'              => 'Created',
            'others'              => $this->input->post('others'),
            'clientfeedback'      => '',
            'programlink'         => $this->input->post('programlink'),
            'cricoscode'          => $this->input->post('cricoscode'),
            'application_id'      => $this->input->post('application_id'),
            'remarks'             => $this->input->post('remarks'),
            'followupdate'        => $this->input->post('followupdate'),
            'processstatus'       => 'Waiting',
            'dateofpayment'       => $this->input->post('dateofpayment'),
            'numberofdependent'   => $this->input->post('numberofdependent') !== '' ? $this->input->post('numberofdependent') : 0,
            'schoollink'          => $this->input->post('schoollink'),
            'scholarship_id'      => $this->input->post('scholarship_id'),
            'campuslocation'      => $this->input->post('campuslocation'),
            'pofile'              => $pofile_name // store file name in DB
        );
    
        $this->db->insert('programoptions', $data);
    
        redirect('editclientinfo2/' . $this->input->post('client_id') . "#counselling");
    }

// 	public function updateprogramoptions() {
// 		if($this->input->post('birthday') == "") {
// 			$birthday = NULL;
// 		} else {
// 			$birthday = $this->input->post('birthday');
// 		}

// 		$this->db->set('provider_id', $this->input->post('provider_id'));
// 		$this->db->set('sp_id', $this->input->post('sp_id'));
// 		$this->db->set('indicativeannualcost', str_replace(",","", str_replace(" ","",$this->input->post('indicativeannualcost'))));
// 		$this->db->set('duration', $this->input->post('duration'));
// 		$this->db->set('location', $this->input->post('location'));
// 		$this->db->set('englishrequirement', $this->input->post('englishrequirement'));
// 		$this->db->set('intake', $this->input->post('intake'));
// // 		$this->db->set('importanttoconsider', $this->input->post('importanttoconsider'));
// // 		$this->db->set('migrationpathway', $this->input->post('migrationpathway'));
// 		$this->db->set('client_id', $this->input->post('client_id'));
// 		$this->db->set('others', $this->input->post('others'));
// 		$this->db->set('programlink', $this->input->post('programlink'));
// // 		$this->db->set('birthday', $birthday);
// 		$this->db->set('cricoscode', $this->input->post('cricoscode'));
// // 		$this->db->set('englishtestresult', $this->input->post('englishtestresult'));
// 		$this->db->set('application_id', $this->input->post('application_id'));
// 		$this->db->set('remarks', $this->input->post('remarks'));
// 		$this->db->set('followupdate', $this->input->post('followupdate'));
		
// 		$this->db->set('dateofpayment', $this->input->post('dateofpayment') !== '' ? $this->input->post('dateofpayment') : null);
// 		$this->db->set('schoollink', $this->input->post('schoollink'));
// 		$this->db->set('numberofdependent', $this->input->post('numberofdependent') !== '' ? $this->input->post('numberofdependent') : 0);
// 		$this->db->set('scholarship_id', $this->input->post('scholarship_id'));
// 		$this->db->set('processstatus', $this->input->post('processstatus') !== '' ? $this->input->post('processstatus') : null);
// 		$this->db->set('campuslocation', $this->input->post('campuslocation') !== '' ? $this->input->post('campuslocation') : null);
// 		$this->db->where('poid', $this->input->post('poid'));
// 		$this->db->update('programoptions');
		
// 		redirect('editclientinfo2/'.$this->input->post('client_id')."#counselling");
// 	}

    public function updateprogramoptions() {
        // --- Handle optional file upload for `pofile` ---
        $upload_path = FCPATH . 'assets/pofiles/'; // absolute path next to index.php
    
        // Ensure folder exists & is writable
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, true);
        }
        if (!is_writable($upload_path)) {
            show_error('Upload folder is not writable: ' . $upload_path);
        }
    
        $config = [
            'upload_path'   => $upload_path,
            'allowed_types' => 'jpg|jpeg|png|pdf|doc|docx',
            'max_size'      => 2048,
            'encrypt_name'  => true,
        ];
    
        $this->load->library('upload');
        $this->upload->initialize($config);
    
        $poid = $this->input->post('poid');
    
        // If a new file is selected, try to upload
        if (!empty($_FILES['pofile']['name'])) {
            if (!$this->upload->do_upload('pofile')) {
                $error = $this->upload->display_errors('', '');
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
                return;
            }
    
            // Upload OK: set new filename and delete old file (if any)
            $upload_data = $this->upload->data();
            $new_filename = $upload_data['file_name'];
    
            // Get old filename
            $old = $this->db->select('pofile')->from('programoptions')->where('poid', $poid)->get()->row();
            if (!empty($old->pofile) && file_exists($upload_path . $old->pofile)) {
                @unlink($upload_path . $old->pofile);
            }
    
            $this->db->set('pofile', $new_filename);
        }
    
        // --- Regular fields ---
        $this->db->set('provider_id', $this->input->post('provider_id'));
        $this->db->set('sp_id', $this->input->post('sp_id'));
        $this->db->set('indicativeannualcost', str_replace(",", "", str_replace(" ", "", $this->input->post('indicativeannualcost'))));
        $this->db->set('duration', $this->input->post('duration'));
        $this->db->set('location', $this->input->post('location'));
        $this->db->set('englishrequirement', $this->input->post('englishrequirement'));
        $this->db->set('intake', $this->input->post('intake'));
        $this->db->set('client_id', $this->input->post('client_id'));
        $this->db->set('others', $this->input->post('others'));
        $this->db->set('programlink', $this->input->post('programlink'));
        $this->db->set('cricoscode', $this->input->post('cricoscode'));
        $this->db->set('application_id', $this->input->post('application_id'));
        $this->db->set('remarks', $this->input->post('remarks'));
        $this->db->set('followupdate', $this->input->post('followupdate'));
        $this->db->set('dateofpayment', $this->input->post('dateofpayment') !== '' ? $this->input->post('dateofpayment') : null);
        $this->db->set('schoollink', $this->input->post('schoollink'));
        $this->db->set('numberofdependent', $this->input->post('numberofdependent') !== '' ? $this->input->post('numberofdependent') : 0);
        $this->db->set('scholarship_id', $this->input->post('scholarship_id'));
        $this->db->set('processstatus', $this->input->post('processstatus') !== '' ? $this->input->post('processstatus') : null);
        $this->db->set('campuslocation', $this->input->post('campuslocation') !== '' ? $this->input->post('campuslocation') : null);
    
        $this->db->where('poid', $poid);
        $this->db->update('programoptions');
    
        redirect('editclientinfo2/' . $this->input->post('client_id') . "#counselling");
    }

	public function editprogramoption($poid)
	{
		$asset_url = base_url()."assets/";
		$data['title'] = "Program Options ID #".$poid;
		$data['asset_url'] = $asset_url;
		$data['poid'] = $poid;

        $client_id = 0;

		//$poidnew = 0;

		$sql6 = "SELECT *, po.intake as pointake, po.campuslocation as pocampuslocation FROM programoptions po inner join education_provider s on po.provider_id = s.provider_id inner join schoolprograms sp on sp.spid = po.sp_id where po.poid = '$poid'";
        $query6 = $this->db->query($sql6);
        $programoptions = $query6->result();
        
        foreach ($programoptions as $row) {
            $client_id = $row->client_id;
            
            $provider_id = $row->provider_id;
            $sql = "SELECT * FROM schoolprograms WHERE provider_id = $provider_id";
    	    $query = $this->db->query($sql);
    	    $programs = $query->result();
        }

        // $sql7 = "SELECT * FROM programoptionsdetails pod where poid = '$poid'";
        // $query7 = $this->db->query($sql7);
        // $programoptionsdetails = $query7->result();

        $sql9 = "SELECT * FROM programoptionsdetaileipwithdependent where poid = '$poid'";
        $query9 = $this->db->query($sql9);
        $programoptionsdetaileipwithdependent = $query9->result();

        $sql9 = "SELECT * FROM programoptionsdetaileipwithoutdependent where poid = '$poid'";
        $query9 = $this->db->query($sql9);
        $programoptionsdetaileipwithoutdependent = $query9->result();

        $sql9 = "SELECT * FROM programoptionsdetailwithdependent where poid = '$poid'";
        $query9 = $this->db->query($sql9);
        $programoptionsdetailwithdependent = $query9->result();

        $sql9 = "SELECT * FROM programoptionsdetailwithoutdependent where poid = '$poid'";
        $query9 = $this->db->query($sql9);
        $programoptionsdetailwithoutdependent = $query9->result();
        
        $sql9 = "SELECT * FROM newprogramoptionsdetails where poid = '$poid'";
        $query9 = $this->db->query($sql9);
        $newprogramoptionsdetails = $query9->result();
        
        $sql4 = "SELECT * FROM student_application sp INNER JOIN education_provider ep ON sp.provider_id = ep.provider_id where client_id = '$client_id'";
	    $query4 = $this->db->query($sql4);
	    $applications = $query4->result();

        $data['programoptions'] = $programoptions;
        // $data['programoptionsdetails'] = $programoptionsdetails;
        $data['programoptionsdetaileipwithdependent'] = $programoptionsdetaileipwithdependent;
        $data['programoptionsdetaileipwithoutdependent'] = $programoptionsdetaileipwithoutdependent;
        $data['programoptionsdetailwithdependent'] = $programoptionsdetailwithdependent;
        $data['programoptionsdetailwithoutdependent'] = $programoptionsdetailwithoutdependent;
        $data['applications'] = $applications;
        $data['newprogramoptionsdetails'] = $newprogramoptionsdetails;
        
		$sql = "SELECT * FROM education_provider";
	    $query = $this->db->query($sql);
	    $schools = $query->result();

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
				$this->load->view('programoptions/editprogramoptions', $data);
			} else {
				redirect(base_url()."?error3=1");
			}
		}
	}

	public function newprogramoptiondetails($poid)
	{
		$asset_url = base_url()."assets/";
		$data['title'] = "Program Option Details";
		$data['asset_url'] = $asset_url;
		$data['poid'] = $poid;

		//$poidnew = 0;

		$sql = "SELECT * FROM education_provider";
	    $query = $this->db->query($sql);
	    $schools = $query->result();

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
				$this->load->view('programoptions/newprogramoptiondetails', $data);
			} else {
				redirect(base_url()."?error3=1");
			}
		}
	}

	public function editprogramoptiondetails($podid)
	{
		$asset_url = base_url()."assets/";
		$data['title'] = "Program Option Details";
		$data['asset_url'] = $asset_url;
		$data['podid'] = $podid;

		//$poidnew = 0;

		$sql7 = "SELECT * FROM programoptionsdetails pod where podid = '$podid'";
        $query7 = $this->db->query($sql7);
        $programoptionsdetails = $query7->result();

		$data['programoptionsdetails'] = $programoptionsdetails;

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
				$this->load->view('programoptions/editprogramoptiondetails', $data);
			} else {
				redirect(base_url()."?error3=1");
			}
		}
	}

	public function saveprogramoptiondetails() {
		$data = array(
					'poid' => $this->input->post('poid'),
					'expensestype' => $this->input->post('expensestype'),
					'perperson' => str_replace(",","", str_replace(" ","",$this->input->post('perperson'))),
					'amountrequired' => str_replace(",","", str_replace(" ","",$this->input->post('amountrequired'))),
					'numberoffamily' => str_replace(",","", str_replace(" ","",$this->input->post('numberoffamily'))),
					'amounttoaccess' => str_replace(",","", str_replace(" ","",$this->input->post('amounttoaccess'))),
					'confirmaccesstofunds' => str_replace(",","", str_replace(" ","",$this->input->post('confirmaccesstofunds')))
				);
		$this->db->insert('programoptionsdetails', $data);
		redirect(base_url().'index.php/editprogramoptions/'.$this->input->post('poid'));
	}

	public function updateprogramoptiondetails() {
		$this->db->set('expensestype', $this->input->post('expensestype'));
		$this->db->set('perperson', str_replace(",","", str_replace(" ","",$this->input->post('perperson'))));
		$this->db->set('amountrequired', str_replace(",","", str_replace(" ","",$this->input->post('amountrequired'))));
		$this->db->set('numberoffamily', str_replace(",","", str_replace(" ","",$this->input->post('numberoffamily'))));
		$this->db->set('amounttoaccess', str_replace(",","", str_replace(" ","",$this->input->post('amounttoaccess'))));
		$this->db->set('confirmaccesstofunds', str_replace(",","", str_replace(" ","",$this->input->post('confirmaccesstofunds'))));
		$this->db->where('podid', $this->input->post('podid'));
		$this->db->update('programoptionsdetails');

		redirect(base_url().'index.php/editprogramoptions/'.$this->input->post('podid'));
	}

	public function acceptpo() {
		$this->db->set('status', 'Accepted');
		$this->db->where('poid', $this->input->post('poid'));
		$this->db->update('programoptions');

		$this->db->where('poid', $this->input->post('poid'));
        $poquery = $this->db->get('programoptions');

		foreach ($poquery->result() as $porow)
		{
		        $this->db->where('sender_id', $porow->prepby);
		        $this->db->where('receiver_id', $porow->client_id);
		        $threadquery = $this->db->get('thread');

				foreach ($threadquery->result() as $threadrow)
				{
					$data = array(
						'thread_id' => $threadrow->thread_id,
						'message' => 'Hello! Thank you for accepting the PO, please download and fill-up the following files and send it back to us once done. Thank you!',
						'message_from' => $porow->prepby,
						'message_type' => 'text',
						'message_status' => 'Sent',
						'message_date' => date("Y-m-d"),
						'message_time' => date("H:i:s"),
						'message_date_time' => date("Y-m-d H:i:s")
					);
					$this->db->insert('thread_conversations', $data);

					$data = array(
						'thread_id' => $threadrow->thread_id,
						'message' => "<a href='".base_url()."assets/forms/956_Form.pdf'>956_Form.pdf<a>",
						'message_from' => $porow->prepby,
						'message_type' => 'file',
						'message_status' => 'Sent',
						'message_date' => date("Y-m-d"),
						'message_time' => date("H:i:s"),
						'message_date_time' => date("Y-m-d H:i:s")
					);
					$this->db->insert('thread_conversations', $data);

					$data = array(
						'thread_id' => $threadrow->thread_id,
						'message' => "<a href='".base_url()."assets/forms/PROGRESS_ADMISSION_FORMS.docx'>PROGRESS_ADMISSION_FORMS.docx<a>",
						'message_from' => $porow->prepby,
						'message_type' => 'text',
						'message_status' => 'Sent',
						'message_date' => date("Y-m-d"),
						'message_time' => date("H:i:s"),
						'message_date_time' => date("Y-m-d H:i:s")
					);
					$this->db->insert('thread_conversations', $data);

					$data = array(
						'thread_id' => $threadrow->thread_id,
						'message' => "<a href='".base_url()."assets/forms/PROGRESS_STUDY_VISA_APPLICATION_FORM.docx'>PROGRESS_STUDY_VISA_APPLICATION_FORM.docx<a>",
						'message_from' => $porow->prepby,
						'message_type' => 'text',
						'message_status' => 'Sent',
						'message_date' => date("Y-m-d"),
						'message_time' => date("H:i:s"),
						'message_date_time' => date("Y-m-d H:i:s")
					);
					$this->db->insert('thread_conversations', $data);

				}
		}

		$this->posuccess('accepted', $this->input->post('poid'));
	}

	public function rejectpo($poid) {
		$this->db->set('status', 'Rejected');
		$this->db->where('poid', $poid);
		$this->db->update('programoptions');

		//redirect(base_url().'index.php/posuccess?result=reject&poid='.$this->input->post('poid'));
		$this->posuccess('rejected', $poid);
	}

	public function posuccess($status, $poid) {
		$data['poid'] = $poid;
		$data['status'] = $status;

		$asset_url = base_url()."assets/";
		$data['title'] = "PO Response";
		$data['asset_url'] = $asset_url;

		$this->load->view('forms/posuccess', $data);;
	}

	public function saveclientfeedback() {
		$this->db->set('clientfeedback', $this->input->post('feedback'));
		$this->db->where('poid', $this->input->post('poid'));
		$this->db->update('programoptions');

		$asset_url = base_url()."assets/";
		$data['title'] = "Success Feedback";
		$data['asset_url'] = $asset_url;

		$this->load->view('forms/clientfeedbacksuccess', $data);
	}

	public function deletepo($poid, $client_id)
	{
	    $this->db->where('poid', $poid);
        $pos = $this->db->get('programoptions');
        $burl = base_url()."index.php/editclientinfo2/".$client_id."#counselling";
        
        $pos2 = $pos->result();
        // print_r($pos2[0]->status);
        
        if($pos2[0]->status != "Created") {
            if($pos2[0]->status != "Rejected") {
                if($pos2[0]->application_id == "0") {
                    echo "<script>alert('PO was already accepted and already contained student application!'); window.location.href = '".$burl."';</script>";
                } else {
                    echo "<script>alert('PO was already accepted!'); window.location.href = '".$burl."';</script>";
                }
            } elseif($pos2[0]->status == "Rejected") {
                $this->db->where('poid', $poid);
		        $this->db->delete('programoptions');
		        redirect(base_url()."index.php/editclientinfo2/".$client_id."#counselling");
            }
        } elseif($pos2[0]->status == "Created") {
            $this->db->where('poid', $poid);
		    $this->db->delete('programoptions');
		    redirect(base_url()."index.php/editclientinfo2/".$client_id."#counselling");
        }
        
        // else {
            
        // }
	    
// 		$this->db->where('poid', $poid);
// 		$this->db->delete('programoptions');
		//echo json_encode("Successfully done reset!");
		//redirect(base_url()."index.php/editclientinfo2/".$client_id."#counselling");
	}

	public function newprogramoptiondetailwithoutdependent($poid)
	{
		$asset_url = base_url()."assets/";
		$data['title'] = "New Program Option Detail Without Dependent for PO #".$poid;
		$data['asset_url'] = $asset_url;
		$data['poid'] = $poid;

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
				$this->load->view('programoptions/newprogramoptiondetailwithoutdependent', $data);
			} else {
				redirect(base_url()."?error3=1");
			}
		}
	}

	public function saveprogramoptiondetailwithoutdependent() {
		$data = array(
					'poid' => $this->input->post('poid'),
					'category' => $this->input->post('category'),
					'type' => $this->input->post('type'),
					'woscholarship' => $this->input->post('woscholarship'),
					'wscholarship' => $this->input->post('wscholarship')
				);
		$this->db->insert('programoptionsdetailwithoutdependent', $data);
		redirect(base_url().'index.php/editprogramoptions/'.$this->input->post('poid'));
	}

	public function deleteprogramoptiondetailnew($poid, $id)
	{
		$this->db->where('id', $id);
		$this->db->delete('newprogramoptionsdetails');
		redirect(base_url().'index.php/editprogramoptions/'.$poid);
	}

	public function newprogramoptiondetailwithdependent($poid)
	{
		$asset_url = base_url()."assets/";
		$data['title'] = "New Program Option Detail With Dependent for PO #".$poid;
		$data['asset_url'] = $asset_url;
		$data['poid'] = $poid;

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
				$this->load->view('programoptions/newprogramoptiondetailwithdependent', $data);
			} else {
				redirect(base_url()."?error3=1");
			}
		}
	}

	public function saveprogramoptiondetailwithdependent() {
		$data = array(
					'poid' => $this->input->post('poid'),
					'category' => $this->input->post('category'),
					'type' => $this->input->post('type'),
					'woscholarship' => $this->input->post('woscholarship'),
					'wscholarship' => $this->input->post('wscholarship')
				);
		$this->db->insert('programoptionsdetailwithdependent', $data);
		redirect(base_url().'index.php/editprogramoptions/'.$this->input->post('poid'));
	}

	public function deleteprogramoptiondetailwithdependent($poid, $id)
	{
		$this->db->where('id', $id);
		$this->db->delete('programoptionsdetailwithdependent');
		redirect(base_url().'index.php/editprogramoptions/'.$poid);
	}

	public function newprogramoptiondetaileipwithoutdependent($poid)
	{
		$asset_url = base_url()."assets/";
		$data['title'] = "New Estimated Initial Payment Without Dependent for PO #".$poid;
		$data['asset_url'] = $asset_url;
		$data['poid'] = $poid;

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
				$this->load->view('programoptions/newprogramoptiondetaileipwithoutdependent', $data);
			} else {
				redirect(base_url()."?error3=1");
			}
		}
	}

	public function saveprogramoptiondetaileipwithoutdependent() {
		$data = array(
					'poid' => $this->input->post('poid'),
					'type' => $this->input->post('type'),
					'woscholarship' => $this->input->post('woscholarship'),
					'wscholarship' => $this->input->post('wscholarship')
				);
		$this->db->insert('programoptionsdetaileipwithoutdependent', $data);
		redirect(base_url().'index.php/editprogramoptions/'.$this->input->post('poid'));
	}

	public function deleteprogramoptiondetaileipwithoutdependent($poid, $id)
	{
		$this->db->where('id', $id);
		$this->db->delete('programoptionsdetaileipwithoutdependent');
		redirect(base_url().'index.php/editprogramoptions/'.$poid);
	}

	public function newprogramoptiondetaileipwithdependent($poid)
	{
		$asset_url = base_url()."assets/";
		$data['title'] = "New Estimated Initial Payment With Dependent for PO #".$poid;
		$data['asset_url'] = $asset_url;
		$data['poid'] = $poid;

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
				$this->load->view('programoptions/newprogramoptiondetaileipwithdependent', $data);
			} else {
				redirect(base_url()."?error3=1");
			}
		}
	}

	public function saveprogramoptiondetaileipwithdependent() {
		$data = array(
					'poid' => $this->input->post('poid'),
					'type' => $this->input->post('type'),
					'woscholarship' => $this->input->post('woscholarship'),
					'wscholarship' => $this->input->post('wscholarship')
				);
		$this->db->insert('programoptionsdetaileipwithdependent', $data);
		redirect(base_url().'index.php/editprogramoptions/'.$this->input->post('poid'));
	}

	public function deleteprogramoptiondetaileipwithdependent($poid, $id)
	{
		$this->db->where('id', $id);
		$this->db->delete('programoptionsdetaileipwithdependent');
		redirect(base_url().'index.php/editprogramoptions/'.$poid);
	}
	
	public function newpotemplate($client_id) {
	    $asset_url = base_url()."assets/";
		$data['title'] = "New PO Template";
		$data['asset_url'] = $asset_url;
		
	    $data['client_id'] = $client_id;
	    $this->load->view('programoptions/newpotemplate', $data);
	}
	
	
	public function programoptionsdetailsnew($poid)
	{
		$asset_url = base_url()."assets/";
		$data['title'] = "New Payment Details for PO #".$poid;
		$data['asset_url'] = $asset_url;
		$data['poid'] = $poid;
		
		$sql6 = "SELECT * FROM programoptions po inner join scholarships sch on sch.scholarshipid = po.scholarship_id inner join mastersetting ms on sch.paymenttype = ms.id where po.poid = '$poid'";
        $query6 = $this->db->query($sql6);
        $programoptions = $query6->result();
        
        $data['programoptions'] = $programoptions;

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
				$this->load->view('programoptions/programoptionsdetailsnew', $data);
			} else {
				redirect(base_url()."?error3=1");
			}
		}
	}
	
	public function saveprogramoptionsdetailsnew() {
	    if($this->input->post('wscholarship') == "") {
	        $ws = 0;
	    } else {
	        $ws = $this->input->post('wscholarship');
	    }
	    
		$data = array(
					'poid' => $this->input->post('poid'),
					'table_category' => $this->input->post('tablecategory'),
					'cost_category' => $this->input->post('costcategory'),
					'payment_type' => $this->input->post('paymenttype'),
					'amount_with_scholarship' => $ws,
					'amount_without_scholarship' => $this->input->post('woscholarship')
				);
		$this->db->insert('newprogramoptionsdetails', $data);
		redirect(base_url().'index.php/editprogramoptions/'.$this->input->post('poid'));
	}
	
	public function getscholarshopfromschool($schoolid) {
		$sql3 = "SELECT * FROM `scholarships` sch INNER JOIN mastersetting ms ON sch.paymenttype = ms.id WHERE `school` = $schoolid";
	    $query3 = $this->db->query($sql3);
	    $program = $query3->result();
	    echo json_encode($program);
	}
	
	public function getprogramdetails($spid) {
		$sql3 = "SELECT * FROM schoolprograms where spid  = $spid";
	    $query3 = $this->db->query($sql3);
	    $program = $query3->result();
	    echo json_encode($program);
	}
	
}