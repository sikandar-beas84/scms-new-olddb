<?php
namespace App\Models;
use CodeIgniter\Model;

class LoginSessionModel extends Model
{
    protected $table      = 'login_sessions';
    protected $primaryKey = 'id'; // or whatever your PK is

    protected $allowedFields = [
        'user_id', 
        'login_time', 
        'logout_time', 
        'is_active', 
        'last_activity',
    ];

}

