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
        $this->load->library('helper');

// Load database
        $this->load->model('CPCRModel');
		$this->load->model('CommonModel');
		$this->load->model('ProgramModel');
        $this->load->model('ProductModel');
        $this->load->model('WBSModel');
        $this->load->model('OBSModel');
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
		write_file($this->log_path,"\n".$mess.":\n".print_r($data,true),'a');
	}
    
    public function search() {
        $this->form_validation->set_rules('cpcr_id', 'CPCR ID', 'trim');
        $this->form_validation->set_rules('program_name', 'Program Name', 'trim');
        $this->form_validation->set_rules('product_name', 'Product Name', 'trim');
        $this->form_validation->set_rules('wbs_name', 'WBS Name', 'trim');
		$this->form_validation->set_rules('cpcr_status', 'CPCR Status', 'trim');
		$this->form_validation->set_rules('updated', 'Updated', 'trim');
		$this->form_validation->set_rules('created', 'Created', 'trim');
        $data['cpcr_id'] = $this->input->post('cpcr_id');
        $data['program_name'] = $this->input->post('program_name');
        $data['product_name'] = $this->input->post('product_name');
        $data['wbs_name'] = $this->input->post('wbs_name');
		$data['cpcr_status'] = $this->input->post('cpcr_status');
		$data['updated'] = $this->input->post('updated');
		$data['created'] = $this->input->post('created');

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
			$data['program_name'] = '';
			$data['product_name'] = '';
			$data['wbs_name'] = '';
			$data['cpcr_status'] = '';
			$data['updated'] = '';
			$data['created'] = '';
        }

        $this->load->view('cpcr/search', $data);
    }
    
    public function get_upload() {
        $this->load->view('cpcr/upload');
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
            $this->load->view('cpcr/upload',$data);
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
				,'cpcr_status'
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
				$this->load->view('cpcr/upload',$data);
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
					$obs_id = $this->OBSModel->insert($obs_data,true);
					$this->debuglog('obs_id ',$obs_id);
					$cpcr_data = array('obs_id'=>$obs_id
										,'cpcr_status'=>$row['cpcr_status']
										);
					$cpcr_id = 	$this->CPCRModel->insert($cpcr_data);
					$this->debuglog('cpcr_id ',$cpcr_id);
					if($cpcr_id != false){
						$insert_counter ++;
					}
					else{
						$error_counter ++;
					}
					
				}
				
				$data['result'] = "{$insert_counter} rows inserted, {$error_counter} errors";
				$this->load->view('cpcr/upload', $data);
			}
			
        }
        
    }
    public function get_insert($data = null) {
		if (!isset($data)) {
            $data['cpcr_id'] = '';
            $data['obs_id'] = '';
            $data['program_id'] = '';
            $data['product_id'] = '';
            $data['wbs_id'] = '';
            $data['cpcr_status'] = '';
			$data['obs_data'] = $this->helper->process_obs($this->CommonModel->getOBSList());
			$data['cpcr_status_codeset'] = $this->CPCRModel->get_status_codeset();
        }
        $this->load->view('cpcr/insert', $data);
    }
	
	public function insert($data=null){
		$this->form_validation->set_rules('obs_id', 'Program,Product, WBS', 'trim|required|numeric');
		$this->form_validation->set_rules('cpcr_status', 'Hours', 'trim|required');
		$data['obs_id'] = $this->input->post('obs_id');
		$data['cpcr_status'] = $this->input->post('cpcr_status');
		
		if ($this->form_validation->run() == FALSE) {
			$data['obs_data'] = $this->helper->process_obs($this->CommonModel->getOBSList());
			$data['cpcr_status_codeset'] = $this->CPCRModel->get_status_codeset();
            $this->get_insert($data);
        } else {
            $result = $this->CPCRModel->insert($data);
			$data['obs_data'] = $this->helper->process_obs($this->CommonModel->getOBSList());
			$data['program_id'] = $this->input->post('program_id');
			$data['product_id'] = $this->input->post('product_id');
			$data['wbs_id'] = $this->input->post('wbs_id');
            if ($result == FALSE) {
                $data['status'] = 'failed';
                $data['result'] = "Insert failed.";
				$data['cpcr_id'] = '';
				
                $this->load->view('cpcr/insert', $data);
            } else {
                $data['status'] = 'success';
                $data['result'] = "Insert success.";
				$data['cpcr_id'] = $result;
                $this->load->view('cpcr/insert', $data);
            }
        }
		
	}
	
	
    
    
	public function get_edit($id = null) {
        if (isset($id)) {
            $record = $this->CPCRModel->get($id);
			if ($record != false) {
                $data['cpcr_id'] = $record[0]->cpcr_id;
                $data['program_id'] = $record[0]->program_id;
                $data['product_id'] = $record[0]->product_id;
                $data['wbs_id'] = $record[0]->wbs_id;
                $data['obs_id'] = $record[0]->obs_id;
				$data['cpcr_status'] = $record[0]->cpcr_status;
				$data['obs_data'] = $this->helper->process_obs($this->CommonModel->getOBSList());
				$data['cpcr_status_codeset'] = $this->CPCRModel->get_status_codeset();
				$this->load->view('cpcr/edit', $data);
            }
        }
        
    }
	
	public function edit(){
		$this->form_validation->set_rules('cpcr_id', 'CPCR ID', 'trim|numeric|required');
		$this->form_validation->set_rules('obs_id', 'Program, Product, WBS', 'trim|numeric|required');
        $this->form_validation->set_rules('cpcr_status', 'CPCR Status', 'trim|required');
        $data['cpcr_id'] = $this->input->post('cpcr_id');
		$data['obs_id'] = $this->input->post('obs_id');
        $data['cpcr_status'] = $this->input->post('cpcr_status');
					$this->debuglog('CPCRModel  POST',$_POST);
		if ($this->form_validation->run() == FALSE) {
            $this->get_edit($data['cpcr_id']);
        } else {
            $result = $this->CPCRModel->update($data);
			$data['obs_data'] = $this->helper->process_obs($this->CommonModel->getOBSList());
			$data['cpcr_status_codeset'] = $this->CPCRModel->get_status_codeset();
			$record = $this->CPCRModel->get($data['cpcr_id']);
			$data['obs_id'] = $record[0]->obs_id;
			$data['program_id'] = $record[0]->program_id;
			$data['product_id'] = $record[0]->product_id;
			$data['wbs_id'] = $record[0]->wbs_id;
			$data['cpcr_status'] = $record[0]->cpcr_status;
			$this->debuglog('CPCRModel ',$record);
            if ($result == FALSE) {
                $data['status'] = 'failed';
                $data['result'] = "Edit failed.";
                $this->load->view('cpcr/edit', $data);
            } else {
                $data['status'] = 'success';
                $data['result'] = "Edit success.";
                $this->load->view('cpcr/edit', $data);
            }
        }
	}

}
