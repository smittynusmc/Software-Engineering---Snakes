<?php

Class CPCR extends CI_Controller {
	private $log_path = "logs/applog.txt";
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
        $this->load->model('CPCRModel');
		$this->load->model('CommonModel');
// Load file helper library        
        $this->load->helper('file');
    }
    
    public function index($id=null) {
        $data['cpcr_id'] = '';
        $data['program_name'] = '';
		$data['product_name'] = '';
		$data['wbs_name'] = '';
        $data['cpcr_status'] = '';
        $data['updated'] = '';
        $data['created'] = '';
        if (isset($id)) {
            $record = $this->CPCRModel->get($id);
            if ($record != FALSE) {
				$data['cpcr_id'] = $record[0]->cpcr_id;
                $data['program_name'] = $record[0]->program_name;;
				$data['product_name'] = $record[0]->product_name;;
				$data['wbs_name'] = $record[0]->wbs_name;;
				$data['cpcr_status'] = $record[0]->cpcr_status;
				$data['updated'] = $record[0]->updated;
                $data['created'] = $record[0]->created;
            }
        }
       
        $this->load->view('cpcr/view',$data);
    }
	
	private function debuglog($mess,$data=null){
		write_file($this->log_path,print_r($data,true));
	}
    
    public function search() {
        $this->form_validation->set_rules('cpcr_id', 'CPCR ID', 'trim');
        $this->form_validation->set_rules('program_code', 'Program Code', 'trim');
        $this->form_validation->set_rules('program_name', 'Program Name', 'trim');
        $this->form_validation->set_rules('product_code', 'Product Code', 'trim');
        $this->form_validation->set_rules('product_name', 'Product Name', 'trim');
        $this->form_validation->set_rules('wbs_code', 'Wbs Code', 'trim');
        $this->form_validation->set_rules('wbs_name', 'Wbs Name', 'trim');
        $data['cpcr_id'] = $this->input->post('cpcr_id');
        $data['program_code'] = $this->input->post('program_code');
        $data['program_name'] = $this->input->post('program_name');
        $data['product_code'] = $this->input->post('product_code');
        $data['product_name'] = $this->input->post('product_name');
        $data['wbs_code'] = $this->input->post('wbs_code');
        $data['wbs_name'] = $this->input->post('wbs_name');

        if ($this->form_validation->run() == FALSE) {
            $this->get_search($data);
        } else {
            $result = $this->CPCRModel->search($data);
            if ($result == FALSE) {
                $data['status'] = 'failed';
                $data['result'] = "0 project found.";
                $this->load->view('cpcr/search', $data);
            } else {
                $data['status'] = 'success';
                $data['result'] = $result;
                $this->load->view('cpcr/search', $data);
            }
        }
    }

    public function get_search($data = null) {
        if (!isset($data)) {
			$data['cpcr_id'] = '';
			$data['program_code'] = '';
			$data['program_name'] = '';
			$data['product_code'] = '';
			$data['product_name'] = '';
			$data['wbs_code'] = '';
			$data['wbs_name'] = '';
        }

        $this->load->view('cpcr/search', $data);
    }
    
    public function get_upload() {
        $this->load->view('cpcr/upload');
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
            $this->load->view('cpcr/upload',$data);
        } else {
            $upload_info = $this->upload->data();
            $csvdata = array_map('str_getcsv', file($upload_info['full_path'])); 
            if($has_header == 1){
                array_shift($csvdata);
            }
            $data['status'] = 'success';
            $data['has_header'] = $has_header;
            $result = $this->CPCRModel->import($csvdata);
            $data['result'] = "{$result['success']} rows inserted, {$result['error']} errors";
            $this->load->view('cpcr/upload', $data);
        }
        
    }
    public function get_insert($data = null) {
		$data['program'] = $this->CommonModel->getTable('program');
		$data['product'] = $this->CommonModel->getTable('product');
		$data['wbs'] = $this->CommonModel->getTable('wbs');
        $this->load->view('cpcr/insert', $data);
    }
	
	public function insert($data=null){
		$this->form_validation->set_rules('program_id', 'Program', 'trim|required');
        $this->form_validation->set_rules('product_id', 'Product', 'trim|required');
        $this->form_validation->set_rules('wbs_id', 'WBS', 'trim|required');
		$data['program_id'] = $this->input->post('program_id');
        $data['product_id'] = $this->input->post('product_id');
        $data['wbs_id'] = $this->input->post('wbs_id');
		if ($this->form_validation->run() == FALSE) {
            $this->get_insert($data);
        } else {
            $result = $this->CPCRModel->insert($data);
            if ($result == -1) {
                $data['status'] = 'failed';
                $data['result'] = "The CPCR is already existed.";
                $this->get_insert($data);
            }
			elseif ($result == -2) {
                $data['status'] = 'failed';
                $data['result'] = "Failed to insert cpcr.";
                $this->get_insert($data);
			}
			else {
                $data['status'] = 'success';
                $data['result'] ="Insert success.";
				$data['cpcr_id'] = $result; 
                $this->get_insert($data);
            }
        }
		
	}
	
	
    
    
	public function get_edit($id = null) {
        if (isset($id)) {
            $record = $this->CPCRModel->get($id);
			if ($record != false) {
				$data['program'] = $this->CommonModel->getTable('program');
				$data['product'] = $this->CommonModel->getTable('product');
				$data['wbs'] = $this->CommonModel->getTable('wbs');
                $data['cpcr_id'] = $record[0]->cpcr_id;
                $data['program_id'] = $record[0]->program_id;
                $data['product_id'] = $record[0]->product_id;
                $data['wbs_id'] = $record[0]->wbs_id;
				$this->load->view('cpcr/edit', $data);
            }
        }
        
    }
	
	public function edit(){
		$this->form_validation->set_rules('cpcr_id', 'CPCR ID', 'trim|required');
		$this->form_validation->set_rules('program_id', 'Program', 'trim|required');
        $this->form_validation->set_rules('product_id', 'Product', 'trim|required');
        $this->form_validation->set_rules('wbs_id', 'WBS', 'trim|required');
		$data['program_id'] = $this->input->post('program_id');
        $data['product_id'] = $this->input->post('product_id');
        $data['wbs_id'] = $this->input->post('wbs_id');
        $data['cpcr_id'] = $this->input->post('cpcr_id');
		
		if ($this->form_validation->run() == FALSE) {
            $this->get_edit($data['cpcr_id']);
        } else {
            $result = $this->CPCRModel->update($data);
			$this->debuglog('after update cpcr data:',$data);
			$data['program'] = $this->CommonModel->getTable('program');
			$data['product'] = $this->CommonModel->getTable('product');
			$data['wbs'] = $this->CommonModel->getTable('wbs');
            if ($result == -1) {
                $data['status'] = 'failed';
                $data['result'] = "The CPCR is already existed.";
                $this->load->view('cpcr/edit', $data);
            }
			elseif ($result == -2) {
                $data['status'] = 'failed';
                $data['result'] = "Failed to Update CPCR.";
                $this->load->view('cpcr/edit', $data);
			}
			else {
                $data['status'] = 'success';
                $data['result'] ="Update success.";
				$data['cpcr_id'] = $result; 
                $this->load->view('cpcr/edit', $data);
            }
        }
	}

}
