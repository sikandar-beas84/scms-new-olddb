<?php
namespace App\Models;
use CodeIgniter\Model;

class SubjectToClassModel extends Model
{
    protected $table      = 'subject_to_class';
    protected $primaryKey = 'id'; // or whatever your PK is

    protected $allowedFields = [
		'class_id',
		'subject_id',
		'sub_order',
		'create_date',
		'updated_at',
    ];

}