<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    //relasi product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    //realasi user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
