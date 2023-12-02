<?php

namespace Deschool\Models;

use Illuminate\Database\Eloquent\Model;

class RegisterResultAggregator extends Model
{
    protected $fillable = [
        'student_id',
        'corox_model_id',
        'subject_id',
        'term',
        'class_id',
        'mark',
        'mark_type',
        'year',
        'register_date',
        'register_time',
    ];
    public $timestamps=false;
   protected $table='register_aggregator';
   protected $primaryKey='id';
}


