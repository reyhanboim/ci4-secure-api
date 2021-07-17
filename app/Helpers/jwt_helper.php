<?php

use App\Models\UserModel;
use Config\Services;
use Firebase\JWT\JWT;

function getJwtFromRequest($authHeader): string
{
    if (is_null($authHeader))
        throw new Exception('Kesalahan Penggunaan JWT');

    return explode(' ',$authHeader[1]);
}

function validationJwtFromRequest(string $encodedToken)
{
    $key = Service::getSecretKey();
    $decodedToken = JWT::decode($encodedToken, $key, ['HS256']);
    $userModel = new UserModel();
    $userModel->findUserByEmail($decodedToken->email);
}

function getSignedJwtUser(string $email)
{
    $issuedAtTime = time();
    $tokenTimeToLive = getenv('JWT_TIME_TO_LIVE');
    $tokenExpiration = $issuedAtTime + $tokenTimeToLive;
    $payload = [
        'email'     => $email,
        'iat'       => $issuedAtTime,
        'exp'       => $tokenExpiration
    ];

    $jwt = JWT::encode($payload, Services::getSecretKey());
    return $jwt;
}