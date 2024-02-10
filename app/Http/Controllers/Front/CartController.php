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
use App\Models\Wishlist;
use App\Models\ProductVariantCombination;
use App\Models\ProductVariantCombinationImage;
use App\Models\CategoryTax;
use Session;
class CartController extends Controller
{

    public function index(Request $request) {
        // try {
            if(!empty($request->checkoutFrom) ){
                if (auth()->guard('customer')->check()) {
                    $cartData = Cart::where('user_id', auth()->guard('customer')->user()->id)->select('product_id', 'quantity')->get()->toArray();
                  } else {
              
                    $cartData = session()->get('cartData', []);
                  }
               
                moveCartSessionDataToCheckoutSessionData($cartData,$request->checkoutFrom);
           
                return redirect()->route('front-user.checkout');
            }
            $cartData = getCartData();

            if(count($cartData) == 0){
                return redirect()->route('front-home.index')->with('error','Cart is empty');
            }
            return view('front.modules.cart.index',compact('cartData'));
        // } catch (Exception $e) {
        //     Log::error($e);
        //     return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        // }
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
            if(auth()->guard('customer')->check()){
                Cart::where('user_id',auth()->guard('customer')->user()->id)->where('product_id',$productId)->delete();
            }else{
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
            }
 
            if ($request->ajax()) {
                $cartData = getCartData();
                $htmlData = View('front.includes.cart_data',compact('cartData'))->render();
                $count = count($cartData);
                return response()->json(['success' => true,'data' => ['htmlData' => $htmlData, 'count' => $count]]);
            }else{
                return redirect()->back()->with('success','Product removed from cart successfully');
            }



        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }
    }

    public function addToWishlist(Request $request) {
        try {
            
            $productId = $request->input('product_id');
            if(!empty($request->action) && $request->action == 'move'){
                Cart::where('user_id',auth()->guard('customer')->user()->id)->where('product_id',$productId)->delete();
            }

            $isProductAddedInWishlistAlready = Wishlist::where('user_id',auth()->guard('customer')->user()->id)->where('product_id',$productId)->first();
            if(empty($isProductAddedInWishlistAlready)){
                $obj   = new Wishlist;
                $obj->user_id = auth()->guard('customer')->user()->id;
                $obj->product_id = $productId;
                $obj->save();
            }


            if($request->ajax()){
                $count = Wishlist::where('user_id',auth()->guard('customer')->user()->id)->count();
                return response()->json(['success' => true,'data' => ['count' => $count]]);
            }else{
                
                return Redirect()->back()->with(['success' => 'Product has been added to wishlist successfully']);
            }
            
            
            
            
            
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }
    }

    public function removeFromWishlist(Request $request) {
        try {
            $productId = $request->input('product_id');
         
            Wishlist::where('user_id',auth()->guard('customer')->user()->id)->where('product_id',$productId)->delete();
            
            if ($request->ajax()) {
                $count = Wishlist::where('user_id',auth()->guard('customer')->user()->id)->count();
                return response()->json(['success' => true,'data' => [ 'count' => $count]]);
            }else{
                return redirect()->route('front-user.wishlist')->with('success','Product removed from wishlist successfully');
            }
            
               
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }
    }

}
