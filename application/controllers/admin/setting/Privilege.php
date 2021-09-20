<?php
class Privilege extends Auth_Controller implements ReskaraCrud
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("admin/setting/M_privilege", "M_privilege");
    }

    function index()
    {
        $this->load->view("admin/setting/privilege");
    }

    function datatable()
    {
        $list = $this->M_privilege->show_table();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $key) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $key->name;
            $row[] = '<a class="btn btn-sm btn-info text-white" href="javascript:void(0)" onclick="access_setting(' . $key->id . ')"><i class="fa fa-file-signature"></i></a> ' . '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit(' . "'" . $key->id . "'" . ')"><i class="fa fa-edit"></i></a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="deleteData(' . "'" . $key->id . "'" . ')"><i class="fa fa-trash"></i></a>';

            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_privilege->count_all(),
            "recordsFiltered" => $this->M_privilege->count_filtered(),
            "data" => $data
        );
        echo json_encode($output);
    }

    function save()
    {
        $data = $this->input->post();
        $this->M_privilege->insert($data);
        $this->response200("success");
    }

    function delete($id)
    {
        $this->M_privilege->delete($id);
        $this->response200("success");
    }

    function edit($id)
    {
        $data = $this->M_privilege->get_by_id($id);
        $this->response200($data);
    }

    function update($id)
    {
        $data = $this->input->post();
        $this->M_privilege->update($id, $data);
        $this->response200("success");
    }

    function get_access_setting($id)
    {
        $data = $this->M_privilege->get_menu($id);
        $menu = [];
        if ($data) :
            foreach ($data as $key => $value) {

                if ($value->parent == null) :
                    $child = $this->find_child($data, $value->id);
                    $value->child = $child;
                    $menu[] = $value;
                endif;
            }
        endif;
        $this->response200($menu);
    }

    function set_access_setting()
    {
        $data = $this->input->post();
        $result = $this->M_privilege->set_access_setting($data['id_menu'], $data['id_privilege'], $data['status']);
        $this->response200($result);
    }
}
