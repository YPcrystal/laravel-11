<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;
    
    /**
    *fillable
    *
    *@var array
    */

    protected $fillable = [
        'image',
        'title',
        'content',
        'user_id',
        'source',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // relasi ke comment
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}