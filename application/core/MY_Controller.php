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

    function response401($text = "Login required!")
    {
        http_response_code(401);
        exit($text);
    }
}

class Auth_Controller extends Res_Controller
{
    function __construct()
    {
        parent::__construct();
        $sess = $this->session->userdata();
        if (!isset($sess['reskara_login'])) {
            redirect(base_url() . "auth/sign/login401");
        }
        $this->validate_access_control();
    }

    private function list_menu(): array
    {
        $id_user = $this->get_user_login()->id;
        $this->db->select("m.*, u.full_name, u.id as id_user");
        $this->db->from("privilege_menu pm");
        $this->db->join("menu m", "m.id = pm.id_menu", "left");
        $this->db->join("privilege p", "p.id = pm.id_privilege", "left");
        $this->db->join("user u", "u.id_privilege = p.id", "left");
        $this->db->where("u.id", $id_user);
        $this->db->order_by("m.sequence", "asc");
        $data = $this->db->get()->result();
        return $data;
    }



    private function validate_access_control()
    {
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        if ($actual_link != base_url()) {
            $uri = str_split($actual_link);
            $actual_link = "";
            for ($i = 0; $i <  count($uri); $i++) {
                $value = $uri[$i];
                if ($value == "?") break;
                else $actual_link .= $value;
            }
            $uri = str_replace(base_url(), "", $actual_link);
            $uri = explode("/", $uri);

            $data = $this->list_menu();
            $status = false;
            for ($i = 0; $i < count($data); $i++) {
                $value = $data[$i];
                $path = explode("/", $value->path);
                $set_status = false;

                foreach ($path as $key => $value) {
                    if (isset($uri[$key])) {
                        if ($value == $uri[$key])
                            $set_status = true;
                        else $set_status = false;
                    }
                }

                if ($set_status == true) {
                    $status = true;
                    break;
                }
            }
            if ($status == false) {
                $this->response401("You have no access here!");
                die;
            }
        }
    }



    function get_user_login()
    {
        return $this->session->userdata("reskara_login");
    }


    function isLogedIn()
    {
        $sess = $this->session->userdata();
        if (isset($sess['reskara_login'])) return true;
        else return false;
    }

    function get_menu()
    {
        $data = $this->list_menu();
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

    function find_child($data, $parent_id)
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

interface ReskaraCrud
{
    public function save();
    public function edit($id);
    public function delete($id);
    public function update($id);
    public function index();
    public function datatable();
}
