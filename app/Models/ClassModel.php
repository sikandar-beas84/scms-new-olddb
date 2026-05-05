<?php
namespace App\Models;
use CodeIgniter\Model;

class ClassModel extends Model
{
    protected $table      = 'class';
    protected $primaryKey = 'id'; // or whatever your PK is

    protected $allowedFields = [
        'class_name', 
        'id_range', 
        'age', 
    ];

    public function getClassAgeLimit($classId)
    {
        $builder = $this->db->table('class');
        $builder->select('age');
        $builder->where('id', $classId);

        $query = $builder->get();
        $row = $query->getRow();

        return $row ? $row->age : null;
    }

    public function get_class_subjects($id)
    {
        $builder = $this->db->table('subject_to_class stc');
        $builder->select('
            stc.*,
            c.class_name,
            sm.subject_code,
            sm.subject_name
        ');
        $builder->join('class c', 'c.id = stc.class_id', 'left');
        $builder->join('subject_master sm', 'sm.id = stc.subject_id', 'left');
        $builder->where('stc.class_id', $id);

        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getClassIdRange($classId)
    {
        return $this->select('id_range')
                    ->where('id', $classId)
                    ->first()['id_range'] ?? '';
    }


}

