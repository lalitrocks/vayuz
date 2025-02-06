<?php

defined('BASEPATH') or exit('No direct script access allowed');



class User_education_model extends CI_Model
{

    public function insert_batch_university($university, $course, $insert_id)
    {
        if (!empty($university) && sizeof($university) === sizeof($course)) {
            $res = array();
            foreach ($university as  $key => $value) {
                $data = [
                    'admin_id' => $insert_id,
                    'university' => $value,
                    'course' => $course[$key],
                    'created_at' => date('y-m-d h:i:s'),
                    'updated_at' => date('y-m-d h:i:s')
                ];
                array_push($res, $data);
            }

            $this->db->insert_batch('user_education', $res);
        }
    }

    public function update_batch_university($university, $course, $university_id){
        if (!empty($university) && sizeof($university) === sizeof($course)) {

            foreach ($university as  $key => $value) {
                $data = [
                    'university' => $value,
                    'course' => $course[$key],
                    'updated_at' => date('y-m-d h:i:s')
                ];

                if (empty($university_id[$key])) {
                    $data['admin_id'] = $this->input->post('id');
                    $data['created_at'] = date('y-m-d h:i:s');

                    $this->db->insert('user_education', $data);
                } else {

                    $this->db->where('id', $university_id[$key])->update('user_education', $data);
                }
            }
        }
    }


   
}
