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

    function in()
    {
        $result = $this->auth->sign($this->input->post('username'), $this->input->post('password'));

        if ($result == null)
            $this->response401();
        else {
            unset($result->password);

            $result->avatar = base_url() . $result->avatar;
            $this->session->set_userdata("reskara_login", $result);
            $this->response200($result);
        }
    }

    function logout()
    {
        $this->session->unset_userdata("reskara_login");
        redirect(base_url('auth/sign/login'));
    }
}
