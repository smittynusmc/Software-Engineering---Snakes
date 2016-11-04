<?php

Class WBS extends CI_Controller {

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
        $this->load->model('WBSModel');
    }

    public function index($id = null) {
        $data['WBS_ID'] = '';
        $data['WBS_Name'] = '';
        if(isset($id)){
            $result = $this->WBSModel->get($id);
            if($result == FALSE){
                $data['WBS_ID'] = "$id";
                $data['WBS_Name'] = '';
            }
            else{
                $data['WBS_ID'] = $result[0]->WBS_ID;
                $data['WBS_Name'] = $result[0]->WBS_Name;
                
            }
        }
        $data['id'] = $id;
        $this->load->view('wbs/view', $data);
    }

    public function get_search($data = null) {
        if (!isset($data)) {
            $data['WBS_ID'] = '';
            $data['WBS_Name'] = '';
        }
        $this->load->view('wbs/search', $data);
    }

    public function search() {
        $this->form_validation->set_rules('WBS_ID', 'WBS ID', 'trim');
        $this->form_validation->set_rules('WBS_Name', 'WBS Name', 'trim');
        $data['WBS_ID'] = $this->input->post('WBS_ID');
        $data['WBS_Name'] = $this->input->post('WBS_Name');
        if ($this->form_validation->run() == FALSE) {
            $this->get_search($data);
        } else {
            $result = $this->WBSModel->search($data);
            if ($result == FALSE) {
                $data['status'] = 'failed';
                $data['result'] = "0 wbs found.";
                $this->load->view('wbs/search', $data);
            } else {
                $data['status'] = 'success';
                $data['result'] = $result;
                $this->load->view('wbs/search', $data);
            }
        }
    }
    
    public function get_upload() {
        $this->load->view('wbs/upload');
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
            $this->load->view('wbs/upload',$data);
        } else {
            $upload_info = $this->upload->data();
            $csvdata = array_map('str_getcsv', file($upload_info['full_path'])); 
            if($has_header == 1){
                array_shift($csvdata);
            }
            $data['status'] = 'success';
            $data['has_header'] = $has_header;
            $result = $this->WBSModel->import($csvdata);
            $data['result'] = "{$result['success']} rows inserted, {$result['error']} errors";
            $this->load->view('wbs/upload', $data);
        }
        
    }

}
