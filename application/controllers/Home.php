<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends Auth_Controller
{
	public function index()
	{
		$this->load->view('template/layout');
	}
}
