<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use File;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

}
