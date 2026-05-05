<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\LoginSessionModel;

class ActivityTimeoutFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $sessionModel = new LoginSessionModel();

        if ($session->get('isLoggedIn')) {

            $timeout = 1800; // 30 minutes
            $lastActivity = $session->get('lastActivity') ?? time();

            // Check inactivity
            if ((time() - $lastActivity) > $timeout) {

                

                $userId = $session->get('user_id');
                $sessionId = $session->get('login_session_id');

                // Update DB: mark sessions inactive
                if ($sessionId) {
                    $sessionModel->update($sessionId, [
                        'is_active'   => false,
                        'logout_time' => date('Y-m-d H:i:s'),
                    ]);
                } elseif ($userId) {
                    // If sessionId is missing, mark all user's active sessions as inactive
                    $sessionModel->where('user_id', $userId)
                        ->where('is_active', true)
                        ->set([
                            'is_active'   => false,
                            'logout_time' => date('Y-m-d H:i:s'),
                        ])
                        ->update();
                }

                // Destroy PHP session
                $session->destroy();

                return redirect()->to('/login')->with('error', 'Session expired due to inactivity.');
            }

            // If still active, update last activity time in PHP session
            $session->set('lastActivity', time());

            // Optional: also update in DB for cleanup jobs
            $loginSessionId = $session->get('login_session_id');
            


            if (!empty($loginSessionId) && is_numeric($loginSessionId)) {
                $ddd = $sessionModel->find($loginSessionId);

                if ($sessionModel->find($loginSessionId)) {
                    $sessionModel->update($loginSessionId, [
                        'last_activity' => date('Y-m-d H:i:s')
                    ]);
                }
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Not needed
    }
}
