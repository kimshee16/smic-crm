<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter FPDF Class
 *
 * This class enables PDF reporting using FPDF
 *
 */

//use fpdf\fpdf;
//require 'fpdf/fpdf.php';

class Mypdf {
	public function __construct() {
		include APPPATH . 'third_party/fpdf/fpdf.php';
	}
}
/* End of file Pdf.php */