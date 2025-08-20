<?php

namespace Deschool\Models;

use Illuminate\Database\Eloquent\Model;

class Booked extends Model
{

    protected $fillable = ['name', 'email',  'class_id'];
    protected $table='booked';
    protected $primaryKey='id';

}
