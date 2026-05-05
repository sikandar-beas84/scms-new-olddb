<?php
namespace App\Models;
use CodeIgniter\Model;

class SessionYearModel extends Model
{
    protected $table      = 'session_year';
    protected $primaryKey = 'id'; // or whatever your PK is

    protected $allowedFields = [
        'session_name', 
        'start_date', 
        'end_date', 
        'is_current', 
    ];

    // ✅ Get current active session ID
    public function getCurrentSessionId()
    {
        return $this->where('is_current', true)
                    ->select('id')
                    ->get()
                    ->getRow('id');
    }

    public function getSessionYearName($sess_id)
    {
        if (!$sess_id) {
            return null;
        }

        $builder = $this->db->table('session_year');

        return $builder
            ->select('session_name, start_date, end_date')
            ->where('id', $sess_id)
            ->get()
            ->getRowArray(); // same as CI3 ->row()
    }


}

