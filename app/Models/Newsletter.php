<?php

namespace Deschool\Models;

use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{

    protected $fillable = ['name', 'email'];
    protected $table='newsletter';
    protected $primaryKey='id';

}
