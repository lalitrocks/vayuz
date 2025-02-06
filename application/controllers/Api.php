<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller
{
    public  function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('upload');
        $this->load->model('admin_model');
        $this->load->model('user_education_model');
        $this->load->model('user_company_model');
        $this->load->library('form_validation');

        // Load the third-party library
        require_once APPPATH . 'third_party/Jwttoken.php';
    }

    public function register()
    {
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('username', 'User Name', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('c_password', 'Confirm Password', 'required');
        $this->form_validation->set_rules('role', 'Role', 'required');
        if ($this->form_validation->run() == FALSE) {
            //checking required fields
            send_output(['msg' => 'Please fill all the required field'], '400');
        } else if ($this->input->post('password') !== $this->input->post('c_password')) {
            //checking password and confirm password

            send_output(['msg' => 'Password and confirm password are not same'], '400');
        } else {

            $res = $this->db->where('username', $this->input->post('username'))->get('admin');
            if ($res->num_rows()) {

                //user already exist
                send_output(['msg' => 'User already exist'], '400');
            } else {
                //storing a new user
                if ($this->admin_model->create_user()) {
                    send_output(['msg' => 'Account created successfully.Please Login'], '200');
                } else {
                    send_output(['msg' => 'Account Not created successfully.'], '400');
                };
            }
        }
    }

    public function login()
    {

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() == FALSE) {

            //checking required fields
            send_output(['msg' => 'Please fill all the required field'], '400');
        } else {
            $res = $this->admin_model->is_user_already_exist($this->input->post('username'));
            if ($res) {

                if (md5($this->input->post('password')) !== $res->row()->password) {
                    //password not match
                    send_output(['msg' => 'Invalid Credentials'], '400');
                } else {

                    $issued_at = time();
                    $payload = [
                        'username' => $res->row()->username,
                        'role' => $res->row()->role == 1 ? 'admin' : 'user',
                        'logged_in' => true,
                        "iat" => $issued_at,  // Issued at time
                        "exp" => $issued_at + 1500, //expiry time
                    ];
                    $key = $this->config->item('hash_key');
                    //generate token
                    $token  = Jwttoken::create_token($payload, $key);

                    //update last and current log in
                    if ($this->admin_model->update_user_stamp($res->row())) {

                        send_output(['msg' => 'Login Successfully', 'role' => $res->row()->role == 1 ? 'admin' : 'user', 'token' => $token], '200');
                    } else {

                        send_output(['msg' => 'Login Not Successfully'], '400');
                    }
                }
            } else {
                send_output(['msg' => 'user not exist'], '400');
            }
        }
    }

    public function get_logged_in_userdetail()
    {
        //check token
        $tokendata = bearer_token_is_valid();

        if ($tokendata !== null) {
            $user = $this->admin_model->is_user_already_exist($tokendata->username);
            //user already exist
            if ($user) {
                //load user data
                $data = $this->admin_model->get_logged_in_userdetail($user->row());
                send_output($data, '200');
            } else {
                send_output(['msg' => 'User data not found'], '400');
            }
        } else {
            send_output(['msg' => 'Token is invalid'], '500');
        }
    }

    public function add_user()
    {
        //checking a token is valid .. not expired..
        $tokendata = bearer_token_is_valid();
        if ($tokendata !== null) {

            $this->form_validation->set_rules('first_name', 'First Name', 'required');
            $this->form_validation->set_rules('last_name', 'Last Name', 'required');
            $this->form_validation->set_rules('username', 'User Name', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('c_password', 'Confirm Password', 'required');

            if ($this->form_validation->run() == FALSE) {

                //checking required fields
                send_output(['msg' => 'Please fill all the required field'], '400');
            } else if ($this->input->post('password') !== $this->input->post('c_password')) {

                //password and confirm password not same 

                send_output(['msg' => 'Password and confirm password are not same'], '400');
            } else {

                $res = $this->db->where('username', $this->input->post('username'))->get('admin');
                if ($res->num_rows()) {
                    send_output(['msg' => 'username already taken'], '400');
                }

                // insert user
                $this->admin_model->create_user_via_admin();

                $insert_id = $this->db->insert_id();

                // insert university of user
                $university = $this->input->post('university[]');
                $course = $this->input->post('course[]');
                $this->user_education_model->insert_batch_university($university, $course, $insert_id);

                // insert Company of user
                $company = $this->input->post('company[]');
                $jobprofile = $this->input->post('jobprofile[]');
                $this->user_company_model->insert_batch_company($company, $jobprofile, $insert_id);

                send_output(['msg' => 'User added successfully'], '200');
            }
        } else {
            send_output(['msg' => 'Token is invalid'], '500');
        }
    }

    public function edit_user()
    {
        //above function and below function can be merged but for sinmplicity and readability i have kept them seperate 

        //checking a token is valid .. not expired..
        $tokendata = bearer_token_is_valid();
        if ($tokendata !== null && $this->input->post('id') && is_numeric($this->input->post('id'))) {
            if ($this->input->post('username') === null ||  $this->input->post('first_name') === null  || $this->input->post('last_name') === null) {
                //checking required fields

                send_output(['msg' => 'Please fill all the required field'], '400');
            } else if ($this->input->post('password') !== $this->input->post('c_password')) {
                //password and confirm password not same 

                send_output(['msg' => 'Password and confirm password are not same'], '400');
            } else {
                //Start -- update user
                $res = $this->db->where('username', $this->input->post('username'))->where('admin_id!=', $this->input->post('id'))->get('admin');
                if ($res->num_rows()) {
                    send_output(['msg' => 'username already taken'], '400');
                }

                //start -- update user
                $this->admin_model->update_user_via_admin();

                //Start -- insert or update university of user
                $university = $this->input->post('university[]');
                $university_id = $this->input->post('university_id[]');
                $course = $this->input->post('course[]');
                $this->user_education_model->update_batch_university($university, $course, $university_id);

                //Start -- insert or update Company of user
                $company = $this->input->post('company[]');
                $company_id = $this->input->post('company_id[]');
                $jobprofile = $this->input->post('jobprofile[]');
                $this->user_company_model->update_batch_company($company, $jobprofile, $company_id);

                send_output(['msg' => 'User Updated successfully'], '200');
            }
        } else {
            send_output(['msg' => 'Token is invalid'], '500');
        }
    }

    public function get_user_detail_by_id()
    {
        $tokendata = bearer_token_is_valid();

        if ($tokendata !== null && $this->input->post('id')) {
            $user = $this->db->where('admin_id', $this->input->post('id'))->get('admin');

            if ($user->num_rows()) {
                $user_education = $this->db->where('admin_id', $this->input->post('id'))->get('user_education');
                $user_employment = $this->db->where('admin_id', $this->input->post('id'))->get('user_employment');
                send_output(['user' => $user->row(), 'user_education' => $user_education->result_array(), 'user_employment' => $user_employment->result_array()], '200');
            } else {
                send_output(['msg' => 'User data not found'], '400');
            }
        } else {
            send_output(['msg' => 'Token is invalid'], '500');
        }
    }

    public function admin_access_page()
    {
        //if a user is admin
        $tokendata = bearer_token_is_valid();

        if ($tokendata !== null) {
            if ($tokendata->role !== 'admin') {
                send_output([], '404');
            } else {
                send_output([], '200');
            }
        } else {
            send_output(['msg' => 'Token is invalid'], '500');
        }
    }
}
