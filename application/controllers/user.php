<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->helper('cookie');
        $this->load->helper('url');
    }

    public function index(){
    	$this->load->view('user/login');
    }

    public function user_in(){

    	$response = array();
    	$name = $this->input->post('name');
    	$pass = $this->input->post('password');
        // check all necessary input
        if(!empty($name)){
            // search for user id
            $database_input_array = array();
            $user_detail = $this->user_model->get_user_by_name($name, $pass);
            
            if($user_detail){
                $response['status'] = 1;
                $response['user'] = $user_detail;
                $response['nama'] = $name;
                $response['password'] = $pass;
                echo json_encode($response);
            }else{
                $response['status'] = 0;
                $response['message'] = "Username dan Password tidak ada dalam system.";
                echo json_encode($response);
            }
        }else{
            $response['status'] = 0;
            $response['message'] = "Username dan Password tidak ada dalam system.";
            echo json_encode($response);
        }
    }

}

?>