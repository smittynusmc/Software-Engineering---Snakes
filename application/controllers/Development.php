<?php

Class Development extends CI_Controller {
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
        $this->load->model('DevelopmentModel');
// Load file helper library        
        $this->load->helper('file');
    }
    
    public function index($id=null) {
        $data['Project_ID'] = '';
        $data['Project_Name'] = '';
        $data['Product_Code'] = '';
        $data['Product_Name'] = '';
        $data['WBS_ID'] = '';
        $data['WBS_Name'] = '';
        $data['Date'] = '';
        $data['SLOC'] = '';
        $data['Hours'] = '';
        if (isset($id)) {
            $record = $this->DevelopmentModel->get($id);
            if ($record != FALSE) {
                $data['Project_ID'] = $record[0]->Project_ID;
                $data['Project_Name'] = $record[0]->Project_Name;
                $data['Product_Code'] = $record[0]->Product_Code;
                $data['Product_Name'] = $record[0]->Product_Name;
                $data['WBS_ID'] = $record[0]->WBS_ID;
                $data['WBS_Name'] = $record[0]->WBS_Name;
                $data['Date'] = $record[0]->Date;
                $data['SLOC'] = $record[0]->SLOC;
                $data['Hours'] = $record[0]->Hours;
            }
        }
       
        $this->load->view('development/view',$data);
    }
    
    public function search() {
        $this->form_validation->set_rules('Project_ID', 'Project ID', 'trim');
        $this->form_validation->set_rules('Project_Name', 'Project Name', 'trim');
        $this->form_validation->set_rules('Product_Code', 'Product ID', 'trim');
        $this->form_validation->set_rules('Product_Name', 'Product Name', 'trim');
        $this->form_validation->set_rules('WBS_ID', 'WBS ID', 'trim');
        $this->form_validation->set_rules('WBS_Name', 'WBS Name', 'trim');
        $data['Project_ID'] = $this->input->post('Project_ID');
        $data['Project_Name'] = $this->input->post('Project_Name');
        $data['Product_Code'] = $this->input->post('Product_Code');
        $data['Product_Name'] = $this->input->post('Product_Name');
        $data['WBS_ID'] = $this->input->post('WBS_ID');
        $data['WBS_Name'] = $this->input->post('WBS_Name');
        if ($this->form_validation->run() == FALSE) {
            $this->get_search($data);
        } else {
            $result = $this->DevelopmentModel->search($data);
            if ($result == FALSE) {
                $data['status'] = 'failed';
                $data['result'] = "0 project found.";
                $this->load->view('development/search', $data);
            } else {
                $data['status'] = 'success';
                $data['result'] = $result;
                $this->load->view('development/search', $data);
            }
        }
    }

    public function get_search($data = null) {
        if (!isset($data)) {
            $data['Project_ID'] = '';
            $data['Project_Name'] = '';
            $data['Product_Code'] = '';
            $data['Product_Name'] = '';
            $data['WBS_ID'] = '';
            $data['WBS_Name'] = '';
        }

        $this->load->view('development/search', $data);
    }
    
    public function get_upload() {
        $this->load->view('development/upload');
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
            $this->load->view('development/upload',$data);
        } else {
            $upload_info = $this->upload->data();
            $csvdata = array_map('str_getcsv', file($upload_info['full_path'])); 
            if($has_header == 1){
                array_shift($csvdata);
            }
            $data['status'] = 'success';
            $data['has_header'] = $has_header;
            $result = $this->DevelopmentModel->import($csvdata);
            $data['result'] = "{$result['success']} rows inserted, {$result['error']} errors";
            $this->load->view('development/upload', $data);
        }
        
    }
    public function get_insert($data = null) {
        
        $this->load->view('development/insert', $data);
    }
    
    public function get_edit($id = null) {
        
        $this->load->view('development/edit', $data);
    }
}
