<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibraryPost extends Model
{
    use HasFactory;

    protected $table = 'library_posts';

    protected $fillable = [
        'title',
        'subtitle',
        'content',
        'public'
    ];
}
