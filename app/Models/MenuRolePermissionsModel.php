<?php
namespace App\Models;
use CodeIgniter\Model;

class MenuRolePermissionsModel extends Model
{
    protected $table      = 'menu_role_permissions';
    protected $primaryKey = 'id'; // or whatever your PK is

    protected $allowedFields = [
        'menu_id', 
        'menu_id', 
        'can_view', 
        'created_at', 
    ];

}

