<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Users extends Authenticatable
{
    use HasFactory, Notifiable;

    // Explicitly binding the table name
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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