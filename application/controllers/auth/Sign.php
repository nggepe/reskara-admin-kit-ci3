<?php
class Sign extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function login()
    {
        $this->load->view("auth/login");
    }

    function logout()
    {
        redirect(base_url('auth/sign/login'));
    }
}
