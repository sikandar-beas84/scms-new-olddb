<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;

use App\Models\AdminUserModel;


class Profile extends BaseController
{
	public function index()
	{
		$data['title'] = "Profile";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);
        
        $data['f_name'] = $this->session->get('f_name');
        $data['user_id'] = $userId = $this->session->get('user_id');

        $adminUserModel = new AdminUserModel();
        $data['user_details'] = $adminUserModel->find($userId);

        echo view('admin/profile/index', $data);  

        echo view('admin/common/footer', $data);
	}

	public function update_profile()
	{

	}

	public function update_password()
	{
		$data['title'] = "Update Password";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);
        
        $data['f_name'] = $this->session->get('f_name');
        $data['user_id'] = $this->session->get('user_id');

        echo view('admin/profile/password-update', $data);  

        echo view('admin/common/footer', $data);
	}

	public function ajax_update_profile_password()
	{
		$current = $this->request->getPost('current_password');
	    $new = $this->request->getPost('new_password');
	    $confirm = $this->request->getPost('confirm_password');

        $userId = $this->session->get('user_id');
        if (!$userId) {
	        return $this->response->setJSON([
	            'status' => 'error',
	            'message' => 'Session expired! Please login again.'
	        ]);
	    }

	    // Empty field validation
	    if (empty($current) || empty($new) || empty($confirm)) {
	        return $this->response->setJSON([
	            'status' => 'error',
	            'message' => 'All fields are required.'
	        ]);
	    }

	    // Check new password + confirm
	    if ($new !== $confirm) {
	        return $this->response->setJSON([
	            'status' => 'error',
	            'message' => 'New password & confirm password do not match.'
	        ]);
	    }

	    // Strong password check
	    if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/', $new)) {
		    return $this->response->setJSON([
		        'status' => 'error',
		        'message' => 'Password must be at least 8 characters, include uppercase, lowercase, number & special character.'
		    ]);
		}


        $adminUserModel = new AdminUserModel();
        $user = $adminUserModel->find($userId);

	    // user not found
	    if (!$user) {
	        return $this->response->setJSON([
	            'status' => 'error',
	            'message' => 'User not found.'
	        ]);
	    }

	    // Check current password
	    if (!password_verify($current, $user['password'])) {
	        return $this->response->setJSON([
	            'status' => 'error',
	            'message' => 'Current password is incorrect.'
	        ]);
	    }

	    // Update password
	    $adminUserModel->update($userId, [
	        'password' => password_hash($new, PASSWORD_DEFAULT)
	    ]);

	    return $this->response->setJSON([
	        'status' => 'success',
	        'message' => 'Password updated successfully.'
	    ]);
	}

	public function uploadPhoto()
    {
    	$userId = $this->session->get('user_id');
        if (!$userId) {
	        return $this->response->setJSON([
	            'status' => 'error',
	            'message' => 'Session expired! Please login again.'
	        ]);
	    }

	    $adminUserModel = new AdminUserModel();
        $user = $adminUserModel->find($userId);
        
        // user not found
	    if (!$user) {
	        return $this->response->setJSON([
	            'status' => 'error',
	            'message' => 'User not found.'
	        ]);
	    }

        helper(['filesystem']);

        // CAMERA IMAGE
        if ($this->request->getPost('camera_image')) {
            $img = $this->request->getPost('camera_image');
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = base64_decode($img);

            $filename = 'profile_' . time() . '.png';
            file_put_contents(FCPATH . 'uploads/profile/' . $filename, $img);
        }

        // FILE UPLOAD
        if ($file = $this->request->getFile('photo')) {
            if ($file->isValid()) {
                $filename = $file->getRandomName();
                $file->move(FCPATH . 'uploads/profile/', $filename);
            }
        }

        // SAVE TO DB HERE (optional)
        // AdminUserModel update profile_image
        $adminUserModel->update($userId, [
	        'image' => $filename
	    ]);

        // ✅ UPDATE SESSION VALUE
    	$this->session->set('userimage', $filename);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Profile photo uploaded successfully'
        ]);
    }
}