<?php
namespace Firebase\JWT;

require_once APPPATH . 'third_party/Jwt/JWT.php';
require_once APPPATH . 'third_party/Jwt/CachedKeySet.php';
require_once APPPATH . 'third_party/Jwt/ExpiredException.php';
require_once APPPATH . 'third_party/Jwt/JWK.php';
require_once APPPATH . 'third_party/Jwt/JWTExceptionWithPayloadInterface.php';
require_once APPPATH . 'third_party/Jwt/Key.php';
require_once APPPATH . 'third_party/Jwt/SignatureInvalidException.php';


class BeforeValidException extends \UnexpectedValueException implements JWTExceptionWithPayloadInterface
{
    private object $payload;

    public function setPayload(object $payload): void
    {
        $this->payload = $payload;
    }

    public function getPayload(): object
    {
        return $this->payload;
    }
}
