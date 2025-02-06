<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'third_party/Jwt/Jwt.php';

require_once APPPATH . 'third_party/Jwt/Key.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Jwttoken
{

    public static function create_token($payload, $key)
    {
        return JWT::encode($payload, $key, 'HS256');
    }


    public static function decode_token($jwt, $key)
    {
        try {
            // Decode the JWT (it will verify the signature and validate the claims)
            $decoded = JWT::decode($jwt, new Key($key, 'HS256')); // Specify the algorithm used (HS256 is typical)

            // If decoding is successful, the token is valid
            return $decoded; // Output the decoded data (claims)
        } catch (Exception $e) {
            // Catch errors like invalid token or expired token
            return null;
        }
    }
}
