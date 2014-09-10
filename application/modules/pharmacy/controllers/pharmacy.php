<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/auth/controllers/auth.php";

class Pharmacy extends auth
{	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('pharmacy_model');
		$this->load->model('reception/reception_model');
		$this->load->model('database');
		$this->load->model('reception/reception_model');
		$this->load->model('nurse/nurse_model');
	}
	
	public function index()
	{
		echo "no patient id";
	}

}
?>