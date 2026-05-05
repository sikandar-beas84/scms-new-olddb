<?php
namespace App\Models;
use CodeIgniter\Model;

class StudentTransportFinancialModel extends Model
{
    protected $table      = 'student_transport_financial';
    protected $primaryKey = 'id'; // or whatever your PK is

    protected $allowedFields = [
		'student_id',
		'student_code',
		'bank_acc_no',
		'bank_ifsc_no',
		'transport_required',
		'stoppage',
		'bus_id',
		'bus_alloted_date',
		'allow_transport',
		'deposit_refund_status',
		'refund_date',
		'refund_message',
		'sm_refund_amount',
		'sm_refund_date',
		'allow_readmission',
		'dmg_prd',
		'dmg_prd_price',
		'dmg_prd_img',
    ];

    /**
     * Copy transport & financial details for a new student
     *
     * @param int $oldStudentId
     * @param int $newStudentId
     * @return int|false
     */
    public function copyStudentTransportFinancial(int $oldStudentId, int $newStudentId)
    {
        // 1️⃣ Fetch old transport/financial record
        $transport = $this->where('student_id', $oldStudentId)->first();

        if (!$transport) {
            return false;
        }

        // 2️⃣ Remove primary key
        unset($transport['id']);

        // 3️⃣ Assign new student_id
        $transport['student_id'] = $newStudentId;

        // (Optional) reset or adjust values for new session
        // $transport['deposit_refund_status'] = 'N';
        // $transport['refund_date'] = null;
        // $transport['refund_message'] = null;

        // 4️⃣ Insert copied record
        $this->insert($transport);

        // 5️⃣ Return new inserted ID
        return $this->getInsertID();
    }
}