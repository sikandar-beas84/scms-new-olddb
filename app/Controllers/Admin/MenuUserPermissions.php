<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MenuUserPermissionsModel;
use App\Models\AdminUserModel;
use App\Models\MenusModel;


class MenuUserPermissions extends BaseController
{
	public function index() 
	{
        $data['title'] = "Menu Permissions";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);
        
        $adminUserModel = new AdminUserModel();
        $data['users'] = $adminUserModel->where('status', 't')->findAll();

        $menusModel = new MenusModel();
        $data['menus'] = $menusModel->whereNotIn('id', [19])->orderBy('id', 'ASC')->findAll();
        
        // echo "<pre>"; print_r($data); die();
        
        echo view('admin/menu-user-permissions/list', $data);  
        echo view('admin/common/footer', $data);
	}

    public function fetch()
    {
        $menuUserPermissionsModel = new MenuUserPermissionsModel();
        $permissions = $menuUserPermissionsModel->getPermissionsWithDetails();

        return $this->response->setJSON(['permissions' => $permissions]);
    }

    public function store()
    {
        if ($this->request->getMethod() !== 'POST') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid request method.'
            ]);
        }

        $menuUserPermissionsModel = new MenuUserPermissionsModel();

        $id = $this->request->getPost('id');
        $menu_id = $this->request->getPost('menu_id');
        $user_id = $this->request->getPost('user_id');

        // ✅ Convert checkbox "on" to 1, otherwise 0
        $can_view   = $this->request->getPost('can_view');
        $can_add    = $this->request->getPost('can_add');
        $can_edit   = $this->request->getPost('can_edit');
        $can_delete = $this->request->getPost('can_delete');

        $data = [
            'menu_id' => $menu_id,
            'user_id'   => $user_id,
            'can_view'     => $can_view,
            'can_add'     => $can_add,
            'can_edit'     => $can_edit,
            'can_delete'     => $can_delete,
        ];

        if ($id) {
            // UPDATE
            if ($menuUserPermissionsModel->update($id, $data)) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Permission updated successfully.'
                ]);
            }
        } else {
            // ✅ Check for existing record before inserting
            $exists = $menuUserPermissionsModel
                        ->where('menu_id', $menu_id)
                        ->where('user_id', $user_id)
                        ->first();

            if ($exists) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Permission already exists for this user and menu.'
                ]);
            }

            // INSERT
            if ($menuUserPermissionsModel->insert($data)) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Permission added successfully.'
                ]);
            }
        }

        // If failed
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Database operation failed.'
        ]);
    }

    public function get_menu_permissions()
    {
        $id = $this->request->getPost('id');

        $menuUserPermissionsModel = new MenuUserPermissionsModel();
        $menu_permissions = $menuUserPermissionsModel->where('id', $id)->first();

        return $this->response->setJSON(['status' => 'success', 'menu_permissions' => $menu_permissions]);
    }

    public function setMenuView()
    {
        $id = $this->request->getPost('id');
        $is_checked = $this->request->getPost('is_checked');

        $menuUserPermissionsModel = new MenuUserPermissionsModel();
        $response = $menuUserPermissionsModel->update($id, ['can_view' => $is_checked]);

        if($response) {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'false']);
        }
    }

    /**
     * ===================================================================
     * New Code
     * ===================================================================
     * */
    public function newpermission()
    {
        $data['title'] = "Menu Permissions";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);
        
        $adminUserModel = new AdminUserModel();
        $data['users'] = $adminUserModel
            ->select('admin_users.*, dept.name AS dept_name')
            ->join('dept', 'dept.id = admin_users.dept_id', 'left')
            ->where('admin_users.status', true) // boolean 't'
            ->whereNotIn('admin_users.dept_id', [3, 7]) // ✅ exclude Student & Vendor   
            ->orderBy('admin_users.first_name', 'ASC')
            ->findAll();

        
        $menusModel = new MenusModel();
        $data['menus'] = $menusModel->getMenuTree();
        
        echo view('admin/menu-user-permissions/new-list', $data);  
        echo view('admin/common/footer', $data);
    }

    public function getUserPermissions()
    {
        $userId = $this->request->getPost('user_id');

        $permModel = new MenuUserPermissionsModel();
        $rows = $permModel->where('user_id', $userId)->findAll();

        $data = [];
        foreach ($rows as $r) {
            $data[$r['menu_id']] = $r['can_view'];
        }

        return $this->response->setJSON($data);
    }

    public function save()
    {
        $userId = $this->request->getPost('user_id');
        $menus  = $this->request->getPost('menus');

        if (!$userId) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid user'
            ]);
        }
        
        $permModel = new MenuUserPermissionsModel();

        $permModel->where('user_id', $userId)->delete();

        if ($menus) {
            foreach ($menus as $menuId) {
                $permModel->insert([
                    'user_id'  => $userId,
                    'menu_id'  => $menuId,
                    'can_view' => 1,
                    'can_add' => 1,
                    'can_edit' => 1,
                    'can_delete' => 1,
                ]);
            }
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Permissions saved'
        ]);
    }


}