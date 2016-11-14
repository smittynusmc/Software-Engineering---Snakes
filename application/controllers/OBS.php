<?php

Class OBS extends CI_Controller {
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
        $this->load->model('OBSModel');
		$this->load->model('CommonModel');
// Load file helper library        
        $this->load->helper('file');
    }
    
    public function index($id=null) {
        $data['obs_id'] = '';
        $data['program_id'] = '';
        $data['program_code'] = '';
        $data['program_name'] = '';
        $data['product_id'] = '';
        $data['product_code'] = '';
        $data['product_name'] = '';
        $data['wbs_id'] = '';
        $data['wbs_code'] = '';
        $data['wbs_name'] = '';
        if (isset($id)) {
            $record = $this->OBSModel->get($id);
            if ($record != FALSE) {
				$data['obs_id'] = $record[0]->obs_id;
                $data['program_id'] = $record[0]->program_id;
				$data['program_code'] = $record[0]->program_code;
				$data['program_name'] = $record[0]->program_name;
                $data['product_id'] = $record[0]->product_id;
				$data['product_code'] = $record[0]->product_code;
				$data['product_name'] = $record[0]->product_name;
                $data['wbs_id'] = $record[0]->wbs_id;
				$data['wbs_code'] = $record[0]->wbs_code;
				$data['wbs_name'] = $record[0]->wbs_name;
                
            }
        }
       
        $this->load->view('obs/view',$data);
    }
	
	private function debuglog($mess,$data=null){
		write_file($this->log_path,"\n".$mess.":\n".print_r($data,true),'a');
	}
	
	
    
    public function search() {
        $this->form_validation->set_rules('obs_id', 'OBS ID', 'trim');
        $this->form_validation->set_rules('program_code', 'Program Code', 'trim');
        $this->form_validation->set_rules('program_name', 'Program Name', 'trim');
        $this->form_validation->set_rules('product_code', 'Product Code', 'trim');
        $this->form_validation->set_rules('product_name', 'Product Name', 'trim');
        $this->form_validation->set_rules('wbs_code', 'Wbs Code', 'trim');
        $this->form_validation->set_rules('wbs_name', 'Wbs Name', 'trim');
        $data['obs_id'] = $this->input->post('obs_id');
        $data['program_code'] = $this->input->post('program_code');
        $data['program_name'] = $this->input->post('program_name');
        $data['product_code'] = $this->input->post('product_code');
        $data['product_name'] = $this->input->post('product_name');
        $data['wbs_code'] = $this->input->post('wbs_code');
        $data['wbs_name'] = $this->input->post('wbs_name');

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
			$data['program_code'] = '';
			$data['program_name'] = '';
			$data['product_code'] = '';
			$data['product_name'] = '';
			$data['wbs_code'] = '';
			$data['wbs_name'] = '';
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
		$data['program'] = $this->CommonModel->getTable('program');
		$data['product'] = $this->CommonModel->getTable('product');
		$data['wbs'] = $this->CommonModel->getTable('wbs');
        $this->load->view('obs/insert', $data);
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
            $result = $this->OBSModel->insert($data);
            if ($result == -1) {
                $data['status'] = 'failed';
                $data['result'] = "The OBS is already existed.";
                $this->get_insert($data);
            }
			elseif ($result == -2) {
                $data['status'] = 'failed';
                $data['result'] = "Failed to insert obs.";
                $this->get_insert($data);
			}
			else {
                $data['status'] = 'success';
                $data['result'] ="Insert success.";
				$data['obs_id'] = $result; 
                $this->get_insert($data);
            }
        }
		
	}
	
	
    
    
	public function get_edit($id = null) {
        if (isset($id)) {
            $record = $this->OBSModel->get($id);
			if ($record != false) {
				$data['program'] = $this->CommonModel->getTable('program');
				$data['product'] = $this->CommonModel->getTable('product');
				$data['wbs'] = $this->CommonModel->getTable('wbs');
                $data['obs_id'] = $record[0]->obs_id;
                $data['program_id'] = $record[0]->program_id;
                $data['product_id'] = $record[0]->product_id;
                $data['wbs_id'] = $record[0]->wbs_id;
				$this->load->view('obs/edit', $data);
            }
        }
        
    }
	
	public function edit(){
		$this->form_validation->set_rules('obs_id', 'OBS ID', 'trim|required');
		$this->form_validation->set_rules('program_id', 'Program', 'trim|required');
        $this->form_validation->set_rules('product_id', 'Product', 'trim|required');
        $this->form_validation->set_rules('wbs_id', 'WBS', 'trim|required');
		$data['program_id'] = $this->input->post('program_id');
        $data['product_id'] = $this->input->post('product_id');
        $data['wbs_id'] = $this->input->post('wbs_id');
        $data['obs_id'] = $this->input->post('obs_id');
		
		if ($this->form_validation->run() == FALSE) {
            $this->get_edit($data['obs_id']);
        } else {
            $result = $this->OBSModel->update($data);
			$data['program'] = $this->CommonModel->getTable('program');
			$data['product'] = $this->CommonModel->getTable('product');
			$data['wbs'] = $this->CommonModel->getTable('wbs');
            if ($result == -1) {
                $data['status'] = 'failed';
                $data['result'] = "The OBS is already existed.";
                $this->load->view('obs/edit', $data);
            }
			elseif ($result == -2) {
                $data['status'] = 'failed';
                $data['result'] = "Failed to Update OBS.";
                $this->load->view('obs/edit', $data);
			}
			else {
                $data['status'] = 'success';
                $data['result'] ="Update success.";
				$data['obs_id'] = $result; 
                $this->load->view('obs/edit', $data);
            }
        }
	}

}
