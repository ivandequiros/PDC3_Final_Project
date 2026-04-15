<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnsRefunds extends Model
{
    use HasFactory;

    // Explicitly binding the table name
    protected $table = 'returns_refunds';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'transaction_id',
        'reason',
        'refund_amount',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'refund_amount' => 'decimal:2',
    ];

    /**
     * Get the original transaction associated with this return/refund.
     */
    public function transaction()
    {
        return $this->belongsTo(Transactions::class, 'transaction_id');
    }
}