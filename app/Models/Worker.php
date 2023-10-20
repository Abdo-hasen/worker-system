<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject; 

class Worker extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    const PATH = "images/workers/"; 

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'location',
        'image',
        "status"
    ];

    protected $hidden = 
    [
        "password"
    ];

  
 
    
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     */
    public function getJWTCustomClaims() {
        return [];
    } 
    
    public function posts()
    {
        return $this->hasMany(Post::class)->select("content","price","worker_id","id");
    }
}
