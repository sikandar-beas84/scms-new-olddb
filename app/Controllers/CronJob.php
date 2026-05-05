<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\Email\Email;

use App\Models\SessionYearModel;
use App\Models\StudentDetailsModel;

class CronJob extends Controller
{
	protected $email;

    public function __construct()
    {
        // Load email service
        $this->email = \Config\Services::email();
    }

	public function birthday_mail()
	{
		$sessionYearModel = new SessionYearModel();
		$studentDetailsModel = new StudentDetailsModel();

		$currentSessionId = $sessionYearModel->getCurrentSessionId();
		$today_birthdays = $studentDetailsModel->getTodayBirthdays($currentSessionId);

		if( isset($today_birthdays) && !empty($today_birthdays) ) {
			foreach ($today_birthdays as $birthdays) {
				$name  = $birthdays['full_name'] ?? '';
				$dob  = $birthdays['dob'] ?? '';
		        $type  = $birthdays['type'] ?? '';
		        $emailTo = $birthdays['email'] ?? '';
		        $image = $birthdays['image'] ?? '';

		        // Skip if email empty
		        if (empty($emailTo)) {
		            continue;
		        }

		        // Load email template view
		        $message = view('admin/emails/birthday', [
		            'name' => $name,
		            'type' => $type,
		            'image' => $image,
		        ]);

		        // pr($message);

		        // ✅ MUST SET AGAIN AFTER CLEAR
    			$this->email->setFrom('noreply@scmschakdaha.in', 'Satish Chandra Memorial School');
		        
		        // Set email
		        $emailTo = "bubaimathura@gmail.com";
		        $this->email->setTo($emailTo);
		        $this->email->setSubject('🎉 Happy Birthday '.$name);

		        $this->email->setMessage($message);
    			$this->email->setMailType('html');

		        // Send email
		        if ($this->email->send()) {
		            echo "Sent to: ".$name." (".$emailTo.") <br>";
		        } else {
		            echo "Failed: ".$emailTo."<br>";
		            // Debug (optional)
		            print_r($this->email->printDebugger(['headers']));
		        }

		        // IMPORTANT: clear before next loop
		        $this->email->clear();
			}
		}
	}
}