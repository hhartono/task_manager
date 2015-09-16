<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Worker extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('worker_model');
        $this->load->helper('cookie');
        $this->load->helper('url');
    }

    public function index(){
        $this->load->view('worker/tambahworker');
    }

    public function get_worker_detail($worker_id){
        date_default_timezone_set('Asia/Jakarta');

        $worker_id = urldecode($worker_id);
        $worker_detail = $this->worker_model->get_worker_by_id($worker_id);
        $worker_detail['formatted_join_date'] = date("d-m-Y", strtotime($worker_detail['join_date']));
        echo json_encode($worker_detail);
    }

    public function get_all_worker(){
        $response = array();
        
        $worker_all = $this->worker_model->get_all_workers();
        if(!empty($worker_all)){
            $response['status'] = 1;
            $response['worker'] = $worker_all;
            echo json_encode($response);
        }else{
            $response['status'] = 0;
            $response['worker'] = "Tugas tidak ditemukan";
            echo json_encode($response);
        }
    }

    public function set_worker(){
        $response = array();
        if(!empty($this->input->post('nama')) && !empty($this->input->post('password'))){
            $nama = $this->input->post('nama');
            $pass = $this->input->post('password');

            $process = $this->worker_model->set_worker($nama, $pass);

            if($process){
                $response['status'] = 1;
                $response['message'] = "Worker berhasil disimpan.";
                $response['worker'] = $process;
                echo json_encode($response);
            }else{
                $response['status'] = 0;
                $response['message'] = "Worker gagal disimpan.";
                echo json_encode($response);
            }
        }else{
            $response['status'] = 0;
            $response['message'] = "Worker gagal disimpan.";
            echo json_encode($response);
        }
    }
}

/* End of file worker.php */
/* Location: ./application/controllers/worker.php */