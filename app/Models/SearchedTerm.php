<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchedTerm extends Model
{
    use HasFactory;

    protected $fillable = ['term', 'caches', 'pages'];

    protected $casts = [
        'caches' => 'json'
    ];
}
