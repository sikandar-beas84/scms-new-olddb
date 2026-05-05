<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTAuth implements FilterInterface
{
    private $key = "MyVeryStrongSecretKey1234567890@#$";

    public function before(RequestInterface $request, $arguments = null)
    {
        // More reliable way to get header
        $authHeader = $_SERVER['HTTP_AUTHORIZATION']
            ?? $_SERVER['REDIRECT_HTTP_AUTHORIZATION']
            ?? $_SERVER['HTTP_X_AUTHORIZATION']
            ?? null;

        if (!$authHeader) {
            return service('response')
                ->setJSON(['status' => false, 'message' => 'Token Required'])
                ->setStatusCode(401);
        }

        // Check Bearer format
        if (!preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            return service('response')
                ->setJSON(['status' => false, 'message' => 'Invalid Token Format'])
                ->setStatusCode(401);
        }

        $token = $matches[1];

        try {
            $decoded = JWT::decode($token, new Key($this->key, 'HS256'));

            // VERY IMPORTANT: pass user data forward
            $request->user = $decoded->data ?? null;

        } catch (\Exception $e) {
            return service('response')
                ->setJSON([
                    'status' => false,
                    'message' => 'Invalid or Expired Token'
                ])
                ->setStatusCode(401);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}