<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        "post_id",
        "client_id",
    ];

    protected $guarded = [
        "status"
    ];

    //order belongs to one client
    public function client()
    {
        return $this->belongsTo(Client::class)->select("id", "name");
    } 

    //order belongs to one post
    public function post()
    {
        return $this->belongsTo(Post::class)->select("id", "content");
    } 
}


