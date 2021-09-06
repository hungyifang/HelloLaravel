<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_like extends Model
{
    use HasFactory;

    // public function users()
    // {
    //     return $this->belongsToMany(User::class, 'user_likes', 'user_id');
    // }

    // public function articles()
    // {
    //     return $this->belongsToMany(Article::class, 'user_likes', 'article_id');
    // }

    protected $fillable = ['doLike', 'user_id', 'article_id'];

}
