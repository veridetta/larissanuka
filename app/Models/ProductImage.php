<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    //favorit
    public function favorit()
    {
        return $this->belongsTo(Favorit::class,'product_id','product_id');
    }
}
