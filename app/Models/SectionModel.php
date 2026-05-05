<?php
namespace App\Models;
use CodeIgniter\Model;

class SectionModel extends Model
{
    protected $table      = 'section';
    protected $primaryKey = 'id'; // or whatever your PK is

    protected $allowedFields = [
        'class_id',
        'section_name',
        'no_of_student',
        'teacher_id',
        'session_year_id' 
    ];

	public function get_section_class_id($classId, $sessionYearId)
	{
	    $builder = $this->db->table('section');
	    $builder->select('id, section_name');
	    $builder->where('class_id', $classId);
	    $builder->where('session_year_id', $sessionYearId);
	    // $builder->where('status', 1); // Uncomment if needed
	    $builder->orderBy('section_name', 'ASC');

	    $query = $builder->get();
	    return $query->getResultArray();
	}

	public function section_lists()
	{
	    $builder = $this->db->table('section');

	    $builder->join('class', 'class.id = section.class_id', 'left');
	    $builder->join('admin_users', 'admin_users.id = section.teacher_id', 'left');
	    $builder->join('session_year', 'session_year.id = section.session_year_id', 'left');

	    $builder->select("
	    	section.*,
	    	class.class_name,
	    	session_year.session_name,
	    	CONCAT(admin_users.first_name, ' ', admin_users.last_name) AS full_name
	    ");

	    $sessionYearId = session()->get('session_year_id');
	    $builder->where('session_year_id', $sessionYearId);

	    $query = $builder->get();
	    return $query->getResultArray();
	}
}