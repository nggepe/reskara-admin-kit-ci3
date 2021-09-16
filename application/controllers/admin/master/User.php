<?php
class User extends Auth_Controller implements ReskaraCrud
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("admin/master/M_user", "M_user");
    }

    function index()
    {
        $this->load->view("admin/master/user");
    }

    function datatable()
    {
        $list = $this->M_user->show_table();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $key) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $key->full_name;
            $row[] = $key->username;
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit(' . "'" . $key->id . "'" . ')"><i class="fa fa-edit"></i></a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="deleteData(' . "'" . $key->id . "'" . ')"><i class="fa fa-trash"></i></a>';

            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_user->count_all(),
            "recordsFiltered" => $this->M_user->count_filtered(),
            "data" => $data
        );
        echo json_encode($output);
    }

    function select2_privilege()
    {
        $q = $this->input->get("q");
        $page = $this->input->get("page");

        $this->db->from("privilege");
        $this->db->like("name", $q);
        $this->db->where("name<>'developer'");
        $this->db->limit(10, (10 * $page));
        $data = $this->db->get()->result();

        $this->response200(["items" => $data, "count" => count($data)]);
    }

    function save()
    {
        $data = $this->input->post();

        $username = $this->db->get_where("user", ["username" => $data['username']])->row();

        if ($username) {
            $this->response_custom(500, "username sudah ada!");
            die();
        }

        $email = $this->db->get_where("user", ["email" => $data['email']])->row();

        if ($email) {
            $this->response_custom(500, "email sudah ada!");
            die();
        }


        if ($data['password'] == $data['retypepassword']) {
            unset($data['retypepassword']);
            $data['password'] = md5($data['password']);
            $result = $this->M_user->insert($data);
            $this->response200($result);
        } else {
            $this->response_custom(500, "password tidak sama!");
        }
    }

    public function edit($id)
    {
        $this->db->select("u.*, p.name as privilege");
        $this->db->from("user u");
        $this->db->join("privilege p", "p.id = u.id_privilege");
        $this->db->where("u.id", $id);
        $data = $this->db->get()->row();
        unset($data->password);
        $this->response200($data);
    }

    public  function update($id)
    {
        $data = $this->input->post();

        $username = $this->db->get_where("user", ["username" => $data['username']])->row();

        if ($username) {
            if ($username->id != $id) {
                $this->response_custom(500, "username sudah ada!");
                die();
            }
        }

        $email = $this->db->get_where("user", ["email" => $data['email']])->row();

        if ($email) {
            if ($email->id != $id) {
                $this->response_custom(500, "email sudah ada!");
                die();
            }
        }


        if ($data['password'] == $data['retypepassword']) {
            unset($data['retypepassword']);
            $data['password'] = md5($data['password']);
            $this->M_user->update($id, $data);
            $this->response200("oke");
        } else {
            $this->response_custom(500, "password tidak sama!");
        }
    }

    public function delete($id)
    {
        $this->M_user->delete($id);
        $this->response200("oke");
    }
}
