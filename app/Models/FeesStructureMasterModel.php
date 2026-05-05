<?php
namespace App\Models;
use CodeIgniter\Model;

class FeesStructureMasterModel extends Model
{
    protected $table      = 'fees_structure_master';
    protected $primaryKey = 'fs_id'; // or whatever your PK is

    protected $allowedFields = [
        'class_id',
        'tuition_fee',
        'security_deposite',
        'development_fee',
        'exam_fee',
        'festival_celebration_fee',
        'games_sports_fee',
        'audio_visual_lab_fee',
        'library_fee',
        'electricity_maintenance_fee',
        'computer_fee',
        'session_charges',
        'admission_fee',
        'session_year_id',
        'status',
    ];

    public function get_all_fees()
    {
        $builder = $this->db->table('fees_structure_master');

        $builder->select('fees_structure_master.*, class.class_name, session_year.session_name, class.id as class_id');
        $builder->join('session_year', 'session_year.id = fees_structure_master.session_year_id', 'left');
        $builder->join('class', 'class.id = fees_structure_master.class_id', 'left');
        
        $query = $builder->get();
        return $query->getResultArray(); // return array
    }


}