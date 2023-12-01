<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    //relasi user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    //relasi transaction detail
    public function transactionDetail()
    {
        return $this->hasMany(TransactionDetail::class);
    }
    //relasi service
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
