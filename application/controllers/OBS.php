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
		$this->load->model('ProgramModel');
        $this->load->model('ProductModel');
        $this->load->model('WBSModel');
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
	public function upload_validation($data){
		$this->form_validation->set_rules('program_code', 'Program Code', 'trim|required|max_length[10]');
		$this->form_validation->set_rules('program_name', 'Program Name', 'trim|required|max_length[75]');
		$this->form_validation->set_rules('product_code', 'Product Code', 'trim|required|max_length[20]');
		$this->form_validation->set_rules('product_name', 'Product Name', 'trim|required|max_length[75]');
		$this->form_validation->set_rules('wbs_code', 'WBS Code', 'trim|required|max_length[20]');
		$this->form_validation->set_rules('wbs_name', 'WBS Name', 'trim|required|max_length[75]');
		$this->form_validation->set_data($data);
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
            $this->load->view('obs/upload',$data);
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
				$this->load->view('obs/upload',$data);
			}
			else{
				$data['status'] = 'success';
				$data['has_header'] = $has_header;
				foreach($csvdata as $key=>$row){
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
					$obs_id = $this->OBSModel->insert($obs_data);
					$this->debuglog('obs_id ',$obs_id);
					if($obs_id != false){
						$insert_counter ++;
					}
					else{
						$error_counter ++;
					}
					
				}
				
				$data['result'] = "{$insert_counter} rows inserted, {$error_counter} existed";
				$this->load->view('obs/upload', $data);
			}
			
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
