<?php

Class Report extends CI_Controller {
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
		$this->load->model('CPCRModel');
		$this->load->model('DevelopmentModel');
		$this->load->library('helper');
// Load file helper library        
        $this->load->helper('file');
    }

    public function index() {
        
        $this->load->view('report/view');
    }
	
	public function development_cost($data=null){
		if(empty($data['program'])){
			$data['program'] = $this->CommonModel->getTable('program');
		}
		if(empty($data['product'])){
			$data['product'] = $this->CommonModel->getTable('product');
		}
		if(empty($data['wbs'])){
			$data['wbs'] = $this->CommonModel->getTable('wbs');
		}
		
        $this->load->view('report/development_cost', $data);
	}
	private function debuglog($mess,$data=null){
		write_file($this->log_path,"\n".$mess.":\n".print_r($data,true),'a');
	}
	
	public function cpcr_status($data=null){
		if(empty($data['program'])){
			$data['program'] = $this->CommonModel->getTable('program');
		}
		if(empty($data['product'])){
			$data['product'] = $this->CommonModel->getTable('product');
		}
		if(empty($data['wbs'])){
			$data['wbs'] = $this->CommonModel->getTable('wbs');
		}
		if(empty($data['cpcr_status_codeset'])){
			$data['cpcr_status_codeset'] = $this->CPCRModel->get_status_codeset();
		}
        $this->load->view('report/cpcr_status', $data);
	}
	public function cpcr_status_get_result(){
		$this->form_validation->set_rules('program_id', 'Program', 'trim|numeric');
        $this->form_validation->set_rules('product_id', 'Product ', 'trim|numeric');
        $this->form_validation->set_rules('wbs_id', 'WBS ', 'trim|numeric');
        $this->form_validation->set_rules('cpcr_status', 'CPCR status ', 'trim');
		$data['program_id'] = $this->input->post('program_id');
		$data['product_id'] = $this->input->post('product_id');
        $data['wbs_id'] = $this->input->post('wbs_id');
        $data['cpcr_status'] = $this->input->post('cpcr_status');
		$this->debuglog('cpcr_status_get_result:::',$_POST);
		if ($this->form_validation->run() == FALSE) {
            $this->cpcr_status($data);
        } else {
			
			$cpcr_status_report = $this->CPCRModel->cpcr_status_report($data);
			
			if($cpcr_status_report != FALSE){
				$data['status'] = 'SUCCESS';
				$data['report_data'] = $cpcr_status_report;
			}
			else{
				$data['status'] = 'FAIL';
			}
			$this->cpcr_status($data);
		}
		
	}
	
	public function development_cost_get_result(){
		$this->form_validation->set_rules('program_id', 'Program', 'trim|numeric');
        $this->form_validation->set_rules('product_id', 'Product ', 'trim|numeric');
        $this->form_validation->set_rules('wbs_id', 'WBS ', 'trim|numeric');
		$data['program_id'] = $this->input->post('program_id');
		$data['product_id'] = $this->input->post('product_id');
        $data['wbs_id'] = $this->input->post('wbs_id');
        $data['program_detail_level'] = $this->input->post('program_detail_level');
        $data['product_detail_level'] = $this->input->post('product_detail_level');
        $data['wbs_detail_level'] = $this->input->post('wbs_detail_level');
		if ($this->form_validation->run() == FALSE) {
            $this->development_cost($data);
        } else {
			$development_cost_data = $this->DevelopmentModel->development_cost_report($data);
			if($development_cost_data != FALSE){
				$data['status'] = 'SUCCESS';
				$data['report_data'] = $development_cost_data;
			}
			else{
				$data['status'] = 'FAIL';
			}
			$this->development_cost($data);
		}
	}
	
	

}
