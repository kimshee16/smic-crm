<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Feecontroller extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->helper('form');
	}
	
	public function do_upload()
        {
                
            $config['upload_path']          = './assets/fees/';
            $config['allowed_types']        = 'docx|doc|jpg|png|pdf';
            $config['max_size']             = 50000;
            $config['max_width']            = 50000;
            $config['max_height']           = 50000;
            
            if($this->input->post('formtype') == "new") {
                
                $this->load->library('upload', $config);
            
                if ($this->upload->do_upload('feefile'))
                {
                    $upload_data = $this->upload->data();
        			$file_name = $upload_data['file_name'];
        					
                    $data = array(
            			'client_id' => $this->input->post('feeclientid'),
            			'fee_description' => $this->input->post('feedescription'),
            			'fee_date' => $this->input->post('feedatetime'),
            			'fee_remarks' => $this->input->post('feeremarks'),
            			'fee_amount' => $this->input->post('feeamount'),
            			'fee_receipt' => $file_name
            		);
            		$this->db->insert('fee_receipts', $data);
                } else {
                    $upload_data = $this->upload->data();
        			$file_name = $upload_data['file_name'];
        					
                    $data = array(
            			'client_id' => $this->input->post('feeclientid'),
            			'fee_description' => $this->input->post('feedescription'),
            			'fee_date' => $this->input->post('feedatetime'),
            			'fee_remarks' => $this->input->post('feeremarks'),
            			'fee_amount' => $this->input->post('feeamount'),
            			'fee_receipt' => ''
            		);
            		$this->db->insert('fee_receipts', $data);
                }
                
                redirect(base_url()."index.php/editclientinfo2/".$this->input->post('feeclientid')."#counselling");
                    
            } else {
                
                $this->load->library('upload', $config);
                
                if ($this->upload->do_upload('feefile'))
                {
                    
                    $upload_data = $this->upload->data();
        			$file_name = $upload_data['file_name'];
        			
        			if (file_exists($this->input->post('editfilelink'))) {
                        unlink($this->input->post('editfilelink'));
                    }
        			
                    $this->db->set('fee_description', $this->input->post('feedescription'));
            		$this->db->set('fee_date', $this->input->post('feedatetime'));
            		$this->db->set('fee_amount', $this->input->post('feeamount'));
            		$this->db->set('fee_remarks', $this->input->post('feeremarks'));
            		$this->db->set('fee_receipt', $file_name);
            		$this->db->where('id', $this->input->post('feeid'));
            		$this->db->update('fee_receipts');
            		
                } else {
                    
                    $this->db->set('fee_description', $this->input->post('feedescription'));
            		$this->db->set('fee_date', $this->input->post('feedatetime'));
            		$this->db->set('fee_remarks', $this->input->post('feeremarks'));
            		$this->db->set('fee_amount', $this->input->post('feeamount'));
            		$this->db->set('fee_receipt', $this->input->post('editfilelink'));
            		$this->db->where('id', $this->input->post('feeid'));
            		$this->db->update('fee_receipts');
            		
                }
                
            }
            
            redirect(base_url()."index.php/editclientinfo2/".$this->input->post('editfileclientid')."#counselling");

                
        }
	
}