<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorit extends Model
{
    use HasFactory;
    //relasi
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    //user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    //productImage
    public function productImage()
    {
        return $this->belongsTo(ProductImage::class,'product_id','product_id');
    }
}
