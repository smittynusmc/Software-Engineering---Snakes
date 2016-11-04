<?php

Class Product extends CI_Controller {

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
        $this->load->model('ProductModel');
// Load file helper library        
        $this->load->helper('file');
    }

    public function index($id = null) {
        $data['Product_Code'] = '';
        $data['Product_Name'] = '';
        if (isset($id)) {
            $record = $this->ProductModel->get($id);
            if ($record != FALSE) {
                $data['Product_Code'] = $record[0]->Product_Code;
                $data['Product_Name'] = $record[0]->Product_Name;
            }
        }

        $this->load->view('product/view', $data);
    }
    
    public function search() {
        $this->form_validation->set_rules('Product_Code', 'Product Code', 'trim');
        $this->form_validation->set_rules('Product', 'Product Name', 'trim');
        $data['Product_Code'] = $this->input->post('Product_Code');
        $data['Product_Name'] = $this->input->post('Product_Name');
        if ($this->form_validation->run() == FALSE) {
            $this->get_search($data);
        } else {
            $result = $this->ProductModel->search($data);
            if ($result == FALSE) {
                $data['status'] = 'failed';
                $data['result'] = "0 product found.";
                $this->load->view('product/search', $data);
            } else {
                $data['status'] = 'success';
                $data['result'] = $result;
                $this->load->view('product/search', $data);
            }
        }
    }
    
    public function get_search($data = null) {
        if (!isset($data)) {
            $data['Product_Code'] = '';
            $data['Product_Name'] = '';
        }

        $this->load->view('product/search', $data);
    }
    
    public function insert() {
        $this->form_validation->set_rules('Product_Code', 'Product Code', 'trim|required|is_unique[Product.Product_Code]');
        $this->form_validation->set_rules('Product_Name', 'Product Name', 'trim|required');
        $data['Product_Code'] = $this->input->post('Product_Code');
        $data['Product_Name'] = $this->input->post('Product_Name');
        if ($this->form_validation->run() == FALSE) {
            $this->get_insert($data);
        } else {
            $result = $this->ProductModel->insert($data);
            if ($result == FALSE) {
                $data['status'] = 'failed';
                $data['result'] = "Insert failed.";
                $this->load->view('product/insert', $data);
            } else {
                $data['status'] = 'success';
                $data['result'] = "Insert success.";
                $this->load->view('product/insert', $data);
            }
        }
    }

    public function get_insert($data = null) {
        if (!isset($data)) {
            $data['Product_Code'] = '';
            $data['Product_Name'] = '';
        }
        $this->load->view('product/insert', $data);
    }
    
    public function edit($data = null) {
        $this->form_validation->set_rules('Product_Code', 'Product ID', 'trim|required');
        $this->form_validation->set_rules('Product_Name', 'Product Name', 'trim|required');
        $data['Product_Code'] = $this->input->post('Product_Code');
        $data['Product_Name'] = $this->input->post('Product_Name');
        if ($this->form_validation->run() == FALSE) {
            $this->get_insert($data);
        } else {
            $result = $this->ProductModel->update($data);
            if ($result == FALSE) {
                $data['status'] = 'failed';
                $data['result'] = "Edit failed.";
                $this->load->view('product/edit', $data);
            } else {
                $data['status'] = 'success';
                $data['result'] = "Edit success.";
                $this->load->view('product/edit', $data);
            }
        }
    }

    public function get_edit($id = null) {
        if (isset($id)) {
            $record = $this->ProductModel->get($id);
            if ($record != FALSE) {
                $data['Product_Code'] = $record[0]->Product_Code;
                $data['Product_Name'] = $record[0]->Product_Name;
            }
        }
        $this->load->view('product/edit', $data);
    }

    public function view($id) {
        if (!isset($data)) {
            $data['Product_Code'] = '';
            $data['Product_Name'] = '';
        }
    }
    
    public function get_upload() {
        $this->load->view('product/upload');
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
            $this->load->view('product/upload',$data);
        } else {
            $upload_info = $this->upload->data();
            $csvdata = array_map('str_getcsv', file($upload_info['full_path'])); 
            if($has_header == 1){
                array_shift($csvdata);
            }
            $data['status'] = 'success';
            $data['has_header'] = $has_header;
            $result = $this->ProductModel->import($csvdata);
            $data['result'] = "{$result['success']} rows inserted, {$result['error']} errors";
            $this->load->view('product/upload', $data);
        }
        
    }
}
