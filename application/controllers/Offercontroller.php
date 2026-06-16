<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Offercontroller extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->helper('form');
	}
	
	public function do_upload()
        {
            
            $config['upload_path']          = './assets/offerletters/';
            $config['allowed_types']        = 'docx|doc|jpg|png|pdf';
            $config['max_size']             = 50000;
            $config['max_width']            = 50000;
            $config['max_height']           = 50000;

            $this->load->library('upload', $config);
            
            if($this->input->post('formtype') == "new") {
                
                if ($this->upload->do_upload('offerletterfile'))
                {
                    $upload_data = $this->upload->data();
        			$file_name = $upload_data['file_name'];
        					
                    $data = array(
            			'client_id' => $this->input->post('offerletterclientid'),
            			'conditionaloffer' => $this->input->post('offerletterconditionaloffer'),
            			'date' => $this->input->post('offerletterdate'),
            			'remarks' => $this->input->post('offerletterremarks'),
            			'type' => $this->input->post('offerlettertype'),
            			'attachmentlink' => $file_name
            		);
            		$this->db->insert('admissionofferletter', $data);
                } else {
                    $upload_data = $this->upload->data();
        			$file_name = $upload_data['file_name'];
        					
                    $data = array(
            			'client_id' => $this->input->post('offerletterclientid'),
            			'conditionaloffer' => $this->input->post('offerletterconditionaloffer'),
            			'date' => $this->input->post('offerletterdate'),
            			'remarks' => $this->input->post('offerletterremarks'),
            			'type' => $this->input->post('offerlettertype'),
            			'attachmentlink' => ''
            		);
            		$this->db->insert('admissionofferletter', $data);
                }
                
                redirect(base_url()."index.php/editclientinfo2/".$this->input->post('offerletterclientid')."#admission");  
                
            } else {
                
                $this->load->library('upload', $config);
                
                if ($this->upload->do_upload('offerletterfile'))
                {
                    
                    $upload_data = $this->upload->data();
        			$file_name = $upload_data['file_name'];
        			
        			if (file_exists($this->input->post('editfilelink'))) {
                        unlink($this->input->post('editfilelink'));
                    }
        			$this->db->set('type', $this->input->post('offerlettertype'));
                    $this->db->set('conditionaloffer', $this->input->post('offerletterconditionaloffer'));
            		$this->db->set('date', $this->input->post('offerletterdate'));
            		$this->db->set('remarks', $this->input->post('offerletterremarks'));
            		$this->db->set('attachmentlink', $file_name);
            		$this->db->where('id', $this->input->post('admissionofferletterid'));
            		$this->db->update('admissionofferletter');
            		
                } else {
        			
                    $this->db->set('conditionaloffer', $this->input->post('offerletterconditionaloffer'));
                    $this->db->set('type', $this->input->post('offerlettertype'));
            		$this->db->set('date', $this->input->post('offerletterdate'));
            		$this->db->set('remarks', $this->input->post('offerletterremarks'));
            		$this->db->set('attachmentlink', $this->input->post('editfilelink'));
            		$this->db->where('id', $this->input->post('admissionofferletterid'));
            		$this->db->update('admissionofferletter');
            		
                }
                
            }
            
            redirect(base_url()."index.php/editclientinfo2/".$this->input->post('editfileclientid')."#admission");    
        }
	
}