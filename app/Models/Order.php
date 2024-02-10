<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use File;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function address()
    {
        return $this->belongsTo(UserAddress::class,'address_id','id');
    }

}
