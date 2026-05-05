<?php
namespace App\Controllers\Admin;
use CodeIgniter\Controller;
use CodeIgniter\Email\Email;
use CodeIgniter\I18n\Time;

use App\Models\SessionYearModel;
use App\Models\AdminUserModel;
use App\Models\LoginSessionModel;


class Login extends Controller
{

    public function index()
    {
        $this->session = \Config\Services::session();
        if( $this->session->get('isLoggedIn') ) {
            return redirect()->to('/dashboard');
            exit();
        }

        // $settingsModel = new SettingsModel();
        $sessionModel = new SessionYearModel();
        $data['title'] = "Login";

        // $data['settings'] = $settingsModel->first();

        $data['sessions'] = $sessionModel->findAll();
        echo view('admin/login', $data);        
    }

    public function auth()
    {
        $timeout = 1800; // 30 minutes
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $session_year = $this->request->getPost('session_year');

        $validationRules = [
            'username' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Username cannot be empty'
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password cannot be empty'
                ]
            ],
            'session_year' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Please select session year'
                ]
            ]
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel = new AdminUserModel();
        $sessionModel = new LoginSessionModel();

        $user = $userModel->where('email', $username)->first();
        // echo "<pre>"; print_r($user); die();
        if (!$user || !password_verify($password, $user['password'])) {
            // echo "fgdfgf";die();
            return redirect()->back()->with('error', 'Invalid credentials');
        }
        // pr($user);
        // Accept typical values: 1, '1', true, 'true', 'active', 'enabled'
        $statusStr = strtolower((string)($user['status'] ?? ''));
        $isActive  = in_array($statusStr, ['1', 'true', 't', 'TRUE'], true)
                     || (is_numeric($user['status'] ?? null) && (int)$user['status'] === 1);

        if (!$isActive) {
            return redirect()->back()->with('error', 'Your account is inactive or blocked. Please contact the administrator.');
        }
        
        if( isset($user['dept_id']) && $user['dept_id'] == 3 ) {

            if ($user['is_student_password_set'] === 'f') {
                // echo '<pre>'; print_r($user['id']);
                // pr(encrypt_id($user['id']));

                $payload = [
                    'user_id' => $user['id'],
                    'session_year_id' => $session_year
                ];
                $getStudentPasswordSetUrl = base_url('student-set-password/'.encrypt_id($payload));
                return redirect()->to($getStudentPasswordSetUrl);
            }
        }

        // Step 2: Check for an active session
        $existingSession = $sessionModel
            ->where('user_id', $user['id'])
            ->where('is_active', true)
            ->first();

        if ($existingSession) {
            // return redirect()->back()->with('error', 'User is already logged in from another device.');

            $lastActivity = strtotime($existingSession['last_activity']);
            if ((time() - $lastActivity) <= $timeout) {
                return redirect()->back()->with('error', 'User is already logged in from another device.');
            }

            // If timeout passed, mark old session inactive
            $sessionModel->update($existingSession['id'], [
                'is_active' => false,
                'logout_time' => date('Y-m-d H:i:s')
            ]);
        }

        // Step 3: Allow login, create new login session
        $sessionId = $sessionModel->insert([
            'user_id'    => $user['id'],
            'login_time' => date('Y-m-d H:i:s'),
            'is_active'  => true,
        ]);
    
        $session = \Config\Services::session();

        $sessionYearModel = new SessionYearModel();
        $sessionYearDetails = $sessionYearModel->where('id', $session_year)->first();

        $getUserImage = $user['image'] ?? '';
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
        ]);

        if( isset($user['dept_id']) && $user['dept_id'] == 3 ) {
            $getStudentCode = $user['code'] ?? '';
            $session->set([
                'student_code' => $getStudentCode
            ]);
        }

        // $currentLoginType = '';
        // if( isset($user['dept_id']) && $user['dept_id'] == 1 ) {
        //     $session->set(["admin_logged_in" => TRUE]);
        // }

        $currentLoginType = '';

        $deptLoginMap = [
            1 => 'admin_logged_in',
            2 => 'teacher_logged_in',
            3 => 'student_logged_in',
            4 => 'nonteaching_logged_in',
            5 => 'groupd_logged_in',
            6 => 'principal_logged_in',
            7 => 'vendor_logged_in',
            8 => 'specialadmin_logged_in',
        ];

        $deptRedirectMap = [
            1 => '/dashboard',
            2 => '/dashboardteacher',
            3 => '/dashboardstudent',
            4 => '/dashboardnonteaching',
            5 => '/dashboardgroupd',
            6 => '/dashboardprincipal',
            7 => '/dashboardvendor',
            8 => '/dashboard',
        ];

        $deptDashboarsRedirectURL = '/dashboard';

        if (isset($user['dept_id']) && array_key_exists($user['dept_id'], $deptLoginMap)) {

            $currentLoginType = $deptLoginMap[$user['dept_id']];
            $session->set([$currentLoginType => TRUE]);

            $deptDashboarsRedirectURL = $deptRedirectMap[$user['dept_id']] ?? '/dashboard';
        } else {
            // Default (Super Admin / Unknown role)
            $currentLoginType = 'superadmin_logged_in';
            $session->set([$currentLoginType => TRUE]);

            $deptDashboarsRedirectURL = '/dashboard';
        }


        // return redirect()->to('/dashboard');

        // Get stored redirect URL if available
        $redirectURL = $session->get('redirect_url') ?? $deptDashboarsRedirectURL;

        // Clear it from session so it doesn’t stay there
        $session->remove('redirect_url');

        return redirect()->to($redirectURL);
    }

    public function logout()
    {
        $session = session();
        $sessionId = $session->get('login_session_id');
        if ($sessionId) {
            $sessionModel = new LoginSessionModel();
            $sessionModel->update($sessionId, [
                'is_active'   => false,
                'logout_time' => date('Y-m-d H:i:s'),
            ]);
        }

        session()->destroy();
        return redirect()->to('/login');
    }    
}