<?php

class BugUpload extends CI_Controller {

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
        $this->load->model('login_database');
    }

    public function index() {
        $this->load->view('bug_upload', array('error' => ' '));
    }

    public function do_upload() {
        $config['upload_path'] = '/uploads/';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = 100;
        $config['max_width'] = 1024;
        $config['max_height'] = 768;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('bugcsv')) {
            $error = array('error' => $this->upload->display_errors());

            $this->load->view('bug_upload', $error);
        } else {
            $data = array('bug_upload' => $this->upload->data());

            $this->load->view('bug_upload_success', $data);
        }
    }

}

?>