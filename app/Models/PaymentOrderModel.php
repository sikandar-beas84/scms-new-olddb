<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentOrderModel extends Model
{
    protected $table            = 'payment_orders';
    protected $primaryKey       = 'id';

    protected $allowedFields = [
        'order_id',
        'student_id',
        'session_year_id',
        'payment_data',
        'created_at',
        'updated_at'
    ];
}