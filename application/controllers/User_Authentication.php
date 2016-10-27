<?php


Class User_Authentication extends CI_Controller {

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

// Show login page
    public function index() {
//         echo $this->encryption->encrypt('phong');
        $this->load->view('login_form');
    }

// Show registration page
    public function user_registration_show() {
       
        $this->load->view('registration_form');
    }
    
    public function getKey(){
        echo $this->encryption;
    }

// Validate and store registration data in database
    public function new_user_registration() {
// Check validation for user input in SignUp form
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('firstname', 'First Name', 'trim|required');
        $this->form_validation->set_rules('lastname', 'Last Name', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('registration_form');
        } else {
            $data = array(
                'user_name' => $this->input->post('username'),
                'user_email' => $this->input->post('email'),
                'user_password' => $this->encryption->encrypt($this->input->post('password')),
                'firstname' => $this->input->post('firstname'),
                'lastname' => $this->input->post('lastname')
            );
            $result = $this->login_database->registration_insert($data);
            if ($result == TRUE) {
                $data['message_display'] = 'Registration Successfully !';
                $this->load->view('login_form', $data);
            } else {
                $data['message_display'] = 'Username already exist!';
                $this->load->view('registration_form', $data);
            }
        }
    }

// Check for user login process
    public function user_login_process() {
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        
        if ($this->form_validation->run() == FALSE) {
            if (isset($this->session->userdata['logged_in'])) {
                $this->load->view('admin_page');
            } else {
                $this->load->view('login_form');
            }
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $result = $this->login_database->read_user_information($username);
             
            if ($result != false) {
                if($this->check_password($password,$result[0]->user_password)){
                    $session_data = array(
                        'username' => $result[0]->user_name,
                        'email' => $result[0]->user_email,
                        'firstname' => $result[0]->firstname,
                        'lastname' => $result[0]->lastname,
                    );
    // Add user data in session
                    $this->session->set_userdata('logged_in', $session_data);
                    $this->load->view('admin_page');
                }
                else{
                    $data = array(
                    'error_message' => 'Invaslid Username or Password'
                    );
                    $this->load->view('login_form', $data);
                }
                
            }
            else {
                $data = array(
                    'error_message' => 'Invalid Username or Password'
                );
                $this->load->view('login_form', $data);
            }
        }
    }

// Logout from admin page
    public function logout() {

// Removing session data
        $sess_array = array(
            'username' => ''
        );
        $this->session->unset_userdata('logged_in', $sess_array);
        $data['message_display'] = 'Successfully Logout';
        $this->load->view('login_form', $data);
    }
    private function check_password($password,$encryted_password){
        return $this->encryption->decrypt($encryted_password) == $password;
    }

}

?>