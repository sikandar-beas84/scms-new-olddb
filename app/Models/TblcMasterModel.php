<?php
namespace App\Models;
use CodeIgniter\Model;

class TblcMasterModel extends Model
{
    protected $table      = 'tblc_master';
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

    function get_class_lang_items($class_id='', $lang_name='')
    {
        if( $class_id == '' || $lang_name == '' ) {
            return [];
        }

        $session = session();
        $session_year_id = $session->get('session_year_id');

        $builder = $this->db->table('tblc_master');

        $builder->select('tblc_master.*, class.class_name');
        $builder->join('class', 'class.id = tblc_master.class_id');
        $builder->where('tblc_master.class_id', $class_id);
        $builder->where('tblc_master.sec_lang', $lang_name);
        $builder->where('tblc_master.session_year_id', $session_year_id);

        $query = $builder->get();
        return $query->getResultArray();   // returns array of objects
    }
}