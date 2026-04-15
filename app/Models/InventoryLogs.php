<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryLogs extends Model
{
    use HasFactory;

    // Explicitly binding the table name
    protected $table = 'inventory_logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'change_amount',
        'reason',
        'timestamp',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'change_amount' => 'integer',
        'timestamp'     => 'datetime',
    ];

    /**
     * Get the product associated with this inventory log.
     */
    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
}