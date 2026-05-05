<?php

namespace App\Controllers\Api;

use Firebase\JWT\JWT;
use App\Models\AdminUserModel;
use App\Models\SessionYearModel;

class Auth extends BaseApiController
{
    private $key;

    public function __construct()
    {
        $this->key = getenv('JWT_SECRET') ?: 'MyVeryStrongSecretKey1234567890@#$';
    }

    public function login()
    {
        $data = $this->request->getJSON(true);

        // Validation
        if (empty($data['username']) || empty($data['password']) || empty($data['session_year'])) {
            return $this->error("Username, Password and Session Year required", 400);
        }

        $userModel = new AdminUserModel();
        $sessionYearModel = new SessionYearModel();

        // Find user
        $user = $userModel->where('email', $data['username'])->first();

        
        if (!$user || !password_verify($data['password'], $user['password'])) {
            return $this->error("Invalid credentials", 401);
        }


        // Status check
        $statusStr = strtolower((string)($user['status'] ?? ''));
        $isActive  = in_array($statusStr, ['1', 'true', 't'], true)
                     || (is_numeric($user['status']) && (int)$user['status'] === 1);

        if (!$isActive) {
            return $this->error("Account inactive or blocked", 403);
        }

        // Session year details
        $sessionYear = $sessionYearModel->where('id', $data['session_year'])->first();

        if (!$sessionYear) {
            return $this->error("Invalid session year", 400);
        }

        // Prepare JWT payload (VERY IMPORTANT)
        $payload = [
            'iat' => time(),
            'exp' => time() + 3600,
            'data' => [
                'user_id' => $user['id'],
                'email'   => $user['email'],
                'dept_id' => $user['dept_id'],
                'code'    => $user['code'] ?? null,

                // session data (important for your system)
                'session_year_id'    => $data['session_year'],
                'session_year_name'  => $sessionYear['session_name'],
                'session_start_date' => $sessionYear['start_date'],
                'session_end_date'   => $sessionYear['end_date'],
            ]
        ];

        $token = JWT::encode($payload, $this->key, 'HS256');

        // Return JSON (NO redirect)
        return $this->success([
            'token' => $token,
            'user' => [
                'id'    => $user['id'],
                'name'  => $user['first_name'] . ' ' . $user['last_name'],
                'email' => $user['email'],
                'dept_id' => $user['dept_id'],
            ]
        ], "Login successful");
    }
}