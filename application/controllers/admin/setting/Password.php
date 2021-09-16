<?php
class Password extends Auth_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $this->load->view("admin/setting/password");
    }

    function password_validate()
    {
        $data = $this->get_user_login();

        $get_user = $this->db->get_where("user", ["id" => $data->id])->row();
        $password = md5($this->input->post("password"));
        if ($get_user->password == $password) $this->response200("success");
        else $this->response200("failed");
    }
}
