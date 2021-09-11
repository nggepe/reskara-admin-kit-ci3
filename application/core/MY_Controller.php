<?php

class Res_Controller extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function response200($body)
    {
        exit(json_encode($body));
    }

    function response_custom($code, $body)
    {
        http_response_code($code);
        exit(json_encode($body));
    }

    function response400()
    {
        http_response_code(400);
        exit("Bad request!");
    }

    function response401()
    {
        http_response_code(401);
        exit("Login required!");
    }
}

class Auth_Controller extends Res_Controller
{
    function __construct()
    {
        parent::__construct();
        $sess = $this->session->userdata();
        if (!isset($sess['reskara_login'])) {
            http_response_code(401);
            $this->load->view("errors/html/error_401");
        }
    }

    function get_user_login()
    {
        return $this->session->userdata("reskara_login");
    }

    function get_menu()
    {
        $id_user = $this->get_user_login()->id;
        $this->db->select("m.*");
        $this->db->from("privilege_menu pm");
        $this->db->join("menu m", "m.id = pm.id_menu", "left");
        $this->db->join("privilege p", "p.id = pm.id_privilege", "left");
        $this->db->join("user u", "u.id_privilege = p.id", "left");
        $this->db->where("u.id", $id_user);
        $this->db->order_by("m.sequence", "asc");
        $data = $this->db->get()->result();
        if ($data) :
            $menu = [];
            foreach ($data as $key => $value) {

                if ($value->parent == null) :
                    $child = $this->find_child($data, $value->id);
                    $value->child = $child;
                    $menu[] = $value;
                endif;
            }
            return $menu;
        else :
            return [];
        endif;
    }

    private function find_child($data, $parent_id)
    {
        $menu = [];

        foreach ($data as $key => $value) {
            if ($value->parent == $parent_id && $value->id != $parent_id) {
                $value->child = [];
                if ($this->has_child($data, $value->id)) {
                    $value->child = $this->find_child($data, $value->id);
                }
                $menu[] = $value;
            }
        }

        return $menu;
    }

    private function  has_child($data, $parent_id): bool
    {
        $status = false;
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]->parent == $parent_id) {
                $status = true;
                break;
            }
        }
        return $status;
    }
}
