<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    // Explicitly binding the table name
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'category_id',
        'supplier_id',
        'stock_level',
        'current_price',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'stock_level'   => 'integer',
        'current_price' => 'decimal:2',
    ];

    /**
     * Get the category that this product belongs to.
     */
    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }

    /**
     * Get the supplier that provides this product.
     */
    public function supplier()
    {
        return $this->belongsTo(Suppliers::class, 'supplier_id');
    }

    /**
     * Get the transaction details (sales) for this product.
     */
    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetails::class, 'product_id');
    }

    /**
     * Get the inventory logs tracking this product.
     */
    public function inventoryLogs()
    {
        return $this->hasMany(InventoryLogs::class, 'product_id');
    }

    /**
     * Get the price history records for this product.
     */
    public function priceHistory()
    {
        return $this->hasMany(PriceHistory::class, 'product_id');
    }

    /**
     * Get the low stock alerts configured for this product.
     */
    public function lowStockAlerts()
    {
        return $this->hasMany(LowStockAlerts::class, 'product_id');
    }
}