<?php

class Res_Controller extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function response200($body)
    {
        echo json_encode($body);
    }

    function response400()
    {
        $this->output->set_status_header(400)->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode("Bad request!", JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
            ->_display();
    }

    function response401()
    {
        $this->output->set_status_header(401)->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode("Login required!", JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
            ->_display();
    }
}

class Auth_Controller extends Res_Controller
{
    function __construct()
    {
        parent::__construct();
        $sess = $this->session->userdata();
        if (!isset($sess['reskara_login'])) redirect(base_url("auth/sign/login"));
    }

    function get_user_login()
    {
        return $this->session->userdata("reskara_login");
    }
}
