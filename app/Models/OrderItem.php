<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use File;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    const RECEIVED = 'received';
    const CONFIRMED = 'confirmed';
    const SHIPPED = 'shipped';
    const OUT_FOR_DELIVERY = 'out_for_delivery';
    const DELIVERED = 'delivered';
    const CANCELLED = 'cancelled';
    const RETURNED = 'returned';

}
