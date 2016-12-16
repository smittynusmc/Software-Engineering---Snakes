<?php

Class Sprint extends CI_Controller {

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
        $this->load->model('SprintModel');
// Load file helper library        
        $this->load->helper('file');
    }

    public function index($id = null) {
        $data['sprint_id'] = '';
		$data['sprint_name'] = '';
        if (isset($id)) {
            $record = $this->SprintModel->get($id);
           if ($record != FALSE) {
               $data['sprint_id'] = $record[0]->sprint_id;
			   $data['sprint_name'] = $record[0]->sprint_name;
            }
        }

        $this->load->view('sprint/view', $data);
    }
    
    public function search() {
        $this->form_validation->set_rules('sprint_id', 'Sprint ID', 'trim');
        $this->form_validation->set_rules('sprint_name', 'Sprint Name', 'trim');
        $data['sprint_id'] = $this->input->post('sprint_id');
        $data['sprint_name'] = $this->input->post('sprint_name');
        if ($this->form_validation->run() == FALSE) {
            $this->get_search($data);
        } else {
            $result = $this->SprintModel->search($data);
            if ($result == FALSE) {
                $data['status'] = 'failed';
                $data['result'] = "0 sprint found.";
                $this->load->view('sprint/search', $data);
            } else {
                $data['status'] = 'success';
                $data['result'] = $result;
                $this->load->view('sprint/search', $data);
            }
        }
    }
    
    public function get_search($data = null) {
        if (!isset($data)) {
            $data['sprint_id'] = '';
            $data['sprint_name'] = '';
        }

        $this->load->view('sprint/search', $data);
    }
    
    public function insert() {
        $this->form_validation->set_rules('sprint_name', 'Sprint Name', 'trim|required');
        $data['sprint_name'] = $this->input->post('sprint_name');
        if ($this->form_validation->run() == FALSE) {
            $this->get_insert($data);
        } else {
            $result = $this->SprintModel->insert($data);
            if ($result == FALSE) {
                $data['status'] = 'failed';
                $data['result'] = "Insert failed.";
                $this->load->view('sprint/insert', $data);
            } else {
                $data['status'] = 'success';
                $data['result'] = "Insert success.";
				$data['sprint_id'] = $result;
                $this->load->view('sprint/insert', $data);
            }
        }
    }

    public function get_insert($data = null) {
        if (!isset($data)) {
			$data['sprint_id'] = '';
            $data['sprint_name'] = '';
        }
        $this->load->view('sprint/insert', $data);
    }
    
    public function edit($data = null) {
        $this->form_validation->set_rules('sprint_id', 'Sprint ID', 'trim|required');
        $this->form_validation->set_rules('sprint_name', 'Sprint Name', 'trim|required');
        $data['sprint_id'] = $this->input->post('sprint_id');
        $data['sprint_name'] = $this->input->post('sprint_name');
        if ($this->form_validation->run() == FALSE) {
            $this->get_insert($data);
        } else {
            $result = $this->SprintModel->update($data);
            if ($result == FALSE) {
                $data['status'] = 'failed';
                $data['result'] = "Edit failed.";
                $this->load->view('sprint/edit', $data);
            } else {
                $data['status'] = 'success';
                $data['result'] = "Edit success.";
				
                $this->load->view('sprint/edit', $data);
            }
        }
    }

    public function get_edit($id = null) {
        if (isset($id)) {
            $record = $this->SprintModel->get($id);
            if ($record != FALSE) {
                $data['sprint_id'] = $record[0]->sprint_id;
                $data['sprint_name'] = $record[0]->sprint_name;
            }
        }
        $this->load->view('sprint/edit', $data);
    }

    public function view($id) {
        if (!isset($data)) {
            $data['sprint_id'] = '';
            $data['sprint_name'] = '';
        }
    }
    
    public function get_upload() {
        $this->load->view('sprint/upload');
    }

    
	public function upload_validation($data){
		$this->form_validation->reset_validation();
		$this->form_validation->set_data($data);
		$this->form_validation->set_rules('sprint_name', 'Sprint Name', 'trim|required|max_length[75]');
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
            $this->load->view('sprint/upload',$data);
        } else {
            $upload_info = $this->upload->data();
            $csvdata = array_map('str_getcsv', file($upload_info['full_path'])); 
			if($has_header == 1){
                array_shift($csvdata);
            }
			$column_names = array(
				'sprint_name'
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
				$this->load->view('sprint/upload',$data);
			}
			else{
				$data['status'] = 'success';
				$data['has_header'] = $has_header;
				foreach($csvdata as $key=>$row){
					$capability_data = array('sprint_name'=>$row['sprint_name']
									);
					$capability_id = $this->SprintModel->insert($capability_data,$overwrite);
					if($capability_id != false){
						$insert_counter ++;
					}
					else{
						$error_counter ++;
					}
					
				}
				
				$data['result'] = "{$insert_counter} rows inserted, {$error_counter} existed";
				$this->load->view('sprint/upload', $data);
			}
			
        }
        
    }
}
