<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;

class User extends Authenticatable implements CanResetPassword
{
    use HasFactory, Notifiable, CanResetPasswordTrait;

    public $timestamps = true; // (created_at, updated_at)

    
    protected $fillable = [
        'username',  
        'email',     
        'password',  
        'role',     
        'reset_token', 
    ];

    public function employee()
    {
        return $this->hasOne(Employee::class, 'user_id');
    }
    public function admin()
    {
        return $this->hasOne(Admin::class, 'user_id');
    }
    protected $hidden = [
        'password',
        'remember_token',
        'reset_token', 
    ];

    /**
     * Cast attributes.
     */
    protected $casts = [
        'password' => 'hashed', 
        'created_at' => 'datetime',
    ];

    //for debug
    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            dump("Before user creation:", $user->toArray()); // Dump user data before creation
        });

        static::created(function ($user) {
            dump("User created successfully!", $user->toArray()); // Dump user data after creation
        });
    }
   
    public function generateResetToken()
    {
        $token = \Illuminate\Support\Str::random(60);
        $this->reset_token = bcrypt($token); // Hash token for security
        $this->save();
        return $token;
    }

    
    public function verifyResetToken($token)
    {
        return \Illuminate\Support\Facades\Hash::check($token, $this->reset_token);
    }


}
