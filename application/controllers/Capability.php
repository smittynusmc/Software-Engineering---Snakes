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
        $overwrite = $this->input->post('overwrite');
        $overwrite = ($overwrite == 1);
		$insert_counter = 0;
		$error_counter = 0;
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
			$column_names = array(
				'program_code', 'program_name'
				,'product_code', 'product_name'
				,'wbs_code', 'wbs_name'
				,'capability_name'
				);
			array_walk($csvdata, function(&$a) use ($column_names) {
				$a = array_combine($column_names, $a);
			});
			$this->debuglog('before validations',$csvdata);
			$error = array();
			foreach($csvdata as $key=>$row){
				$validation_result = $this->upload_validation($row);
				$this->debuglog('validation_result ',$validation_result);
				if($validation_result['status'] < 0){
					$error[$key] = $validation_result['error'];
				}
			}
			
			$this->debuglog('validation_result  error',$error);
			if(!empty($error)){
				$data['error'] = $error;
				$this->load->view('capability/upload',$data);
			}
			else{
				$data['status'] = 'success';
				$data['has_header'] = $has_header;
				foreach($csvdata as $key=>$row){
					$row['date'] = $row['date'].'-01';
					$program_data = array('program_code'=>$row['program_code']
									,'program_name'=>$row['program_name']);
					$program_id = $this->ProgramModel->insert($program_data,$overwrite,true);
					$this->debuglog('program_id ',$program_id);
					$product_data = array('product_code'=>$row['product_code']
									,'product_name'=>$row['product_name']);
					$product_id = $this->ProductModel->insert($product_data,$overwrite,true);
					$this->debuglog('product_id ',$product_id);
					$wbs_data = array('wbs_code'=>$row['wbs_code']
									,'wbs_name'=>$row['wbs_name']);
					$wbs_id = $this->WBSModel->insert($wbs_data,$overwrite,true);
					$this->debuglog('wbs_id ',$wbs_id);
					$obs_data  = array('program_id'=>$program_id,
								'product_id'=>$product_id,
								'wbs_id'=>$wbs_id);
					$obs_id = $this->OBSModel->insert($obs_data,true);
					$this->debuglog('obs_id ',$obs_id);
					$capability_data = array(
										'capability_name'=>$row['capability_name']
										);
					$capability_id = 	$this->CapabilityModel->insert($capability_data,$overwrite);
					if($capability_id != false){
						$insert_counter ++;
					}
					else{
						$error_counter ++;
					}
					
				}
				
				$data['result'] = "{$insert_counter} rows inserted, {$error_counter} errors";
				$this->load->view('capability/upload', $data);
			}
			
        }
        
    }
	
	public function upload_validation($data){
		$this->form_validation->reset_validation();
		$this->form_validation->set_data($data);
		$this->form_validation->set_rules('program_code', 'Program Code', 'trim|required|max_length[10]');
		$this->form_validation->set_rules('program_name', 'Program Name', 'trim|required|max_length[75]');
		$this->form_validation->set_rules('product_code', 'Product Code', 'trim|required|max_length[20]');
		$this->form_validation->set_rules('product_name', 'Product Name', 'trim|required|max_length[75]');
		$this->form_validation->set_rules('wbs_code', 'WBS Code', 'trim|required|max_length[20]');
		$this->form_validation->set_rules('wbs_name', 'WBS Name', 'trim|required|max_length[75]');
		$this->form_validation->set_rules('date', 'Month', 'trim|required|callback_regex_check_date');
		
		if($this->form_validation->run() == FALSE){
			$result['status'] = -1;
			$result['error'] = validation_errors();
		}
		else{
			$result['status'] = 1;
		}
		return $result;
	}
}
