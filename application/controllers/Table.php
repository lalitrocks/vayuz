<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Table extends CI_Controller
{
    public  function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function users()
    {
        

        $data = bearer_token_is_valid();
    

        if ($data !== null) {

            $this->db->select('*');
            $this->db->from('admin');
            $this->db->where('role', 0);
            $query = $this->db->get();

            $result = [];
            foreach ($query->result() as $row) {
                $data = [
                    'id' => $row->admin_id,
                    'username' => $row->username,
                    'last_log_in' => $row->last_log_in,

                    'action' => '
                <a class="me-2" href="' . SERVER_URL . 'admin/user_edit/' . $row->admin_id . '" ><i class="fa-solid fa-pencil"></i></a>
                
                '
                ];
                array_push($result, $data);
            }
            echo json_encode($result);
        } else {
            echo json_encode(['msg' => 'Token is invalid']);

        }
    }


}
