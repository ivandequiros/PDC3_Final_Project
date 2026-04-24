<?php

namespace App\Models;

// IMPORTANT: Use the Authenticatable class
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Users extends Authenticatable // NOT extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'username',
        'password',
        'role_id',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
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
        'password' => 'hashed',
    ];

    /**
     * Get the logs associated with the user.
     */
    public function logs()
    {
        return $this->hasMany(Logs::class, 'user_id'); 
    }

    /**
     * Get the role associated with the user.
     */
    public function role()
    {
        return $this->belongsTo(UserRoles::class, 'role_id');
    }

    /**
     * Get the transactions processed by this user.
     */
    public function transactions()
    {
        return $this->hasMany(Transactions::class, 'user_id');
    }
}