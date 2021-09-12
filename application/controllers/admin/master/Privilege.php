<?php
class Privilege extends Auth_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $this->is_no_log_tologin();
        $this->load->view("admin/master/privilege");
    }
}
