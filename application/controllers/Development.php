<?php

Class Development extends CI_Controller {
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
        $this->load->library('helper');
		$this->load->helper('security');
// Load session library
        $this->load->library('session');

// Load database
        $this->load->model('DevelopmentModel');
        $this->load->model('ProgramModel');
        $this->load->model('ProductModel');
        $this->load->model('WBSModel');
        $this->load->model('OBSModel');
        $this->load->model('CommonModel');
// Load file helper library        
        $this->load->helper('file');
    }
    
	
	private function debuglog($mess,$data=null){
		write_file($this->log_path,"\n".$mess.":\n".print_r($data,true),'a');
	}
	
    public function index($id=null) {
        $data['development_id'] = '';
        $data['program_name'] = '';
        $data['product_name'] = '';
        $data['wbs_name'] = '';
        $data['date'] = '';
        $data['sloc'] = '';
        $data['hours'] = '';
        if (isset($id)) {
            $record = $this->DevelopmentModel->get($id);
            if ($record != FALSE) {
                $data['development_id'] = $record[0]->development_id;
                $data['program_name'] = $record[0]->program_name;
                $data['product_name'] = $record[0]->product_name;
                $data['wbs_name'] = $record[0]->wbs_name;
                $data['date'] = $record[0]->date;
                $data['sloc'] = $record[0]->sloc;
                $data['hours'] = $record[0]->hours;
            }
        }
       
        $this->load->view('development/view',$data);
    }
    
    public function search() {
        $this->form_validation->set_rules('development_id', 'Development ID', 'trim');
        $this->form_validation->set_rules('program_name', 'Program Name', 'trim');
        $this->form_validation->set_rules('product_name', 'Product Name', 'trim');
        $this->form_validation->set_rules('wbs_name', 'WBS Name', 'trim');
        $this->form_validation->set_rules('sloc', 'SLOC', 'trim');
        $this->form_validation->set_rules('hours', 'Hours', 'trim');
        $data['development_id'] = $this->input->post('development_id');
        $data['program_name'] = $this->input->post('program_name');
        $data['product_name'] = $this->input->post('product_name');
        $data['wbs_name'] = $this->input->post('wbs_name');
        $data['sloc'] = $this->input->post('sloc');
        $data['hours'] = $this->input->post('hours');
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
            $data['development_id'] = '';
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
            $data['sloc'] = '';
            $data['hours'] = '';
			$data['obs_data'] = $this->helper->process_obs($this->CommonModel->getOBSList());
        }

        $this->load->view('development/search', $data);
    }
    
    public function get_insert($data = null) {
        if (!isset($data)) {
            $data['development_id'] = '';
            $data['obs_id'] = '';
            $data['program_id'] = '';
            $data['product_id'] = '';
            $data['wbs_id'] = '';
            $data['sloc'] = '';
            $data['date'] = '';
            $data['hours'] = '';
			$data['obs_data'] = $this->helper->process_obs($this->CommonModel->getOBSList());
        }
        $this->load->view('development/insert', $data);
    }
    
    public function get_edit($id = null) {
        $record = $this->DevelopmentModel->get($id);
		$data['development_id'] = $record[0]->development_id;
		$data['obs_id'] = $record[0]->obs_id;
		$data['program_id'] = $record[0]->program_id;
		$data['product_id'] = $record[0]->product_id;
		$data['wbs_id'] = $record[0]->wbs_id;;
		$data['sloc'] = $record[0]->sloc;
		$data['date'] = $record[0]->date;
		$data['hours'] = $record[0]->hours;
		$data['obs_data'] = $this->helper->process_obs($this->CommonModel->getOBSList());
        
        $this->load->view('development/edit', $data);
    }
	public function edit(){
		$this->form_validation->set_rules('development_id', 'Development ID', 'trim|required|numeric');
		$this->form_validation->set_rules('obs_id', 'Program,Product, WBS', 'trim|required|numeric');
		$this->form_validation->set_rules('hours', 'Hours', 'trim|numeric');
		$this->form_validation->set_rules('sloc', 'SLOC', 'trim|numeric');
		$this->form_validation->set_rules('date', 'Date', 'trim');
		$data['development_id'] = $this->input->post('development_id');
		$data['obs_id'] = $this->input->post('obs_id');
		$data['hours'] = $this->input->post('hours');
        $data['sloc'] = $this->input->post('sloc');
        $data['date'] = $this->input->post('date');
		
		if ($this->form_validation->run() == FALSE) {
            $this->get_edit($data['development_id']);
        } else {
            $result = $this->DevelopmentModel->update($data);
			$record = $this->DevelopmentModel->get($data['development_id']);
			$data['development_id'] = $record[0]->development_id;
			$data['obs_id'] = $record[0]->obs_id;
			$data['program_id'] = $record[0]->program_id;
			$data['product_id'] = $record[0]->product_id;
			$data['wbs_id'] = $record[0]->wbs_id;;
			$data['sloc'] = $record[0]->sloc;
			$data['date'] = $record[0]->date;
			$data['hours'] = $record[0]->hours;
			$data['obs_data'] = $this->helper->process_obs($this->CommonModel->getOBSList());
            if ($result == FALSE) {
                $data['status'] = 'failed';
                $data['result'] = "Edit failed.";
                $this->load->view('development/edit', $data);
            } else {
                $data['status'] = 'success';
                $data['result'] = "Edit success.";
                $this->load->view('development/edit', $data);
            }
        }
	}
	
	public function regex_check_date($str)
	{
		if (1 !== preg_match("/\d{4}-(0[1-9]|1[0-2])/", $str))
		{
			$this->form_validation->set_message('regex_check_date', 'The Month field has to be in format yyyy-dd!');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	
	public function upload_validation($data){
		$this->form_validation->set_rules('program_code', 'Program Code', 'trim|required|max_length[10]');
		$this->form_validation->set_rules('program_name', 'Program Name', 'trim|required|max_length[75]');
		$this->form_validation->set_rules('product_code', 'Product Code', 'trim|required|max_length[20]');
		$this->form_validation->set_rules('product_name', 'Product Name', 'trim|required|max_length[75]');
		$this->form_validation->set_rules('wbs_code', 'WBS Code', 'trim|required|max_length[20]');
		$this->form_validation->set_rules('wbs_name', 'WBS Name', 'trim|required|max_length[75]');
		$this->form_validation->set_rules('date', 'Month', 'trim|required|callback_regex_check_date');
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
	public function insert($data=null){
		$this->form_validation->set_rules('obs_id', 'Program,Product, WBS', 'trim|required|numeric');
		$this->form_validation->set_rules('hours', 'Hours', 'trim|numeric');
		$this->form_validation->set_rules('sloc', 'SLOC', 'trim|numeric');
		$this->form_validation->set_rules('date', 'Date', 'trim');
		$data['obs_id'] = $this->input->post('obs_id');
		$data['hours'] = $this->input->post('hours');
        $data['sloc'] = $this->input->post('sloc');
        $data['date'] = $this->input->post('date');
		if ($this->form_validation->run() == FALSE) {
			$data['obs_data'] = $this->helper->process_obs($this->CommonModel->getOBSList());
            $this->get_insert($data);
        } else {
            $result = $this->DevelopmentModel->insert($data);
			$data['obs_data'] = $this->helper->process_obs($this->CommonModel->getOBSList());
            if ($result == FALSE) {
                $data['status'] = 'failed';
                $data['result'] = "Insert failed.";
				$data['development_id'] = '';
                $this->load->view('development/insert', $data);
            } else {
                $data['status'] = 'success';
                $data['result'] = "Insert success.";
				$data['development_id'] = $result;
                $this->load->view('development/insert', $data);
            }
        }
		
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
        $overwrite = $this->input->post('overwrite');
        $overwrite = ($overwrite == 1);
		$insert_counter = 0;
		$error_counter = 0;
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
			$column_names = array(
				'program_code', 'program_name'
				,'product_code', 'product_name'
				,'wbs_code', 'wbs_name'
				,'date', 'sloc'
				,'hours'
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
				$this->load->view('development/upload',$data);
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
					$development_data = array('obs_id'=>$obs_id
										,'sloc'=>$row['sloc']
										,'date'=>$row['date']
										,'hours'=>$row['hours']
										);
					$development_id = 	$this->DevelopmentModel->insert($development_data,$overwrite);
					if($development_id != false){
						$insert_counter ++;
					}
					else{
						$error_counter ++;
					}
					
				}
				
				$data['result'] = "{$insert_counter} rows inserted, {$error_counter} errors";
				$this->load->view('development/upload', $data);
			}
			
        }
        
    }
}
