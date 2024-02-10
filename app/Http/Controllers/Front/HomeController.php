<?php

namespace App\Http\Controllers\Front;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Banner;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index() {
        try {
            $banners = new Banner;
            $all_top_sliders = $banners->getTopActiveSliders();
            $all_middle_sliders = $banners->getMiddleActiveSliders();

            $categories = new Category;
            $all_categories = $categories->getActiveCategories();

            $product  =  new Product;
            $featured_products = $product->getAllFeaturedProducts();

            $sub_category = Category::whereNotNull('categories.parent_id')->whereNotNull('categories.description')->first();
            if(!empty($sub_category)) {
                $sub_cat_product  =  new Product;
                $sub_cat_products = $sub_cat_product->getAllHomeSubCatProducts($sub_category->id);

                $sub_category->sub_cat_products = $sub_cat_products;
            }

            $product  =  new Product;
            $bottom_products = $product->getAllBottomProducts();

            $testimonials = new Testimonial;
            $all_testimonials = $testimonials->getActiveTestimonial();
            // echo "<pre>"; print_r($sub_category); die;
            return view('front.modules.home.index',compact("all_top_sliders", "all_middle_sliders","all_categories","featured_products", "sub_category", "all_testimonials"));
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }
    }

    public function setCurrency(Request $request)
    {
        // Retrieve the selected currency from the request
        $selectedCurrency = $request->input('currency');
        // Set the selected currency in the session
        $request->session()->put('currency', $selectedCurrency);

        // You can return a response if needed
        return back();
    }
}
