<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vevocontroller extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->helper('form');
	}
	
	public function do_upload()
        {
                
            $config['upload_path']          = './assets/vevo/';
            $config['allowed_types']        = 'docx|doc|jpg|png|pdf';
            $config['max_size']             = 50000;
            $config['max_width']            = 50000;
            $config['max_height']           = 50000;
            
            if($this->input->post('formtype') == "new") {
                
                $this->load->library('upload', $config);
            
                if ($this->upload->do_upload('vevoexpiry'))
                {
                    $upload_data = $this->upload->data();
        			$file_name = $upload_data['file_name'];
        					
                    $startdate = $this->input->post('startdate');
            		$time1 = strtotime($startdate);
            		$month1 = date("m",$time1);
            		$year1 = date("Y",$time1);
            		$day1 = date("d",$time1);
            
            		$enddate = $this->input->post('enddate');
            		$time2 = strtotime($enddate);
            		$month2 = date("m",$time2);
            		$year2 = date("Y",$time2);
            		$day2 = date("d",$time2);
            
            		$coedate = $this->input->post('coedate');
            		$time3 = strtotime($coedate);
            		$month3 = date("m",$time3);
            		$year3 = date("Y",$time3);
            		$day3 = date("d",$time3);
            
            		$program = $this->input->post('program');
            		$sql = "SELECT * FROM schoolprograms WHERE spid = '$program'";
                    $query = $this->db->query($sql);
                    $programs = $query->result();
            
                    foreach($programs as $programrows) {
                    	$programname = $programrows->spid;
                    	$programtype = $programrows->programtype;
                    }
            
            		$data = array(
            					'client_id' => $this->input->post('clientid'),
            					'officer_id' => $this->session->userdata('officer_id'),
            					'provider_id' => $this->input->post('school'),
            					'studentapp_record_created_date' => date('Y-m-d'),
            					'studentapp_course_starting_day' => $day1,
            					'studentapp_course_starting_month' => $month1,
            					'studentapp_course_starting_year' => $year1,
            					'studentapp_course_end_day' => $day2,
            					'studentapp_course_end_month' => $month2,
            					'studentapp_course_end_year' => $year2,
            					'studentapp_course_name' => $programname,
            					'studentapp_course_level' => $programtype,
            					'studentapp_coe_day' => $day3,
            					'studentapp_coe_month' => $month3,
            					'studentapp_coe_year' => $year3,
            					'studentapp_visa_lodged_day' => '',
            					'studentapp_visa_lodged_month' => '',
            					'studentapp_visa_lodged_year' => '',
            					'studentapp_visa_status' => '',
            					'studentapp_documents_pending' => '',
            					'studentapp_comments' => '',
            					'studentapp_flag' => 'Submitted',
            					'studentapp_invoice_processed_flag' => '',
            					'studentapp_student_no' => '',
            					'course_starting_date' => $this->input->post('startdate'),
            					'course_ending_date' => $this->input->post('enddate'),
            					'offices_id' => 0,
            					'subagent_id' => 0,
            					'staff_invoice_no' => '',
            					'staff_invoice_no2' => '',
            					'studentapp_event_id' => 0,
            					'intake' => $this->input->post('intake'),
            					'remarks' => $this->input->post('remarks'),
            					'campus' => $this->input->post('campus'),
            					'vevo_expiry' => $file_name,
            					'vevo_expiry_date' => $this->input->post('vevo_expiry_date')
            				);
            		$this->db->insert('student_application', $data);
                } else {
                    $upload_data = $this->upload->data();
        			$file_name = $upload_data['file_name'];
        					
                    $startdate = $this->input->post('startdate');
            		$time1 = strtotime($startdate);
            		$month1 = date("m",$time1);
            		$year1 = date("Y",$time1);
            		$day1 = date("d",$time1);
            
            		$enddate = $this->input->post('enddate');
            		$time2 = strtotime($enddate);
            		$month2 = date("m",$time2);
            		$year2 = date("Y",$time2);
            		$day2 = date("d",$time2);
            
            		$coedate = $this->input->post('coedate');
            		$time3 = strtotime($coedate);
            		$month3 = date("m",$time3);
            		$year3 = date("Y",$time3);
            		$day3 = date("d",$time3);
            
            		$program = $this->input->post('program');
            		$sql = "SELECT * FROM schoolprograms WHERE spid = '$program'";
                    $query = $this->db->query($sql);
                    $programs = $query->result();
            
                    foreach($programs as $programrows) {
                    	$programname = $programrows->spid;
                    	$programtype = $programrows->programtype;
                    }
            
            		$data = array(
            					'client_id' => $this->input->post('clientid'),
            					'officer_id' => $this->session->userdata('officer_id'),
            					'provider_id' => $this->input->post('school'),
            					'studentapp_record_created_date' => date('Y-m-d'),
            					'studentapp_course_starting_day' => $day1,
            					'studentapp_course_starting_month' => $month1,
            					'studentapp_course_starting_year' => $year1,
            					'studentapp_course_end_day' => $day2,
            					'studentapp_course_end_month' => $month2,
            					'studentapp_course_end_year' => $year2,
            					'studentapp_course_name' => $programname,
            					'studentapp_course_level' => $programtype,
            					'studentapp_coe_day' => $day3,
            					'studentapp_coe_month' => $month3,
            					'studentapp_coe_year' => $year3,
            					'studentapp_visa_lodged_day' => '',
            					'studentapp_visa_lodged_month' => '',
            					'studentapp_visa_lodged_year' => '',
            					'studentapp_visa_status' => '',
            					'studentapp_documents_pending' => '',
            					'studentapp_comments' => '',
            					'studentapp_flag' => 'Submitted',
            					'studentapp_invoice_processed_flag' => '',
            					'studentapp_student_no' => '',
            					'course_starting_date' => $this->input->post('startdate'),
            					'course_ending_date' => $this->input->post('enddate'),
            					'offices_id' => 0,
            					'subagent_id' => 0,
            					'staff_invoice_no' => '',
            					'staff_invoice_no2' => '',
            					'studentapp_event_id' => 0,
            					'intake' => $this->input->post('intake'),
            					'remarks' => $this->input->post('remarks'),
            					'campus' => $this->input->post('campus'),
            					'vevo_expiry' => $file_name,
            					'vevo_expiry_date' => $this->input->post('vevo_expiry_date')
            				);
            		$this->db->insert('student_application', $data);
                }
                
                redirect(base_url()."index.php/editclientinfo2/".$this->input->post('clientid')."#admission");
                    
            } else {
                
                $this->load->library('upload', $config);
                
                if ($this->upload->do_upload('vevoexpiry'))
                {
                    
                    $upload_data = $this->upload->data();
        			$file_name = $upload_data['file_name'];
        			
        			if (file_exists($this->input->post('editfilelink'))) {
                        unlink($this->input->post('editfilelink'));
                    }
        			
                    $startdate = $this->input->post('startdate');
            		$time1 = strtotime($startdate);
            		$month1 = date("m",$time1);
            		$year1 = date("Y",$time1);
            		$day1 = date("d",$time1);
            
            		$enddate = $this->input->post('enddate');
            		$time2 = strtotime($enddate);
            		$month2 = date("m",$time2);
            		$year2 = date("Y",$time2);
            		$day2 = date("d",$time2);
            
            		$coedate = $this->input->post('coedate');
            		$time3 = strtotime($coedate);
            		$month3 = date("m",$time3);
            		$year3 = date("Y",$time3);
            		$day3 = date("d",$time3);
            
            		$program = $this->input->post('program');
            		$sql = "SELECT * FROM schoolprograms WHERE spid = '$program'";
                    $query = $this->db->query($sql);
                    $programs = $query->result();
            
                    foreach($programs as $programrows) {
                    	$programname = $programrows->spid;
                    	$programtype = $programrows->programtype;
                    }
            
            		$this->db->set('provider_id', $this->input->post('school'));
            		$this->db->set('studentapp_course_starting_day', $day1);
            		$this->db->set('studentapp_course_starting_month', $month1);
            		$this->db->set('studentapp_course_starting_year', $year1);
            		$this->db->set('studentapp_course_end_day', $day2);
            		$this->db->set('studentapp_course_end_month', $month2);
            		$this->db->set('studentapp_course_end_year', $year2);
            		$this->db->set('studentapp_course_name', $programname);
            		$this->db->set('studentapp_course_level', $programtype);
            		$this->db->set('studentapp_coe_day', $day3);
            		$this->db->set('studentapp_coe_month', $month3);
            		$this->db->set('studentapp_coe_year',$year3);
            		$this->db->set('studentapp_flag', $this->input->post('flag'));
            		$this->db->set('course_starting_date', $this->input->post('state'));
            		$this->db->set('course_ending_date', $this->input->post('startdate'));
            		$this->db->set('intake', $this->input->post('intake'));
            		$this->db->set('remarks', $this->input->post('remarks'));
            		$this->db->set('campus', $this->input->post('campus'));
            		$this->db->set('vevo_expiry', $file_name);
            		$this->db->set('vevo_expiry_date', $this->input->post('vevo_expiry_date'));
            		$this->db->where('studentapp_id', $this->input->post('studentapp_id'));
            		$this->db->update('student_application');
            		echo $file_name;
                } else {
                    
                    $startdate = $this->input->post('startdate');
            		$time1 = strtotime($startdate);
            		$month1 = date("m",$time1);
            		$year1 = date("Y",$time1);
            		$day1 = date("d",$time1);
            
            		$enddate = $this->input->post('enddate');
            		$time2 = strtotime($enddate);
            		$month2 = date("m",$time2);
            		$year2 = date("Y",$time2);
            		$day2 = date("d",$time2);
            
            		$coedate = $this->input->post('coedate');
            		$time3 = strtotime($coedate);
            		$month3 = date("m",$time3);
            		$year3 = date("Y",$time3);
            		$day3 = date("d",$time3);
            
            		$program = $this->input->post('program');
            		$sql = "SELECT * FROM schoolprograms WHERE spid = '$program'";
                    $query = $this->db->query($sql);
                    $programs = $query->result();
            
                    foreach($programs as $programrows) {
                    	$programname = $programrows->spid;
                    	$programtype = $programrows->programtype;
                    }
            
            		$this->db->set('provider_id', $this->input->post('school'));
            		$this->db->set('studentapp_course_starting_day', $day1);
            		$this->db->set('studentapp_course_starting_month', $month1);
            		$this->db->set('studentapp_course_starting_year', $year1);
            		$this->db->set('studentapp_course_end_day', $day2);
            		$this->db->set('studentapp_course_end_month', $month2);
            		$this->db->set('studentapp_course_end_year', $year2);
            		$this->db->set('studentapp_course_name', $programname);
            		$this->db->set('studentapp_course_level', $programtype);
            		$this->db->set('studentapp_coe_day', $day3);
            		$this->db->set('studentapp_coe_month', $month3);
            		$this->db->set('studentapp_coe_year',$year3);
            		$this->db->set('studentapp_flag', $this->input->post('flag'));
            		$this->db->set('course_starting_date', $this->input->post('state'));
            		$this->db->set('course_ending_date', $this->input->post('startdate'));
            		$this->db->set('intake', $this->input->post('intake'));
            		$this->db->set('remarks', $this->input->post('remarks'));
            		$this->db->set('campus', $this->input->post('campus'));
            		$this->db->set('vevo_expiry', $this->input->post('editfilelink'));
            		$this->db->set('vevo_expiry_date', $this->input->post('vevo_expiry_date'));
            		$this->db->where('studentapp_id', $this->input->post('studentapp_id'));
            		$this->db->update('student_application');
            		
                }
                
                redirect(base_url()."index.php/editclientinfo2/".$this->input->post('clientid')."#admission");
                
            }

                
        }
	
}