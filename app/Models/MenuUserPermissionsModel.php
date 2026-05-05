<?php
namespace App\Models;
use CodeIgniter\Model;

class MenuUserPermissionsModel extends Model
{
    protected $table      = 'menu_user_permissions';
    protected $primaryKey = 'id'; // or whatever your PK is

    protected $allowedFields = [
        'menu_id', 
        'user_id', 
        'can_view', 
        'can_add', 
        'can_edit', 
        'can_delete', 
        'created_at',
    ];


    public function getPermissionsWithDetails()
    {
        return $this->select('
                    menu_user_permissions.*,
                    admin_users.first_name,
                    admin_users.last_name,
                    menus.title AS menu_title
                ')
                ->join('admin_users', 'admin_users.id = menu_user_permissions.user_id')
                ->join('menus', 'menus.id = menu_user_permissions.menu_id')
                ->whereNotIn('menu_user_permissions.menu_id', [19])
                ->findAll();
    }

}

