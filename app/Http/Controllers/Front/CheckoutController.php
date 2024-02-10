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
use App\Models\UserAddress;
use App\Models\PaymentMethod;
use App\Models\ProductVariantCombinationImage;
use Session,Auth;
class CheckoutController extends Controller
{

    public function index(Request $request) {
        // try {
            $userAddresses = UserAddress::where('user_id',Auth::guard('customer')->user()->id)->get();
            $paymentMethods = PaymentMethod::where('is_active',1)->get();
            if(!empty($request->action) && $request->action == 'addressSelect'){
                $addressData = UserAddress::where('id',$request->address_id ?? 0)->first();
                if(!empty($addressData)){
                    setDeliveryChargesIntoCheckoutSession($addressData->postal_code,$request->address_id);
                }
                return redirect()->back()->with('flash_notice','Address changes successfully');
               
            }
            if(!empty($request->action) && $request->action == 'applyCoupon'){
                $applyCouponResponse = isCouponValid($request->coupon_code);
                
                return redirect()->back()->with($applyCouponResponse['status'],$applyCouponResponse['msg']);
               
            }
            $checkoutData = session()->has('checkoutData') ? session()->get('checkoutData') : [];
            $checkoutItemData = getCheckoutItemData();
            
            if(count($checkoutItemData) == 0 || count($checkoutData) == 0){
                return redirect()->route('front-cart.index');
            }
            // print_r($checkoutItemData);die;
            return view('front.modules.checkout.index',compact('checkoutItemData','checkoutData','userAddresses','paymentMethods'));
        // } catch (Exception $e) {
        //     Log::error($e);
        //     return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        // }
    }

    


}
