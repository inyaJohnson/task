<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Client extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['password', 'is_verified', 'consultant_id', 'name', 'email', 'phone', 'address', 'registered_address', 'is_public_entity', 'nature_of_business', 'doubts'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function engagement(){
        return $this->hasMany(Engagement::class);
    }

    public function directors(){
        return $this->hasMany(ClientDirector::class)->select('consultant_id', 'client_id', 'name', 'units_held', 'designation');
    }

    public function subsidiaries(){
        return $this->hasMany(ClientSubsidiary::class)->select('consultant_id', 'client_id', 'name', 'percentage_holding', 'nature', 'nature_of_business');
    }

    public function consultant(){
        return $this->belongsTo(User::class, 'consultant_id')->select('id','first_name', 'last_name', 'email', 'phone', 'password', 'is_verified', 'user_type_id');
    }

    public function fullName(): string
    {
        return $this->name;
    }
}
