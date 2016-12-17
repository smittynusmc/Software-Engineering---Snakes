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
        $data['product_id'] = '';
        $data['product_code'] = '';
        $data['product_name'] = '';
        if (isset($id)) {
            $record = $this->ProductModel->get($id);
            if ($record != FALSE) {
                $data['product_id'] = $record[0]->product_id;
                $data['product_code'] = $record[0]->product_code;
                $data['product_name'] = $record[0]->product_name;
            }
        }

        $this->load->view('product/view', $data);
    }
    
    public function search() {
        $this->form_validation->set_rules('product_id', 'Product ID', 'trim');
        $this->form_validation->set_rules('product_code', 'Product Code', 'trim');
        $this->form_validation->set_rules('product_name', 'Product Name', 'trim');
        $data['product_id'] = $this->input->post('product_id');
        $data['product_code'] = $this->input->post('product_code');
        $data['product_name'] = $this->input->post('product_name');
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
            $data['product_id'] = '';
            $data['product_code'] = '';
            $data['product_name'] = '';
        }

        $this->load->view('product/search', $data);
    }
    
    public function insert() {
        $this->form_validation->set_rules('product_code', 'Product Code', 'trim|required|is_unique[product.product_code]');
        $this->form_validation->set_rules('product_name', 'Product Name', 'trim|required');
        $data['product_code'] = $this->input->post('product_code');
        $data['product_name'] = $this->input->post('product_name');
        if ($this->form_validation->run() == FALSE) {
            $this->get_insert($data);
        } else {
            $result = $this->ProductModel->insert($data);
            if ($result == FALSE) {
                $data['status'] = 'failed';
                $data['result'] = "Insert failed.";
				$data['product_id'] = '';
                $this->load->view('product/insert', $data);
            } else {
                $data['status'] = 'success';
                $data['result'] = "Insert success.";
				$data['product_id'] = $result;
                $this->load->view('product/insert', $data);
            }
        }
    }

    public function get_insert($data = null) {
        if (!isset($data)) {
            $data['product_id'] = '';
            $data['product_code'] = '';
            $data['product_name'] = '';
        }
        $this->load->view('product/insert', $data);
    }
    
    public function edit($data = null) {
        $this->form_validation->set_rules('product_id', 'Product ID', 'trim|required');
        $this->form_validation->set_rules('product_code', 'Product ID', 'trim|required');
        $this->form_validation->set_rules('product_name', 'Product Name', 'trim|required');
        $data['product_id'] = $this->input->post('product_id');
        $data['product_code'] = $this->input->post('product_code');
        $data['product_name'] = $this->input->post('product_name');
        if ($this->form_validation->run() == FALSE) {
            $this->get_edit($data['product_id']);
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
            if ($record != false) {
                $data['product_id'] = $record[0]->product_id;
                $data['product_code'] = $record[0]->product_code;
                $data['product_name'] = $record[0]->product_name;
            }
        }
        $this->load->view('product/edit', $data);
    }

    
    public function upload_validation($data){
		$this->form_validation->reset_validation();
		$this->form_validation->set_data($data);
		$this->form_validation->set_rules('product_code', 'Product Code', 'trim|required|max_length[20]');
		$this->form_validation->set_rules('product_name', 'Product Name', 'trim|required|max_length[75]');
		if($this->form_validation->run() == FALSE){
			$result['status'] = -1;
			$result['error'] = validation_errors();
		}
		else{
			$result['status'] = 1;
		}
		return $result;
	}

    public function upload() {
        $config['upload_path'] = 'uploads';
        $config['allowed_types'] = '*';
        $config['max_size'] = 3000;

        $this->load->library('upload', $config);
        $has_header = $this->input->post('has_header');
        $overwrite = $this->input->post('overwrite');
        $overwrite = ($overwrite == 1);
		$insert_counter = 0;
		$error_counter = 0;
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
			$column_names = array(
				'product_code', 'product_name'
				);
			array_walk($csvdata, function(&$a) use ($column_names) {
				$a = array_combine($column_names, $a);
			});
			$error = array();
			foreach($csvdata as $key=>$row){
				
				$validation_result = $this->upload_validation($row);
				if($validation_result['status'] < 0){
					$error[$key] = $validation_result['error'];
				}
			}
			
			if(!empty($error)){
				$data['error'] = $error;
				$this->load->view('product/upload',$data);
			}
			else{
				$data['status'] = 'success';
				$data['has_header'] = $has_header;
				foreach($csvdata as $key=>$row){
					$product_data = array('product_code'=>$row['product_code']
									,'product_name'=>$row['product_name']);
					$product_id = $this->ProductModel->insert($product_data,$overwrite);
					if($product_id != false){
						$insert_counter ++;
					}
					else{
						$error_counter ++;
					}
					
				}
				
				$data['result'] = "{$insert_counter} rows inserted/updated, {$error_counter} rows existed";
				$this->load->view('product/upload', $data);
			}
			
        }
        
    }
	
		public function get_upload() {
        $this->load->view('product/upload');
    }
        
}
