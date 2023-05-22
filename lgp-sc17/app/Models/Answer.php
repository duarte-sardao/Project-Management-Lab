<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $table = 'answers';

    protected $fillable = [
        'post_id',
        'forum_post_id',
    ];

    public function getForumPost()
    {
      return $this->belongsTo(ForumPost::class, 'forum_post_id');
    }

    public function post()
    {
      return $this->belongsTo(Post::class, 'post_id');
    }
    
}
