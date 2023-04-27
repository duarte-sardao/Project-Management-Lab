<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $fillable = [
        'content',
        'posted_at',
        'author',
    ];

    protected $casts = [
        'posted_at' => 'datetime',
    ];

    public function likes() {
        return $this->hasMany(Like::class);
    }

    public function user() {
        return $this->belongsTo(User::class, 'author');
    }

    public function userLikes($user_id) {
        return $this->hasMany(Like::class)->where('user_id',$user_id)->first();
    }
}
