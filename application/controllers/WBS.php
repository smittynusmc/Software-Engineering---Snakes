<?php

Class WBS extends CI_Controller {

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
        $this->load->model('WBSModel');
    }

    public function index($id = null) {
        $data['wbs_id'] = '';
        $data['wbs_code'] = '';
        $data['wbs_name'] = '';
        if(isset($id)){
            $result = $this->WBSModel->get($id);
            if($result == FALSE){
                $data['wbs_id'] = "";
                $data['wbs_code'] = "";
                $data['wbs_name'] = '';
            }
            else{
                $data['wbs_id'] = $result[0]->wbs_id;
                $data['wbs_code'] = $result[0]->wbs_code;
                $data['wbs_name'] = $result[0]->wbs_name;
                
            }
        }
        $data['id'] = $id;
        $this->load->view('wbs/view', $data);
    }

    public function get_search($data = null) {
        if (!isset($data)) {
            $data['wbs_id'] = '';
            $data['wbs_code'] = '';
            $data['wbs_name'] = '';
        }
        $this->load->view('wbs/search', $data);
    }

    public function search() {
        $this->form_validation->set_rules('wbs_id', 'WBS ID', 'trim');
        $this->form_validation->set_rules('wbs_code', 'WBS Code', 'trim');
        $this->form_validation->set_rules('wbs_name', 'WBS Name', 'trim');
        $data['wbs_id'] = $this->input->post('wbs_id');
        $data['wbs_code'] = $this->input->post('wbs_code');
        $data['wbs_name'] = $this->input->post('wbs_name');
        if ($this->form_validation->run() == FALSE) {
            $this->get_search($data);
        } else {
            $result = $this->WBSModel->search($data);
            if ($result == FALSE) {
                $data['status'] = 'failed';
                $data['result'] = "0 wbs found.";
                $this->load->view('wbs/search', $data);
            } else {
                $data['status'] = 'success';
                $data['result'] = $result;
                $this->load->view('wbs/search', $data);
            }
        }
    }
    
    public function get_upload() {
        $this->load->view('wbs/upload');
    }
	
	public function get_insert($data = null){
		if(!isset($data)){
			$data['wbs_id'] = '';
			$data['wbs_code'] = '';
			$data['wbs_name'] = '';
		}
		$this->load->view('wbs/insert',$data);
	}
	
	public function insert() {
        $this->form_validation->set_rules('wbs_code', 'WBS Code', 'trim|required|is_unique[wbs.wbs_code]');
        $this->form_validation->set_rules('wbs_name', 'WBS Name', 'trim|required');
        $data['wbs_code'] = $this->input->post('wbs_code');
        $data['wbs_name'] = $this->input->post('wbs_name');
        if ($this->form_validation->run() == FALSE) {
            $this->get_insert($data);
        } else {
            $result = $this->WBSModel->insert($data);
            if ($result == FALSE) {
                $data['status'] = 'failed';
                $data['result'] = "Insert failed.";
                $this->load->view('wbs/insert', $data);
            } else {
                $data['status'] = 'success';
                $data['result'] = "Insert success.";
				$data['wbs_id'] = $result;
                $this->load->view('wbs/insert', $data);
            }
        }
    }
	
	public function get_edit($id = null){
		if(isset($id)){
			$record = $this->WBSModel->get($id);
            if ($record != false) {
                $data['wbs_id'] = $record[0]->wbs_id;
                $data['wbs_code'] = $record[0]->wbs_code;
                $data['wbs_name'] = $record[0]->wbs_name;
            }
			else{
				$data['wbs_id'] = '';
				$data['wbs_code'] = '';
				$data['wbs_name'] = '';
			}
		}
		else{
			$data['wbs_id'] = '';
			$data['wbs_code'] = '';
			$data['wbs_name'] = '';
		}
		$this->load->view('wbs/edit',$data);
	}
	
	public function edit(){
		$this->form_validation->set_rules('wbs_id', 'WBS ID', 'trim');
        $this->form_validation->set_rules('wbs_code', 'WBS Code', 'trim');
        $this->form_validation->set_rules('wbs_name', 'WBS Name', 'trim');
        $data['wbs_id'] = $this->input->post('wbs_id');
        $data['wbs_code'] = $this->input->post('wbs_code');
        $data['wbs_name'] = $this->input->post('wbs_name');
        if ($this->form_validation->run() == FALSE) {
            $this->get_search($data);
        } else {
            $result = $this->WBSModel->update($data);
            if ($result == FALSE) {
                $data['status'] = 'failed';
                $data['result'] = "Edit Fail.";
                $this->load->view('wbs/edit', $data);
            } else {
                $data['status'] = 'success';
                $data['result'] = "Edit Success.";
                $this->load->view('wbs/edit', $data);
            }
        }
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
            $this->load->view('wbs/upload',$data);
        } else {
            $upload_info = $this->upload->data();
            $csvdata = array_map('str_getcsv', file($upload_info['full_path'])); 
            if($has_header == 1){
                array_shift($csvdata);
            }
            $data['status'] = 'success';
            $data['has_header'] = $has_header;
            $result = $this->WBSModel->import($csvdata);
            $data['result'] = "{$result['success']} rows inserted, {$result['error']} errors";
            $this->load->view('wbs/upload', $data);
        }
        
    }

}
