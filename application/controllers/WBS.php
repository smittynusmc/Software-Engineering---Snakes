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
    }
    
    public function index($id=null) {
        
       
        $this->load->view('wbs/view');
    }
    
}
