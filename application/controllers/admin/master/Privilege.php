<?php
class Privilege extends Auth_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $this->load->view("admin/master/privilege");
    }
}
