<?php

namespace Deschool\Models;

use Illuminate\Database\Eloquent\Model;

class RegisterSalesRecord extends Model
{
    protected $fillable = [
        'stationary_id',
        'student_id',
        'quantity',
        'transaction_type',
        'corox_model_id',
        'time',
        'date',
    ];
    public $timestamps=false;
    protected $table='register_sales_record';
    protected $primaryKey='id';
}
