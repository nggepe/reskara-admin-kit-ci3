<?php

/**the easiest way to create a spesific class with the same method is using interface class,
 * if you want to create some crud, just use it
 */
interface CoreModel
{
  /** for insert data */
  function insert($data);
  /** for update data */
  function update($id, $data);
  /** for delete data */
  function delete($id);
  /** for get data by id */
  function get_by_id($id);
}

/** 
 * 
 * auto generate CRUD function
 * 
 * you have to set the table and your table id to make it work! good luck!
 * 
 * `insert($data)` for insert
 * 
 * `update($id, $data)` for update
 * 
 * `delete($id)` for delete
 * 
 * `get_by_id($id)` to get single data
 * 
 * 
 */
class MY_Model extends CI_Model implements CoreModel
{
  var $table = "";
  var $name_id = "id";

  function __construct($table, $name_id)
  {
    $this->table = $table;
    $this->name_id = $name_id;
  }

  function insert($data)
  {
    $this->db->insert($this->table, $data);
  }

  function update($id, $data)
  {
    $this->db->where($this->name_id, $id);
    $this->db->update($this->table, $data);
  }
  function delete($id)
  {
    $this->db->where($this->name_id, $id);
    $this->db->delete($this->table);
  }
  function get_by_id($id)
  {
    return $this->db->get_where($this->table, [$this->name_id => $id])->row();
  }
}
