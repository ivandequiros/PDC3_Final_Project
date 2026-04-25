<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category_id', 'supplier_id', 'current_price', 'stock_level'];

    public function category() {
        return $this->belongsTo(Categories::class, 'category_id');
    }

    public function supplier() {
        return $this->belongsTo(Suppliers::class, 'supplier_id');
    }
}