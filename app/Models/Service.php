<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    //relasi transaction
    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }
}
