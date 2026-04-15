<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LowStockAlerts extends Model
{
    use HasFactory;

    // Explicitly binding the table name
    protected $table = 'low_stock_alerts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'threshold',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'threshold' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Get the product being monitored by this alert.
     */
    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
}