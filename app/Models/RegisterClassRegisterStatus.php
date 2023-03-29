<?php

namespace Deschool\Models;

use Illuminate\Database\Eloquent\Model;

class RegisterClassRegisterStatus extends Model
{
    protected $fillable = [
        'student_id',
        'corox_model_id',
        'term',
        'class_id',
        'year',
        'register_date',
    ];
    public $timestamps=false;
   protected $table='register_class_register_status';
   protected $primaryKey='id';
}
