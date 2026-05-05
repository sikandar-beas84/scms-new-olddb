<?php
namespace App\Models;
use CodeIgniter\Model;

class StudentDocumentsModel extends Model
{
    protected $table      = 'student_documents';
    protected $primaryKey = 'id'; // or whatever your PK is

    protected $allowedFields = [
		'student_id',
		'student_code',
		'signature',
		'f_image',
		'm_image',
		'f_signature',
		'm_signature',
		'g_image',
		'g_signature',
		'stu_signature',
		'cast_certificate',
		'caste_photocopy',
		'application',
		'trans_cert',
		'migration_cert',
		'any_special_cert',
    ];

	/**
     * Copy student documents for a new student_id
     *
     * @param int $oldStudentId
     * @param int $newStudentId
     * @return int|false  New record ID or false
     */
    public function copyStudentDocuments(int $oldStudentId, int $newStudentId)
    {
        // 1️⃣ Fetch old document record
        $document = $this->where('student_id', $oldStudentId)->first();

        if (!$document) {
            return false;
        }

        // 2️⃣ Remove primary key
        unset($document['id']);

        // 3️⃣ Assign new student_id
        $document['student_id'] = $newStudentId;

        // 4️⃣ Insert copied record
        $this->insert($document);

        // 5️⃣ Return new inserted ID
        return $this->getInsertID();
    }
}