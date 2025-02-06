<?php

namespace Firebase\JWT;
require_once APPPATH . 'third_party/Jwt/BeforeValidException.php';
require_once APPPATH . 'third_party/Jwt/CachedKeySet.php';
require_once APPPATH . 'third_party/Jwt/ExpiredException.php';
require_once APPPATH . 'third_party/Jwt/JWK.php';
require_once APPPATH . 'third_party/Jwt/JWTExceptionWithPayloadInterface.php';
require_once APPPATH . 'third_party/Jwt/Key.php';
require_once APPPATH . 'third_party/Jwt/JWT.php';
class SignatureInvalidException extends \UnexpectedValueException
{
}
