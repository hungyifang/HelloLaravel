<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(related:User::class);
    }

    public function likes()
    {
        // Model: User -- (pivot) User_like -- Article
        // Table: users - (pivot) user_likes - articles
        //第二個參數是自訂關聯表名稱,照預設會是 article_user
        //第三個參數是自訂關聯表的 table 名稱,照預設會是 user_like_id
        return $this->belongsToMany(User::class, 'user_likes');
    }

    protected $fillable = ['title', 'content', 'state', 'likes', 'viewed'];
}
