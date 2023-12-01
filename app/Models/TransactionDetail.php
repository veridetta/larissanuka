<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;
    //relasi product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    //relasi transaction
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

}
