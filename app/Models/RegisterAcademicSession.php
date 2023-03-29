<?php

namespace Deschool\Models;

use Illuminate\Database\Eloquent\Model;

class RegisterAcademicSession extends Model
{
    protected $fillable = [
        'corox_model_id',
        'term',
        'session',
    ];
    public $timestamps=false;
   protected $table='register_academic_session';
   protected $primaryKey='id';
}
