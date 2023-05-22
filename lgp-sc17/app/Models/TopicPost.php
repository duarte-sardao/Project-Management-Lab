<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopicPost extends Model
{
    use HasFactory;

    protected $table = 'topic_post';

    protected $fillable = [
        'forum_post_id',
        'topic_id',
    ];
    
}
