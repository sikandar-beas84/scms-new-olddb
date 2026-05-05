<?php
namespace App\Models;
use CodeIgniter\Model;

class StudentPersonalDetailsModel extends Model
{
    protected $table      = 'student_personal_details';
    protected $primaryKey = 'id'; // or whatever your PK is

    protected $allowedFields = [
		'student_id',
		'student_code',
		'mother_language',
		'second_language',
		'immunization',
		'medical_condition',
		'only_child',
		'religion',
		'nationality',
		'bpl',
		'bpl_number',
		'lkg_onw_sec_lang',
		'std_three_sec_lang',
		'telephone_resi',
		'pincode',
		'permanent_address',
		'residential_address',
		'residential_phone',
		'residential_mobile',
		'email',
		'whatsapp_number_one',
		'whatsapp_number_two',
    ];

    /**
     * Copy personal details for a new student
     *
     * @param int $oldStudentId
     * @param int $newStudentId
     * @return int|false
     */
    public function copyStudentPersonalDetails(int $oldStudentId, int $newStudentId)
    {
        // 1️⃣ Fetch old personal details
        $personal = $this->where('student_id', $oldStudentId)->first();

        if (!$personal) {
            return false;
        }

        // 2️⃣ Remove primary key
        unset($personal['id']);

        // 3️⃣ Assign new student_id
        $personal['student_id'] = $newStudentId;

        // (Optional) update student_code if required
        // $personal['student_code'] = $newStudentCode;

        // 4️⃣ Insert copied record
        $this->insert($personal);

        // 5️⃣ Return new inserted ID
        return $this->getInsertID();
    }
}