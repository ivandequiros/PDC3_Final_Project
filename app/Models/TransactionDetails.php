<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetails extends Model
{
    use HasFactory;

    // Explicitly binding the table name
    protected $table = 'transaction_details';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'transaction_id',
        'product_id',
        'quantity',
        'unit_price',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'quantity'   => 'integer',
        'unit_price' => 'decimal:2',
    ];

    /**
     * Get the parent transaction for this detail record.
     */
    public function transaction()
    {
        return $this->belongsTo(Transactions::class, 'transaction_id');
    }

    /**
     * Get the product associated with this detail record.
     */
    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
}