<?php

namespace App\Http\Controllers\Front;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Cart;
use App\Models\ProductVariantCombination;
use App\Models\ProductVariantCombinationImage;
use Session;
class CheckoutController extends Controller
{

    public function index(Request $request) {
        try {
            $checkoutData = getCheckoutData();
            
            if(count($checkoutData) == 0){
                return redirect()->route('front-cart.index');
            }
            return view('front.modules.checkout.index',compact('checkoutData'));
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }
    }

    


}
