<?php

namespace Deschool\Models;

use Illuminate\Database\Eloquent\Model;

class RegisterStudentSubject extends Model
{
    protected $fillable = [
        'corox_model_id',
        'student_id',
        'subject_id',
        'deparment_name',
        'class_id',
        'term',
        'year',

    ];
     public $timestamps=false;
   protected $table='register_student_subject';
   protected $primaryKey='id';
}
