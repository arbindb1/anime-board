<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anime extends Model
{
    protected $fillable = [
        'title',
        'image_url',
        'score',
        'rank', // integer
        'popularity', // integer
        'format', // string, e.g., 'TV Series'
        'episodes', // integer
        'status', // string
        'season', // string
        'genres', // array of strings
        'user_rating', // integer 0-5
        'global_score', // decimal:1
        'description', // text
        'mal_id', // integer
        'progress', // integer
        'group_name', // string
        'sort_order', // integer
    ];

    protected $casts = [
        'genres' => 'array',
        'score' => 'decimal:1',
    ];
}
