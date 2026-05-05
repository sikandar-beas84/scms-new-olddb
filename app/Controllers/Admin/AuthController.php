<?php
namespace App\Controllers\Admin;
use CodeIgniter\Controller;
use CodeIgniter\Email\Email;
use CodeIgniter\I18n\Time;

use App\Models\PasswordResetModel;
use App\Models\AdminUserModel;
use App\Models\LoginSessionModel;
use App\Models\SessionYearModel;
use App\Models\StudentModel;
use App\Models\StudentPersonalDetailsModel;

class AuthController extends Controller
{
    protected $email;

    public function __construct()
    {
        // Load email service
        $this->email = \Config\Services::email();
    }

	public function index()
	{
		// 
	}


 	/**
     * Show forgot password form
     */
    public function forgotPassword()
    {
    	$this->session = \Config\Services::session();
        if( $this->session->get('isLoggedIn') ) {
            return redirect()->to('/dashboard');
            exit();
        }
        
    	$data['title'] = "Forgot Password";
        echo view('admin/auth/forgot-password', $data);
    }
    
    /**
     * Process forgot password request
     */
    public function processForgotPassword()
    {

        $email = $this->request->getPost('email');
        $user_type = $this->request->getPost('user_type');

        if( $user_type == 0 ) {
            $validationRules = [
                'email' => [
                    'rules' => 'required|email_or_student',
                    'errors' => [
                        'required' => 'Email address or student code is required',
                        'email_or_student' => 'Please enter a valid email address or student code'
                    ]
                ]
            ];
        } else {
            $validationRules = [
                'email' => [
                    'rules' => 'required|valid_email',
                    'errors' => [
                        'required' => 'Email is required',
                        'valid_email' => 'Please enter a valid email address'
                    ]
                ]
            ];
        }

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        if( $user_type == 0 ) {
            $adminUserModel = new AdminUserModel();
            $studentModel = new StudentModel();
            $studentPersonalDetailsModel = new StudentPersonalDetailsModel();

            $user = $adminUserModel->where('email', $email)->first();
            $student_id = student_id_by_code($email) ?? '';

            if (!$user && empty($student_id)) {
                // For security, don't reveal that user doesn't exist
                return redirect()->to('/forgot-password')->with('message', 'If your email / student code exists in our system, you will receive a password reset link.');
            }
            
            // Create reset token
            $passwordResetModel = new PasswordResetModel();
            $token = $passwordResetModel->createToken($email);
            
            if (!$token) {
                return redirect()->back()->with('error', 'Failed to create reset token. Please try again.');
            }
            
            // Send reset email
            $resetLink = base_url("reset-password/{$token}");

            // If you enter student code then take email address from Student Personal Details
            if (!$user) {
                $student = $studentPersonalDetailsModel->select('email')->where('student_id', $student_id)->first();

                $email = $student['email'] ?? '';
            }

            if( empty($email) ) {
                return redirect()->back()->with('error', 'Sorry, we couldn’t find your account. Please check your email or student code and try again.')->with('debug', $this->email->printDebugger());
            }

            // $email = "bubaimathura@gmail.com"; // For Test
            $this->email->setTo($email);
            $this->email->setFrom('noreply@scmschakdaha.in', 'Satish Chandra Memorial School');
            $this->email->setSubject('Password Reset Request');
            
            $message = view('admin/emails/reset-password', [
                'resetLink' => $resetLink,
                'user' => $user
            ]);
            
            $this->email->setMessage($message);
            
            if ($this->email->send()) {
                return redirect()->to('/forgot-password')->with('success', 'Password reset link has been sent to your email.');
            } else {
                return redirect()->back()->with('error', 'Failed to send email. Please try again.')->with('debug', $this->email->printDebugger());
            }
        }else {
            // Check if user exists
            $adminUserModel = new AdminUserModel();
            $user = $adminUserModel->where('email', $email)->first();
            
            if (!$user) {
                // For security, don't reveal that user doesn't exist
                return redirect()->to('/forgot-password')->with('message', 'If your email exists in our system, you will receive a password reset link.');
            }
            
            // Create reset token
            $passwordResetModel = new PasswordResetModel();
            $token = $passwordResetModel->createToken($email);
            
            if (!$token) {
                return redirect()->back()->with('error', 'Failed to create reset token. Please try again.');
            }
            
            // Send reset email
            $resetLink = base_url("reset-password/{$token}");
            
            // $email = "bubaimathura@gmail.com"; // For Test
            $this->email->setTo($email);
            $this->email->setFrom('noreply@scmschakdaha.in', 'Satish Chandra Memorial School');
            $this->email->setSubject('Password Reset Request');
            
            $message = view('admin/emails/reset-password', [
                'resetLink' => $resetLink,
                'user' => $user
            ]);
            
            $this->email->setMessage($message);
            
            if ($this->email->send()) {
                return redirect()->to('/forgot-password')->with('success', 'Password reset link has been sent to your email.');
            } else {
                return redirect()->back()->with('error', 'Failed to send email. Please try again.')->with('debug', $this->email->printDebugger());
            }
        }
    }
    
    /**
     * Show reset password form
     */
    public function resetPassword($token = null)
    {
        $data['title'] = "Reset Password";
        if (!$token) {
            return redirect()->to('/forgot-password')->with('error', 'Invalid reset token.');
        }
        
        // Validate token
        $passwordResetModel = new PasswordResetModel();
        $tokenRecord = $passwordResetModel->validateToken($token);
        
        if (!$tokenRecord) {
            return redirect()->to('/forgot-password')->with('error', 'Invalid or expired reset token.');
        }
        
        $data['token'] = $token;
        return view('admin/auth/reset-password', $data);
    }
    
    /**
     * Process password reset
     */
    public function processResetPassword()
    {
        $validationRules = [
            'token' => 'required',
            'password' => [
                'rules' => 'required|min_length[8]',
                'errors' => [
                    'required' => 'Password is required',
                    'min_length' => 'Password must be at least 8 characters long'
                ]
            ],
            'confirm_password' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Please confirm your password',
                    'matches' => 'Passwords do not match'
                ]
            ]
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $token = $this->request->getPost('token');
        $password = $this->request->getPost('password');
        
        // Validate token
        $passwordResetModel = new PasswordResetModel();
        $tokenRecord = $passwordResetModel->validateToken($token);
        
        if (!$tokenRecord) {
            return redirect()->to('/forgot-password')->with('error', 'Invalid or expired reset token.');
        }
        
        // Hash new password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        // Update user password
        $adminUserModel = new AdminUserModel();
        $updated = $adminUserModel
                       ->where('id', $tokenRecord['user_id'])
                       ->set('password', $hashedPassword)
                       ->update();
        
        if ($updated) {
            // Delete used token
            $passwordResetModel->deleteToken($token);
            
            return redirect()->to('/login')->with('success', 'Password has been reset successfully. Please login with your new password.');
        } else {
            return redirect()->back()->with('error', 'Failed to reset password. Please try again.');
        }
    }

    public function studentSetPassword($encryptedStudentUserId)
    {
        $decrypt_data = decrypt_id($encryptedStudentUserId);
        $userId = $decrypt_data['user_id'] ?? '';
        $sessionYearId = $decrypt_data['session_year_id'] ?? '';


        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Invalid Student Login Details');
        }

        $data['title'] = "Set Password";
        $data['student_user_id'] = $encryptedStudentUserId;
        echo view('admin/auth/set-password', $data);
    }

    public function setStudentPassword()
    {
        $validationRules = [
            'student_user_id' => 'required',
            'password' => [
                'rules' => 'required|min_length[8]',
                'errors' => [
                    'required' => 'Password is required',
                    'min_length' => 'Password must be at least 8 characters long'
                ]
            ],
            'confirm_password' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Please confirm your password',
                    'matches' => 'Passwords do not match'
                ]
            ]
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $enc_student_user_id = $this->request->getPost('student_user_id');
        $decrypt_data = decrypt_id($enc_student_user_id);
        $student_user_id = $decrypt_data['user_id'] ?? '';
        $session_year = $decrypt_data['session_year_id'] ?? '';

        $password = $this->request->getPost('password');

        // Hash new password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        // Update user password
        $adminUserModel = new AdminUserModel();
        // Check if record exists
        $user = $adminUserModel->find($student_user_id);

        if ($user) {
            $updated = $adminUserModel
                       ->where('id', $student_user_id)
                       ->set('password', $hashedPassword)
                       ->set('is_student_password_set', true)
                       ->update();

            if( $updated ) {
                $sessionModel = new LoginSessionModel();

                $timeout = 1800; // 30 minutes
                // Step 2: Check for an active session
                $existingSession = $sessionModel
                    ->where('user_id', $student_user_id)
                    ->where('is_active', true)
                    ->first();

                if ($existingSession) {
                    // return redirect()->back()->with('error', 'User is already logged in from another device.');

                    $lastActivity = strtotime($existingSession['last_activity']);
                    if ((time() - $lastActivity) <= $timeout) {
                        return redirect()->to(base_url('login'))->with('error', 'User is already logged in from another device.');
                    }

                    // If timeout passed, mark old session inactive
                    $sessionModel->update($existingSession['id'], [
                        'is_active' => false,
                        'logout_time' => date('Y-m-d H:i:s')
                    ]);
                }

                // Step 3: Allow login, create new login session
                $sessionId = $sessionModel->insert([
                    'user_id'    => $student_user_id,
                    'login_time' => date('Y-m-d H:i:s'),
                    'is_active'  => true,
                ]);
            
                $session = \Config\Services::session();

                $sessionYearModel = new SessionYearModel();
                $sessionYearDetails = $sessionYearModel->where('id', $session_year)->first();

                $getUserImage = $user['image'] ?? '';
                $getStudentCode = $user['code'] ?? '';
                // 🔐 Store session in CI session
                $session->set([
                    "session_year_id"       => $session_year,
                    "session_year_name"     => $sessionYearDetails['session_name'],
                    "session_start_date"    => $sessionYearDetails['start_date'],
                    "session_end_date"      => $sessionYearDetails['end_date'],    

                    'user_id'               => $user['id'],
                    'dept_id'               => $user['dept_id'],
                    'code'                  => $user['code'],
                    'f_name'                => $user['first_name'],
                    'l_name'                => $user['last_name'],
                    'username'              => $user['email'],
                    'email'                 => $user['email'],
                    'userimage'             => $getUserImage,
                    'login_session_id'      => $sessionId,
                    'isLoggedIn'            => true,
                    'lastActivity'          => time(),
                    'student_code'          => $getStudentCode,
                    'student_logged_in'     => TRUE,
                ]);

                return redirect()->to(base_url('dashboardstudent'));
            } else {
                return redirect()->back()->with('error', 'Password setup could not be completed. Please try again later.');
            }
            
        } else {
            return redirect()->back()->with('error', 'Student not found.');
        }

    }
}