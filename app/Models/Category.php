<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use File;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // function getImageAttribute($value = ""){
    //     if($value != "" && File::exists(Config('constant.CATEGORY_IMAGE_ROOT_PATH').$value)){
    //         return  Config('constant.CATEGORY_IMAGE_URL').$value;
    //     }
    // }

    function getThumbnailImageAttribute($value = ""){
        if($value != "" && File::exists(Config('constant.CATEGORY_IMAGE_ROOT_PATH').$value)){
            return  Config('constant.CATEGORY_IMAGE_URL').$value;
        }
    }

    function getVideoAttribute($value = ""){
        if($value != "" && File::exists(Config('constant.CATEGORY_VIDEO_ROOT_PATH').$value)){
            return  Config('constant.CATEGORY_VIDEO_URL').$value;
        }
    }
}
