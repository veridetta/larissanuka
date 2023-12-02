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
    //relasi customer sama-sama menggunakan user_id
    public function customer()
    {
        return $this->hasMany(Customer::class, 'user_id');
    }
    //relasi dimension
    public function dimension()
    {
        return $this->hasOne(Dimension::class);
    }
    //relasi favorit
    public function favorit()
    {
        return $this->hasMany(Favorit::class);
    }
    //boot slug
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            Product::where('isPromosi', true)->update(['isPromosi' => false]);
            $product->slug = Str::slug($product->nama);

        });
        static::updating(function($product){
            Product::where('isPromosi', true)->update(['isPromosi' => false]);
        });
    }


}
