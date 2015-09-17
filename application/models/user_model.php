<?php
class User_model extends CI_Model {
    public function __construct()
    {
        $this->load->database();
    }

    public function get_user_by_name($name){
        $query = $this->db->query("Select user.id as iduser, worker.id as idworker, worker.nama as nama, user.status as status
                                    from user, worker
                                    where user.worker_id = worker.id AND user.username ='$name'");
        return $query->row_array();
    }
}