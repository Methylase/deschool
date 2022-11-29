<?php

namespace Deschool;

use Illuminate\Database\Eloquent\Model;

class Corox_model extends Model
{
    protected $fillable = ['username', 'email', 'password'];
   public $timestamps=false;
   protected $table='corox_models';
}
