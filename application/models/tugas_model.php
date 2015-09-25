<?php
class Tugas_model extends CI_Model {
    public function __construct()
    {
        $this->load->database();
    }

    public function get_tugas_by_id($id){
        $query = $this->db->get_where('tugas', array('id' => $id));
        return $query->row_array();
    }

    public function get_tugas_by_worker_id($worker_id){
        $tanggal = date('Y-m-d');
        $query = $this->db->query("(select tugas_assignment.id as task_id, worker.nama as worker, project.nama_project as project, tugas.deskripsi as deskripsi, tugas.keterangan as keterangan, tugas_assignment.tanggal_selesai as tanggal_selesai, tugas_assignment.creation_date as creation_date, tugas_assignment.last_update_timestamp as last_update_timestamp
                                        from project, tugas, tugas_assignment, worker
                                        where tugas.project_id = project.id AND tugas.id = tugas_assignment.tugas_id AND worker.id = tugas_assignment.worker_id AND worker.id = '$worker_id' AND tugas_assignment.tanggal_selesai = '0000-00-00'
                                        order by tugas_assignment.tanggal_selesai DESC) 
                                        UNION (select tugas_assignment.id as task_id, worker.nama as worker, project.nama_project as project, tugas.deskripsi as deskripsi, tugas.keterangan as keterangan, tugas_assignment.tanggal_selesai as tanggal_selesai, tugas_assignment.creation_date as creation_date, tugas_assignment.last_update_timestamp as last_update_timestamp
                                        from project, tugas, tugas_assignment, worker
                                        where tugas.project_id = project.id AND tugas.id = tugas_assignment.tugas_id AND worker.id = tugas_assignment.worker_id AND worker.id = '$worker_id' AND tugas_assignment.tanggal_selesai = '$tanggal'
                                        order by tugas_assignment.tanggal_selesai DESC)");
        return $query->result_array();
    }

    public function get_tugas_by_tanggal_selesai($tanggal){
        $query = $this->db->query("select tugas_assignment.id as task_id, worker.nama as worker, project.nama_project as project, tugas.deskripsi as deskripsi, tugas_assignment.tanggal_selesai as tanggal_selesai
                                        from project, tugas, tugas_assignment, worker
                                        where tugas.project_id = project.id AND tugas.id = tugas_assignment.tugas_id AND worker.id = tugas_assignment.worker_id AND tugas_assignment.tanggal_selesai = '$tanggal'");
        return $query->result_array();
    }

    public function get_tugas_by_creation_date($tanggal){
        $query = $this->db->query("select worker.nama as worker, project.nama_project as project, tugas.deskripsi as deskripsi, tugas_assignment.tanggal_selesai as tanggal_selesai
                                        from project, tugas, tugas_assignment, worker
                                        where tugas.project_id = project.id AND tugas.id = tugas_assignment.tugas_id AND worker.id = tugas_assignment.worker_id AND tugas.creation_date = '$tanggal'");
        return $query->result_array();
    }

    public function get_all_tugas()
    {
        $this->db->select('tugas.*, project.nama_project as nama_project');
        $this->db->from('tugas, project');
        $this->db->where('tugas.project_id = project.id');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function set_tugas($database_input_array){
        if($database_input_array['deskripsi'] !== false && $database_input_array['worker_id'] !== false && $database_input_array['project_id'] !== false){
            date_default_timezone_set('Asia/Jakarta');

            $this->db->trans_start();

            $data = array(
                'deskripsi' => $database_input_array['deskripsi'],
                'project_id' => $database_input_array['project_id'],
                'keterangan' => $database_input_array['keterangan'],
                'creation_date' => date("Y-m-d H:i:s")
            );
            $this->db->insert('tugas', $data);

            $database_input_array['tugas_id'] = $this->db->insert_id();

            foreach ($database_input_array['worker_id'] as $worker) {
                $data = array(
                    'tugas_id' => $database_input_array['tugas_id'],
                    'worker_id' => $worker,
                    'creation_date' => date("Y-m-d H:i:s")
                );
                $this->db->insert('tugas_assignment', $data);
            }

            // complete database transaction
            $this->db->trans_complete();

            // return false if something went wrong
            if ($this->db->trans_status() === FALSE){
                return FALSE;
            }else{
                return TRUE;
            }
        }else{
            return false;
        }
    }

    public function delete_tugas($tugas_id){
        $response = $this->db->delete('tugas', array('id' => $tugas_id));
        $affected_row = $this->db->affected_rows();

        $delete_status = false;
        if($response === true && $affected_row > 0){
            $delete_status = true;
        }

        return $delete_status;
    }

    public function update_status_selesai($tugas_assignment_id){
        if($tugas_assignment_id){
            date_default_timezone_set('Asia/Jakarta');
            $data = array(
                'tanggal_selesai' => date("Y-m-d H:i:s")
            );

            $this->db->where('id', $tugas_assignment_id);
            return $this->db->update('tugas_assignment', $data);
        }else{
            return false;
        }
    }

    public function load_all_project()
    {
        $query = $this->db->query("
                SELECT *
                FROM project
                ORDER BY id ASC
            ");
        if($query->num_rows() > 0){
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }

    public function load_all_worker()
    {
        $query = $this->db->query("
                SELECT *
                FROM worker
                ORDER BY id ASC
            ");
        if($query->num_rows() > 0){
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }
}