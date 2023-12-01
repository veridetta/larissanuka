<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;
    //relasi
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    //relasi transactionDetail
    public function transactionDetail()
    {
        return $this->hasMany(TransactionDetail::class);
    }
    //relasi productImage
    public function productImage()
    {
        return $this->hasMany(ProductImage::class);
    }
    //relasi rating
    public function rating()
    {
        return $this->hasMany(Rating::class);
    }
    //boot slug
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            $product->slug = Str::slug($product->nama);
        });
    }

}
