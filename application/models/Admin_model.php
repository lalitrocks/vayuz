<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Admin_model extends CI_Model
{
    public function create_user()
    {

        $data = array(
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'username' => $this->input->post('username'),
            'password' => md5($this->input->post('password')),
            'role' => $this->input->post('role'), // admin:normal user
            'last_log_in' => 0,
            'created_at' => date('y-m-d h:i:s'),
            'updated_at' => date('y-m-d h:i:s')
        );

        if ($this->db->insert('admin', $data)) {
            return true;
        } else {
            return false;
        };
    }

    public function create_user_via_admin()
    {

        $data = [
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'username' => $this->input->post('username'),
            'password' => md5($this->input->post('password')),
            'role' => '0',
            'last_log_in' => 0,
            'created_at' => date('y-m-d h:i:s'),
            'updated_at' => date('y-m-d h:i:s')
        ];


        //Start -- download image

        if ($this->input->post('base64crop')) {
            # code...
            $folderPath = 'assets/images/';
            $image_parts = explode(";base64,", $this->input->post('base64crop'));
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $name = uniqid() . '.jpg';
            $data['profile_img'] = $name;
            $file = $folderPath . $name;
            file_put_contents($file, $image_base64);
        }else if (!empty($_FILES['profile_img']['name'])) {
            // If no file is uploaded, return an error message
            $img_res = $this->upload_img();
            if (!$img_res['success']) {
                send_output(['msg' => strip_tags($img_res['msg'])], '400');
            } else {
                $data['profile_img'] = $img_res['path'];
            }
        }
        //End -- download image


        if ($this->db->insert('admin', $data)) {
            return true;
        } else {
            return false;
        };
    }

    public function update_user_via_admin()
    {
        $data = [
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'username' => $this->input->post('username'),
            'updated_at' => date('y-m-d h:i:s')
        ];

        if ($this->input->post('password')) {
            $data['password'] = md5($this->input->post('password'));
        }

        //Start -- download image

        if ($this->input->post('base64crop')) {
            # code...
            $folderPath = 'assets/images/';
            $image_parts = explode(";base64,", $this->input->post('base64crop'));
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $name = uniqid() . '.jpg';
            $data['profile_img'] = $name;
            $file = $folderPath . $name;
            file_put_contents($file, $image_base64);
        }else if (!empty($_FILES['profile_img']['name'])) {
            // If no file is uploaded, return an error message
            $img_res = $this->upload_img();
            if (!$img_res['success']) {
                send_output(['msg' => strip_tags($img_res['msg'])], '400');
            } else {
                $data['profile_img'] = $img_res['path'];
            }
        }
        //End -- download image

        $this->db->where('admin_id', $this->input->post('id'))->update('admin', $data);
    }

    protected function upload_img()
    {

        $config['upload_path'] = './assets/images';  // Path where you want to save the file
        $config['allowed_types'] = 'jpg|jpeg|png';  // Allowed file types
        $config['max_size'] = 2048;  // Max file size in KB (2MB)
        $config['encrypt_name'] = TRUE;  // Encrypt the file name for uniqueness

        // Initialize the upload library with the config
        $this->upload->initialize($config);

        if ($this->upload->do_upload('profile_img')) {  // 'userfile' is the name of the input field
            // If upload is successful
            $data = $this->upload->data();
            $image_path =  $data['file_name'];  // Path to the uploaded image

            return ['success' => true, 'path' => $image_path];
        } else {
            // If upload fails
            $error = $this->upload->display_errors();
            return ['success' => false, 'msg' => $this->upload->display_errors()];
        }
    }

    public function update_user_stamp($userdata)
    {
        $update_data = [
            'current_log_in' => date('y-m-d h:i:s'),
            'last_log_in' => $userdata->current_log_in
        ];
        if ($this->db->where('username', $userdata->username)->update('admin', $update_data)) {
            return true;
        } else {
            return false;
        }
    }

    public function is_user_already_exist($username)
    {

        $res = $this->db->where('username', $username)->get('admin');
        if ($res->num_rows()) {
            return $res;
        } else {
            return false;
        }
    }


    public function get_logged_in_userdetail($userdata)
    {
        $data = [];

        $data['user'] = $userdata;
        $data['last_log_in'] = ($userdata->last_log_in) == '0000-00-00 00:00:00' ? 'First Time Log In ' : date('d-M-Y h:i:s', strtotime($userdata->last_log_in));

        if ($userdata->role == 1) {

            $all_users = $this->db->where('role', 0)->order_by('created_at', 'DESC')->get('admin');
            $user_education = $this->db->where('admin_id', $userdata->admin_id)->get('user_education');
            $user_employment = $this->db->where('admin_id', $userdata->admin_id)->get('user_employment');

            $data['user_education'] = $user_education->result_array();
            $data['user_employment'] = $user_employment->result_array();
            $data['total_users'] = $all_users->num_rows();
            $data['last_five_users'] = json_encode(array_slice($all_users->result_array(), 0, 5));
        }


        return $data;
    }
}
