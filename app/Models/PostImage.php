<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{
    use HasFactory;

    const PATH = "images/Posts/"; 

    protected $fillable = 
    [
        "post_id",
        "images",
    ];
}

