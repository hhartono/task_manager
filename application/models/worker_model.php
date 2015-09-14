<?php
class Worker_model extends CI_Model {
    public function __construct()
    {
        $this->load->database();
    }

    public function get_worker_by_id($id){
        $query = $this->db->get_where('worker', array('id' => $id));
        return $query->row_array();
    }

    public function get_all_workers()
    {
        $this->db->select('worker.*');
        $this->db->from('worker');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_worker_by_name($name){
        $query = $this->db->get_where('worker', array('nama' => $name));
        return $query->row_array();
    }

    public function set_worker(){
        $nama = $this->input->post('nama');
        if($nama !== false){
            date_default_timezone_set('Asia/Jakarta');

            $data = array(
                'nama' => $nama,
                'creation_date' => date("Y-m-d H:i:s")
            );
            return $this->db->insert('worker', $data);
        }else{
            return false;
        }
    }
}