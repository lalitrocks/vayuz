<?php

defined('BASEPATH') or exit('No direct script access allowed');



class User_company_model extends CI_Model
{
    public function insert_batch_company($company, $jobprofile, $insert_id)
    {

        if (!empty($company) && sizeof($jobprofile) === sizeof($company)) {
            $res = array();

            foreach ($company as  $key => $value) {
                $data = [
                    'admin_id' => $insert_id,
                    'company_name' => $value,
                    'job_profile' => $jobprofile[$key],
                    'created_at' => date('y-m-d h:i:s'),
                    'updated_at' => date('y-m-d h:i:s')
                ];
                array_push($res, $data);
            }

            $this->db->insert_batch('user_employment', $res);
        }
    }
    public function update_batch_company($company, $jobprofile, $company_id) {
        if (!empty($company) && sizeof($jobprofile) === sizeof($company)) {

            foreach ($company as  $key => $value) {
                $data = [
                    'company_name' => $value,
                    'job_profile' => $jobprofile[$key],
                    'updated_at' => date('y-m-d h:i:s')
                ];
                if (empty($company_id[$key])) {
                    $data['admin_id'] = $this->input->post('id');
                    $data['created_at'] = date('y-m-d h:i:s');

                    $this->db->insert('user_employment', $data);
                } else {

                    $this->db->where('id', $company_id[$key])->update('user_employment', $data);
                }
            }
        }
    }
}
