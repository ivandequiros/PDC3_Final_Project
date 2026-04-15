<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountsPromos extends Model
{
    use HasFactory;

    // Explicitly define the table name if Laravel's pluralization doesn't match your DB
    protected $table = 'discount_promos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'promo_name',
        'discount_percent',
        'expiry_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'discount_percent' => 'decimal:2',
        'expiry_date'      => 'datetime',
    ];

    /**
     * Get the transactions that use this promo.
     */
    public function transactions()
    {
        return $this->hasMany(Transactions::class, 'promo_id');
    }
}