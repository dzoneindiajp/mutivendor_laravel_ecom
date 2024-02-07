<?php

namespace App\Http\Controllers\Front;

use App\Models\ProductDescription;
use Exception,DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\ProductVariantCombination;
use App\Models\ProductVariantCombinationImage;
use App\Models\ProductSpecification;
use App\Models\ProductVariant;
use App\Models\ProductVariantValue;

class ShopController extends Controller
{
    public function index(Request $request,$categorySlug = null,$subCategorySlug = null,$childCategorySlug = null) {
        // try {
            $DB = ProductVariantCombination::leftJoin('products','products.id','product_variant_combinations.product_id')->leftJoin('categories', 'products.category_id', '=', 'categories.id');
            $categoriesData = Category::whereNull('parent_id')->where('is_deleted', 0)->where('is_active',1)->get();

            if(!empty($categorySlug)){
                $categoryId = Category::where('slug',$categorySlug)->value('id');
                $DB->where('products.category_id',$categoryId);
                $categoriesData = Category::where('parent_id',$categoryId)->where('is_deleted', 0)->where('is_active',1)->get();
            }
            if(!empty($categorySlug) && !empty($subCategorySlug)){
                $categoryId = Category::where('slug',$categorySlug)->value('id');
                $subCategoryId = Category::where('parent_id',$categoryId)->where('slug',$subCategorySlug)->value('id');
                $DB->where('products.category_id',$categoryId)->where('products.sub_category_id',$subCategoryId);
                $categoriesData = Category::where('parent_id',$subCategoryId)->where('is_deleted', 0)->where('is_active',1)->get();
            }
            if(!empty($categorySlug) && !empty($subCategorySlug) && !empty($childCategorySlug)){
                $categoryId = Category::where('slug',$categorySlug)->value('id');
                $subCategoryId = Category::where('parent_id',$categoryId)->where('slug',$subCategorySlug)->value('id');
                $childCategoryId = Category::where('parent_id',$subCategoryId)->where('slug',$childCategorySlug)->value('id');
                $DB->where('products.category_id',$categoryId)->where('products.sub_category_id',$subCategoryId)->where('products.child_category_id',$childCategoryId);
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
            $results = $DB->select('product_variant_combinations.*','products.name','categories.name as category_name',DB::raw('(SELECT name from variant_values WHERE id = product_variant_combinations.variant1_value_id ) as variant_value1_name'),DB::raw('(SELECT name from variant_values WHERE id = product_variant_combinations.variant2_value_id ) as variant_value2_name'))->groupBy('product_variant_combinations.id')->offset($offset)->limit($limit)->get();
            if($results->isNotEmpty()){
                foreach($results as $result){
                    $result->productImages = ProductVariantCombinationImage::where('product_variant_combination_images.product_variant_combination_id',$result->id)->leftJoin('product_images','product_images.id','product_variant_combination_images.product_image_id')->limit(2)->pluck('product_images.image')->toArray();
                    if(!empty($result->productImages)){
                        $tempProductImages = [];

                        foreach ($result->productImages as $productImageKey => $productImage) {
                            $productImage = (!empty($productImage)) ? Config('constant.PRODUCT_IMAGE_URL') . $productImage : Config('constant.IMAGE_URL') . "noimage.png";
                            $tempProductImages[$productImageKey] = $productImage;
                        }
                        $result->productImages = $tempProductImages;
                    }
                    $result->isProductAddedIntoCart = isProductAddedInCart($result->id) ? 1 : 0;
                    $result->isProductAddedIntoWishlist = isProductAddedInWishlist($result->id) ? 1 : 0;
                }
            }


            if ($request->ajax()) {

                return View("front.modules.shop.load_more_data", compact('results', 'totalResults'));
            } else {

                return view('front.modules.shop.index', compact('results', 'categoriesData', 'totalResults','categorySlug','subCategorySlug','childCategorySlug'));

            }

        // } catch (Exception $e) {
        //     Log::error($e);
        //     return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        // }
    }

    public function productDetail(Request $request,$productSlug) {
        // try {
            if(!empty($request->product_id)){
                $findProductCombination = ProductVariantCombination::where('product_id',$request->product_id)->where('variant1_value_id',!empty($request->variant1Id) ? $request->variant1Id : NULL )->where('variant2_value_id',!empty($request->variant2Id) ? $request->variant2Id : NULL )->first();
                if(!empty($findProductCombination)){
                    return redirect()->route('front-shop.productDetail',$findProductCombination->slug);
                }else{
                    return redirect()->back();
                }
            }
            if(!empty($request->product_id) && !empty($request->quantity) ){
                $checkoutData = ['product_id' =>$request->product_id, 'quantity' => $request->quantity ];
                session()->put('checkoutData',$checkoutData);
                session()->put('checkoutFrom','detailPage');
                return redirect()->route('front-user.checkout');
            }
            $productDetails = ProductVariantCombination::where('product_variant_combinations.slug',$productSlug)->leftJoin('products','products.id','product_variant_combinations.product_id')->leftJoin('categories', 'products.category_id', '=', 'categories.id')->select('product_variant_combinations.*','products.name','products.is_including_taxes','products.in_stock','categories.name as category_name',DB::raw('(SELECT name from variant_values WHERE id = product_variant_combinations.variant1_value_id ) as variant_value1_name'),DB::raw('(SELECT name from variant_values WHERE id = product_variant_combinations.variant2_value_id ) as variant_value2_name'))->groupBy('product_variant_combinations.id')->first();

            if(!empty($productDetails)){

                $productDetails->productImages = ProductVariantCombinationImage::where('product_variant_combination_images.product_variant_combination_id',$productDetails->id)->leftJoin('product_images','product_images.id','product_variant_combination_images.product_image_id')->select('product_images.*')->get()->toArray();
                    if(!empty($productDetails->productImages)){

                        $modifiedProductImages = [];

                        foreach ($productDetails->productImages as $productImageKey => $productImage) {
                            $imagePath = (!empty($productImage['image'])) ? Config('constant.PRODUCT_IMAGE_URL') . $productImage['image'] : Config('constant.IMAGE_URL') . "noimage.png";

                            // Add the modified image path to the new array
                            $modifiedProductImages[$productImageKey] = array_merge($productImage, ['image' => $imagePath]);
                        }
                        $productDetails->productImages = $modifiedProductImages;
                    }
                $productDetails->isProductAddedIntoCart = isProductAddedInCart($productDetails->id) ? 1 : 0;
                $productDetails->isProductAddedIntoWishlist = isProductAddedInWishlist($productDetails->id) ? 1 : 0;
                $productDetails->productDescriptions = ProductDescription::where('product_id',$productDetails->product_id)->get();
                $productDetails->productSpecifications = ProductSpecification::leftJoin('specifications','product_specifications.specification_id','specifications.id')->leftJoin('specification_values','product_specifications.specification_value_id','specification_values.id')->where('product_specifications.product_id',$productDetails->product_id)->select('product_specifications.specification_id','specifications.name',DB::raw('GROUP_CONCAT(specification_values.name) as specification_values_names'))->groupBy('product_specifications.specification_id')->get();
                $productDetails->productVariants = ProductVariant::leftJoin('variants','variants.id','product_variants.variant_id')->where('product_variants.product_id',$productDetails->product_id)->select('product_variants.*','variants.name')->get();
                if($productDetails->productVariants->isNotEmpty()){
                    foreach($productDetails->productVariants as $productVariant){
                        $productVariant->variantValuesData = ProductVariantValue::where('product_variant_values.product_veriant_id',$productVariant->id)->leftJoin('variant_values','variant_values.id','product_variant_values.veriant_value_id')->select('product_variant_values.*','variant_values.name')->get();
                    }
                }

            }else{
                return redirect()->back()->with(['error' => 'Invalid Request']);
            }
            // echo "<pre>";
            // print_r($productDetails);die;

            return View("front.modules.shop.product-detail", compact('productDetails'));

        // } catch (Exception $e) {
        //     Log::error($e);
        //     return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        // }
    }
}
