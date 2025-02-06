<?php

require_once APPPATH . 'third_party/Jwttoken.php';


if (!function_exists('get_bearer_token')) {

    function get_bearer_token()
    {

        // Get the Authorization header
        $CI = &get_instance();  // Get the CI super object


        $authorizationHeader = $CI->input->get_request_header('Authorization', TRUE);

        // Check if the Authorization header exists
        if ($authorizationHeader) {
            // Split the header value "Bearer <token>" to extract the token
            $token = null;
            if (preg_match('/Bearer\s(\S+)/', $authorizationHeader, $matches)) {
                // $matches[1] will contain the token value
                $token = $matches[1];
            }

            if ($token) {
                return $token;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }
}

if (!function_exists('bearer_token_is_valid')) {

    function bearer_token_is_valid()
    {

        $token  = get_bearer_token();
        if ($token == null) {
            return null;
        }

        // Get the Authorization header
        $CI = &get_instance();  // Get the CI super object

        $key = $CI->config->item('hash_key');

        $data = Jwttoken::decode_token($token, $key);

        return $data;
    }
}


if (!function_exists('extarct_key_from_array')) {

    function extarct_key_from_array($providedkey,$arr)
    {
        $res = array();
        foreach ($arr as $key => $value) {

            if ($value['name'] === $providedkey ) {
               $res[] = $value['value']; 
            }
        }
        return $res;
    }


}


if (!function_exists('send_output')) {
    function send_output($data, $status)
    {
        echo json_encode(['data' => $data, 'status' => $status], true);
        die;
    }
}

