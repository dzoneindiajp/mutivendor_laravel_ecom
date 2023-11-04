<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index() {
        try {
            $categoriesCount = Category::whereNull('parent_id')->count();
            $usersCount = User::where('is_deleted',0)->where('user_role_id',config('constant.ROLE_ID.CUSTOMER_ROLE_ID'))->count();
            $productsCount = Product::count();
            return view('admin.dashboard',compact('categoriesCount','productsCount','usersCount'));
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }
    }
}
