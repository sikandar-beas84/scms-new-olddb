<?php
namespace App\Models;
use CodeIgniter\Model;

class ParentEventsModel extends Model
{
    protected $table      = 'parent_events';
    protected $primaryKey = 'id'; // or whatever your PK is

    protected $allowedFields = [
        'event_no', 
        'event_name', 
        'event_description', 
        'event_date', 
        'event_fee', 
        'status', 
        'add_date', 
        'add_by', 
        'updated_at', 
        'updated_by', 
    ];

}