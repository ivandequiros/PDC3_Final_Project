<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }

    protected $fillable = ['user_id', 'action', 'timestamp'];
}
