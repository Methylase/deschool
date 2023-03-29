<?php

namespace Deschool\Models;

use Illuminate\Database\Eloquent\Model;

class RegisterStationeries extends Model
{
    protected $fillable = [
        'corox_model_id',
        'stationary_name',
        'stationary_status',
        'stationary_quantity',
        'stationary_amount',
    ];
     public $timestamps=false;
   protected $table='register_stationeries';
   protected $primaryKey='id';
}
