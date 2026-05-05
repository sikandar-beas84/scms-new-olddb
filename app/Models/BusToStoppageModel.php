<?php
namespace App\Models;
use CodeIgniter\Model;

class BusToStoppageModel extends Model
{
    protected $table      = 'bus_to_stoppage';
    protected $primaryKey = 'id'; // or whatever your PK is

    protected $allowedFields = [
        'bus_id',
        'area_id',
        'stoppage_id', 
    ];

	public function get_bus_list_by_stoppage($stoppage_id)
	{
		if (!isset($stoppage_id) || empty($stoppage_id)) {
		    return [];
		}

	    $builder = $this->db->table('bus_to_stoppage');
	    $builder->select('bus_to_stoppage.*, bus_master.bus_licence_no, bus_master.bus_serial_no');
	    $builder->join('bus_master', 'bus_master.bus_id =  CAST(bus_to_stoppage.bus_id AS INTEGER)', 'left');
	    $builder->where('bus_to_stoppage.stoppage_id', $stoppage_id);

	    $query = $builder->get();
	    return $query->getResultArray(); // use getResultArray() if you want array output
	}

	public function get_bus($id)
	{
	    $builder = $this->db->table('bus_to_stoppage');
	    $builder->select('*');
	    $builder->join('bus_master', 'bus_master.bus_id = CAST(bus_to_stoppage.bus_id AS INTEGER)', 'left');
	    $builder->where('bus_to_stoppage.stoppage_id', (int)$id);

	    $query = $builder->get();
	    return $query->getResultArray();
	}

	public function get_bus_stoppage($bus_id)
	{
	    $builder = $this->db->table('bus_to_stoppage');
	    $builder->select('stoppage_id');
	    $builder->where('bus_id', $bus_id);

	    $query = $builder->get();
	    return $query->getResultArray();
	}

	public function del_bus_stoppage($bus_id)
	{
	    return $this->where('bus_id', $bus_id)->delete();
	}


}