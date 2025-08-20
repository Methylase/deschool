<?php

namespace Deschool\Models;

use Illuminate\Database\Eloquent\Model;

class RegisterResultEstimator extends Model
{
    protected $fillable = [
        'corox_model_id',
        'estimator_type',
        'estimator_value',
    ];
    public $timestamps=false;
   protected $table='register_result_estimator';
   protected $primaryKey='id';
}
