<?php
namespace App\Models;
use CodeIgniter\Model;

class ConfigurationModel extends Model
{
    protected $table      = 'configuration';
    protected $primaryKey = 'configuration_id'; // or whatever your PK is

    protected $allowedFields = [
		'configuration_level',
		'configuration_key',
		'configuration_value',
		'create_date',
    ];

	public function get_configuration_by_key($key){
		$builder = $this->db->table('configuration');
        $builder->where('configuration_key', $key);
        $query = $builder->get();
        
        $row = $query->getRowArray();
    	return $row ? $row['configuration_value'] : null;
	}

}