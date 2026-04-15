<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suppliers extends Model
{
    use HasFactory;

    // Explicitly binding the table name
    protected $table = 'suppliers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company_name',
        'contact_person',
        'phone',
    ];

    /**
     * Get the products supplied by this supplier.
     */
    public function products()
    {
        return $this->hasMany(Products::class, 'supplier_id');
    }

    /**
     * Get the purchase orders associated with this supplier.
     */
    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrders::class, 'supplier_id');
    }
}