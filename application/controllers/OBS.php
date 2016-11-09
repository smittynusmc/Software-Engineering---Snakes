<?php

Class OBS extends CI_Controller {
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
        $this->load->model('OBSModel');
// Load file helper library        
        $this->load->helper('file');
    }
    
    public function index($id=null) {
        $data['obs_id'] = '';
        $data['program_id'] = '';
        $data['product_id'] = '';
        $data['wbs_id'] = '';
        if (isset($id)) {
            $record = $this->OBSModel->get($id);
            if ($record != FALSE) {
                $data['obs_id'] = $record[0]->obs_id;
                $data['program_id'] = $record[0]->program_id;
                $data['product_id'] = $record[0]->product_id;
                $data['wbs_id'] = $record[0]->wbs_id;
            }
        }
       
        $this->load->view('obs/view',$data);
    }
    
    public function search() {
        $this->form_validation->set_rules('obs_id', 'obs_id', 'trim');
        $this->form_validation->set_rules('program_id', 'program_id', 'trim');
        $this->form_validation->set_rules('product_id', 'product_id', 'trim');
        $this->form_validation->set_rules('wbs_id', 'wbs_id', 'trim');
        $data['obs_id'] = $this->input->post('obs_id');
        $data['program_id'] = $this->input->post('program_id');
        $data['product_id'] = $this->input->post('product_id');
        $data['wbs_id'] = $this->input->post('wbs_id');

        if ($this->form_validation->run() == FALSE) {
            $this->get_search($data);
        } else {
            $result = $this->OBSModel->search($data);
            if ($result == FALSE) {
                $data['status'] = 'failed';
                $data['result'] = "0 project found.";
                $this->load->view('obs/search', $data);
            } else {
                $data['status'] = 'success';
                $data['result'] = $result;
                $this->load->view('obs/search', $data);
            }
        }
    }

    public function get_search($data = null) {
        if (!isset($data)) {
            $data['obs_id'] = '';
            $data['program_id'] = '';
            $data['product_id'] = '';
            $data['wbs_id'] = '';
        }

        $this->load->view('obs/search', $data);
    }
    
    public function get_upload() {
        $this->load->view('obs/upload');
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
            $this->load->view('obs/upload',$data);
        } else {
            $upload_info = $this->upload->data();
            $csvdata = array_map('str_getcsv', file($upload_info['full_path'])); 
            if($has_header == 1){
                array_shift($csvdata);
            }
            $data['status'] = 'success';
            $data['has_header'] = $has_header;
            $result = $this->OBSModel->import($csvdata);
            $data['result'] = "{$result['success']} rows inserted, {$result['error']} errors";
            $this->load->view('obs/upload', $data);
        }
        
    }
    public function get_insert($data = null) {
        
        $this->load->view('obs/insert', $data);
    }
    
    public function get_edit($id = null) {
        
        $this->load->view('obs/edit', $data);
    }
}
