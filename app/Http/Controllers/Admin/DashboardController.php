<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\Product;
use App\Models\SubCategory;

class DashboardController extends Controller
{
    public function index() {
        try {
            $categoriesCount = Category::count();
            $subCategoriesCount = SubCategory::count();
            $childCategoriesCount = ChildCategory::count();
            $productsCount = Product::count();
            return view('admin.dashboard',compact('categoriesCount','subCategoriesCount','childCategoriesCount','productsCount'));
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }
    }
}
