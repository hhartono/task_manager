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

    public function set_worker($nama, $pass){
        //$nama = $this->input->post('nama');
        if($nama !== false){

            $this->db->trans_start();

            date_default_timezone_set('Asia/Jakarta');

            $data = array(
                'nama' => $nama,
                'creation_date' => date("Y-m-d H:i:s")
            );
            $this->db->insert('worker', $data);

            $data = array(
                'id' => $this->db->insert_id(),
                'username' => $nama,
                'password' => $pass,
                'worker_id' => $this->db->insert_id(),
                'status' => 'worker'
            );
            $this->db->insert('user', $data);

            // complete database transaction
            $this->db->trans_complete();

            // return false if something went wrong
            if ($this->db->trans_status() === FALSE){
                return FALSE;
            }else{
                return $data;
            }

        }else{
            return false;
        }
    }
}