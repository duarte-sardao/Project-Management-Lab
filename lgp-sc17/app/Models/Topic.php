<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $table = 'topics';

    protected $fillable = [
        'topic',
        'color',
    ];

    public function posts() {
        return $this->belongsToMany(ForumPost::class, 'topic_post');
    }

    public function userFollows($user_id) {
        return $this->hasMany(Follow::class)->where('user_id', $user_id)->first();
    }
}
