<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Receiptscontroller extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->helper('form');
	}
	
	public function do_upload()
        {
                
            $config['upload_path']          = './assets/receipts/';
            $config['allowed_types']        = 'docx|doc|jpg|png|pdf';
            $config['max_size']             = 50000;
            $config['max_width']            = 50000;
            $config['max_height']           = 50000;
            
            $this->load->library('upload', $config);
            
            if($this->input->post('formtype') == "new") {
            
                if ($this->upload->do_upload('paymentattachment'))
                {
                    $upload_data = $this->upload->data();
        			$file_name = $upload_data['file_name'];
        					
            		$data = array(
            			'paymenttype' => $this->input->post('paymenttype'),
            			'referencenumber' => $this->input->post('referencenumber'),
            			'payee' => $this->input->post('payee'),
            			'paymentdate' => $this->input->post('paymentdate'),
            			'processedby' => $this->session->userdata('officer_id'),
            			'barchived' => 0,
            			'paymentschedule' => $this->input->post('paymentschedule'),
            			'paymentattachment' => $file_name,
            			'paymentdescription' => $this->input->post('paymentdescription'),
            			'amount' => $this->input->post('amount'),
            			'currency' => $this->input->post('currency'),
            			'payment_business_registration_number' => $this->input->post('businessregistrationnumber'),
            			'total_price' => $this->input->post('totalprice'),
            			'gst' => $this->input->post('gst'),
            			'quantity' => $this->input->post('quantity'),
            			'unit_price' => $this->input->post('unitprice'),
            			'invoice_number' => $this->input->post('invoicenumber'),
            			'student_id' => $this->input->post('studentid')
            		);
            		$this->db->insert('payments', $data);
                } else {
                    
                    $data = array(
            			'paymenttype' => $this->input->post('paymenttype'),
            			'referencenumber' => $this->input->post('referencenumber'),
            			'payee' => $this->input->post('payee'),
            			'paymentdate' => $this->input->post('paymentdate'),
            			'processedby' => $this->session->userdata('officer_id'),
            			'barchived' => 0,
            			'paymentschedule' => $this->input->post('paymentschedule'),
            			'paymentattachment' => '',
            			'paymentdescription' => $this->input->post('paymentdescription'),
            			'amount' => $this->input->post('amount'),
            			'currency' => $this->input->post('currency'),
            			'payment_business_registration_number' => $this->input->post('businessregistrationnumber'),
            			'total_price' => $this->input->post('totalprice'),
            			'gst' => $this->input->post('gst'),
            			'quantity' => $this->input->post('quantity'),
            			'unit_price' => $this->input->post('unitprice'),
            			'invoice_number' => $this->input->post('invoicenumber'),
            			'student_id' => $this->input->post('studentid')
            		);
            		$this->db->insert('payments', $data);
                    
                }
                
                redirect('payments');
            
                
            } else {
                
                if ($this->upload->do_upload('paymentattachment'))
                {
                    
                    $upload_data = $this->upload->data();
        			$file_name = $upload_data['file_name'];
        			
        			if (file_exists($this->input->post('editfilelink'))) {
                        unlink($this->input->post('editfilelink'));
                    }
        			
                    $this->db->set('paymenttype', $this->input->post('paymenttype'));
            		$this->db->set('referencenumber', $this->input->post('referencenumber'));
            		$this->db->set('payee', $this->input->post('payee'));
            		$this->db->set('paymentdate', $this->input->post('paymentdate'));
            		$this->db->set('processedby', $this->session->userdata('officer_id'));
            		$this->db->set('barchived', 0);
            		$this->db->set('paymentschedule', $this->input->post('paymentschedule'));
            		$this->db->set('paymentattachment', $file_name);
            		$this->db->set('paymentdescription', $this->input->post('paymentdescription'));
            		$this->db->set('amount', $this->input->post('amount'));
            		$this->db->set('currency', $this->input->post('currency'));
            		$this->db->set('payment_business_registration_number', $this->input->post('businessregistrationnumber'));
            		$this->db->set('total_price', $this->input->post('totalprice'));
            		$this->db->set('gst', $this->input->post('gst'));
            		$this->db->set('quantity', $this->input->post('quantity'));
            		$this->db->set('unit_price', $this->input->post('unitprice'));
            		$this->db->set('invoice_number', $this->input->post('invoicenumber'));
            		$this->db->set('student_id', $this->input->post('studentid'));
            		$this->db->where('paymentid', $this->input->post('paymentid'));
            		$this->db->update('payments');
            		
                } else {
                    
                    $this->db->set('paymenttype', $this->input->post('paymenttype'));
            		$this->db->set('referencenumber', $this->input->post('referencenumber'));
            		$this->db->set('payee', $this->input->post('payee'));
            		$this->db->set('paymentdate', $this->input->post('paymentdate'));
            		$this->db->set('processedby', $this->session->userdata('officer_id'));
            		$this->db->set('barchived', 0);
            		$this->db->set('paymentschedule', $this->input->post('paymentschedule'));
            		$this->db->set('paymentattachment', $this->input->post('editfilelink'));
            		$this->db->set('paymentdescription', $this->input->post('paymentdescription'));
            		$this->db->set('amount', $this->input->post('amount'));
            		$this->db->set('currency', $this->input->post('currency'));
            		$this->db->set('payment_business_registration_number', $this->input->post('businessregistrationnumber'));
            		$this->db->set('total_price', $this->input->post('totalprice'));
            		$this->db->set('gst', $this->input->post('gst'));
            		$this->db->set('quantity', $this->input->post('quantity'));
            		$this->db->set('unit_price', $this->input->post('unitprice'));
            		$this->db->set('invoice_number', $this->input->post('invoicenumber'));
            		$this->db->set('student_id', $this->input->post('studentid'));
            		$this->db->where('paymentid', $this->input->post('paymentid'));
            		$this->db->update('payments');
                
                    
                }
                
                redirect('payments');
                
            }
                
        }
	
}