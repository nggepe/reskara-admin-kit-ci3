<?php
class Profile extends Auth_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $this->load->view("admin/setting/profile");
    }
}
