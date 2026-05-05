<?php
namespace App\Models;
use CodeIgniter\Model;

class MenusModel extends Model
{
    protected $table      = 'menus';
    protected $primaryKey = 'id'; // or whatever your PK is

    protected $allowedFields = [
        'parent_id', 
        'title', 
        'icon', 
        'url', 
        'sort_order', 
        'is_active', 
        'created_at', 
        'updated_at', 
    ];


    function getMenuByDept($dept_id = null) {
        if( !isset($dept_id) || $dept_id == '' ) 
            return [];

        $builder = $this->db->table('menus m');
        $builder->select('m.*');
        $builder->join('menu_role_permissions mrp', 'mrp.menu_id = m.id'); // or menu_role_permissions
        $builder->where('mrp.dept_id', 1);
        $builder->where('m.is_active', 1);
        $builder->orderBy('m.title', 'ASC')
                ->orderBy('m.sort_order', 'ASC');
        $result = $builder->get()->getResultArray();

        return $result;
    }

    function getMenuByUser($user_id = null) {
        if (!isset($user_id) || $user_id == '') 
            return [];

        $builder = $this->db->table('menus m');
        $builder->select('m.*');
        $builder->join('menu_user_permissions mup', 'mup.menu_id = m.id');
        $builder->where('mup.user_id', $user_id);
        $builder->where('mup.can_view', 1);   // ✅ only menus user can view
        $builder->where('m.is_active', 1);
        $builder->orderBy('m.title', 'ASC');
        // $builder->orderBy('m.sort_order', 'ASC')
        //         ->orderBy('m.title', 'ASC');

        return $builder->get()->getResultArray();
    }

    public function getMenuTree()
    {
        $menus = $this->where('is_active', 1)
                      ->orderBy('title', 'ASC')
                      ->findAll();

        $tree = [];
        foreach ($menus as $menu) {
            if (empty($menu['parent_id'])) {
                $tree[$menu['id']] = $menu;
                $tree[$menu['id']]['children'] = [];
            }
        }

        foreach ($menus as $menu) {
            if (!empty($menu['parent_id']) && isset($tree[$menu['parent_id']])) {
                $tree[$menu['parent_id']]['children'][] = $menu;
            }
        }

        return $tree;
    }
}

