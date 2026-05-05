<?php
namespace App\Models;
use CodeIgniter\Model;

class StoppageFareMasterModel extends Model
{
    protected $table      = 'stoppage_fare_master';
    protected $primaryKey = 'sfm_id'; // or whatever your PK is

    protected $allowedFields = [
        'stoppage_id',
        'stoppage_fare',
        'session_year_id',
    ];

    public function stoppage_fee_by_id($id)
    {
        // Get session value (CI4 way)
        $session = session();
        $sessionYearId = $session->get('session_year_id');

        // Build the query using CI4’s Query Builder
        $builder = $this->builder();
        $builder->select('*');
        $builder->where('stoppage_id', $id);
        $builder->where('session_year_id', $sessionYearId);
        $query = $builder->get();

        // ✅ Print last query
		// echo $this->db->getLastQuery();
		// die();
		
        // Return single row as object
        return $query->getRow();
    }

    public function session_stoppage_fee_by_id($id, $session_year_id)
    {
        $builder = $this->builder();
        $builder->select('*');
        $builder->where('stoppage_id', $id);
        $builder->where('session_year_id', $session_year_id);
        $query = $builder->get();

        // ✅ Print last query
        // echo $this->db->getLastQuery();
        // die();
        
        // Return single row as object
        return $query->getRowArray();
    }

}