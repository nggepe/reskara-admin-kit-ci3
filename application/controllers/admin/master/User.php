<?php
class User extends Auth_Controller
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
}
