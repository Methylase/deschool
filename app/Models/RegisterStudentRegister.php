<?php

namespace Deschool\Models;

use Illuminate\Database\Eloquent\Model;

class RegisterStudentRegister extends Model
{
    protected $fillable = [
        'corox_model_id',
        'student_id',
        'register_date',
        'register_time',
    ];
    public $timestamps=false;
   protected $table='register_student_register';
   protected $primaryKey='id';
}
