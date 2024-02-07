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
    public function addToCart(Request $request) {
        try {
            $productId = $request->input('product_id');
            $quantity = $request->input('quantity');

            if(auth()->guard('customer')->check()){
                $isProductAddedInCartAlready = Cart::where('user_id',auth()->guard('customer')->user()->id)->where('product_id',$productId)->first();
                if(!empty($isProductAddedInCartAlready)){
                    Cart::where('user_id',auth()->guard('customer')->user()->id)->where('product_id',$productId)->update(['quantity' => $isProductAddedInCartAlready->quantity + $quantity]);
                }else{
                    $obj   = new Cart;
                    $obj->user_id = auth()->guard('customer')->user()->id;
                    $obj->product_id = $productId;
                    $obj->quantity = $quantity;
                    $obj->save();
                }
            }else{
                $cart = session()->get('cartData', []);
                $isProductAddedInCartAlready = 0;
                // Check if the product is already in the cart
                foreach ($cart as &$item) {
                    if ($item['product_id'] === $productId) {
                        $item['quantity'] += $quantity;
                        $isProductAddedInCartAlready = 1;
                    }
                }
                if($isProductAddedInCartAlready == 0){
    
                    // If the product is not in the cart, add it
                    $newProduct = [
                        'product_id' => $productId,
                        'quantity' => $quantity,
                    ];
                    $cart[] = $newProduct;
                }
                session()->put('cartData', $cart);
            }
        
            if($request->ajax()){
                $cartData = getCartData();
                $htmlData = View('front.includes.cart_data',compact('cartData'))->render();
                $count = count($cartData);
                return response()->json(['success' => true,'data' => ['htmlData' => $htmlData, 'count' => $count]]);
            }else{
                
                return Redirect()->back()->with(['success' => 'Product has been added to cart successfully']);
            }
            
            
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }
    }

    public function removeFromCart(Request $request) {
        try {
            $productId = $request->input('product_id');

            $cart = session()->get('cartData', []);
           
            // print_r($cart);die;
            $isProductAddedInCartAlready = 0;
            // Check if the product is already in the cart
            foreach ($cart as $key => &$item) {
                if ($item['product_id'] === $productId) {
                   unset($cart[$key]);
                }
            }
            
            session()->put('cartData', $cart);
            if ($request->ajax()) {
                $cartData = getCartData();
                $htmlData = View('front.includes.cart_data',compact('cartData'))->render();
                $count = count($cartData);
                return response()->json(['success' => true,'data' => ['htmlData' => $htmlData, 'count' => $count]]);
            }else{
                return redirect()->route('front-cart.index')->with('success','Product removed from cart successfully');
            }
           
            
            
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }
    }

    


}
