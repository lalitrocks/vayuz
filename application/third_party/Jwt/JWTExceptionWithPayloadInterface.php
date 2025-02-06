<?php
namespace Firebase\JWT;
require_once APPPATH . 'third_party/Jwt/BeforeValidException.php';
require_once APPPATH . 'third_party/Jwt/CachedKeySet.php';
require_once APPPATH . 'third_party/Jwt/ExpiredException.php';
require_once APPPATH . 'third_party/Jwt/JWK.php';
require_once APPPATH . 'third_party/Jwt/JWT.php';
require_once APPPATH . 'third_party/Jwt/Key.php';
require_once APPPATH . 'third_party/Jwt/SignatureInvalidException.php';
interface JWTExceptionWithPayloadInterface
{
    /**
     * Get the payload that caused this exception.
     *
     * @return object
     */
    public function getPayload(): object;

    /**
     * Get the payload that caused this exception.
     *
     * @param object $payload
     * @return void
     */
    public function setPayload(object $payload): void;
}
