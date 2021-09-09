<?php
class Dashboard extends Auth_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $data = $this->session->userdata("reskara_login");
        $this->load->view('admin/dashboard', $data);
    }
}
