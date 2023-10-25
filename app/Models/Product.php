<?php

namespace App\Models;

use App\Models\ChildCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = ['id'];

    protected $appends = [
        'front_image_url','back_image_url',
    ];

    public function getFrontImageUrlAttribute()
    {
        $frontImage = $this->front_image ?? null;
        $frontImageUrl = null;
        if (! empty($frontImage) && Storage::exists($frontImage)) {
            $frontImageUrl = url(Storage::url($frontImage));
        }

        return $frontImageUrl;
    }

    public function getBackImageUrlAttribute()
    {
        $backImage = $this->back_image ?? null;
        $backImageUrl = null;
        if (! empty($backImage) && Storage::exists($backImage)) {
            $backImageUrl = url(Storage::url($backImage));
        }

        return $backImageUrl;
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class,'sub_category_id','id');
    }

    public function childCategory()
    {
        return $this->belongsTo(ChildCategory::class,'child_category_id','id');
    }
}
