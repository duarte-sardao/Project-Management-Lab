<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumPost extends Model
{
    use HasFactory;

    protected $table = 'forum_posts';

    protected $fillable = [
        'title',
        'post_id',
    ];
    
    public function answers()
    {
      return $this->hasMany(Answer::class)->select('id', 'post_id', 'forum_post_id');
    }

    public function topics()
    {
      return $this->belongsToMany(Topic::class, 'topic_post');
    } 

    public function post() {
      return $this->belongsTo(Post::class);
    }
}
