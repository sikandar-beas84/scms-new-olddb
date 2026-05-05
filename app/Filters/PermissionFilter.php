<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Config\Database;

class PermissionFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // 1️⃣ Check login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('user_id');

        // 2️⃣ Get full path
        $currentPath = '/' . trim($request->getUri()->getPath(), '/');

        // Example:
        // /dashboard
        // /admin/student/student-list

        // 3️⃣ Skip permission check for dashboard
        if ($currentPath === '/dashboard') {
            return;
        }

        $db = Database::connect();

        // 4️⃣ Find matching menu
        $menu = $db->table('menus')
                   ->where('url', $currentPath)
                   ->where('is_active', 1)
                   ->get()
                   ->getRow();

        // If URL not defined in menus → skip checking
        if (!$menu) {
            return;
        }

        // 5️⃣ Check can_view permission
        $permission = $db->table('menu_user_permissions')
                         ->where([
                             'menu_id' => $menu->id,
                             'user_id' => $userId,
                             'can_view' => 1
                         ])
                         ->get()
                         ->getRow();

        if (!$permission) {
            return redirect()->to('/dashboard')
                             ->with('error', 'You do not have permission to access this page.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
