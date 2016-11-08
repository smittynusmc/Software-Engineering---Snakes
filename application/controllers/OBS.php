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
        $data['obs_ID'] = '';
        $data['program_ID'] = '';
        $data['product_ID'] = '';
        $data['wbs_ID'] = '';
        if (isset($id)) {
            $record = $this->OBSModel->get($id);
            if ($record != FALSE) {
                $data['obs_ID'] = $record[0]->obs_ID;
                $data['program_ID'] = $record[0]->program_ID;
                $data['product_ID'] = $record[0]->product_ID;
                $data['wbs_ID'] = $record[0]->wbs_ID;
            }
        }
       
        $this->load->view('obs/view',$data);
    }
    
    public function search() {
        $this->form_validation->set_rules('obs_ID', 'obs_ID', 'trim');
        $this->form_validation->set_rules('program_ID', 'program_ID', 'trim');
        $this->form_validation->set_rules('product_ID', 'product_ID', 'trim');
        $this->form_validation->set_rules('wbs_ID', 'wbs_ID', 'trim');
        $data['obs_ID'] = $this->input->post('obs_ID');
        $data['program_ID'] = $this->input->post('program_ID');
        $data['product_ID'] = $this->input->post('product_ID');
        $data['wbs_ID'] = $this->input->post('wbs_ID');

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
            $data['obs_ID'] = '';
            $data['program_ID'] = '';
            $data['product_ID'] = '';
            $data['wbs_ID'] = '';
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
