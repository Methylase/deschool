<?php

namespace Deschool\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
   
    public $timestamps=false;
protected $table='roles';
   protected $primaryKey='id';
  public function users(){
      return  $this->hasMany(Corox_model::class);
        
     }
           public function isNumbersUsers($find){
      foreach($this->users()->get() as $user){
            if($user->username==$find){
              return $user->username;
            }else{
              return 'no user';
            }
      }
     }
}
