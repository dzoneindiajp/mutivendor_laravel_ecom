<?php

namespace App\Http\Controllers\Front;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\ProductVariantCombination;
use App\Models\ProductVariantCombinationImage;

class ShopController extends Controller
{
    public function index(Request $request,$categoryId = null,$subCategoryId = null,$childCategory = null) {
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
            $offset = !empty($request->input('offset')) ? $request->input('offset') : 0;
            $limit = !empty($request->input('limit')) ? $request->input('limit') : Config("Reading.records_per_page");
            
            if (!empty($request->all())) {
                $searchData = $request->all();
                
                if ((isset($searchData['min_price'])) && (isset($searchData['max_price']))) {
                    $DB->whereBetween('product_variant_combinations.selling_price', [$searchData['min_price'], $searchData['max_price']]);
                }
            }
            
            if(!empty($request->sortBy) && $request->sortBy == 'a_z'){
                $DB->orderBy('products.name','asc');
            }elseif(!empty($request->sortBy) && $request->sortBy == 'z_a'){
                $DB->orderBy('products.name','desc');
            }elseif(!empty($request->sortBy) && $request->sortBy == 'low_high'){
                $DB->orderBy('product_variant_combinations.selling_price','asc');
            }elseif(!empty($request->sortBy) && $request->sortBy == 'high_low'){
                $DB->orderBy('product_variant_combinations.selling_price','desc');
            }else{
                $DB->orderBy('product_variant_combinations.created_at','desc');
            }
            
            $totalResults = $DB->count();
            // print_r($totalResults);die;
            $results = $DB->select('product_variant_combinations.*','products.name','categories.name as category_name')->groupBy('product_variant_combinations.id')->offset($offset)->limit($limit)->get();
            if($results->isNotEmpty()){
                foreach($results as $result){
                    $result->productImages = ProductVariantCombinationImage::where('product_variant_combination_images.product_variant_combination_id',$result->id)->leftJoin('product_images','product_images.id','product_variant_combination_images.product_image_id')->limit(2)->pluck('product_images.image')->toArray();
                    if(!empty($result->productImages)){
                        $tempProductImages = [];

                        foreach ($result->productImages as $productImageKey => $productImage) {
                            $productImage = (!empty($productImage)) ? Config('constant.PRODUCT_IMAGE_URL') . $productImage : Config('constant.IMAGE_URL') . "noimage.png";
                            $tempProductImages[$productImageKey] = $productImage;
                        }
                        $result->isProductAddedIntoCart = isProductAddedInCart($result->id) ? 1 : 0;
                        $result->productImages = $tempProductImages;
                    }
                }
            }
            
            
            if ($request->ajax()) {

                return View("front.modules.shop.load_more_data", compact('results', 'totalResults'));
            } else {

                $categories = Category::whereNull('parent_id')->where('is_deleted', 0)->get();
                return view('front.modules.shop.index', compact('results', 'categories', 'totalResults'));

            }
            
        // } catch (Exception $e) {
        //     Log::error($e);
        //     return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        // }
    }
}
