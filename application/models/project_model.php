<?php
class Project_model extends CI_Model {
    public function __construct()
    {
        $this->load->database();
    }

    public function get_project_by_id($id){
        $query = $this->db->get_where('project', array('id' => $id));
        return $query->row_array();
    }

    public function get_all_project()
    {
        $this->db->select('project.*');
        $this->db->from('project');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_project_by_name($name){
        $query = $this->db->get_where('project', array('nama_project' => $name));
        return $query->row_array();
    }

    public function set_project($nama_project){
        if($nama_project !== false){
            date_default_timezone_set('Asia/Jakarta');

            $data = array(
                'nama_project' => $nama_project,
                'creation_date' => date("Y-m-d H:i:s")
            );
            return $this->db->insert('project', $data);
        }else{
            return false;
        }
    }
}