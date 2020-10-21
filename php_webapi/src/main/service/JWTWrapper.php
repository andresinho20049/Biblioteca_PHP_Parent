<?php
namespace Andre\Service;
use \Firebase\JWT\JWT;
 
/**
 * Gerenciamento de tokens JWT
 */
class JWTWrapper
{
    const KEY = 'bc9800b9d52a24cce72a73dd528afed53f10e5fc'; // chave
 
    /**
     * Geracao de um novo token jwt
     */
    public static function encode(array $options)
    {
        $issuedAt = time();
        $expire = $issuedAt + $options['expiration_sec']; // tempo de expiracao do token
 
        $tokenParam = [
            'iat'  => $issuedAt,            // timestamp de geracao do token
            'iss'  => $options['iss'],      // dominio, pode ser usado para descartar tokens de outros dominios
            'exp'  => $expire,              // expiracao do token
            'nbf'  => $issuedAt - 1,        // token nao eh valido Antes de
            'data' => $options['userdata'], // Dados do usuario logado
        ];
 
        return JWT::encode($tokenParam, self::KEY);
    }
 
    /**
     * Decodifica token jwt
     */
    public static function decode($jwt)
    {
        return JWT::decode($jwt, self::KEY, ['HS256']);
    }
}
?>