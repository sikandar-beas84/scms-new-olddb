<?php
namespace App\Models;
use CodeIgniter\Model;

class StationaryItemCollectionModel extends Model
{
    protected $table      = 'stationary_item_collection';
    protected $primaryKey = 'id'; // or whatever your PK is

    protected $allowedFields = [ 
        'student_code',
        'session_year_id',
        'all_item_collected',
        'how_much_item_collected',
        'given_by',
        'given_date',
    ];

    public function student_stationary_collected_item_details($student_code='', $session_year_id='')
    {
		$builder = $this->db->table('stationary_item_collection');

		$result = [];

		// get session value (CI4 way)
		$session = session();
		$getSessionYearId = ($session_year_id != '') ? $session_year_id : $session->get('session_year_id');

		if (!empty($student_code)) {
		    $builder->select('*');
		    $builder->where('session_year_id', $getSessionYearId);
		    $builder->where('student_code', $student_code);

		    $query = $builder->get();
		    $result = $query->getRowArray();
		}

		return $result ?? [];
    }
}