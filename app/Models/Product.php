<?php

namespace App\Models;

use App\Models\ChildCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\ProductImage;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $appends = [
        'front_image_url','back_image_url',
    ];

    public function frontProductImage() {
        return $this->hasOne(ProductImage::class)->where('is_front', 1);
    }






}
