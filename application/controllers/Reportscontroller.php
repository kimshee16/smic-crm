<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportscontroller extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->helper('form');
	}

	public function index() {
		$asset_url = base_url()."assets/";
		$data['title'] = "Reports";
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

		if($this->session->officer_role == "") {
			redirect(base_url()."index.php/messages");
		} else {
			if(isset($this->session->officer_name)) {
				$this->load->view('reports/index', $data);
			} else {
				redirect(base_url()."?error3=1");
			}
		}
	}

	public function generatereportdefault() {
		$this->load->library('mypdf');
		$test = "This is a test";
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',14);
		/*$pdf->Cell(59,5,'',0,1);
		$pdf->Cell(59,5,'',0,1);
		$pdf->Cell(59,5,'',0,1);
		$pdf->Cell(59,5,'',0,1);
		$pdf->Cell(59,5,'',0,1);
		$pdf->Cell(59,5,'',0,1);
		$pdf->Cell(59,5,'',0,1);*/
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(189,5,' ANNUAL INVENTORY REPORT',0,1,'C');
		$pdf->Cell(189,5," As of 2022-04-30 to 2022-04-30",0,1,'C');
		$pdf->Cell(59,5,'',0,1);
		$pdf->Cell(59,5,'',0,1);
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(20,5,"Item Code",1,0,'C');
		$pdf->Cell(60,5,"Name",1,0,'C');
		$pdf->Cell(15,5,"Quantity",1,0,'C');
		$pdf->Cell(25,5,"Room",1,0,'C');
		$pdf->Cell(35,5,"In-charge",1,0,'C');
		$pdf->Cell(20,5,"Status",1,0,'C');
		$pdf->Cell(17,5,"Date",1,1,'C');
		$x = 0;
		while($x < 200){  
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(20,5,"{$test}",1,0,'C');
			$pdf->SetFont('Arial','',7);
			$pdf->Cell(60,5,"{$test}",1,0,'C');
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(15,5,"{$test}",1,0,'C');
			$pdf->SetFont('Arial','',6);
			$pdf->Cell(25,5,"{$test}",1,0,'C');
			$pdf->SetFont('Arial','',7);
			$pdf->Cell(35,5,"{$test}",1,0,'C');
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(20,5,"{$test}",1,0,'C');
			$pdf->Cell(17,5,"{$test}",1,1,'C');
			$x++;
		}
		$pdf->output();
	}

	public function student_application_report() {
		$asset_url = base_url()."assets/";
		$status = $this->input->post('status');
		$sql = "SELECT * FROM student_application sa left join education_provider s on sa.provider_id = s.provider_id left join client c on c.client_id = sa.client_id left join officer o on o.officer_id = sa.officer_id WHERE studentapp_flag = '$status'";
        $query = $this->db->query($sql);
        $result = $query->result();

        $datenow = date("Y-m-d");

		$this->load->library('Mypdf');
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',14);
		$pdf->SetFont('Arial','B',12);
		$pdf->Image($asset_url.'images/logo-new-no-background-2.png',85,10,40);
		$pdf->Cell(59,5,'',0,1);
		$pdf->Cell(59,5,'',0,1);
		$pdf->Cell(59,5,'',0,1);
		$pdf->Cell(59,5,'',0,1);
		$pdf->Cell(59,5,'',0,1);
		$pdf->Cell(59,5,'',0,1);
		$pdf->Cell(59,5,'',0,1);
		$pdf->Cell(189,5,"Student Application (".$status.")",0,1,'C');
		$pdf->Cell(189,5,"(Generated on ".$datenow.")",0,1,'C');
		$pdf->Cell(59,5,'',0,1);
		$pdf->Cell(59,5,'',0,1);
		$pdf->SetFont('Arial','B',6);
		$pdf->Cell(40,5,"Client Name",1,0,'C');
		$pdf->Cell(45,5,"Provider Name",1,0,'C');
		$pdf->Cell(25,5,"Course Level/Name",1,0,'C');
		$pdf->Cell(20,5,"Course Start Date",1,0,'C');
		$pdf->Cell(40,5,"Officer Name",1,0,'C');
		$pdf->Cell(20,5,"Visa Lodged Date",1,1,'C');

		foreach ($result as $row){  
			$visalodgeddate = $row->studentapp_visa_lodged_year."-".$row->studentapp_visa_lodged_month."-".$row->studentapp_visa_lodged_day;
			$coursestartdate = $row->studentapp_course_starting_year."-".$row->studentapp_course_starting_month."-".$row->studentapp_course_starting_day;
			$clientname = $row->client_surname.", ".$row->client_firstname;

			$pdf->SetFont('Arial','',6);
			$pdf->Cell(40,5,"{$clientname}",1,0,'C');
			$pdf->SetFont('Arial','',6);
			$pdf->Cell(45,5,"{$row->provider_name}",1,0,'C');
			$pdf->SetFont('Arial','',6);
			$pdf->Cell(25,5,"{$row->studentapp_course_level}",1,0,'C');
			$pdf->SetFont('Arial','',6);
			$pdf->Cell(20,5,"{$coursestartdate}",1,0,'C');
			$pdf->SetFont('Arial','',6);
			$pdf->Cell(40,5,"{$row->officer_name}",1,0,'C');
			$pdf->SetFont('Arial','',6);
			$pdf->Cell(20,5,"{$visalodgeddate}",1,1,'C');
		}
		$pdf->output();
	}
	
	public function payment_report($payment_id) {
		$asset_url = base_url()."assets/";
		$status = $this->input->post('status');
		$sql = "SELECT * from payments p left join client c on p.payee = c.client_id left join officer o on o.officer_id = p.processedby WHERE paymentid = $payment_id";
        $query = $this->db->query($sql);
        $result = $query->result();

        $datenow = date("Y-m-d");

		$this->load->library('Mypdf');
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',14);
		$pdf->SetFont('Arial','B',12);
		$pdf->Image($asset_url.'images/logo-new-no-background-2.png',85,10,40);
		$pdf->Cell(59,5,'',0,1);
		$pdf->Cell(59,5,'',0,1);
		$pdf->Cell(59,5,'',0,1);
		$pdf->Cell(59,5,'',0,1);
		$pdf->Cell(59,5,'',0,1);
		$pdf->Cell(59,5,'',0,1);
		$pdf->Cell(59,5,'',0,1);
		$pdf->Cell(189,5,"Payment ID # (".$payment_id.")",0,1,'C');
		$pdf->Cell(189,5,"(Generated on ".$datenow.")",0,1,'C');
		$pdf->Cell(59,5,'',0,1);
		$pdf->Cell(59,5,'',0,1);
		
		foreach ($result as $row){  

            $client = $row->client_surname.", ".$row->client_firstname." ".$row->client_middlename;
            $finalamount = $row->currency." ".$row->amount;

            $pdf->SetFont('Arial','B',10);
		    $pdf->Cell(92.5,10,"Reference Number",1,0,'L');
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(92.5,10,"{$row->referencenumber}",1,1,'L');
			
			$pdf->SetFont('Arial','B',10);
		    $pdf->Cell(92.5,10,"Payer Name",1,0,'L');
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(92.5,10,"{$client}",1,1,'L');
			
			$pdf->SetFont('Arial','B',10);
		    $pdf->Cell(92.5,10,"Description",1,0,'L');
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(92.5,10,"{$row->paymentdescription}",1,1,'L');
			
			$pdf->SetFont('Arial','B',10);
		    $pdf->Cell(92.5,10,"Schedule",1,0,'L');
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(92.5,10,"{$row->paymentschedule}",1,1,'L');
			
			$pdf->SetFont('Arial','B',10);
		    $pdf->Cell(92.5,10,"Amount",1,0,'L');
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(92.5,10,"{$finalamount}",1,1,'L');
			
			$pdf->SetFont('Arial','B',10);
		    $pdf->Cell(92.5,10,"Processed By",1,0,'L');
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(92.5,10,"{$row->officer_name}",1,1,'L');
			
// 			$pdf->SetFont('Arial','',6);
// 			$pdf->Cell(45,5,"{$row->provider_name}",1,0,'C');
// 			$pdf->SetFont('Arial','',6);
// 			$pdf->Cell(25,5,"{$row->studentapp_course_level}",1,0,'C');
// 			$pdf->SetFont('Arial','',6);
// 			$pdf->Cell(20,5,"{$coursestartdate}",1,0,'C');
// 			$pdf->SetFont('Arial','',6);
// 			$pdf->Cell(40,5,"{$row->officer_name}",1,0,'C');
// 			$pdf->SetFont('Arial','',6);
// 			$pdf->Cell(20,5,"{$visalodgeddate}",1,1,'C');
		}

// 		foreach ($result as $row){  
// 			$visalodgeddate = $row->studentapp_visa_lodged_year."-".$row->studentapp_visa_lodged_month."-".$row->studentapp_visa_lodged_day;
// 			$coursestartdate = $row->studentapp_course_starting_year."-".$row->studentapp_course_starting_month."-".$row->studentapp_course_starting_day;
// 			$clientname = $row->client_surname.", ".$row->client_firstname;

// 			$pdf->SetFont('Arial','B',6);
// 			$pdf->Cell(40,5,"{$clientname}",1,0,'C');
// 			$pdf->SetFont('Arial','',6);
// 			$pdf->Cell(45,5,"{$row->provider_name}",1,0,'C');
// 			$pdf->SetFont('Arial','',6);
// 			$pdf->Cell(25,5,"{$row->studentapp_course_level}",1,0,'C');
// 			$pdf->SetFont('Arial','',6);
// 			$pdf->Cell(20,5,"{$coursestartdate}",1,0,'C');
// 			$pdf->SetFont('Arial','',6);
// 			$pdf->Cell(40,5,"{$row->officer_name}",1,0,'C');
// 			$pdf->SetFont('Arial','',6);
// 			$pdf->Cell(20,5,"{$visalodgeddate}",1,1,'C');
// 		}
		$pdf->output();
	}

	public function visa_application_report() {
		$asset_url = base_url()."assets/";
		$status = $this->input->post('status');
		$sql = "SELECT * FROM visa_application sa inner join client c on c.client_id = sa.client_id WHERE status = '$status'";
        $query = $this->db->query($sql);
        $result = $query->result();

        $datenow = date("Y-m-d");

		$this->load->library('Mypdf');
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',14);
		$pdf->SetFont('Arial','B',12);
		$pdf->Image($asset_url.'images/logo-new-no-background-2.png',85,10,40);
		$pdf->Cell(59,5,'',0,1);
		$pdf->Cell(59,5,'',0,1);
		$pdf->Cell(59,5,'',0,1);
		$pdf->Cell(59,5,'',0,1);
		$pdf->Cell(59,5,'',0,1);
		$pdf->Cell(59,5,'',0,1);
		$pdf->Cell(59,5,'',0,1);
		$pdf->Cell(189,5,"Visa Application (".$status.")",0,1,'C');
		$pdf->Cell(189,5,"(Generated on ".$datenow.")",0,1,'C');
		$pdf->Cell(59,5,'',0,1);
		$pdf->Cell(59,5,'',0,1);
		$pdf->SetFont('Arial','B',6);
		$pdf->Cell(30,5,"Client Name",1,0,'C');
		$pdf->Cell(20,5,"PR Subclass",1,0,'C');
		$pdf->Cell(20,5,"PR Critical Date",1,0,'C');
		$pdf->SetFont('Arial','B',5);
		$pdf->Cell(20,5,"PR Visa Expiry Date",1,0,'C');
		$pdf->SetFont('Arial','B',4);
		$pdf->Cell(20,5,"PR Assessment Lodged Date",1,0,'C');
		$pdf->SetFont('Arial','B',4);
		$pdf->Cell(20,5,"PR Assessment Result Date",1,0,'C');
		$pdf->SetFont('Arial','B',5);
		$pdf->Cell(20,5,"PR AFP Lodged Date",1,0,'C');
		$pdf->Cell(20,5,"PR AFP Received Date",1,0,'C');
		$pdf->Cell(20,5,"PR Lodged Date",1,1,'C');

		foreach ($result as $row){  
			$clientname = $row->client_surname.", ".$row->client_firstname;
			$visalodgeddate = $row->visa_lodged_year."-".$row->visa_lodged_month."-".$row->visa_lodged_day;
			$visaexpirydate = $row->visa_expiry_year."-".$row->visa_expiry_month."-".$row->visa_expiry_day;
			$visacriticaldate = $row->visa_critical_year."-".$row->visa_critical_month."-".$row->visa_critical_day;
			$skillsassessmentlodgeddate = $row->skills_assessment_lodged_year."-".$row->skills_assessment_lodged_month."-".$row->skills_assessment_lodged_day;
			$visaafplodgeddate = $row->visa_afp_lodged_year."-".$row->visa_afp_lodged_month."-".$row->visa_afp_lodged_day;
			$englishtestdate = $row->english_test_year."-".$row->english_test_month."-".$row->english_test_day;
			$visadecisiondate = $row->visa_decision_year."-".$row->visa_decision_month."-".$row->visa_decision_day;

			$pdf->SetFont('Arial','',6);
			$pdf->Cell(30,5,"{$clientname}",1,0,'C');
			$pdf->SetFont('Arial','',6);
			$pdf->Cell(20,5,"{$row->new_Visa_subclass}",1,0,'C');
			$pdf->SetFont('Arial','',6);
			$pdf->Cell(20,5,"{$visacriticaldate}",1,0,'C');
			$pdf->SetFont('Arial','',6);
			$pdf->Cell(20,5,"{$visaexpirydate}",1,0,'C');
			$pdf->SetFont('Arial','',6);
			$pdf->Cell(20,5,"{$skillsassessmentlodgeddate}",1,0,'C');
			$pdf->SetFont('Arial','',6);
			$pdf->Cell(20,5,"{$visadecisiondate}",1,0,'C');
			$pdf->SetFont('Arial','',6);
			$pdf->Cell(20,5,"{$visaafplodgeddate}",1,0,'C');
			$pdf->SetFont('Arial','',6);
			$pdf->Cell(20,5,"{$englishtestdate}",1,0,'C');
			$pdf->SetFont('Arial','',6);
			$pdf->Cell(20,5,"{$visalodgeddate}",1,1,'C');
		}
		$pdf->output();
	}

	public function visa_eoi() {
		$asset_url = base_url()."assets/";
		$status = $this->input->post('status');
		$sql = "SELECT * FROM expression_of_interest eoi inner join client c on eoi.client_id = c.client_id WHERE eoi.flag = '$status'";
        $query = $this->db->query($sql);
        $result = $query->result();

        $datenow = date("Y-m-d");

		$this->load->library('Mypdf');
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',14);
		$pdf->SetFont('Arial','B',12);
		$pdf->Image($asset_url.'images/logo-new-no-background-2.png',85,10,40);
		$pdf->Cell(59,5,'',0,1);
		$pdf->Cell(59,5,'',0,1);
		$pdf->Cell(59,5,'',0,1);
		$pdf->Cell(59,5,'',0,1);
		$pdf->Cell(59,5,'',0,1);
		$pdf->Cell(59,5,'',0,1);
		$pdf->Cell(59,5,'',0,1);
		$pdf->Cell(189,5,"Visa Application (".$status.")",0,1,'C');
		$pdf->Cell(189,5,"(Generated on ".$datenow.")",0,1,'C');
		$pdf->Cell(59,5,'',0,1);
		$pdf->Cell(59,5,'',0,1);
		$pdf->SetFont('Arial','B',6);
		$pdf->Cell(30,5,"Client Name",1,0,'C');
		$pdf->Cell(25,5,"EOI Number",1,0,'C');
		$pdf->Cell(25,5,"Occupation",1,0,'C');
		$pdf->SetFont('Arial','B',5);
		$pdf->Cell(15,5,"Visa Subclasses",1,0,'C');
		$pdf->SetFont('Arial','B',5);
		$pdf->Cell(15,5,"Submitted Date",1,0,'C');
		$pdf->SetFont('Arial','B',5);
		$pdf->Cell(15,5,"Preferred Date",1,0,'C');
		$pdf->SetFont('Arial','B',6);
		$pdf->Cell(15,5,"Skill Date",1,0,'C');
		$pdf->Cell(15,5,"PY Date",1,0,'C');
		$pdf->Cell(15,5,"English Date",1,0,'C');
		$pdf->Cell(20,5,"Flag",1,1,'C');

		foreach ($result as $row){  
			$clientname = $row->client_surname.", ".$row->client_firstname;

			$pdf->SetFont('Arial','',6);
			$pdf->Cell(30,5,"{$clientname}",1,0,'C');
			$pdf->SetFont('Arial','',6);
			$pdf->Cell(25,5,"{$row->eoi_number}",1,0,'C');
			$pdf->SetFont('Arial','',6);
			$pdf->Cell(25,5,"{$row->nominated_occupation}",1,0,'C');
			$pdf->SetFont('Arial','',6);
			$pdf->Cell(15,5,"{$row->visa_subclasses}",1,0,'C');
			$pdf->SetFont('Arial','',6);
			$pdf->Cell(15,5,"{$row->eoi_submitted_date}",1,0,'C');
			$pdf->SetFont('Arial','',6);
			$pdf->Cell(15,5,"{$row->preferred_date}",1,0,'C');
			$pdf->SetFont('Arial','',6);
			$pdf->Cell(15,5,"{$row->skill_assessment_date}",1,0,'C');
			$pdf->SetFont('Arial','',6);
			$pdf->Cell(15,5,"{$row->py_completion_date}",1,0,'C');
			$pdf->SetFont('Arial','',6);
			$pdf->Cell(15,5,"{$row->english_competency_test_date}",1,0,'C');
			$pdf->SetFont('Arial','',6);
			$pdf->Cell(20,5,"{$row->flag}",1,1,'C');
		}
		$pdf->output();
	}

	public function visa_account() {
		$asset_url = base_url()."assets/";
		$datefrom = $this->input->post('datefrom');
		$dateto = $this->input->post('dateto');
		$sql = "SELECT * FROM visa_accounts vac inner join visa_application vap on vac.client_visa_id = vap.client_visa_id inner join client c on vap.client_id = c.client_id WHERE vac.received_date BETWEEN '$datefrom' AND '$dateto'";
        $query = $this->db->query($sql);
        $result = $query->result();

        $datenow = date("Y-m-d");

		$this->load->library('Mypdf');
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',14);
		$pdf->SetFont('Arial','B',12);
		$pdf->Image($asset_url.'images/logo-new-no-background-2.png',85,10,40);
		$pdf->Cell(59,5,'',0,1);
		$pdf->Cell(59,5,'',0,1);
		$pdf->Cell(59,5,'',0,1);
		$pdf->Cell(59,5,'',0,1);
		$pdf->Cell(59,5,'',0,1);
		$pdf->Cell(59,5,'',0,1);
		$pdf->Cell(59,5,'',0,1);
		$pdf->Cell(189,5,"Visa Account (From ".$datefrom." To ".$dateto.")",0,1,'C');
		$pdf->Cell(189,5,"(Generated on ".$datenow.")",0,1,'C');
		$pdf->Cell(59,5,'',0,1);
		$pdf->Cell(59,5,'',0,1);
		$pdf->SetFont('Arial','B',6);
		$pdf->Cell(30,5,"Client Name",1,0,'C');
		$pdf->SetFont('Arial','B',5);
		$pdf->Cell(20,5,"VISA Application ID",1,0,'C');
		$pdf->SetFont('Arial','B',6);
		$pdf->Cell(20,5,"Received Date",1,0,'C');
		$pdf->SetFont('Arial','B',4);
		$pdf->Cell(25,5,"Received Amount Excluding GST",1,0,'C');
		$pdf->SetFont('Arial','B',6);
		$pdf->Cell(25,5,"Received GST",1,0,'C');
		$pdf->Cell(20,5,"Disbursed Date",1,0,'C');
		$pdf->SetFont('Arial','B',4);
		$pdf->Cell(25,5,"Disbursed Amount Exluding GST",1,0,'C');
		$pdf->SetFont('Arial','B',6);
		$pdf->Cell(25,5,"Disbursed GST",1,1,'C');					

		foreach ($result as $row){  
			$clientname = $row->client_surname.", ".$row->client_firstname;

			$pdf->SetFont('Arial','',6);
			$pdf->Cell(30,5,"{$clientname}",1,0,'C');
			$pdf->SetFont('Arial','',6);
			$pdf->Cell(20,5,"{$row->client_visa_id}",1,0,'C');
			$pdf->SetFont('Arial','',6);
			$pdf->Cell(20,5,"{$row->received_date}",1,0,'C');
			$pdf->SetFont('Arial','',6);
			$pdf->Cell(25,5,"{$row->received_amount_ex_gst}",1,0,'C');
			$pdf->SetFont('Arial','',6);
			$pdf->Cell(25,5,"{$row->received_gst}",1,0,'C');
			$pdf->SetFont('Arial','',6);
			$pdf->Cell(20,5,"{$row->disbursed_date}",1,0,'C');
			$pdf->SetFont('Arial','',6);
			$pdf->Cell(25,5,"{$row->disbursed_amount_ex_gst	}",1,0,'C');
			$pdf->SetFont('Arial','',6);
			$pdf->Cell(25,5,"{$row->disbursed_gst}",1,1,'C');
		}
		$pdf->output();
	}

}