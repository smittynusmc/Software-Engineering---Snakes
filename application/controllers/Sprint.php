<?php

Class Sprint extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
// Load form helper library
        $this->load->helper('form');

// Load form validation library
        $this->load->library('form_validation');
// Load encrytion library
        $this->load->library('encryption');
// Load session library
        $this->load->library('session');
// Load database
        $this->load->model('SprintModel');
// Load file helper library        
        $this->load->helper('file');
    }

    public function index($id = null) {
        $data['sprint_id'] = '';
		$data['sprint_name'] = '';
        if (isset($id)) {
            $record = $this->SprintModel->get($id);
           if ($record != FALSE) {
               $data['sprint_id'] = $record[0]->sprint_id;
			   $data['sprint_name'] = $record[0]->sprint_name;
            }
        }

        $this->load->view('sprint/view', $data);
    }
    
    public function search() {
        $this->form_validation->set_rules('sprint_id', 'Sprint ID', 'trim');
        $this->form_validation->set_rules('sprint_name', 'Sprint Name', 'trim');
        $data['sprint_id'] = $this->input->post('sprint_id');
        $data['sprint_name'] = $this->input->post('sprint_name');
        if ($this->form_validation->run() == FALSE) {
            $this->get_search($data);
        } else {
            $result = $this->SprintModel->search($data);
            if ($result == FALSE) {
                $data['status'] = 'failed';
                $data['result'] = "0 sprint found.";
                $this->load->view('sprint/search', $data);
            } else {
                $data['status'] = 'success';
                $data['result'] = $result;
                $this->load->view('sprint/search', $data);
            }
        }
    }
    
    public function get_search($data = null) {
        if (!isset($data)) {
            $data['sprint_id'] = '';
            $data['sprint_name'] = '';
        }

        $this->load->view('sprint/search', $data);
    }
    
    public function insert() {
        $this->form_validation->set_rules('sprint_name', 'Sprint Name', 'trim|required');
        $data['sprint_name'] = $this->input->post('sprint_name');
        if ($this->form_validation->run() == FALSE) {
            $this->get_insert($data);
        } else {
            $result = $this->SprintModel->insert($data);
            if ($result == FALSE) {
                $data['status'] = 'failed';
                $data['result'] = "Insert failed.";
                $this->load->view('sprint/insert', $data);
            } else {
                $data['status'] = 'success';
                $data['result'] = "Insert success.";
				$data['sprint_id'] = $result;
                $this->load->view('sprint/insert', $data);
            }
        }
    }

    public function get_insert($data = null) {
        if (!isset($data)) {
			$data['sprint_id'] = '';
            $data['sprint_name'] = '';
        }
        $this->load->view('sprint/insert', $data);
    }
    
    public function edit($data = null) {
        $this->form_validation->set_rules('sprint_id', 'Sprint ID', 'trim|required');
        $this->form_validation->set_rules('sprint_name', 'Sprint Name', 'trim|required');
        $data['sprint_id'] = $this->input->post('sprint_id');
        $data['sprint_name'] = $this->input->post('sprint_name');
        if ($this->form_validation->run() == FALSE) {
            $this->get_insert($data);
        } else {
            $result = $this->SprintModel->update($data);
            if ($result == FALSE) {
                $data['status'] = 'failed';
                $data['result'] = "Edit failed.";
                $this->load->view('sprint/edit', $data);
            } else {
                $data['status'] = 'success';
                $data['result'] = "Edit success.";
				
                $this->load->view('sprint/edit', $data);
            }
        }
    }

    public function get_edit($id = null) {
        if (isset($id)) {
            $record = $this->SprintModel->get($id);
            if ($record != FALSE) {
                $data['sprint_id'] = $record[0]->sprint_id;
                $data['sprint_name'] = $record[0]->sprint_name;
            }
        }
        $this->load->view('sprint/edit', $data);
    }

    public function view($id) {
        if (!isset($data)) {
            $data['sprint_id'] = '';
            $data['sprint_name'] = '';
        }
    }
    
    public function get_upload() {
        $this->load->view('sprint/upload');
    }

    public function upload() {
        
       
        $config['upload_path'] = 'uploads';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = 3000;

        $this->load->library('upload', $config);
        $has_header = $this->input->post('has_header');
        if (!$this->upload->do_upload('csv')) {
            $data['status'] = 'fail';
            $data['result'] = $this->upload->display_errors();
            $this->load->view('sprint/upload',$data);
        } else {
            $upload_info = $this->upload->data();
            $csvdata = array_map('str_getcsv', file($upload_info['full_path'])); 
            if($has_header == 1){
                array_shift($csvdata);
            }
            $data['status'] = 'success';
            $data['has_header'] = $has_header;
            $result = $this->SprintModel->import($csvdata);
            $data['result'] = "{$result['success']} rows inserted, {$result['error']} errors";
            $this->load->view('sprint/upload', $data);
        }
        
    }
}
