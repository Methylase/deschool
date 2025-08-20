<?php

namespace Deschool\Models;

use Illuminate\Database\Eloquent\Model;

class RegisterStudentClassStatus extends Model
{
    protected $fillable = [
        'student_id',
        'corox_model_id',
        'year',
        'status',
        'date',
    ];
    public $timestamps=false;
   protected $table='register_student_class_status';
   protected $primaryKey='id';
}