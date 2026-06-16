<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Requireddocumentscontroller extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->helper('form');
	}
	
	public function index()
	{
		$asset_url = base_url()."assets/";
		$data['title'] = "Required Documents";
		$data['asset_url'] = $asset_url;
		
		if($this->session->officer_role == "") {
			redirect(base_url()."index.php/messages");
		} else {
			if(isset($this->session->officer_name)) {
				$this->load->view('requireddocuments/index', $data);
			} else {
				redirect(base_url()."?error3=1");
			}
		}
	}

	public function adddocuments()
	{
		$client_id = $this->input->post('client_id');
		$document_type = $this->input->post('document_type');
		$document_name = $this->input->post('document_name');
		$document_link = $this->input->post('document_link');
		$alias = $this->input->post('alias');
		$remarks = $this->input->post('remarks');

		$data = array(
					'client_id' => $client_id,
					'document_type' => $document_type,
					'document_link' => $document_link,
					'date_uploaded' => date("Y-m-d"),
					'document_name' => $document_name,
					'alias' => $alias,
					'remarks' => $remarks
				);
		$this->db->insert('firebasefiles', $data);
		echo json_encode("Successfully uploaded the document!");
	}
	
	public function updatedocuments()
	{
	    $fbid = $this->input->post('fbid');
		$document_name = $this->input->post('document_name');
		$document_link = $this->input->post('document_link');
		$alias = $this->input->post('alias');
		$remarks = $this->input->post('remarks');

// 		$data = array(
// 					'document_link' => $document_link,
// 					'date_uploaded' => date("Y-m-d"),
// 					'document_name' => $document_name,
// 					'alias' => $alias,
// 					'remarks' => $remarks
// 				);
// 		$this->db->insert('firebasefiles', $data);

        $this->db->set('document_name', $document_name);
		$this->db->set('document_link', $document_link);
        $this->db->set('alias', $alias);
		$this->db->set('remarks', $remarks);
		$this->db->where('fbid', $fbid);
		$this->db->update('firebasefiles');

		echo json_encode("Successfully updated the document!");
	}

	public function getdocuments($client_id)
	{
		$sql = "SELECT * FROM firebasefiles where client_id = '$client_id'";
	    $query = $this->db->query($sql);
	    $firebasefiles = $query->result();
		echo json_encode($firebasefiles);
	}

	public function deletedocuments($client_id)
	{
		$this->db->where('fbid', $client_id);
		$this->db->delete('firebasefiles');
		echo json_encode("Successfully deleted the document!");
	}

}