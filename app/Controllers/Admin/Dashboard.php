<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
	public function index()
    {
        // pr(session()->get());
        $data['title'] = "Dashboard";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);
        
        echo view('admin/dashboard/index', $data);        
        echo view('admin/common/footer', $data);
    }


    public function teacher_dashboard()
    {
        $data['title'] = "Teacher Dashboard";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);
        
        echo view('admin/dashboard/teacher', $data);        
        echo view('admin/common/footer', $data);
    }

    public function student_dashboard()
    {
        $data['title'] = "Student Dashboard";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);
        // pr(session()->get());
        echo view('admin/dashboard/student', $data);        
        echo view('admin/common/footer', $data);
    }

    public function nonteaching_dashboard()
    {
        $data['title'] = "Nonteaching Dashboard";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);
        
        echo view('admin/dashboard/nonteaching', $data);        
        echo view('admin/common/footer', $data);
    }

    public function groupd_dashboard()
    {
        $data['title'] = "Groupd Dashboard";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);
        
        echo view('admin/dashboard/groupd', $data);        
        echo view('admin/common/footer', $data);
    }

    public function principal_dashboard()
    {
        $data['title'] = "Principal Dashboard";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);
        
        echo view('admin/dashboard/principal', $data);        
        echo view('admin/common/footer', $data);
    }

    public function vendor_dashboard()
    {
        $data['title'] = "Vendor Dashboard";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);
        
        echo view('admin/dashboard/vendor', $data);        
        echo view('admin/common/footer', $data);
    }

    public function generate_password()
    {
        $data['title'] = "Generate Password";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);
        
        echo view('admin/generate-password', $data);        
        echo view('admin/common/footer', $data);
    }

    public function get_encrypt_password()
    {
        $password = $this->request->getPost('password');

        if (!empty($password)) {
            $hash = password_hash($password, PASSWORD_DEFAULT);

            return $this->response->setJSON([
                'status' => true,
                'hash'   => $hash
            ]);
        }

        return $this->response->setJSON([
            'status' => false,
            'hash'   => ''
        ]);
    }
}