<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'qty',
        'price',
        'description',
        'image',
        'category_id',
        'barcode'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function stockHistories()
    {
        return $this->hasMany(StockHistory::class);
    }
}
