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

    function getImageAttribute($value = ""){
        if($value != "" && File::exists(Config('constant.PRODUCT_IMAGE_ROOT_PATH').$value)){
            return  Config('constant.PRODUCT_IMAGE_URL').$value;
        }else {
            return  Config('constant.WEBSITE_IMG_URL')."astro/noimage.png";
        }
    }
    public function frontProductImage() {
        return $this->hasOne(ProductImage::class)->where('is_front', 1);
    }







}
