<?php

namespace Deschool\Models;

use Illuminate\Database\Eloquent\Model;

class RegisterTeacherSubject extends Model
{
    protected $fillable = [
        'corox_model_id',
        'teacher_id',
        'subject_id',
    ];
     public $timestamps=false;
   protected $table='register_teacher_subject';
   protected $primaryKey='id';
}
