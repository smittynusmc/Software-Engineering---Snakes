<?php

Class Project extends CI_Controller {
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
        $this->load->model('ProjectModel');
    }
    
    public function index($id=null) {
        $data['Project_ID'] = '';
        $data['Project_Name'] = '';
        $data['Build_Date'] = '';
        $data['End_Date'] = '';
        if(isset($id)){
            $record = $this->ProjectModel->get($id);
            if($record != FALSE){
                $data['Project_ID'] = $record[0]->Project_ID;
                $data['Project_Name'] = $record[0]->Project_Name;
                $data['Build_Date'] = $record[0]->Build_Date;
                $data['End_Date'] = $record[0]->End_Date;
            }
        }
       
        $this->load->view('project/view',$data);
    }
    
    public function search(){
        $this->form_validation->set_rules('Project_ID', 'Project ID', 'trim');
        $this->form_validation->set_rules('Project_Name', 'Project Name', 'trim');
        $this->form_validation->set_rules('Build_Date', 'Build Date', 'trim');
        $this->form_validation->set_rules('End_Date', 'End Date', 'trim');
        $data['Project_ID'] = $this->input->post('Project_ID');
        $data['Project_Name'] = $this->input->post('Project_Name');
        $data['Build_Date'] = $this->input->post('Build_Date');
        $data['End_Date'] = $this->input->post('End_Date');
        if ($this->form_validation->run() == FALSE) {
            $this->get_search($data);
        }
        else{
            $result = $this->ProjectModel->search($data);
            if($result == FALSE){
                $data['status'] = 'failed';
                $data['result'] = "0 project found.";
                $this->load->view('project/search',$data);
            }
            else{
                $data['status'] = 'success';
                $data['result'] = $result;
                $this->load->view('project/search',$data);
            }
            
        }
        
        
    }
    
    public function get_search($data=null){
        if(!isset($data)){
            $data['Project_ID'] = '';
            $data['Project_Name'] = '';
            $data['Build_Date'] = '';
            $data['End_Date'] = '';
        }
        
        $this->load->view('project/search',$data);
    }
    
    
    
    public function edit($data=null){
        $this->form_validation->set_rules('Project_ID', 'Project ID', 'trim|required');
        $this->form_validation->set_rules('Project_Name', 'Project Name', 'trim|required');
        $this->form_validation->set_rules('Build_Date', 'Build Date', 'trim');
        $this->form_validation->set_rules('End_Date', 'End Date', 'trim');
        $data['Project_ID'] = $this->input->post('Project_ID');
        $data['Project_Name'] = $this->input->post('Project_Name');
        $data['Build_Date'] = $this->input->post('Build_Date');
        $data['End_Date'] = $this->input->post('End_Date');
        if ($this->form_validation->run() == FALSE) {
            $this->get_insert($data);
        }
        else{
            $result = $this->ProjectModel->update($data);
            if($result == FALSE){
                $data['status'] = 'failed';
                $data['result'] = "Edit failed.";
                $this->load->view('project/insert',$data);
            }
            else{
                $data['status'] = 'success';
                $data['result'] = "Edit success.";
                $this->load->view('project/insert',$data);
            }
            
        }
    }
    
    public function get_edit($id = null){
        if(isset($id)){
            $record = $this->ProjectModel->get($id);
            if($record != FALSE){
                $data['Project_ID'] = $record[0]->Project_ID;
                $data['Project_Name'] = $record[0]->Project_Name;
                $data['Build_Date'] = $record[0]->Build_Date;
                $data['End_Date'] = $record[0]->End_Date;
            }
        }
        $this->load->view('project/edit',$data);
    }
    
    public function view($id){
        if(!isset($data)){
            $data['Project_ID'] = '';
            $data['Project_Name'] = '';
            $data['Build_Date'] = '';
            $data['End_Date'] = '';
        }
    }
    
    public function insert(){
        $this->form_validation->set_rules('Project_ID', 'Project ID', 'trim|required|is_unique[Project.Project_ID]');
        $this->form_validation->set_rules('Project_Name', 'Project Name', 'trim|required');
        $this->form_validation->set_rules('Build_Date', 'Build Date', 'trim');
        $this->form_validation->set_rules('End_Date', 'End Date', 'trim');
        $data['Project_ID'] = $this->input->post('Project_ID');
        $data['Project_Name'] = $this->input->post('Project_Name');
        $data['Build_Date'] = $this->input->post('Build_Date');
        $data['End_Date'] = $this->input->post('End_Date');
        if ($this->form_validation->run() == FALSE) {
            $this->get_insert($data);
        }
        else{
            $result = $this->ProjectModel->insert($data);
            if($result == FALSE){
                $data['status'] = 'failed';
                $data['result'] = "Insert failed.";
                $this->load->view('project/insert',$data);
            }
            else{
                $data['status'] = 'success';
                $data['result'] = "Insert success.";
                $this->load->view('project/insert',$data);
            }
            
        }
    }
    
    public function get_insert($data=null){
        if(!isset($data)){
            $data['Project_ID'] = '';
            $data['Project_Name'] = '';
            $data['Build_Date'] = '';
            $data['End_Date'] = '';
        }
        $this->load->view('project/insert',$data);
    }
}
