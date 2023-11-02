<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use File;

class Banner extends Model
{
    use HasFactory;
    public $table = 'banners';

    function getActiveSliders(){
        $language_id	        =   getCurrentLanguage();

        $all_sliders 			=   Banner::where('banners.is_active', 1)->where('banners.is_secondary_banner',0)->where('banners.is_side_banner',0)
                                            ->leftjoin('banner_descriptions','banner_descriptions.parent_id','banners.id')
                                            ->where('banner_descriptions.language_id',$language_id)
                                            ->select('banners.id','banner_descriptions.description','banners.image','banners.mobile_image','banners.video_path','banners.is_secondary_banner','banners.is_side_banner')->get()->toArray();
        return $all_sliders;
    }

    function getActiveSecondarySlider(){
        $language_id	        =   getCurrentLanguage();

        $secondary_slider 			=   Banner::where('banners.is_active', 1)->where('banners.is_secondary_banner',1)
                                            ->leftjoin('banner_descriptions','banner_descriptions.parent_id','banners.id')
                                            ->where('banner_descriptions.language_id',$language_id)
                                            ->select('banners.id','banner_descriptions.description','banners.image','banners.mobile_image','banners.video_path','banners.is_secondary_banner','banners.is_side_banner')->first();
        return $secondary_slider;
    }
    function getActiveSideSlider(){
        $language_id	        =   getCurrentLanguage();

        $secondary_slider 			=   Banner::where('banners.is_active', 1)->where('banners.is_side_banner',1)
                                            ->leftjoin('banner_descriptions','banner_descriptions.parent_id','banners.id')
                                            ->where('banner_descriptions.language_id',$language_id)
                                            ->select('banners.id','banner_descriptions.description','banners.image','banners.mobile_image','banners.video_path','banners.is_secondary_banner','banners.is_side_banner')->first();
        return $secondary_slider;
    }

    function getImageAttribute($value = ""){
        if($value != "" && File::exists(Config('constants.BANNER_IMAGE_ROOT_PATH').$value)){
            return  Config('constants.BANNER_IMAGE_URL').$value;
        }else {
            return  Config('constants.WEBSITE_IMG_URL')."astro/noimage.png";
        }
    }

    function getMobileImageAttribute($value = ""){
        if($value != "" && File::exists(Config('constants.BANNER_IMAGE_ROOT_PATH').$value)){
            return  Config('constants.BANNER_IMAGE_URL').$value;
        }else {
            return  Config('constants.WEBSITE_IMG_URL')."astro/noimage.png";
        }
    }

}
