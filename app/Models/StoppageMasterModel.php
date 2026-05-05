<?php
namespace App\Models;
use CodeIgniter\Model;

class StoppageMasterModel extends Model
{
    protected $table      = 'stoppage_master';
    protected $primaryKey = 'stoppage_id'; // or whatever your PK is

    protected $allowedFields = [
        'area_id', 
        'stoppage_name', 
        'stoppage_fare', 
        'create_date', 
        'status', 
        'session_year_id', 
    ];

    public function get_stoppages()
    {
        $sessionYearId = session()->get('session_year_id');
        // $sessionYearId = 9; // For testing insert data new 10 session

        $builder = $this->db->table('stoppage_master sm');
        $builder->select('sm.*, sfm.stoppage_fare as sfm_stoppage_fare, sfm.session_year_id as sessionYearId');
        // ✅ Apply old CI3 logic
        if ($sessionYearId <= 5) {
            $builder->where('sm.session_year_id', 4);
        } else {
            $builder->where('sm.session_year_id !=', 4);
        }

        // $builder->join('stoppage_fare_master sfm', 'sfm.stoppage_id = sm.stoppage_id', 'left');
        $builder->join('stoppage_fare_master sfm', 'sfm.stoppage_id = sm.stoppage_id AND sfm.session_year_id = '.$sessionYearId, 'left');

        // $builder->where('sfm.session_year_id', $sessionYearId);
        $builder->orderBy('sm.stoppage_name', 'ASC');
        $query = $builder->get();

        // ✅ Print last query
        // echo $this->db->getLastQuery();
        // die();

        $result = $query->getResultArray();
        return $result;
    }

    public function get_stoppage_details_by_id($id)
    {
        if( !isset($id) || $id == '' ) {
            return [];
        }

        $sessionYearId = session()->get('session_year_id');

        $builder = $this->db->table('stoppage_master sm');
        $builder->select('sm.*, COALESCE(sfm.stoppage_fare, 0) AS stoppage_fare');
        $builder->join('stoppage_fare_master sfm', 'sfm.stoppage_id = sm.stoppage_id AND sfm.session_year_id = '.$sessionYearId, 'left');

        // $builder->where('sfm.session_year_id', $sessionYearId);
        $builder->where('sm.stoppage_id', $id);
        $builder->orderBy('sm.stoppage_id', 'ASC');
        $query = $builder->get();

        // ✅ Print last query
        // echo $this->db->getLastQuery();
        // die();

        $result = $query->getRowArray();
        return $result;
    }

    public function get_all_stoppage()
    {
        $sessionYearId = session()->get('session_year_id');

        $builder = $this->db->table('stoppage_master sm');
        $builder->select('sm.*, COALESCE(sfm.stoppage_fare, 0) AS stoppage_fare, sfm.session_year_id as sessionYearId');
        $builder->join('stoppage_fare_master sfm', 'sfm.stoppage_id = sm.stoppage_id AND sfm.session_year_id = '.$sessionYearId, 'left');

        if ($sessionYearId <= 5) {
            $builder->where('sm.session_year_id', 4);
        } else {
            $builder->where('sm.session_year_id', 0);
        }
        $builder->orderBy('sm.stoppage_id', 'ASC');
        $query = $builder->get();

        // ✅ Print last query
        // echo $this->db->getLastQuery();
        // die();

        $result = $query->getResultArray();
        return $result;
    }

}