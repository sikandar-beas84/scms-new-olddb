<?php
namespace App\Models;
use CodeIgniter\Model;

class BusMasterModel extends Model
{
    protected $table      = 'bus_master';
    protected $primaryKey = 'bus_id'; // or whatever your PK is

    protected $allowedFields = [
        'vendor_id',
        'area_id',
        'stoppage_id',
        'bus_serial_no',
        'bus_licence_no',
        'bus_seating_capacity',
        'bus_driver_name',
        'bus_driver_phone',
        'bus_attendent_name',
        'bus_attendent_phone',
        'bus_driver_driving_license_no',
        'bus_driver_licence_expiery_date',
        'bus_driver_image',
        'bus_attendent_driving_license_no',
        'bus_attendent_licence_expiery_date',
        'bus_attendent_image',
        'status',
    ];

    function get_all_bus_list()
    {
        $builder = $this->db->table('bus_master');

        $builder->select('bus_master.*, admin_users.first_name, admin_users.last_name');
        $builder->join('admin_users', 'admin_users.id = CAST(bus_master.vendor_id AS INTEGER)', 'left');

        $builder->orderBy('bus_master.bus_id', 'DESC');
        $query = $builder->get();
        

        // ✅ Print last query
        // echo $this->db->getLastQuery();
        // die();

        $result = $query->getResultArray();
        return $result;
    }

    public function update_bus($id, $data){
        return $this->where('bus_id', $id)->set($data)->update();         
    }

    public function getBusBySerial($serial)
    {
        return $this->select('bus_id')
                    ->where('bus_serial_no', $serial)
                    ->first();
    }

}