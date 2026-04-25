<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    use HasFactory;

    // Optional: Only needed if Laravel looks for 'transactions' and gets confused by the plural class name
    protected $table = 'transactions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'date',
        'user_id',
        'total_amount',
        'promo_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date'         => 'datetime',
        'total_amount' => 'decimal:2',
    ];

    /**
     * Get the user who processed the transaction.
     */
    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }

    /**
     * Get the promo applied to the transaction.
     */
    public function promo()
    {
        return $this->belongsTo(DiscountsPromos::class, 'promo_id');
    }

    /**
     * Get the line items (details) for this transaction.
     */
    public function details()
{
    return $this->hasMany(TransactionDetails::class, 'transaction_id');
}

    /**
     * Get the return message associated with this transaction, if any.
     */
    /**
     * Get the return/refund record associated with this transaction, if any.
     */
    public function returnRefund()
    {
        return $this->hasOne(ReturnsRefunds::class, 'transaction_id');
    }
}