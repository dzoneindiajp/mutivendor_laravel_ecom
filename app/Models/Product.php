<?php

namespace App\Models;

use App\Models\ChildCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\ProductImage;
use App\Models\ProductVariantCombination;
use App\Models\ProductVariantCombinationImage;

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


    public function getAllFeaturedProducts($categoryId = null,$subCategoryId = null,$childCategory = null) {

        // try {
            $DB = ProductVariantCombination::leftJoin('products','products.id','product_variant_combinations.product_id')->leftJoin('categories', 'products.category_id', '=', 'categories.id');

            if(!empty($categoryId)){
                $DB->where('products.category_id',$categoryId);
            }
            if(!empty($subCategoryId)){
                $DB->where('products.sub_category_id',$subCategoryId);
            }
            if(!empty($childCategory)){
                $DB->where('products.child_category_id',$childCategory);
            }
            $limit = Config("Reading.records_per_page");
            // print_r($limit);die;
            // print_r($totalResults);die;
            $results = $DB->where('products.is_featured', 1)->select('product_variant_combinations.*','products.name','categories.name as category_name', 'products.is_featured')->groupBy('product_variant_combinations.id')->limit($limit)->get();
            if($results->isNotEmpty()){
                foreach($results as $result){
                    $result->productImages = ProductVariantCombinationImage::where('product_variant_combination_images.product_variant_combination_id',$result->id)->leftJoin('product_images','product_images.id','product_variant_combination_images.product_image_id')->limit(2)->pluck('product_images.image')->toArray();
                    $result->isProductAddedIntoCart = isProductAddedInCart($result->id) ? 1 : 0;
                    if(!empty($result->productImages)){
                        $tempProductImages = [];

                        foreach ($result->productImages as $productImageKey => $productImage) {
                            $productImage = (!empty($productImage)) ? Config('constant.PRODUCT_IMAGE_URL') . $productImage : Config('constant.IMAGE_URL') . "noimage.png";
                            $tempProductImages[$productImageKey] = $productImage;
                        }

                        $result->productImages = $tempProductImages;
                    }
                }
            }
            return $results;



        // } catch (Exception $e) {
        //     Log::error($e);
        //     return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        // }
    }


    public function getAllHomeSubCatProducts($subCategoryId) {

        // try {

            $DB = ProductVariantCombination::leftJoin('products','products.id','product_variant_combinations.product_id')->leftJoin('categories', 'products.category_id', '=', 'categories.id');

            if(!empty($subCategoryId)){
                $DB->where('products.sub_category_id',$subCategoryId);
            }

            $limit = Config("Reading.records_per_page");
            // print_r($limit);die;
            // print_r($totalResults);die;
            $results = $DB->where('products.is_featured', 1)->select('product_variant_combinations.*','products.name','categories.name as category_name', 'products.is_featured')->groupBy('product_variant_combinations.id')->limit($limit)->get();
            if($results->isNotEmpty()){
                foreach($results as $result){
                    $result->productImages = ProductVariantCombinationImage::where('product_variant_combination_images.product_variant_combination_id',$result->id)->leftJoin('product_images','product_images.id','product_variant_combination_images.product_image_id')->limit(2)->pluck('product_images.image')->toArray();
                    $result->isProductAddedIntoCart = isProductAddedInCart($result->id) ? 1 : 0;
                    if(!empty($result->productImages)){
                        $tempProductImages = [];

                        foreach ($result->productImages as $productImageKey => $productImage) {
                            $productImage = (!empty($productImage)) ? Config('constant.PRODUCT_IMAGE_URL') . $productImage : Config('constant.IMAGE_URL') . "noimage.png";
                            $tempProductImages[$productImageKey] = $productImage;
                        }

                        $result->productImages = $tempProductImages;
                    }
                }
            }
            return $results;



        // } catch (Exception $e) {
        //     Log::error($e);
        //     return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        // }
    }






}
