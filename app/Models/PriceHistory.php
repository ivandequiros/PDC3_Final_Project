<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceHistory extends Model
{
    use HasFactory;

    // Explicitly binding the table name
    protected $table = 'price_history';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'old_price',
        'new_price',
        'change_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'old_price'   => 'decimal:2',
        'new_price'   => 'decimal:2',
        'change_date' => 'datetime',
    ];

    /**
     * Get the product associated with this price history record.
     */
    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
}