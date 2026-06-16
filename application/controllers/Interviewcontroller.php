<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Interviewcontroller extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->helper('form');
	}
	
	public function do_upload()
        {
                
            $config['upload_path']          = './assets/interviews/';
            $config['allowed_types']        = 'docx|doc|jpg|png|pdf';
            $config['max_size']             = 50000;
            $config['max_width']            = 50000;
            $config['max_height']           = 50000;

            
            
            
            if($this->input->post('formtype') == "new") {
                
                $this->load->library('upload', $config);
            
                if ($this->upload->do_upload('interviewfile'))
                {
                    $upload_data = $this->upload->data();
        			$file_name = $upload_data['file_name'];
        					
                    $data = array(
            			'client_id' => $this->input->post('interviewclientid'),
            			'interview_datetime' => $this->input->post('interviewdatetime'),
            			'interview_link' => $file_name
            		);
            		$this->db->insert('interviews', $data);
                } else {
                    $upload_data = $this->upload->data();
        			$file_name = $upload_data['file_name'];
        					
                    $data = array(
            			'client_id' => $this->input->post('interviewclientid'),
            			'interview_datetime' => $this->input->post('interviewdatetime'),
            			'interview_link' => ''
            		);
            		$this->db->insert('interviews', $data);
                }
                
                redirect(base_url()."index.php/editclientinfo2/".$this->input->post('interviewclientid')."#counselling");
                    
            } else {
                
                $this->load->library('upload', $config);
            
                if ($this->upload->do_upload('interviewfile'))
                {
                    
                    $upload_data = $this->upload->data();
        			$file_name = $upload_data['file_name'];
        			
        			if (file_exists($this->input->post('editfilelink'))) {
                        unlink($this->input->post('editfilelink'));
                    }
        			
                    $this->db->set('interview_datetime', $this->input->post('interviewdatetime'));
            		$this->db->set('interview_link', $file_name);
            		$this->db->where('id', $this->input->post('interviewid'));
            		$this->db->update('interviews');
            		
                } else {
                    
                    $upload_data = $this->upload->data();
        			$file_name = $upload_data['file_name'];
        			
        			if (file_exists($this->input->post('editfilelink'))) {
                        unlink($this->input->post('editfilelink'));
                    }
        			
                    $this->db->set('interview_datetime', $this->input->post('interviewdatetime'));
            		$this->db->set('interview_link', $this->input->post('editfilelink'));
            		$this->db->where('id', $this->input->post('interviewid'));
            		$this->db->update('interviews');
            		
                }
                
                redirect(base_url()."index.php/editclientinfo2/".$this->input->post('editfileclientid')."#counselling");  
                
            }
            
              
        }
	
}