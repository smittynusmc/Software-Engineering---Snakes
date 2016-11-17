<?php

Class Capability extends CI_Controller {

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
        $this->load->model('CapabilityModel');
// Load file helper library        
        $this->load->helper('file');
    }

    public function index($id = null) {
        $data['capability_id'] = '';
        $data['capability_name'] = '';
        if (isset($id)) {
            $record = $this->CapabilityModel->get($id);
            if ($record != FALSE) {
                $data['capability_id'] = $record[0]->capability_id;
                $data['capability_name'] = $record[0]->capability_name;
            }
        }

        $this->load->view('capability/view', $data);
    }
    
    public function search() {
        $this->form_validation->set_rules('capability_id', 'Capability ID', 'trim');
        $this->form_validation->set_rules('capability_name', 'Capability Name', 'trim');
        $data['capability_id'] = $this->input->post('capability_id');
        $data['capability_name'] = $this->input->post('capability_name');
        if ($this->form_validation->run() == FALSE) {
            $this->get_search($data);
        } else {
            $result = $this->CapabilityModel->search($data);
            if ($result == FALSE) {
                $data['status'] = 'failed';
                $data['result'] = "0 capability found.";
                $this->load->view('capability/search', $data);
            } else {
                $data['status'] = 'success';
                $data['result'] = $result;
                $this->load->view('capability/search', $data);
            }
        }
    }
    
    public function get_search($data = null) {
        if (!isset($data)) {
            $data['capability_id'] = '';
            $data['capability_name'] = '';
        }

        $this->load->view('capability/search', $data);
    }
    
    public function insert() {
        $this->form_validation->set_rules('capability_name', 'Capability Name', 'trim|required');
        $data['capability_name'] = $this->input->post('capability_name');
        if ($this->form_validation->run() == FALSE) {
            $this->get_insert($data);
        } else {
            $result = $this->CapabilityModel->insert($data);
            if ($result == FALSE) {
                $data['status'] = 'failed';
                $data['result'] = "Insert failed.";
				$data['capability_id'] = '';
                $this->load->view('capability/insert', $data);
            } else {
                $data['status'] = 'success';
                $data['result'] = "Insert success.";
				$data['capability_id'] = $result;
                $this->load->view('capability/insert', $data);
            }
        }
    }

    public function get_insert($data = null) {
        if (!isset($data)) {
            $data['capability_id'] = '';
            $data['capability_name'] = '';
        }
        $this->load->view('capability/insert', $data);
    }
    
    public function edit($data = null) {
        $this->form_validation->set_rules('capability_id', 'Capability ID', 'trim|required');
        $this->form_validation->set_rules('capability_name', 'Capability Name', 'trim|required');
        $data['capability_id'] = $this->input->post('capability_id');
        $data['capability_name'] = $this->input->post('capability_name');
        if ($this->form_validation->run() == FALSE) {
            $this->get_edit($data['capability_id']);
        } else {
            $result = $this->CapabilityModel->update($data);
            if ($result == FALSE) {
                $data['status'] = 'failed';
                $data['result'] = "Edit failed.";
                $this->load->view('capability/edit', $data);
            } else {
                $data['status'] = 'success';
                $data['result'] = "Edit success.";
                $this->load->view('capability/edit', $data);
            }
        }
    }

    public function get_edit($id = null) {
        if (isset($id)) {
            $record = $this->CapabilityModel->get($id);
            if ($record != false) {
                $data['capability_id'] = $record[0]->capability_id;
                $data['capability_name'] = $record[0]->capability_name;
            }
        }
        $this->load->view('capability/edit', $data);
    }

    
    public function get_upload() {
        $this->load->view('capability/upload');
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
            $this->load->view('capability/upload',$data);
        } else {
            $upload_info = $this->upload->data();
            $csvdata = array_map('str_getcsv', file($upload_info['full_path'])); 
            if($has_header == 1){
                array_shift($csvdata);
            }
            $data['status'] = 'success';
            $data['has_header'] = $has_header;
            $result = $this->CapabilityModel->import($csvdata);
            $data['result'] = "{$result['success']} rows inserted, {$result['error']} errors";
            $this->load->view('capability/upload', $data);
        }
        
    }
}
