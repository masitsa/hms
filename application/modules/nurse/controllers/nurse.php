<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/auth/controllers/auth.php";

class Nurse extends auth
{	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('nurse_model');
		$this->load->model('database');
	}
}
?>