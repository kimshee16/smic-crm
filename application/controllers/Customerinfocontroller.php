<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customerinfocontroller extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->helper('form');
	}

	public function index()
	{

		$sql = "SELECT *,
		        c.client_id AS ctclientid,
		        CASE 
                    WHEN sa.studentapp_course_name REGEXP '^[0-9]+(\.[0-9]+)?$' THEN spro.program
                    ELSE sa.studentapp_course_name 
                END AS course_actual_name
		        FROM client c 
		        LEFT JOIN student_application sa ON c.client_id = sa.client_id 
		        LEFT JOIN education_provider ep ON sa.provider_id = ep.provider_id 
		        LEFT JOIN programoptions po ON po.application_id = sa.studentapp_id 
		        LEFT JOIN officer o ON c.client_officer_id = o.officer_id
		        LEFT JOIN (
    	           SELECT spid,program FROM schoolprograms
    	        ) spro ON spro.spid = sa.studentapp_course_name
		        WHERE client_flag = 'active' 
		        ORDER BY c.client_id DESC";
        $query = $this->db->query($sql);
        $result = $query->result();

        $sql2 = "SELECT * FROM officer";
        $query2 = $this->db->query($sql2);
        $result2 = $query2->result();

        $asset_url = base_url()."assets/";
		$data['title'] = "Client Information";
		$data['asset_url'] = $asset_url;
		$data['clients'] = $result;
		$data['officer'] = $result2;

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

		if(isset($this->session->officer_name)) {
			$this->load->view('customerinfo/index', $data);
		} else {
			redirect(base_url()."?error3=1");
		}

	}

	public function editclientinfo($client_id) 
	{
		$sql1 = "SELECT * FROM client WHERE client_id = '$client_id'";
        $query1 = $this->db->query($sql1);
        $client = $query1->result();

        $sql2 = "SELECT * FROM offices";
        $query2 = $this->db->query($sql2);
        $offices = $query2->result();

        $sql3 = "SELECT * FROM events";
        $query3 = $this->db->query($sql3);
        $events = $query3->result();

        $sql4 = "SELECT * FROM student_application sa inner join education_provider s on sa.provider_id = s.provider_id inner join client c on c.client_id = sa.client_id where sa.client_id = $client_id";
        $query4 = $this->db->query($sql4);
        $student_application = $query4->result();

        $sql5 = "SELECT * FROM clientscholarship cs inner join client c on c.client_id = cs.clientid inner join scholarships s on s.scholarshipid = cs.scholarshipid";
	    $query5 = $this->db->query($sql5);
	    $clientscholarship = $query5->result();

	    $sql6 = "SELECT * FROM programoptions po inner join education_provider s on po.provider_id = s.provider_id inner join schoolprograms sp on sp.spid = po.sp_id where po.client_id = '$client_id'";
        $query6 = $this->db->query($sql6);
        $programoptions = $query6->result();
        
        $sql7 = "SELECT * FROM interview client_id = $client_id";
        $query7 = $this->db->query($sql7);
        $interviews = $query7->result();

        $data['client'] = $client;
        $data['offices'] = $offices;
		$data['events'] = $events;
		$data['student_application'] = $student_application;
		$data['clientscholarship'] = $clientscholarship;
		$data['programoptions'] = $programoptions;
		$data['interviews'] = $interviews;

		$asset_url = base_url()."assets/";
		$data['title'] = "Edit/View Client Information";
		$data['asset_url'] = $asset_url;

		if($this->session->officer_role == "") {
			redirect(base_url()."index.php/messages");
		} else {
			if(isset($this->session->officer_name)) {
				$this->load->view('customerinfo/editclientinfo', $data);
			} else {
				redirect(base_url()."?error3=1");
			}
		}
	}

	public function enterclientinfo($inquiry_id) {
	    
		$sql1 = "SELECT client_id FROM client WHERE client_inquiries_id = '$inquiry_id'";
		$query1 = $this->db->query($sql1);

		foreach($query1->result() as $row) {
			redirect(base_url()."index.php/editclientinfo2/".$row->client_id);
		}

	}

	public function editclientinfo2($client_id)
	{
		$sql1 = "SELECT * FROM client WHERE client_id = '$client_id'";
        $query1 = $this->db->query($sql1);
        $client = $query1->result();

        $sql2 = "SELECT * FROM offices";
        $query2 = $this->db->query($sql2);
        $offices = $query2->result();

        $sql3 = "SELECT * FROM events";
        $query3 = $this->db->query($sql3);
        $events = $query3->result();

        $sql4 = "SELECT *, sa.intake AS saintake FROM student_application sa inner join education_provider s on sa.provider_id = s.provider_id inner join client c on c.client_id = sa.client_id inner join schoolprograms sp on sa.studentapp_course_name = sp.spid where sa.client_id = $client_id";
        $query4 = $this->db->query($sql4);
        $student_application = $query4->result();

        $sql5 = "SELECT * FROM clientscholarship cs inner join client c on c.client_id = cs.clientid inner join scholarships s on s.scholarshipid = cs.scholarshipid where cs.clientid = '$client_id' and cs.bactive = 1";
	    $query5 = $this->db->query($sql5);
	    $clientscholarship = $query5->result();

	    $sql6 = "SELECT * FROM visa_application va inner join client c on va.client_id = c.client_id where va.client_id = $client_id";
	    $query6 = $this->db->query($sql6);
	    $visa_application = $query6->result();

	    $sql7 = "SELECT * FROM expression_of_interest eoi inner join client c on eoi.client_id = c.client_id where eoi.client_id = $client_id";
	    $query7 = $this->db->query($sql7);
	    $eoi = $query7->result();

	    $sql8 = "SELECT * FROM visa_accounts vac inner join visa_application vap on vac.client_visa_id = vap.client_visa_id inner join client c on vap.client_id = c.client_id where vap.client_id = $client_id";
	    $query8 = $this->db->query($sql8);
	    $visa_accounts = $query8->result();

	    $sql9 = "SELECT * from payments p inner join client c on p.payee = c.client_id inner join officer o on o.officer_id = p.processedby inner join mastersetting m on p.paymenttype = m.id where p.barchived = 0 and p.payee = $client_id";
	    $query9 = $this->db->query($sql9);
	    $payments = $query9->result();

	    $sql10 = "SELECT *, po.intake as pointake, po.campuslocation as pocampuslocation FROM programoptions po inner join education_provider s on po.provider_id = s.provider_id inner join schoolprograms sp on sp.spid = po.sp_id where po.client_id = '$client_id'";
        $query10 = $this->db->query($sql10);
        $programoptions = $query10->result();

        $sql11 = "SELECT * FROM officer";
        $query11 = $this->db->query($sql11);
        $officer = $query11->result();
        
        $sql12 = "SELECT * FROM interviews WHERE client_id = $client_id";
        $query12 = $this->db->query($sql12);
        $interviews = $query12->result();
        
        $sql13 = "SELECT * FROM fee_receipts WHERE client_id = $client_id";
        $query13 = $this->db->query($sql13);
        $fees = $query13->result();
        
        $sql14 = "SELECT * FROM firebasefiles WHERE client_id = $client_id";
        $query14 = $this->db->query($sql14);
        $firebasefiles = $query14->result();
        
        $sql15 = "SELECT * FROM admissionofferletter WHERE client_id = $client_id";
        $query15 = $this->db->query($sql15);
        $admissionofferletter = $query15->result();
        
        $sql16 = "SELECT * FROM result WHERE client_id = $client_id";
        $query16 = $this->db->query($sql16);
        $result = $query16->result();

        $this->db->where('privilege_id', $this->session->officer_role_id);
        $query3 = $this->db->get('privilege');

		foreach ($query3->result() as $row3)
		{
		        $data['privilege_view_fees'] = $row3->privilege_view_fees;
		        $data['privilege_manage_clients'] = $row3->privilege_manage_clients;
		        $data['privilege_manage_studentapps'] = $row3->privilege_manage_studentapps;
		        $data['privilege_manage_studentdocs'] = $row3->privilege_manage_studentdocs;
		        $data['privilege_manage_prapps'] = $row3->privilege_manage_prapps;
		        $data['privilege_manage_prdocs'] = $row3->privilege_manage_prdocs;
		        $data['privilege_manage_prfeereceived'] = $row3->privilege_manage_prfeereceived;
		        $data['privilege_manage_prfeepaid'] = $row3->privilege_manage_prfeepaid;
		        $data['privilege_manage_providers'] = $row3->privilege_manage_providers;
		        $data['privilege_manage_reporting'] = $row3->privilege_manage_reporting;
		}

        //id=2018&name=De%20Leon%20Abigail_PRApplication_127%20-2018&gdrive_id=150guQ5rBvbqw4Vo7HsAZAJJhUl6w6T3B&exist=exist

	    $data['client_id'] = $client_id;
        $data['client'] = $client;
        $data['offices'] = $offices;
        $data['officer'] = $officer;
		$data['events'] = $events;
		$data['student_application'] = $student_application;
		$data['clientscholarship'] = $clientscholarship;
		$data['visa_application'] = $visa_application;
		$data['visa_accounts'] = $visa_accounts;
		$data['eoi'] = $eoi;
		$data['payments'] = $payments;
		$data['programoptions'] = $programoptions;
        $data['interviews'] = $interviews;
        $data['fees'] = $fees;
        $data['firebasefiles'] = $firebasefiles;
        $data['admissionofferletter'] = $admissionofferletter;
        $data['result'] = $result;

		$data['exist'] = 'exist';

		$asset_url = base_url()."assets/";
		$data['title'] = "Edit/View Client Information";
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

		if($this->session->officer_role == "") {
			redirect(base_url()."index.php/messages");
		} else {
			if(isset($this->session->officer_name)) {
				$this->load->view('customerinfo/editclientinfo2', $data);
			} else {
				redirect(base_url()."?error3=1");
			}
		}
	}
	
	public function updateclientinfo()
	{
		$birthdate = DateTime::createFromFormat("Y-m-d", $this->input->post('birthdate'));
    	$birthyear = $birthdate->format("Y");
    	$birthmonth = $birthdate->format("m");
    	$birthday = $birthdate->format("d");

    	$vedate = DateTime::createFromFormat("Y-m-d", $this->input->post('vedate'));
    	$veyear = $vedate->format("Y");
    	$vemonth = $vedate->format("m");
    	$veday = $vedate->format("d");

    	if($this->input->post('selectevent') != "") {
    		$selectevent = $this->input->post('selectevent');
    	} else {
    		$selectevent = 0;
    	}

    	if($this->input->post('selectoffice') != "") {
    		$selectoffice = $this->input->post('selectoffice');
    	} else {
    		$selectoffice = 0;
    	}

    	if($this->input->post('selectofficer') != "") {
    		$selectofficer = $this->input->post('selectofficer');
    	} else {
    		$selectofficer = 0;
    	}

    	if($this->input->post('selectflag') != "") {
    		$selectflag = $this->input->post('selectflag');
    	} else {
    		$selectflag = "";
    	}

    	echo $selectofficer;

		$this->db->set('client_surname', $this->input->post('lastname'));
		$this->db->set('client_firstname', $this->input->post('firstname'));
		$this->db->set('client_middlename', $this->input->post('middlename'));
		$this->db->set('client_dob_day', $birthday);
		$this->db->set('client_dob_month', $birthmonth);
		$this->db->set('client_dob_year', $birthyear);
		$this->db->set('client_phoneno', $this->input->post('phoneno'));
		$this->db->set('client_mobileno', $this->input->post('mobileno'));
		$this->db->set('client_overseas_mobileno', $this->input->post('Overseasmobileno'));
		$this->db->set('client_email', $this->input->post('email'));
		$this->db->set('client_address', $this->input->post('clientaddress'));
		$this->db->set('client_suburb', $this->input->post('suburb'));
		$this->db->set('client_state', $this->input->post('state'));
		$this->db->set('client_postcode', $this->input->post('postcode'));
		$this->db->set('client_overseas_address', $this->input->post('overseasaddress'));
		$this->db->set('client_flag', $selectflag);
		$this->db->set('locked_by_id', '');
		$this->db->set('client_comments', $this->input->post('comment'));
		$this->db->set('client_qualifications', $this->input->post('qualifications'));
		$this->db->set('client_photo', '');
		$this->db->set('client_office_id', $selectoffice);
		$this->db->set('client_officer_id', $selectofficer);
		$this->db->set('client_ve_day', $veday);
		$this->db->set('client_ve_month', $vemonth);
		$this->db->set('client_ve_year', $veyear);
		$this->db->set('client_event_id', $selectevent);
		$this->db->set('client_password', $this->input->post('password'));
		$this->db->set('client_noofchildren', $this->input->post('noofchildren'));
		$this->db->set('client_civilstatus', $this->input->post('civilstatus'));
		$this->db->set('client_nationality', $this->input->post('nationality'));
		$this->db->set('client_country', $this->input->post('country'));
		$this->db->set('client_notes', $this->input->post('notes'));
		
		$this->db->set('proposeddateofinterview', $this->input->post('pdateofinterview'));
		$this->db->set('isonshore', $this->input->post('isonshore'));

		$this->db->where('client_id', $this->input->post('clientid'));
		$this->db->update('client');

		redirect(base_url()."index.php/editclientinfo2/".$this->input->post('clientid'));
	}

	public function do_upload()
        {
                
                $config['upload_path']          = './assets/images/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 10000;
                $config['max_width']            = 10000;
                $config['max_height']           = 10000;

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('userfile'))
                {
                	$birthdate = DateTime::createFromFormat("Y-m-d", $this->input->post('birthdate'));
			    	$birthyear = $birthdate->format("Y");
			    	$birthmonth = $birthdate->format("m");
			    	$birthday = $birthdate->format("d");
                    
                    if($this->input->post('vedate')) {
                        $vedate = DateTime::createFromFormat("Y-m-d", $this->input->post('vedate'));
    			    	$veyear = $vedate->format("Y");
    			    	$vemonth = $vedate->format("m");
    			    	$veday = $vedate->format("d");
                    } else {
                        $veyear = "0000";
    			    	$vemonth = "00";
    			    	$veday = "00";
                    }

			    	if($this->input->post('selectevent') != "") {
			    		$this->db->set('client_event_id', $this->input->post('selectevent'));
			    	}

			    	if($this->input->post('selectoffice') != "") {
			    		$this->db->set('client_office_id', $this->input->post('selectoffice'));
			    	}

			    	if($this->input->post('selectflag') != "" ) {
			    		$this->db->set('client_flag', $this->input->post('selectflag'));
			    	}

			    	if($this->input->post('selectofficer') != "") {
			    		$this->db->set('client_officer_id', $this->input->post('selectofficer'));
			    	}

					$this->db->set('client_surname', $this->input->post('lastname'));
					$this->db->set('client_firstname', $this->input->post('firstname'));
					$this->db->set('client_middlename', $this->input->post('middlename'));
					$this->db->set('client_dob_day', $birthday);
					$this->db->set('client_dob_month', $birthmonth);
					$this->db->set('client_dob_year', $birthyear);
					$this->db->set('client_phoneno', $this->input->post('phoneno'));
					$this->db->set('client_mobileno', $this->input->post('mobileno'));
					$this->db->set('client_overseas_mobileno', $this->input->post('Overseasmobileno'));
					$this->db->set('client_email', $this->input->post('email'));
					$this->db->set('client_address', $this->input->post('clientaddress'));
					$this->db->set('client_suburb', $this->input->post('suburb'));
					$this->db->set('client_state', $this->input->post('state'));
					$this->db->set('client_postcode', $this->input->post('postcode'));
					$this->db->set('client_overseas_address', $this->input->post('overseasaddress'));
					
					$this->db->set('locked_by_id', '');
					$this->db->set('client_comments', $this->input->post('comment'));
					$this->db->set('client_qualifications', $this->input->post('qualification'));
					
					$this->db->set('client_ve_day', $veday);
					$this->db->set('client_ve_month', $vemonth);
					$this->db->set('client_ve_year', $veyear);
					
					if($this->input->post('pdateofinterview') == '') {
			            $pdateofinterview = '0000-00-00';
			        } else {
			            $pdateofinterview = $this->input->post('pdateofinterview');
			        }
					
					$this->db->set('proposeddateofinterview', $pdateofinterview);
            		$this->db->set('isonshore', $this->input->post('isonshore'));
					
					$this->db->where('client_id', $this->input->post('clientid'));
					$this->db->update('client');

                    redirect(base_url().'index.php/editclientinfo2/'.$this->input->post('clientid'));
                }
                else
                {
                	$upload_data = $this->upload->data();
					$file_name = $upload_data['file_name'];

                	$birthdate = DateTime::createFromFormat("Y-m-d", $this->input->post('birthdate'));
			    	$birthyear = $birthdate->format("Y");
			    	$birthmonth = $birthdate->format("m");
			    	$birthday = $birthdate->format("d");

			    	$vedate = DateTime::createFromFormat("Y-m-d", $this->input->post('vedate'));
			    	$veyear = $vedate->format("Y");
			    	$vemonth = $vedate->format("m");
			    	$veday = $vedate->format("d");

			    	if($this->input->post('selectevent') != "") {
			    		$this->db->set('client_event_id', $this->input->post('selectevent'));
			    	}

			    	if($this->input->post('selectoffice') != "") {
			    		$this->db->set('client_office_id', $this->input->post('selectoffice'));
			    	}

			    	if($this->input->post('selectflag') != "" ) {
			    		$this->db->set('client_flag', $this->input->post('selectflag'));
			    	}

			    	if($this->input->post('selectofficer') != "") {
			    		$this->db->set('client_officer_id', $this->input->post('selectofficer'));
			    	}

					$this->db->set('client_surname', $this->input->post('lastname'));
					$this->db->set('client_firstname', $this->input->post('firstname'));
					$this->db->set('client_middlename', $this->input->post('middlename'));
					$this->db->set('client_dob_day', $birthday);
					$this->db->set('client_dob_month', $birthmonth);
					$this->db->set('client_dob_year', $birthyear);
					$this->db->set('client_phoneno', $this->input->post('phoneno'));
					$this->db->set('client_mobileno', $this->input->post('mobileno'));
					$this->db->set('client_overseas_mobileno', $this->input->post('Overseasmobileno'));
					$this->db->set('client_email', $this->input->post('email'));
					$this->db->set('client_address', $this->input->post('clientaddress'));
					$this->db->set('client_suburb', $this->input->post('suburb'));
					$this->db->set('client_state', $this->input->post('state'));
					$this->db->set('client_postcode', $this->input->post('postcode'));
					$this->db->set('client_overseas_address', $this->input->post('overseasaddress'));
					
					$this->db->set('locked_by_id', '');
					$this->db->set('client_comments', $this->input->post('comment'));
					$this->db->set('client_qualifications', $this->input->post('qualification'));
					$this->db->set('client_photo', $file_name);
					
					$this->db->set('client_ve_day', $veday);
					$this->db->set('client_ve_month', $vemonth);
					$this->db->set('client_ve_year', $veyear);
			
			        if($this->input->post('pdateofinterview') == '') {
			            $pdateofinterview = '0000-00-00';
			        } else {
			            $pdateofinterview = $this->input->post('pdateofinterview');
			        }
			
			        $this->db->set('proposeddateofinterview', $pdateofinterview);
            		$this->db->set('isonshore', $this->input->post('isonshore'));
					
					$this->db->where('client_id', $this->input->post('clientid'));
					$this->db->update('client');

                    redirect(base_url().'index.php/editclientinfo2/'.$this->input->post('clientid'));
                }
                
        }

    public function savefirebasefile() {
    	$date = date("Y-m-d");
    	$client_id = $_GET['clientid'];
    	$url =  $_GET['url'];

    	$data = array(
			'client_id' => $client_id,
			'document_type' => $row->inquiries_firstname,
			'document_link' => $url,
			'date_uploaded' => $date
		);
		$this->db->insert('firebasefiles', $data);
		echo json_encode("Successfully saved documents!");
    }

    public function assignofficer()
	{
		$this->db->set('client_officer_id', $this->input->post('officer'));
		$this->db->where('client_id', $this->input->post('clientid'));
		$this->db->update('client');

		$officerthreadid = $this->input->post('officer');
		$clientthreadid = $this->input->post('clientid');
		$threadsql = "SELECT * FROM thread WHERE sender_id = '$officerthreadid' and receiver_id = '$clientthreadid'";
		$threadquery = $this->db->query($threadsql);
		$threadrows = $threadquery->num_rows();

		if ($threadrows == 0) {
			$data = array(
					'sender_id' => $this->input->post('officer'),
					'receiver_id' => $this->input->post('clientid'),
					'created_date' => date("Y-m-d"),
					'status' => 'active',
					'chattype' => 'managerclient'
					);
			$this->db->insert('thread', $data);
		}

		redirect(base_url()."index.php/customerinfo?success1=1");
	}

	public function resetphoto($client_id)
	{
		$this->db->set('client_photo', 'avatar5.png');
		$this->db->where('client_id', $client_id);
		$this->db->update('client');
		//echo json_encode("Successfully done reset!");
		redirect(base_url()."index.php/editclientinfo2/".$client_id);
	}

	public function deactivateclient($client_id)
	{
		$this->db->set('client_flag', 'inactive');
		$this->db->where('client_id', $client_id);
		$this->db->update('client');
		//echo json_encode("Successfully done reset!");
		redirect(base_url()."index.php/customerinfo");
	}

    public function profile($client_id)
	{
		$sql1 = "SELECT * FROM client WHERE client_id = '$client_id'";
	        $query1 = $this->db->query($sql1);
	        $client = $query1->result();

	        $sql2 = "SELECT * FROM offices";
	        $query2 = $this->db->query($sql2);
	        $offices = $query2->result();

	        $sql3 = "SELECT * FROM events";
	        $query3 = $this->db->query($sql3);
	        $events = $query3->result();

	        $sql4 = "SELECT * FROM student_application sa inner join education_provider s on sa.provider_id = s.provider_id inner join client c on c.client_id = sa.client_id where sa.client_id = $client_id";
	        $query4 = $this->db->query($sql4);
	        $student_application = $query4->result();

	        $sql5 = "SELECT * FROM clientscholarship cs inner join client c on c.client_id = cs.clientid inner join scholarships s on s.scholarshipid = cs.scholarshipid";
		    $query5 = $this->db->query($sql5);
		    $clientscholarship = $query5->result();

		    $sql6 = "SELECT * FROM programoptions po inner join education_provider s on po.provider_id = s.provider_id inner join schoolprograms sp on sp.spid = po.sp_id where po.client_id = '$client_id'";
	        $query6 = $this->db->query($sql6);
	        $programoptions = $query6->result();

	        $data['client'] = $client;
	        $data['offices'] = $offices;
		$data['events'] = $events;
		$data['student_application'] = $student_application;
		$data['clientscholarship'] = $clientscholarship;
		$data['programoptions'] = $programoptions;
		$fullname = "";

		foreach($client as $row) {
			$fullname = $row->client_firstname."".$row->client_surname;
		}

		$asset_url = base_url()."assets/";
		$data['title'] = $fullname;
		$data['asset_url'] = $asset_url;

		$this->load->view('customerinfo/profile', $data);
	}
	
	public function saveresult() {
    	$date = date("Y-m-d");
    	$client_id = $this->input->post('resultclientid');
    	$url =  $_GET['url'];

    	$data = array(
			'client_id' => $client_id,
			'stage' => $this->input->post('stagemarketing'),
			'status' => $this->input->post('statusmarketing'),
			'remarks' => $this->input->post('remarksmarketing')
		);
		$this->db->insert('result', $data);
		
		$data = array(
			'client_id' => $client_id,
			'stage' => $this->input->post('stagecounselling'),
			'status' => $this->input->post('statuscounselling'),
			'remarks' => $this->input->post('remarkscounselling')
		);
		$this->db->insert('result', $data);
		
		$data = array(
			'client_id' => $client_id,
			'stage' => $this->input->post('stageadmission'),
			'status' => $this->input->post('statusadmission'),
			'remarks' => $this->input->post('remarksadmission')
		);
		$this->db->insert('result', $data);
		
		$data = array(
			'client_id' => $client_id,
			'stage' => $this->input->post('stagevisaadmission'),
			'status' => $this->input->post('statusvisaadmission'),
			'remarks' => $this->input->post('remarksvisaadmission')
		);
		$this->db->insert('result', $data);
		
		$data = array(
			'client_id' => $client_id,
			'stage' => $this->input->post('stagefinalization'),
			'status' => $this->input->post('statusfinalization'),
			'remarks' => $this->input->post('remarksfinalization')
		);
		$this->db->insert('result', $data);
		
		redirect(base_url()."index.php/editclientinfo2/".$this->input->post('resultclientid'));
    }
    
    public function updateresult() {
    	$date = date("Y-m-d");
    	$client_id = $this->input->post('resultclientid');
    	$url =  $_GET['url'];
    	
		$this->db->set('status', $this->input->post('statusmarketing'));
		$this->db->set('remarks', $this->input->post('remarksmarketing'));
		$this->db->where('client_id', $client_id);
		$this->db->where('stage', "Marketing");
		$this->db->update('result');
		
		$this->db->set('status', $this->input->post('statuscounselling'));
		$this->db->set('remarks', $this->input->post('remarkscounselling'));
		$this->db->where('client_id', $client_id);
		$this->db->where('stage', "Counselling");
		$this->db->update('result');
		
		$this->db->set('status', $this->input->post('statusadmission'));
		$this->db->set('remarks', $this->input->post('remarksadmission'));
		$this->db->where('client_id', $client_id);
		$this->db->where('stage', "Admission");
		$this->db->update('result');
		
		$this->db->set('status', $this->input->post('statusvisaadmission'));
		$this->db->set('remarks', $this->input->post('remarksvisaadmission'));
		$this->db->where('client_id', $client_id);
		$this->db->where('stage', "Visa Documentation");
		$this->db->update('result');
		
		$this->db->set('status', $this->input->post('statusfinalization'));
		$this->db->set('remarks', $this->input->post('remarksfinalization'));
		$this->db->where('client_id', $client_id);
		$this->db->where('stage', "Finalization");
		$this->db->update('result');
		
		redirect(base_url()."index.php/editclientinfo2/".$this->input->post('resultclientid')."#result");
    }
    
    public function editfile() {
        $type = $_GET["type"];
        $id = $_GET["id"];
        $client = $_GET["client"];
        
        if($type == "admissionofferletter") {
            
            $sql = "SELECT * FROM admissionofferletter WHERE id = $id";
            $query = $this->db->query($sql);
            $admissionofferletter = $query->result();
            
            $data['admissionofferletter'] = $admissionofferletter;
            
        } elseif($type == "fee") {
            
            $sql = "SELECT * FROM fee_receipts WHERE id = $id";
            $query = $this->db->query($sql);
            $fee = $query->result();
            
            $data['fee'] = $fee;
            
        } elseif($type == "interviews") {
            
            $sql = "SELECT * FROM interviews WHERE id = $id";
            $query = $this->db->query($sql);
            $interviews = $query->result();
            
            $data['interviews'] = $interviews;
            
        }
        
        $data['type'] = $type;
        $data['id'] = $id;
        $data['client'] = $client;
            
        $asset_url = base_url()."assets/";
    	$data['title'] = "Edit File";
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
            
            $this->load->view('customerinfo/editfile', $data);

    }
    
    public function editfirebasefile() {
        $id = $_GET["id"];
        $client = $_GET["client"];
        
        $sql = "SELECT * FROM firebasefiles WHERE fbid = $id";
        $query = $this->db->query($sql);
        $firebasefiles = $query->result();
            
        $data['firebasefiles'] = $firebasefiles;
        
        $data['id'] = $id;
        $data['client'] = $client;
            
        $asset_url = base_url()."assets/";
    	$data['title'] = "Edit Firebase File";
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
            
            $this->load->view('customerinfo/editfirebasefile', $data);
        
    }
    
    public function deletefile()
	{
	    
	    $type = $_GET["type"];
        $id = $_GET["id"];
        $client = $_GET["client"];
        
        if($type == "admissionofferletter") {
            $this->db->where('id', $id);
    		$this->db->delete('admissionofferletter');
    		redirect(base_url()."index.php/editclientinfo2/".$client);
        } elseif($type == "fee") {
            $this->db->where('id', $id);
    		$this->db->delete('fee_receipts');
    		redirect(base_url()."index.php/editclientinfo2/".$client);
        } elseif($type == "interviews") {
            $this->db->where('id', $id);
    		$this->db->delete('interviews');
    		redirect(base_url()."index.php/editclientinfo2/".$client);
        }
		
	}
	
	public function deletefirebasefile() {
	    
	    $id = $_GET["id"];
        $client = $_GET["client"];
        
	    $this->db->where('fbid', $id);
    	$this->db->delete('firebasefiles');
    	redirect(base_url()."index.php/editclientinfo2/".$client);
	    
	}
	
	public function clientmonitoring() {
	    
	    $sql = "SELECT *, sa.vevo_expiry_date AS sa_vevo_expiry_date, po.location AS polocation, po.intake AS pointake, po.englishrequirement AS poenglishrequirement, sa.studentapp_record_created_date as sacreateddate, po.prepdate AS poprepdate, po.followupdate AS pofollowupdate, po.remarks AS poremarks, po.status AS postatus, sa.intake AS saintake, vap.status AS vastatus, adf.total_amount as adminfeeamount, rf.total_amount as refusalfeeamount, tf.total_amount as tuitionfeeamount, pf.total_amount as processingfeeamount, osch.total_amount as oschfeeamount, vaf.total_amount as visaapplicationfeeamount, po.processstatus as poprocessstatus
	    
	        FROM `client` c 
	        LEFT JOIN `programoptions` po ON c.client_id = po.client_id 
	        LEFT JOIN `visa_application` vap ON c.client_id = vap.client_id 
	        LEFT JOIN `student_application` sa ON po.application_id = sa.studentapp_id
	        LEFT JOIN (
	            SELECT client_id, 
                       FORMAT(SUM(fee_amount), 2) AS total_amount
                FROM fee_receipts
                WHERE fee_description = 'Admin Fee'
                GROUP BY client_id
	        ) adf ON adf.client_id = c.client_id
	        LEFT JOIN (
	            SELECT client_id, 
                       FORMAT(SUM(fee_amount), 2) AS total_amount
                FROM fee_receipts
                WHERE fee_description = 'Refusal Fee'
                GROUP BY client_id
	        ) rf ON rf.client_id = c.client_id
	        LEFT JOIN (
	            SELECT client_id, 
                       FORMAT(SUM(fee_amount), 2) AS total_amount
                FROM fee_receipts
                WHERE fee_description = 'Tuition Fee'
                GROUP BY client_id
	        ) tf ON tf.client_id = c.client_id
	        LEFT JOIN (
	            SELECT client_id, 
                       FORMAT(SUM(fee_amount), 2) AS total_amount
                FROM fee_receipts
                WHERE fee_description = 'Processing Fee'
                GROUP BY client_id
	        ) pf ON pf.client_id = c.client_id
	        LEFT JOIN (
	            SELECT client_id, 
                       FORMAT(SUM(fee_amount), 2) AS total_amount
                FROM fee_receipts
                WHERE fee_description = 'OSCH'
                GROUP BY client_id
	        ) osch ON osch.client_id = c.client_id
	        LEFT JOIN (
	            SELECT client_id, 
                       FORMAT(SUM(fee_amount), 2) AS total_amount
                FROM fee_receipts
                WHERE fee_description = 'Visa Application Fee'
                GROUP BY client_id
	        ) vaf ON vaf.client_id = c.client_id
	        
	        WHERE c.client_flag = 'active'
	        ORDER BY c.client_id DESC
	        ";
        $query = $this->db->query($sql);
        $result = $query->result();

        $sql2 = "SELECT * FROM officer";
        $query2 = $this->db->query($sql2);
        $result2 = $query2->result();

        $asset_url = base_url()."assets/";
		$data['title'] = "Client Monitoring";
		$data['asset_url'] = $asset_url;
		$data['clients'] = $result;
		$data['officer'] = $result2;

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

		if(isset($this->session->officer_name)) {
			$this->load->view('customerinfo/clientmonitoring', $data);
		} else {
			redirect(base_url()."?error3=1");
		}
	    
	}

}