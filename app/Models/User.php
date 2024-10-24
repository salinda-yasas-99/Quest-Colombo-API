<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $table = 'user'; 

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        
        'username',
        'email',
        'password',
        'role',
        'status',
        'points',
        'tier'
    ];

    // Automatically encrypt the password when it's set
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    // Implementing JWTSubject methods
    public function getJWTIdentifier()
    {
        return $this->getKey();  // Return the model's primary key as identifier
    }

    public function getJWTCustomClaims()
    {
        return [
            'uid' => $this->getKey(),  
            'username' => $this->username,
            'email' => $this->email,
            'role' => $this->role,
        ];
    }

   
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'user_id');
    }
}
