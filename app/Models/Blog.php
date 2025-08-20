<?php

namespace Deschool\Models;

use Illuminate\Database\Eloquent\Model;
use Deschool\Models\Comment;
use Deschool\Models\User;
class Blog extends Model
{

    protected $fillable = ['type', 'title',  'description', 'image', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class)->whereNull('parent_id')->latest();
    }
}
