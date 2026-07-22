<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Newpaymentscontroller extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->helper('form');
	}
	
	public function do_upload()
    {
                
        $config['upload_path']          = './assets/newpayments/';
        $config['allowed_types']        = 'docx|doc|jpg|png|pdf';
        $config['max_size']             = 50000;
        $config['max_width']            = 50000;
        $config['max_height']           = 50000;
            
        $this->load->library('upload', $config);
        
        $officer_id = $this->session->userdata('officer_id');
        
        $newpayments_id = "";
        
        if($this->input->post('savetype') == 'new') {
            
            $data = array(
                'paymenttype' => $this->input->post('paymenttype'),
                'description' => $this->input->post('description'),
            	'reference' => $this->input->post('reference'),
            	'paymentdate' => $this->input->post('paymentdate'),
            	'totalprice' => $this->input->post('totalprice'),
            	'taxnumber' => $this->input->post('taxnumber'),
            	'totalpriceinwords' => $this->input->post('totalpriceinwords'),
            	'duedate' => $this->input->post('duedate'),
            	'discount' => '0',
            	'penalty' => '0',
            	'letterhead' => $this->input->post('letterhead'),
            	'createdby' => $officer_id,
            	'taxpercent' => $this->input->post('taxpercent'),
            	'penaltypercent' => $this->input->post('penaltypercent'),
            	'discountpercent' => $this->input->post('discountpercent'),
            );
            $this->db->insert('newpayments', $data);
            $newpayments_id = $this->db->insert_id();
            
            $descriptions = $this->input->post('detaildescription');
            $quantities   = $this->input->post('detailquantity');
            $unit_prices  = $this->input->post('detailunitprice');
            $gst_values   = $this->input->post('detailgst');
            
            $details = [];
    
            $descriptions = is_array($descriptions) ? $descriptions : array();
            $quantities = is_array($quantities) ? $quantities : array();
            $unit_prices = is_array($unit_prices) ? $unit_prices : array();

            for ($i = 0; $i < count($descriptions); $i++) {
                $description = isset($descriptions[$i]) ? trim($descriptions[$i]) : '';
                $quantity = isset($quantities[$i]) ? $quantities[$i] : '';
                $unit_price = isset($unit_prices[$i]) ? $unit_prices[$i] : '';

                if ($description == '' && $quantity == '' && $unit_price == '') {
                    continue;
                }

                $details[] = array(
                    'newpayments_id' => $newpayments_id,
                    'description' => $description,
                    'quantity' => $quantity,
                    'unit_price' => $unit_price
                );
            }
            
            if (count($details) > 0) {
                $this->db->insert_batch('newpayments_details', $details);
            }
            
            if ($this->upload->do_upload('companylogo'))
            {
                
                $upload_data = $this->upload->data();
            	$file_name = $upload_data['file_name'];
            	
                $data = array(
                    'newpayments_id' => $newpayments_id,
                	'companyname' => $this->input->post('companyname'),
                	'companylogo' => $file_name,
                	'businessregistrationnumber' => $this->input->post('businessregistrationnumber'),
                	'companyaddress' => $this->input->post('companyaddress'),
                	'invoicenumber' => $this->input->post('invoicenumber'),
                	'contactdetails' => $this->input->post('contactdetails'),
                	'schedule' => $this->input->post('schedule'),
                	'bankname' => $this->input->post('bankname'),
                	'bankaccountnumber' => $this->input->post('backaccountnumber'),
                	'bankidentifiercode' => $this->input->post('bankidentifiercode'),
                	'branchnumber' => $this->input->post('banknumber')
                );
                $this->db->insert('newpayments_company', $data);
                
            } else {
                        
                $data = array(
                    'newpayments_id' => $newpayments_id,
                	'companyname' => $this->input->post('companyname'),
                	'companylogo' => '',
                	'businessregistrationnumber' => $this->input->post('businessregistrationnumber'),
                	'companyaddress' => $this->input->post('companyaddress'),
                	'invoicenumber' => $this->input->post('invoicenumber'),
                	'contactdetails' => $this->input->post('contactdetails'),
                	'schedule' => $this->input->post('schedule'),
                	'bankname' => $this->input->post('bankname'),
                	'bankaccountnumber' => $this->input->post('backaccountnumber'),
                	'bankidentifiercode' => $this->input->post('bankidentifiercode'),
                	'branchnumber' => $this->input->post('banknumber')
                );
                $this->db->insert('newpayments_company', $data);
                        
            }
            
            $data = array(
                'newpayments_id' => $newpayments_id,
                'payorname' => $this->input->post('payeename'),
            	'client_id' => $this->input->post('payee'),
            	'address' => $this->input->post('address')
            );
            $this->db->insert('newpayments_payor', $data);
    		
    		redirect('payments');
		
        } elseif($this->input->post('savetype') == 'edit') {
            
            $this->db->set('paymenttype', $this->input->post('paymenttype'));
        	$this->db->set('description', $this->input->post('description'));
        	$this->db->set('reference', $this->input->post('reference'));
        	$this->db->set('paymentdate', $this->input->post('paymentdate'));
        	$this->db->set('totalprice', $this->input->post('totalprice'));
        	$this->db->set('taxnumber', $this->input->post('taxnumber'));
        	$this->db->set('totalpriceinwords', $this->input->post('totalpriceinwords'));
        	$this->db->set('duedate', $this->input->post('duedate'));
        	$this->db->set('discount', '0');
        	$this->db->set('penalty', '0');
        	$this->db->set('letterhead', $this->input->post('letterhead'));
        	
        	$this->db->set('taxpercent', $this->input->post('taxpercent'));
        	$this->db->set('discountpercent', $this->input->post('discountpercent'));
        	$this->db->set('penaltypercent', $this->input->post('penaltypercent'));

        	$this->db->where('id', $this->input->post('newpayments_id'));
        	$this->db->update('newpayments');
            
            $descriptions = $this->input->post('detaildescription');
            $quantities   = $this->input->post('detailquantity');
            $unit_prices  = $this->input->post('detailunitprice');
            $gst_values   = $this->input->post('detailgst');
            $ids   = $this->input->post('detailid');
            
            $descriptions = is_array($descriptions) ? $descriptions : array();
            $quantities = is_array($quantities) ? $quantities : array();
            $unit_prices = is_array($unit_prices) ? $unit_prices : array();
            $ids = is_array($ids) ? $ids : array();
            $kept_detail_ids = array();

            for ($i = 0; $i < count($descriptions); $i++) {
                $description = isset($descriptions[$i]) ? trim($descriptions[$i]) : '';
                $quantity = isset($quantities[$i]) ? $quantities[$i] : '';
                $unit_price = isset($unit_prices[$i]) ? $unit_prices[$i] : '';
                $detail_id = isset($ids[$i]) ? $ids[$i] : '';

                if ($description == '' && $quantity == '' && $unit_price == '') {
                    continue;
                }
                
                if(!empty($detail_id)) {
                    
                    $this->db->set('description', $description);
            		$this->db->set('quantity', $quantity);
            		$this->db->set('unit_price', $unit_price);
            		$this->db->where('id', $detail_id);
            		$this->db->update('newpayments_details');
            		$kept_detail_ids[] = $detail_id;
                    
                } else {
                    
                    $data = array(
                        'newpayments_id' => $this->input->post('newpayments_id'),
                        'description' => $description,
                    	'quantity' => $quantity,
                    	'unit_price' => $unit_price
                    );
                    $this->db->insert('newpayments_details', $data);
                    $kept_detail_ids[] = $this->db->insert_id();
                    
                }
                
            }

            $this->db->where('newpayments_id', $this->input->post('newpayments_id'));
            if (count($kept_detail_ids) > 0) {
                $this->db->where_not_in('id', $kept_detail_ids);
            }
            $this->db->delete('newpayments_details');
        	
            if ($this->upload->do_upload('companylogo'))
            {
                
                $upload_data = $this->upload->data();
        		$file_name = $upload_data['file_name'];
                
                $this->db->set('companyname', $this->input->post('companyname'));
        		$this->db->set('companylogo', $file_name);
        		$this->db->set('businessregistrationnumber', $this->input->post('businessregistrationnumber'));
        		$this->db->set('companyaddress', $this->input->post('companyaddress'));
        		$this->db->set('invoicenumber', $this->input->post('invoicenumber'));
        		$this->db->set('contactdetails', $this->input->post('contactdetails'));
        		$this->db->set('schedule', $this->input->post('schedule'));
        		$this->db->set('bankname', $this->input->post('bankname'));
        		$this->db->set('bankaccountnumber', $this->input->post('bankaccountnumber'));
        		$this->db->set('bankidentifiercode', $this->input->post('bankidentifiercode'));
        		$this->db->set('branchnumber', $this->input->post('banknumber'));
        		$this->db->where('newpayments_id', $this->input->post('newpayments_id'));
        		$this->db->update('newpayments_company');
                
            } else {
                
                $this->db->set('companyname', $this->input->post('companyname'));
        		$this->db->set('businessregistrationnumber', $this->input->post('businessregistrationnumber'));
        		$this->db->set('companyaddress', $this->input->post('companyaddress'));
        		$this->db->set('invoicenumber', $this->input->post('invoicenumber'));
        		$this->db->set('contactdetails', $this->input->post('contactdetails'));
        		$this->db->set('schedule', $this->input->post('schedule'));
        		$this->db->set('bankname', $this->input->post('bankname'));
        		$this->db->set('bankaccountnumber', $this->input->post('bankaccountnumber'));
        		$this->db->set('bankidentifiercode', $this->input->post('bankidentifiercode'));
        		$this->db->set('branchnumber', $this->input->post('banknumber'));
        		$this->db->where('newpayments_id', $this->input->post('newpayments_id'));
        		$this->db->update('newpayments_company');
                
            }
            
            $this->db->set('client_id', $this->input->post('payee'));
        	$this->db->set('address', $this->input->post('address'));
        	$this->db->set('payorname', $this->input->post('payeename'));
        	$this->db->where('newpayments_id', $this->input->post('newpayments_id'));
        	$this->db->update('newpayments_payor');
            
            redirect('payments');
            
        }
        
	}
	
}
