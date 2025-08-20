<?php

namespace Deschool\Models;

use Illuminate\Database\Eloquent\Model;

class RegisterAssignBook extends Model
{
    protected $fillable = [
        'corox_model_id',
        'student_id',
        'book_id',
        'book_condition',
    ];
     public $timestamps=false;
   protected $table='register_assign_book';
   protected $primaryKey='id';
}
