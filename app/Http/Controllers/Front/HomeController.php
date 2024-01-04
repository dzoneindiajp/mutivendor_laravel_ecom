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

class HomeController extends Controller
{
    public function index() {
        try {
            $banners = new Banner;
            $all_top_sliders = $banners->getTopActiveSliders();
            $all_middle_sliders = $banners->getMiddleActiveSliders();

            $categories = new Category;
            $all_categories = $categories->getActiveCategories();
            // echo "<pre>"; print_r($all_categories); die;
            return view('front.modules.home.index',compact("all_top_sliders", "all_middle_sliders","all_categories"));
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }
    }
}
