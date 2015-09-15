<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('project_model');
        $this->load->helper('cookie');
        $this->load->helper('url');
    }

    public function index(){
        $this->load->view('project/tambahproject');
    }

    public function get_project_detail($project_id){
        $project_id = urldecode($project_id);
        $project_detail = $this->project_model->get_project_by_id($project_id);
        echo json_encode($project_detail);
    }

    public function get_all_project(){
        $response = array();

        $project_all = $this->project_model->get_all_project();
        if(!empty($project_all)){
            $response['status'] = 1;
            $response['project'] = $project_all;
            echo json_encode($response);
        }else{
            $response['status'] = 0;
            $response['project'] = "Project tidak ditemukan";
            echo json_encode($response);
        }
    }    

    public function set_project(){
        $response = array();
        if(!empty($this->input->post('nama_project'))){
            $nama_project = $this->input->post('nama_project');

            $process = $this->project_model->set_project($nama_project);

            if($process){
                $response['status'] = 1;
                $response['message'] = "Project berhasil disimpan.";
                echo json_encode($response);
            }else{
                $response['status'] = 0;
                $response['message'] = "Project gagal disimpan.";
                echo json_encode($response);
            }
        }else{
            $response['status'] = 0;
            $response['message'] = "Project gagal disimpan.";
            echo json_encode($response);
        }
    }
}

/* End of file project.php */
/* Location: ./application/controllers/project.php */