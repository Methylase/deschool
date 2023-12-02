<?php

namespace Deschool\Models;

use Illuminate\Database\Eloquent\Model;

class RegisterTransaction extends Model
{
    protected $fillable = [
        'student_id',
        'corox_model_id',
        'term',
        'class_id',
        'amount',
        'transaction_type',
        'year',
        'transaction_date',
        'transaction_time',
    ];
    public $timestamps=false;
   protected $table='register_transaction';
   protected $primaryKey='id';
}