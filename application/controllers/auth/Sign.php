<?php
class Sign extends Res_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("auth/M_auth", "auth");
    }

    function login()
    {
        $this->load->view("auth/login");
    }

    function sign()
    {
        $result = $this->auth->sign($this->input->post('username'), $this->input->post('password'));
        $this->json_response($result);
    }

    function logout()
    {
        $this->session->uset_userdata("reskara_login");
        redirect(base_url('auth/sign/login'));
    }
}
