<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use File;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    function getImageAttribute($value = ""){
        if($value != "" && File::exists(Config('constant.CATEGORY_IMAGE_ROOT_PATH').$value)){
            return  Config('constant.CATEGORY_IMAGE_URL').$value;
        }
    }

    function getActiveCategories(){

        $all_categories 			=   Category::where('categories.parent_id', null)->where('categories.is_active', 1)->where('categories.is_deleted', 0)
                                            ->select('categories.id','categories.parent_id','categories.name','categories.slug','categories.description','categories.image','categories.thumbnail_image','categories.video','categories.category_order')->orderBy('category_order', 'ASC')->get()->toArray();
        return $all_categories;
    }

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
