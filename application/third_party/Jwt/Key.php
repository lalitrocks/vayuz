<?php

namespace Firebase\JWT;
require_once APPPATH . 'third_party/Jwt/BeforeValidException.php';
require_once APPPATH . 'third_party/Jwt/CachedKeySet.php';
require_once APPPATH . 'third_party/Jwt/ExpiredException.php';
require_once APPPATH . 'third_party/Jwt/JWK.php';
require_once APPPATH . 'third_party/Jwt/JWTExceptionWithPayloadInterface.php';
require_once APPPATH . 'third_party/Jwt/JWT.php';
require_once APPPATH . 'third_party/Jwt/SignatureInvalidException.php';
use InvalidArgumentException;
use OpenSSLAsymmetricKey;
use OpenSSLCertificate;
use TypeError;

class Key
{
    /**
     * @param string|resource|OpenSSLAsymmetricKey|OpenSSLCertificate $keyMaterial
     * @param string $algorithm
     */
    public function __construct(
         $keyMaterial,
         string $algorithm
    ) {
        if (
            !\is_string($keyMaterial)
            && !$keyMaterial instanceof OpenSSLAsymmetricKey
            && !$keyMaterial instanceof OpenSSLCertificate
            && !\is_resource($keyMaterial)
        ) {
            throw new TypeError('Key material must be a string, resource, or OpenSSLAsymmetricKey');
        }

        if (empty($keyMaterial)) {
            throw new InvalidArgumentException('Key material must not be empty');
        }else{
            $this->keyMaterial = $keyMaterial;

        }

        if (empty($algorithm)) {
            throw new InvalidArgumentException('Algorithm must not be empty');
        }else{
            $this->algorithm = $algorithm;
        }
    }

    /**
     * Return the algorithm valid for this key
     *
     * @return string
     */
    public function getAlgorithm(): string
    {
        return $this->algorithm;
    }

    /**
     * @return string|resource|OpenSSLAsymmetricKey|OpenSSLCertificate
     */
    public function getKeyMaterial()
    {
        return $this->keyMaterial;
    }
}
