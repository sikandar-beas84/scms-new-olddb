<?php
namespace App\Models;
use CodeIgniter\Model;

class ItemMasterModel extends Model
{
    protected $table      = 'item_master';
    protected $primaryKey = 'id'; // or whatever your PK is

    protected $allowedFields = [
        'class_id',
        'sec_lang',
        'item_name',
        'qty',
        'price',
        'status',
        'add_date',
        'session_year_id',
        'created_by',
        'created_date',
        'updated_by',
        'updated_date',
    ];

	public function get_total_price_stn_by_class($class_id, $response_year_id) {
		if( !isset($class_id) || empty($class_id) ) {
			return 0;
		}

		// Use Query Builder
	    $builder = $this->db->table('item_master');
	    $builder->select('SUM(price * qty) AS total_price');
	    $builder->where('class_id', $class_id);
	    $builder->where('sec_lang', 'Bengali');
	    $builder->where('session_year_id', $response_year_id);

	    $query = $builder->get();
	    $row = $query->getRow();

	    return $row ? $row->total_price : 0;
    }

    function get_class_lang_items($class_id='', $lang_name='')
    {
        if( $class_id == '' || $lang_name == '' ) {
            return [];
        }

        $session = session();
        $session_year_id = $session->get('session_year_id');

        $builder = $this->db->table('item_master');

        $builder->select('item_master.*, class.class_name');
        $builder->join('class', 'class.id = item_master.class_id');
        $builder->where('item_master.class_id', $class_id);
        $builder->where('item_master.sec_lang', $lang_name);
        $builder->where('item_master.session_year_id', $session_year_id);

        $query = $builder->get();
        return $query->getResultArray();   // returns array of objects
    }

    public function getStudentItemsByStudentId($student_id, $session_year_id = '')
    {
        $builder = $this->db->table('student_stationary_items');

        $session = session();
        $getSessionYearId = $session_year_id ?: $session->get('session_year_id');

        $builder->where('student_id', (int)$student_id); // ✅ ensure integer
        $builder->where('session_year_id', (int)$getSessionYearId);

        $query = $builder->get();
        
        // $lastQuery = $this->db->getLastQuery();
        // pr($lastQuery);

        $result = $query->getRowArray(); // ✅ always array

        return $result ?? [];
    }
}