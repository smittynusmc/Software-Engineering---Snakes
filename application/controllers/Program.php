<?php

Class Program extends CI_Controller {

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
        $this->load->model('ProgramModel');
// Load file helper library        
        $this->load->helper('file');
    }

    public function index($id = null) {
        $data['program_id'] = '';
        $data['program_code'] = '';
        $data['program_name'] = '';
        $data['build_date'] = '';
        $data['end_date'] = '';
        if (isset($id)) {
            $record = $this->ProgramModel->get($id);
            if ($record != FALSE) {
                $data['program_id'] = $record[0]->program_id;
                $data['program_code'] = $record[0]->program_code;
                $data['program_name'] = $record[0]->program_name;
                $data['build_date'] = $record[0]->build_date;
                $data['end_date'] = $record[0]->end_date;
            }
        }

        $this->load->view('program/view', $data);
    }

    public function search() {
        $this->form_validation->set_rules('program_id', 'Program Id', 'trim');
        $this->form_validation->set_rules('program_code', 'Program Code', 'trim');
        $this->form_validation->set_rules('program_name', 'Program Name', 'trim');
        $this->form_validation->set_rules('build_date', 'Build Date', 'trim');
        $this->form_validation->set_rules('end_date', 'end date', 'trim');
        $data['program_id'] = $this->input->post('program_id');
        $data['program_code'] = $this->input->post('program_code');
        $data['program_name'] = $this->input->post('program_name');
        $data['build_date'] = $this->input->post('build_date');
        $data['end_date'] = $this->input->post('end_date');
        if ($this->form_validation->run() == FALSE) {
            $this->get_search($data);
        } else {
            $result = $this->ProgramModel->search($data);
            if ($result == FALSE) {
                $data['status'] = 'failed';
                $data['result'] = "0 program found.";
                $this->load->view('program/search', $data);
            } else {
                $data['status'] = 'success';
                $data['result'] = $result;
                $this->load->view('program/search', $data);
            }
        }
    }

    public function get_search($data = null) {
        if (!isset($data)) {
            $data['program_id'] = '';
            $data['program_code'] = '';
            $data['program_name'] = '';
            $data['build_date'] = '';
            $data['end_date'] = '';
        }

        $this->load->view('program/search', $data);
    }

    public function edit($data = null) {
        $this->form_validation->set_rules('program_id', 'Program Id', 'trim|required');
        $this->form_validation->set_rules('program_code', 'Program Code', 'trim|required');
        $this->form_validation->set_rules('program_name', 'Program Name', 'trim|required');
        $this->form_validation->set_rules('build_date', 'Build Date', 'trim');
        $this->form_validation->set_rules('end_date', 'End Date', 'trim');
        $data['program_id'] = $this->input->post('program_id');
        $data['program_code'] = $this->input->post('program_code');
        $data['program_name'] = $this->input->post('program_name');
        $data['build_date'] = $this->input->post('build_date');
        $data['end_date'] = $this->input->post('end_date');
        if ($this->form_validation->run() == FALSE) {
            $this->get_insert($data);
        } else {
            $result = $this->ProgramModel->update($data);
            if ($result == FALSE) {
                $data['status'] = 'failed';
                $data['result'] = "Edit failed.";
                $this->load->view('program/edit', $data);
            } else {
                $data['status'] = 'success';
                $data['result'] = "Edit success.";
                $this->load->view('program/edit', $data);
            }
        }
    }

    public function get_edit($id = null) {
        if (isset($id)) {
            $record = $this->ProgramModel->get($id);
            if ($record != FALSE) {
                $data['program_id'] = $record[0]->program_id;
                $data['program_code'] = $record[0]->program_code;
                $data['program_name'] = $record[0]->program_name;
                $data['build_date'] = $record[0]->build_date;
                $data['end_date'] = $record[0]->end_date;
            }
        }
        $this->load->view('program/edit', $data);
    }

    public function insert() {
        $this->form_validation->set_rules('program_code', 'Program Code', 'trim|required');
        $this->form_validation->set_rules('program_name', 'Program Name', 'trim|required');
        $this->form_validation->set_rules('build_date', 'Build Date', 'trim');
        $this->form_validation->set_rules('end_date', 'End Date', 'trim');
        $data['program_code'] = $this->input->post('program_code');
        $data['program_name'] = $this->input->post('program_name');
        $data['build_date'] = $this->input->post('build_date');
        $data['end_date'] = $this->input->post('end_date');
        if ($this->form_validation->run() == FALSE) {
            $this->get_insert($data);
        } else {
            $result = $this->ProgramModel->insert($data);
            if ($result == false) {
                $data['status'] = 'failed';
                $data['result'] = "Insert Failed.";
                $this->load->view('program/insert', $data);
            } else {
                $data['status'] = 'success';
                $data['result'] = "Insert Success.";
                $data['program_id'] = $result;
                $this->load->view('program/insert', $data);
            }
        }
    }

    public function get_insert($data = null) {
        if (!isset($data)) {
            $data['program_id'] = '';
            $data['program_code'] = '';
            $data['program_name'] = '';
            $data['build_date'] = '';
            $data['end_date'] = '';
        }
        $this->load->view('program/insert', $data);
    }

    public function upload_validation($data){
		$this->form_validation->reset_validation();
		$this->form_validation->set_data($data);
		$this->form_validation->set_rules('program_code', 'Program Code', 'trim|required|max_length[10]');
		$this->form_validation->set_rules('program_name', 'Program Name', 'trim|required|max_length[75]');
		$this->form_validation->set_rules('build_date', 'Build Date', 'trim|required|callback_regex_check_date');
		$this->form_validation->set_rules('end_date', 'End Date', 'trim|required|callback_regex_check_date');
		if($this->form_validation->run() == FALSE){
			$result['status'] = -1;
			$result['error'] = validation_errors();
		}
		else{
			$result['status'] = 1;
		}
		return $result;
	}
	
	public function regex_check_date($str)
	{
		if (1 !== preg_match("/\d{4}-(0[1-9]|1[0-2])-(0[1-9]|1[0-9]|2[0-9]|3[0-1])/", $str))
		{
			$this->form_validation->set_message('regex_check_date', 'The Date field must be in the format yyyy-mm-dd!');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	public function get_upload() {
        $this->load->view('program/upload');
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
            $this->load->view('program/upload',$data);
        } else {
            $upload_info = $this->upload->data();
            $csvdata = array_map('str_getcsv', file($upload_info['full_path'])); 
			if($has_header == 1){
                array_shift($csvdata);
            }
			$column_names = array(
				'program_code', 'program_name'
				,'build_date', 'end_date'
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
				$this->load->view('program/upload',$data);
			}
			else{
				$data['status'] = 'success';
				$data['has_header'] = $has_header;
				foreach($csvdata as $key=>$row){
					$program_data = array('program_code'=>$row['program_code']
									,'program_name'=>$row['program_name'],'build_date'=>$row['build_date'],
									'end_date'=>$row['end_date']);
					$program_id = $this->ProgramModel->insert($program_data,$overwrite);
					if($program_id != false){
						$insert_counter ++;
					}
					else{
						$error_counter ++;
					}
					
				}
				
				$data['result'] = "{$insert_counter} rows inserted/updated, {$error_counter} rows existed";
				$this->load->view('program/upload', $data);
			}
			
        }
        
    }

}
