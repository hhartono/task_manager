<?php
class User_model extends CI_Model {
    public function __construct()
    {
        $this->load->database();
    }

    public function get_user_by_name($name, $pass){
        $query = $this->db->query("Select user.id as iduser, user.status as status
                                    from user
                                    where user.username ='$name' AND  user.password ='$pass'");
        return $query->row_array();
    }
}