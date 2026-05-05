<?php
namespace App\Models;
use CodeIgniter\Model;

class StudentElectiveSubjectsModel extends Model
{
    protected $table      = 'student_elective_subjects';
    protected $primaryKey = 'id'; // or whatever your PK is

    protected $allowedFields = [
		'student_id',
		'student_code',
		'first_elective_sub',
		'second_elective_sub',
		'third_elective_sub',
		'fourth_elective_sub',
		'fifth_elective_sub',
		'sixth_elective_sub',
    ];

    /**
     * Copy elective subjects for a new student
     *
     * @param int $oldStudentId
     * @param int $newStudentId
     * @return int|false
     */
    public function copyStudentElectiveSubjects(int $oldStudentId, int $newStudentId)
    {
        // 1️⃣ Fetch old elective subject record
        $elective = $this->where('student_id', $oldStudentId)->first();

        if (!$elective) {
            return false;
        }

        // 2️⃣ Remove primary key
        unset($elective['id']);

        // 3️⃣ Assign new student_id
        $elective['student_id'] = $newStudentId;

        // (Optional) update student_code if it changes
        // $elective['student_code'] = $newStudentCode;

        // 4️⃣ Insert copied record
        $this->insert($elective);

        // 5️⃣ Return new inserted ID
        return $this->getInsertID();
    }
}