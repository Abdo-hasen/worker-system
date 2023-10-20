<?php
namespace App\Models;
use Laravel\Paddle\Billable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, Billable;

    const PATH = "images/clients/"; 

    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
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
}
