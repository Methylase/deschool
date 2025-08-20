<?php

namespace Deschool\Models;

use Illuminate\Database\Eloquent\Model;

class Memo extends Model
{
    protected $fillable = [
        'corox_model_id',
        'sender_email',
        'subject',
        'message',
        'receiver_email',
    ];
    public $timestamps=false;
   protected $table='register_memo';
   protected $primaryKey='id';
}
