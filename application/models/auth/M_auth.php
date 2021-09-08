<?php

class M_auth extends CI_Model
{
    public function sign($username, $password)
    {
        $password = md5($password);
        $this->db->where('username', $username);
        $this->db->where('password', $password);
        $data = $this->db->get('user')->row();



        if ($data) {
            $this->session->set_userdata("reskara_login", $data);
            return true;
        } else return false;
    }
}
