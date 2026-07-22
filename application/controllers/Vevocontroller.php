<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vevocontroller extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->helper('form');
	}

	private function ensure_student_application_programs_table()
	{
		$this->db->query("
			CREATE TABLE IF NOT EXISTS student_application_programs (
				id INT(11) NOT NULL AUTO_INCREMENT,
				studentapp_id INT(11) NOT NULL,
				spid INT(11) NOT NULL,
				programtype VARCHAR(255) NOT NULL DEFAULT '',
				date_created DATETIME NOT NULL,
				PRIMARY KEY (id),
				UNIQUE KEY studentapp_program (studentapp_id, spid),
				KEY studentapp_id (studentapp_id),
				KEY spid (spid)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
		");

		$this->db->query("
			INSERT IGNORE INTO student_application_programs (studentapp_id, spid, programtype, date_created)
			SELECT sa.studentapp_id, sp.spid, COALESCE(sp.programtype, ''), NOW()
			FROM student_application sa
			INNER JOIN schoolprograms sp ON sp.spid = sa.studentapp_course_name
			WHERE sa.studentapp_course_name REGEXP '^[0-9]+$'
		");
	}

	private function normalize_program_ids($programs)
	{
		if (!is_array($programs)) {
			$programs = array($programs);
		}

		$program_ids = array();
		foreach ($programs as $program) {
			$program = trim($program);
			if ($program !== '' && !in_array($program, $program_ids)) {
				$program_ids[] = $program;
			}
		}

		return $program_ids;
	}

	private function get_primary_program($program_ids)
	{
		if (count($program_ids) == 0) {
			return array('spid' => '', 'programtype' => '');
		}

		$this->db->where('spid', $program_ids[0]);
		$query = $this->db->get('schoolprograms', 1);
		$program = $query->row();

		if (!$program) {
			return array('spid' => '', 'programtype' => '');
		}

		return array('spid' => $program->spid, 'programtype' => $program->programtype == null ? '' : $program->programtype);
	}

	private function save_student_application_programs($studentapp_id, $program_ids)
	{
		$this->ensure_student_application_programs_table();

		$this->db->where('studentapp_id', $studentapp_id);
		$this->db->delete('student_application_programs');

		if (count($program_ids) == 0) {
			return;
		}

		$this->db->where_in('spid', $program_ids);
		$query = $this->db->get('schoolprograms');
		$programs = array();
		foreach ($query->result() as $program) {
			$programs[$program->spid] = $program;
		}

		foreach ($program_ids as $program_id) {
			if (!isset($programs[$program_id])) {
				continue;
			}

			$this->db->insert('student_application_programs', array(
				'studentapp_id' => $studentapp_id,
				'spid' => $program_id,
				'programtype' => $programs[$program_id]->programtype == null ? '' : $programs[$program_id]->programtype,
				'date_created' => date('Y-m-d H:i:s')
			));
		}
	}

	private function student_google_drive_table_exists()
	{
		return $this->db->table_exists('student_google_drive');
	}

	private function get_client_row($client_id)
	{
		$this->db->where('client_id', $client_id);
		$query = $this->db->get('client');
		return $query->row();
	}

	private function student_drive_folder_name($client)
	{
		$parts = array();
		if (isset($client->client_surname) && trim($client->client_surname) != '') {
			$parts[] = trim($client->client_surname);
		}
		if (isset($client->client_firstname) && trim($client->client_firstname) != '') {
			$parts[] = trim($client->client_firstname);
		}
		if (isset($client->client_middlename) && trim($client->client_middlename) != '') {
			$parts[] = trim($client->client_middlename);
		}

		$name = trim(implode(', ', array_slice($parts, 0, 1)) . (count($parts) > 1 ? ' ' . implode(' ', array_slice($parts, 1)) : ''));
		if ($name == '') {
			$name = 'Student';
		}

		$name = preg_replace('/[\\\\\/:*?"<>|]+/', '-', $name);
		return $client->client_id . ' - ' . $name;
	}

	private function get_student_drive_folder($client_id)
	{
		if (!$this->student_google_drive_table_exists()) {
			return null;
		}

		$this->db->where('client_id', $client_id);
		$this->db->where('record_type', 'folder');
		$this->db->where('is_active', 1);
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get('student_google_drive', 1);
		return $query->row();
	}

	private function ensure_student_drive_folder($client_id)
	{
		if (!$this->student_google_drive_table_exists()) {
			throw new Exception('The student_google_drive table does not exist yet. Please run the schema in phpMyAdmin.');
		}

		$existing = $this->get_student_drive_folder($client_id);
		if ($existing) {
			return $existing;
		}

		$client = $this->get_client_row($client_id);
		if (!$client) {
			throw new Exception('Client record was not found.');
		}

		$parent_folder_id = $this->config->item('google_drive_parent_folder_id');
		if ($parent_folder_id == '') {
			$parent_folder_id = $this->config->item('google_drive_folder_id');
		}
		if ($parent_folder_id == '') {
			throw new Exception('Google Drive parent folder ID is not configured.');
		}

		$shared_drive_id = $this->config->item('google_shared_drive_id');
		$folder_name = $this->student_drive_folder_name($client);

		$this->load->library('google_drive_service');
		$folder = $this->google_drive_service->create_folder($folder_name, $parent_folder_id, $shared_drive_id);

		$data = array(
			'client_id' => $client_id,
			'record_type' => 'folder',
			'shared_drive_id' => $shared_drive_id,
			'parent_folder_id' => $parent_folder_id,
			'student_folder_id' => $folder['id'],
			'drive_file_id' => $folder['id'],
			'drive_file_name' => $folder_name,
			'drive_web_view_link' => isset($folder['webViewLink']) ? $folder['webViewLink'] : '',
			'uploaded_by_id' => isset($this->session->officer_id) ? $this->session->officer_id : null,
			'uploaded_by_name' => isset($this->session->officer_name) ? $this->session->officer_name : 'SMIC CRM',
			'created_at' => date('Y-m-d H:i:s')
		);

		$this->db->insert('student_google_drive', $data);
		$data['id'] = $this->db->insert_id();

		return (object) $data;
	}

	private function upload_vevo_to_google_drive($client_id, $file_path, $original_name, $mime_type, $file_size)
	{
		if ($file_path == '' || !is_readable($file_path)) {
			return;
		}

		$folder = $this->ensure_student_drive_folder($client_id);
		$shared_drive_id = $this->config->item('google_shared_drive_id');

		$this->load->library('google_drive_service');
		$drive_file = $this->google_drive_service->upload_file(
			$file_path,
			$original_name,
			$mime_type,
			$folder->student_folder_id,
			$shared_drive_id
		);

		$this->db->insert('student_google_drive', array(
			'client_id' => $client_id,
			'record_type' => 'file',
			'shared_drive_id' => $shared_drive_id,
			'parent_folder_id' => $folder->student_folder_id,
			'student_folder_id' => $folder->student_folder_id,
			'drive_file_id' => $drive_file['id'],
			'drive_file_name' => isset($drive_file['name']) ? $drive_file['name'] : $original_name,
			'drive_web_view_link' => isset($drive_file['webViewLink']) ? $drive_file['webViewLink'] : '',
			'drive_web_content_link' => isset($drive_file['webContentLink']) ? $drive_file['webContentLink'] : '',
			'document_purpose' => 'Admission',
			'document_type' => 'VEVO Expiry',
			'document_specific' => 'VEVO Expiry',
			'document_alias' => '',
			'remarks' => '',
			'mime_type' => isset($drive_file['mimeType']) ? $drive_file['mimeType'] : $mime_type,
			'file_size' => isset($drive_file['size']) ? (int) $drive_file['size'] : $file_size,
			'uploaded_by_id' => isset($this->session->officer_id) ? $this->session->officer_id : null,
			'uploaded_by_name' => isset($this->session->officer_name) ? $this->session->officer_name : 'SMIC CRM',
			'created_at' => date('Y-m-d H:i:s')
		));
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
            
            		$program_ids = $this->normalize_program_ids($this->input->post('program'));
            		$primary_program = $this->get_primary_program($program_ids);
            		$programname = $primary_program['spid'];
            		$programtype = $primary_program['programtype'];
            
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
            		$this->db->trans_begin();
            		try {
            			$this->db->insert('student_application', $data);
            			$this->save_student_application_programs($this->db->insert_id(), $program_ids);
            			$this->upload_vevo_to_google_drive(
            				$this->input->post('clientid'),
            				$upload_data['full_path'],
            				$upload_data['file_name'],
            				$upload_data['file_type'],
            				$upload_data['file_size'] * 1024
            			);

            			if ($this->db->trans_status() === FALSE) {
            				throw new Exception('Unable to save student application.');
            			}
            			$this->db->trans_commit();
            		} catch (Exception $e) {
            			$this->db->trans_rollback();
            			if (!empty($upload_data['full_path']) && file_exists($upload_data['full_path'])) {
            				unlink($upload_data['full_path']);
            			}
            			show_error($e->getMessage(), 500);
            			return;
            		}
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
            
            		$program_ids = $this->normalize_program_ids($this->input->post('program'));
            		$primary_program = $this->get_primary_program($program_ids);
            		$programname = $primary_program['spid'];
            		$programtype = $primary_program['programtype'];
            
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
            		$this->db->trans_start();
            		$this->db->insert('student_application', $data);
            		$this->save_student_application_programs($this->db->insert_id(), $program_ids);
            		$this->db->trans_complete();
                }
                
                redirect(base_url()."index.php/editclientinfo2/".$this->input->post('clientid')."/admission");
                    
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
        
        		$program_ids = $this->normalize_program_ids($this->input->post('program'));
        		$primary_program = $this->get_primary_program($program_ids);
        		$programname = $primary_program['spid'];
        		$programtype = $primary_program['programtype'];
        
        		$this->db->trans_start();
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
        		$this->db->set('course_starting_date', $this->input->post('startdate'));
        		$this->db->set('course_ending_date', $this->input->post('enddate'));
        		$this->db->set('intake', $this->input->post('intake'));
        		$this->db->set('remarks', $this->input->post('remarks'));
        		$this->db->set('campus', $this->input->post('campus'));
        		$this->db->set('vevo_expiry_date', $this->input->post('vevo_expiry_date'));
        		$this->db->where('studentapp_id', $this->input->post('studentapp_id'));
        		$this->db->update('student_application');
        		$this->save_student_application_programs($this->input->post('studentapp_id'), $program_ids);
        		$this->db->trans_complete();
                
                redirect(base_url()."index.php/editclientinfo2/".$this->input->post('clientid')."/admission");
                
            }

                
        }
	
}
