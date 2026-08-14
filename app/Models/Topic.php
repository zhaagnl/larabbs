<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body', 'user_id', 'category_id', 'reply_count', 'view_count', 'last_reply_user_id', 'order', 'excerpt', 'slug'];

    // 一个话题属于一个分类，一对一关系
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // 一个话题属于一个作者
    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
