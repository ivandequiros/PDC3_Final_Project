<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRoles extends Model
{
    use HasFactory;

    // Explicitly binding the table name just to be safe
    protected $table = 'user_roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_name',
        'permissions',
    ];

    /**
     * Get the users assigned to this role.
     */
    public function users()
    {
        return $this->hasMany(Users::class, 'role_id');
    }
}