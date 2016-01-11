<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tugas extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('tugas_model');
        $this->load->model('project_model');
        $this->load->model('worker_model');
        $this->load->helper('cookie');
        $this->load->helper('url');
    }

    public function index(){
        $data['project'] = $this->tugas_model->load_all_project();
        $data['worker'] = $this->tugas_model->load_all_worker();
        $this->load->view('tugas/tambahtugas', $data);
    }

    public function get_tugas_detail($tugas_id){
        $tugas_id = urldecode($tugas_id);
        $tugas_detail = $this->tugas_model->get_tugas_by_id($tugas_id);

        echo json_encode($tugas_detail);
    }

    public function get_all_tugas(){
        $response = array();
        $tugas_all = $this->tugas_model->get_all_tugas();
        if(!empty($tugas_all)){
            $response['status'] = 1;
            $response['tugas'] = $tugas_all;
            echo json_encode($response);
        }else{
            $response['status'] = 0;
            $response['tugas'] = "Tugas tidak ditemukan";
            echo json_encode($response);
        }
    }

    public function get_all_tugas_by_worker_id($worker_id){
        $response = array();

        $worker_id = urldecode($worker_id);
        $tanggal = date('Y-m-d');
        $tugas_all = $this->tugas_model->get_tugas_by_worker_id($worker_id);
        if(!empty($tugas_all)){
                $response['status'] = 1;
                $response['tugas'] = $tugas_all;
                echo json_encode($response);
        }else{
            $response['status'] = 0;
            $response['tugas'] = "Tugas tidak ditemukan";
            echo json_encode($response);
        }
    }

    public function get_all_tugas_by_url_project_id($project_id){
        $response = array();

        $project_id = urldecode($project_id);
        $tanggal = date('Y-m-d');
        $tugas_all = $this->tugas_model->get_tugas_by_project_id($project_id);
        if(!empty($tugas_all)){
                $response['status'] = 1;
                $response['tugas'] = $tugas_all;
                echo json_encode($response);
        }else{
            $response['status'] = 0;
            $response['tugas'] = "Tugas tidak ditemukan";
            echo json_encode($response);
        }
    }

    public function get_all_tugas_by_project_id(){
        $response = array();

        $project_id = $this->input->post('project_id');
        $tanggal = date('Y-m-d');
        $tugas_all = $this->tugas_model->get_tugas_by_project_id($project_id);
        if(!empty($tugas_all)){
                $response['status'] = 1;
                $response['tugas'] = $tugas_all;
                echo json_encode($response);
        }else{
            $response['status'] = 0;
            $response['tugas'] = "Tugas tidak ditemukan";
            echo json_encode($response);
        }
    }

    public function get_all_tugas_by_tanggal_selesai(){
        $response = array();
        $tanggal = date('Y-m-d');
        $tugas_all = $this->tugas_model->get_tugas_by_tanggal_selesai($tanggal);
        if(!empty($tugas_all)){
            $response['status'] = 1;
            $response['tugas'] = $tugas_all;
            echo json_encode($response);
        }else{
            $response['status'] = 0;
            $response['tugas'] = "Tugas tidak ditemukan";
            echo json_encode($response);
        }
    }

    public function get_all_tugas_by_creation_date(){
        $response = array();

        $tanggal = $this->input->post('tanggal');
        $tugas_all = $this->tugas_model->get_tugas_by_creation_date($tanggal);
        if(!empty($tugas_all)){
            $response['status'] = 1;
            $response['tugas'] = $tugas_all;
            echo json_encode($response);
        }else{
            $response['status'] = 0;
            $response['tugas'] = "Tugas tidak ditemukan";
            echo json_encode($response);
        }
    }

    public function set_tugas(){
        $response = array();
        if(!empty($this->input->post('deskripsi')) && !empty($this->input->post('worker')) && !empty($this->input->post('project'))){
            
            $database_input_array = array();

            $database_input_array['project_id'] = $this->input->post('project');
 
            $database_input_array['worker_id'] = $this->input->post('worker');
        
            $database_input_array['deskripsi'] = $this->input->post('deskripsi');

            $database_input_array['keterangan'] = $this->input->post('keterangan');
            
            $process = $this->tugas_model->set_tugas($database_input_array);

            if($process){
                $response['status'] = 1;
                $response['message'] = "Tugas berhasil disimpan.";
                echo json_encode($response);
            }else{
                $response['status'] = 0;
                $response['message'] = "Tugas gagal disimpan.";
                echo json_encode($response);
            }
        }else{
            $response['status'] = 0;
            $response['message'] = "Tugas gagal disimpan.";
            echo json_encode($response);
        }
    }

    public function delete_tugas($tugas_id){
        $response = array();
        $process = $this->tugas_model->delete_tugas($tugas_id);

        // display message according db status
        if($process){
            $response['status'] = 1;
            $response['message'] = "Tukang berhasil dihapus.";
            echo json_encode($response);
        }else{
            $response['status'] = 0;
            $response['message'] = "Tukang gagal dihapus.";
            echo json_encode($response);
        }
    }

    public function update_status_selesai(){
        $response = array();

        $tugas_assignment_id = $this->input->post('task_id');
        $process = $this->tugas_model->update_status_selesai($tugas_assignment_id);

        // display message according db status
        if($process){
            $response['status'] = 1;
            $response['message'] = "Tugas berhasil diselesaikan.";
            echo json_encode($response);
        }else{
            $response['status'] = 0;
            $response['message'] = "Tugas gagal diselesaikan.";
            echo json_encode($response);
        }   
    }

    public function update_tugas($worker_id){
        $data['tugas'] = $this->tugas_model->get_tugas_by_worker_id($worker_id);
        $this->load->view('tugas/update_tugas', $data);
    }
}

/* End of file tugas.php */
/* Location: ./application/controllers/tugas.php */