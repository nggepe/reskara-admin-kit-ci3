<?php

class M_privilege extends MY_Model
{
    function __construct()
    {
        parent::__construct("privilege", "id");
    }

    var $table = 'user';
    var $column = array(
        'id',
        'name',
    ); //set column field database for order and search
    var $order = array('id' => 'desc');



    private function _get_datatables_query()
    {
        $this->db->from($this->table);
        $i = 0;

        foreach ($this->column as $item) // loop column 
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. 
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $column[$i] = $item; // set column array variable to order processing
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;

            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();

        return $query->num_rows();
    }
    public function count_all()
    {
        $this->db->from($this->table);

        return $this->db->count_all_results();
    }

    public function show_table()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }


    public function get_menu($id_privilege)
    {
        $this->db->select("m.*, IF(p.id=$id_privilege, 'true', 'false') as status, IFNULL(pm.id, NULL) as privilege_id");
        $this->db->from("menu m");
        $this->db->join("privilege_menu pm", "pm.id_menu = m.id", "left");
        $this->db->join("privilege p", "p.id = pm.id_privilege", "left");
        // $this->db->group_by("m.id");
        $this->db->order_by("m.sequence", "asc");
        $this->db->order_by("status", "desc");
        $data = $this->db->get()->result();
        $data = $this->remove_twin_menu($data, $id_privilege);
        return $data;
    }

    private function remove_twin_menu($data, $id_privilege): array
    {
        $result = [];
        foreach ($data as $key => $value) {
            if ($key > 0) {
                if ($value->id != $data[$key - 1]->id) {
                    $result[] = $value;
                }
            } else $result[] = $value;
        }
        return $result;
    }

    public function set_access_setting($id_menu, $id_privilege, $status): mixed
    {
        if ($status == "true") {
            $this->db->insert("privilege_menu", ["id_menu" => $id_menu, "id_privilege" => $id_privilege]);
            $this->set_to_parents($id_menu, $id_privilege);
            return $this->db->insert_id();
        } else {
            $this->db->where("id_menu", $id_menu);
            $this->db->where("id_privilege", $id_privilege);
            $this->db->delete("privilege_menu");
            return "oke";
        }
    }

    private function set_to_parents($id_menu, $id_privilege)
    {
        $menu = $this->db->get_where("menu", ['id' => $id_menu])->row();
        if ($menu->parent != null) :
            $this->db->insert("privilege_menu", ["id_menu" => $menu->parent, "id_privilege" => $id_privilege]);
            $this->set_to_parents($menu->parent, $id_privilege);
        endif;
    }
}
