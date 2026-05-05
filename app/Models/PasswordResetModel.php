<?php namespace App\Models;

use CodeIgniter\Model;

class PasswordResetModel extends Model
{
    protected $table = 'password_resets';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'email', 
        'user_id', 
        'token', 
        'created_at', 
        'expires_at',  
    ];

    /**
     * Create password reset token using admin_users table
     */
    public function createToken($email)
    {
        $db = \Config\Database::connect();

        // Fetch admin user by email
        $user = $db->table('admin_users')
                   ->select('id, email')
                   ->where('email', $email)
                   ->get()
                   ->getRowArray();

        if (!$user) {
            return false; // email not found
        }

        // 2️⃣ Remove old tokens for this user
        $this->where('user_id', $user['id'])->delete();

        // 3️⃣ Generate secure token
        $token = bin2hex(random_bytes(32));

        // 4️⃣ Expiry time (1 hour)
        $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // 5️⃣ Insert reset record
        $this->insert([
            'user_id'    => $user['id'],
            'email'      => $user['email'],
            'token'      => $token,
            'created_at' => date('Y-m-d H:i:s'),
            'expires_at' => $expiresAt
        ]);

        return $token;
    }
    
    /**
     * Validate token
     */
    public function validateToken($token)
    {
        $record = $this->where('token', $token)
                      ->where('expires_at >', date('Y-m-d H:i:s'))
                      ->first();
        
        return $record ?: false;
    }
    
    /**
     * Delete token after use
     */
    public function deleteToken($token)
    {
        return $this->where('token', $token)->delete();
    }
}