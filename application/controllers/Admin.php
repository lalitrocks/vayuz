<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public  function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
    }

    public function index(){
        $this->login();
    }

    public function login()
    {

        $data['title'] ='Admin panel';
        $this->load->view('admin/admin_login', $data);
    }

    public function register()
    {
        $data['title'] ='Admin register';
        $this->load->view('admin/admin_login', $data);
    }

    public function dashboard()
    {
        $data['page'] = 'dashboard';
        $data['title'] = 'admin dashboard';
        
        $this->load->view('admin/index', $data);

    }

    public function users()
    {

        $data['page'] = 'users';
        $data['title'] = 'admin blog panel';

        $this->load->view('admin/index', $data);
    }

    public function user_add()
    {

        $data['page'] = 'user_add';
        $data['title'] = 'admin add user';

        $this->load->view('admin/index', $data);
    }

    public function user_edit()
    {
        if (!empty($this->uri->segment(3))) {
            $data['page'] = 'user_add';
            $data['title'] = 'admin edit user';
            $data['user_id'] = $this->uri->segment(3);

            $this->load->view('admin/index', $data);
        }else{
            redirect('admin/dashboard');
        }
    }

    public function profile(){
        $data['page'] = 'profile';
        $data['title'] = 'Profile';
        
        $this->load->view('admin/index', $data);
    }

    public function test(){
        $this->load->view('admin/test');

    }
  
}
