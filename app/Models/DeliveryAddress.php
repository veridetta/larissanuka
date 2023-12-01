<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryAddress extends Model
{
    use HasFactory;
    //relasi transaction
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
