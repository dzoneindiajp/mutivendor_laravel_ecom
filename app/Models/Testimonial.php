<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use File;

class Testimonial extends Model
{
    use HasFactory;
    public $table = 'testimonials';

    function getActiveTestimonial($searchData=array()){
        $language_id	        =   getCurrentLanguage();

        $Testimonial                 =  Testimonial::query();
        if(!empty($searchData["name"])){
            $name       =  $searchData["name"];
            $Testimonial    =  $Testimonial->where("testimonial_descriptions.name","LIKE","%".$name."%");
        }
        if(!empty($searchData["city"])){
            $city       =  $searchData["city"];
            $Testimonial    =  $Testimonial->where("testimonial_descriptions.city","LIKE","%".$city."%");
        }
        $all_testimonials 			=   $Testimonial->where('testimonials.is_active', 1)
                                            ->leftjoin('testimonial_descriptions','testimonial_descriptions.parent_id','testimonials.id')
                                            ->where('testimonial_descriptions.language_id',$language_id)
                                            ->select('testimonials.id','testimonial_descriptions.name','testimonial_descriptions.description','testimonial_descriptions.city','testimonials.image','testimonials.rating')->orderBy("testimonial_descriptions.created_at","DESC")->get()->toArray();
                                        
        return $all_testimonials;
    }

    function getImageAttribute($value = ""){
        if($value != "" && File::exists(Config('constants.TESTIMONIAL_IMAGE_ROOT_PATH').$value)){
            return  Config('constants.TESTIMONIAL_IMAGE_URL').$value;
        }else {
            return  Config('constants.WEBSITE_IMG_URL')."astro/noimage.png";
        }
    }
}
