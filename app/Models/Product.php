<?php

namespace App\Models;

use App\Models\ChildCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

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


}
