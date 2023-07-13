<?php

namespace App\Services;

use App\Models\User;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class FirebaseJwtAuth
{
    public function createToken(User $user)
    {
        $payload = [
            'sub' => $user->id,
            'iat' => time(),
            'exp' => time() + config('jwt.ttl')
        ];

        return JWT::encode($payload, config('jwt.secret'), 'HS256');
    }

    public function verifyToken($token): false|\stdClass
    {
        try {
            return JWT::decode($token, new Key(config('jwt.secret'), 'HS256'));
        } catch (Exception $e) {
            return false;
        }
    }
}
