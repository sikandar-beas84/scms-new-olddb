<?php
namespace App\Models;
use CodeIgniter\Model;

class StudentParentsGuardiansModel extends Model
{
    protected $table      = 'student_parents_guardians';
    protected $primaryKey = 'id'; // or whatever your PK is

    protected $allowedFields = [
		'student_id',
		'student_code',
		'father_name',
		'father_occupation',
		'father_designation',
		'father_office_address',
		'father_office_phone',
		'father_mobile',
		'father_qualification',
		'father_annual_income',
		'father_aadhaar_no',
		'father_id',
		'mother_name',
		'mother_occupation',
		'mother_designation',
		'mother_office_address',
		'mother_office_phone',
		'mother_mobile',
		'mother_qualification',
		'mother_annual_income',
		'mother_aadhaar_no',
		'mother_id',
		'mothers_is_gurgent',
		'local_guar_name',
		'local_guar_occupation',
		'local_guar_stu_relation',
		'local_guar_gender',
		'local_guar_annual_income',
		'local_guar_aadhaar_no',
		'local_guar_phone',
		'local_guar_office_phone',
		'local_guar_address',
		'family_earn_memb',
		'dependent',
    ];

    /**
     * Copy parent/guardian details for a new student
     *
     * @param int $oldStudentId
     * @param int $newStudentId
     * @return int|false
     */
    public function copyStudentParentsGuardians(int $oldStudentId, int $newStudentId)
    {
        // 1️⃣ Fetch old record
        $parent = $this->where('student_id', $oldStudentId)->first();

        if (!$parent) {
            return false;
        }

        // 2️⃣ Remove primary key
        unset($parent['id']);

        // 3️⃣ Assign new student_id
        $parent['student_id'] = $newStudentId;

        // (Optional) update student_code if it changes
        // $parent['student_code'] = $newStudentCode;

        // 4️⃣ Insert copied record
        $this->insert($parent);

        // 5️⃣ Return new inserted ID
        return $this->getInsertID();
    }
}