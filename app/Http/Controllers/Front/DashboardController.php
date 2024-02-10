<?php

namespace App\Http\Controllers\Front;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\AuthRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Redirect,Session,Config,DB,Response,Str;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\Wishlist;
use App\Models\ProductVariantCombination;
use App\Models\ProductVariantCombinationImage;
use App\Models\Order;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
class DashboardController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user = User::where('id',Auth::guard('customer')->user()->id)->first();
            return view('front.modules.dashboard.index',compact('user'));
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Somethig went wrong', 'error_msg' => $e->getMessage()]);
        }
    }
    public function addresses(Request $request)
    {
        try {
            $userAddresses = UserAddress::where('user_id',Auth::guard('customer')->user()->id)->get();

            return view('front.modules.dashboard.addresses',compact('userAddresses'));
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Somethig went wrong', 'error_msg' => $e->getMessage()]);
        }
    }
    public function orders(Request $request)
    {
        // try {
            $active_orders = Order::whereNotIn('status', ['delivered', 'cancelled', 'returned'])->get();


            return view('front.modules.dashboard.orders',compact('active_orders'));
        // } catch (Exception $e) {
        //     Log::error($e);
        //     return redirect()->back()->with(['error' => 'Somethig went wrong', 'error_msg' => $e->getMessage()]);
        // }
    }
    public function wishlist(Request $request)
    {
        // try {
            $wishlistData = Wishlist::where('user_id',auth()->guard('customer')->user()->id)->select('product_id')->get()->toArray();
            if(!empty($wishlistData)){
                foreach($wishlistData as &$cartVal){
                  $productDetails = ProductVariantCombination::leftJoin('products','products.id','product_variant_combinations.product_id')->leftJoin('categories', 'products.category_id', '=', 'categories.id')->where('product_variant_combinations.id',$cartVal['product_id'] ?? 0)->select('product_variant_combinations.*','products.name','categories.name as category_name')->first();
                  $cartVal['product_name'] = $productDetails->name ?? '';
                  $cartVal['product_price'] = ($productDetails->selling_price?? 0)  ;
                  $cartVal['buying_price'] = ($productDetails->buying_price?? 0) ;
                  $cartVal['category_name'] = ($productDetails->category_name?? '') ;
                  $cartVal['slug'] = ($productDetails->slug?? '') ;
                  $cartVal['product_image'] = ProductVariantCombinationImage::where('product_variant_combination_images.product_variant_combination_id',$productDetails->id)->leftJoin('product_images','product_images.id','product_variant_combination_images.product_image_id')->limit(2)->pluck('product_images.image')->toArray();
                    if(!empty($cartVal['product_image'])){
                        $tempProductImages = [];

                        foreach ($cartVal['product_image'] as $productImageKey => $productImage) {
                            $productImage = (!empty($productImage)) ? Config('constant.PRODUCT_IMAGE_URL') . $productImage : Config('constant.IMAGE_URL') . "noimage.png";
                            $tempProductImages[$productImageKey] = $productImage;
                        }
                        $cartVal['product_image'] = $tempProductImages;
                    }

                    $cartVal['isProductAddedIntoCart'] = isProductAddedInCart($productDetails->id) ? 1 : 0;
                    $cartVal['isProductAddedIntoWishlist'] = isProductAddedInWishlist($productDetails->id) ? 1 : 0;

                }
            }
            return view('front.modules.dashboard.wishlist',compact('wishlistData'));
        // } catch (Exception $e) {
        //     Log::error($e);
        //     return redirect()->back()->with(['error' => 'Somethig went wrong', 'error_msg' => $e->getMessage()]);
        // }
    }

    public function updateProfile(Request $request)
    {
            $formData = $request->all();
            if (!empty($formData)) {
                $validator = Validator::make(
                    $request->all(),
                    array(
                        'image'      => 'nullable|mimes:jpg,jpeg,png',
                        'first_name' => 'required',
                        'last_name' => 'required',
                        'email' => ['required','email', Rule::unique('users')->ignore(auth()->guard('customer')->user()->id)->where('user_role_id',config('constant.ROLE_ID.CUSTOMER_ROLE_ID'))],
                        'phone_number' =>  ['required','numeric', Rule::unique('users')->ignore(auth()->guard('customer')->user()->id)->where('user_role_id',config('constant.ROLE_ID.CUSTOMER_ROLE_ID')),'digits:10'],

                    ),
                    array(

                        "image.mimes" => trans("The image field must be a file of type jpg jpeg png"),
                        "first_name.required" => trans("The first name field is required"),
                        "last_name.required" => trans("The last name field is required"),
                        "phone_number.required" => trans("The phone number field is required"),
                        "email.required" => trans("The email field is required"),
                        "email.email" => trans("The email field must be a valid email address"),
                        "email.unique" => trans("The email has already been taken"),

                    )
                );
                if ($validator->fails()) {
                    $response = $this->change_error_msg_layout($validator->errors()->getMessages());
                    return Response::json($response, 200);
                } else {
                   DB::beginTransaction();
                   $obj   = User::find(Auth::guard('customer')->user()->id);
                   $obj->name = $request->first_name." ".$request->last_name;
                   $obj->phone_number = $request->phone_number;
                   $obj->email = $request->email;
                   if ($request->hasFile('image')) {
                        $extension = $request->file('image')->getClientOriginalExtension();
                        $originalName = $request->file('image')->getClientOriginalName();
                        $fileName = time() . '-image.' . $extension;

                        $folderName = strtoupper(date('M') . date('Y')) . "/";
                        $folderPath = Config('constant.USER_IMAGE_ROOT_PATH') . $folderName;
                        if (!File::exists($folderPath)) {
                            File::makeDirectory($folderPath, $mode = 0777, true);
                        }
                        if ($request->file('image')->move($folderPath, $fileName)) {
                            $obj->image = $folderName . $fileName;
                        }
                    }
                    $obj->save();
                    $lastId = $obj->id;
                    if (empty($lastId)) {
                        DB::rollback();
                        $response = array();
                        $response["status"] = "error";
                        $response["msg"] = trans("Something went wrong");
                        $response["data"] = (object) array();
                        $response["http_code"] = 500;
                        return Response::json($response, 500);
                    }
                    DB::commit();

                    $response = array();
                    $response["status"] = "success";
                    $response["msg"] = trans("Profile Updated Successfully");
                    $response["data"] = (object) array();
                    $response["http_code"] = 200;
                    return Response::json($response, 200);

                }
            } else {
                $response = array();
                $response["status"] = "error";
                $response["msg"] = trans("Invalid request");
                $response["data"] = (object) array();
                $response["http_code"] = 500;
                return Response::json($response, 500);
            }

    }

    public function changePassword(Request $request)
    {
        $user = User::where('id',auth()->guard('customer')->user()->id)->first();
            $formData = $request->all();
            if (!empty($formData)) {
                Validator::extend('current_password_check', function ($attribute, $value, $parameters, $validator) use ($user) {
                    return Hash::check($value, $user->password);
                });
                $validator = Validator::make(
                    $request->all(),
                    array(
                        'current_password' => (!empty($user->password)) ? 'required|current_password_check' : '',
                        'new_password' => ['required', Password::min(8)],
                        'confirm_password' => 'required|required_with:new_password|min:8|same:new_password'

                    ),
                    array(

                        "current_password.current_password_check" => trans("The password entered is invalid"),
                        "current_password.required" => trans("The current password field is required"),
                        "new_password.required" => trans("The new password field is required"),
                        "new_password.min" => trans("The new password must be atleast 8 characters"),
                        "confirm_password.required" => trans("The confirm password field is required"),
                        "confirm_password.same" => trans("The confirm password should be same as new password")

                    )
                );
                if ($validator->fails()) {
                    $response = $this->change_error_msg_layout($validator->errors()->getMessages());
                    return Response::json($response, 200);
                } else {
                   DB::beginTransaction();
                   $obj   = User::find(Auth::guard('customer')->user()->id);
                   $obj->password = Hash::make($request->new_password);
                    $obj->save();
                    $lastId = $obj->id;
                    if (empty($lastId)) {
                        DB::rollback();
                        $response = array();
                        $response["status"] = "error";
                        $response["msg"] = trans("Something_went_wrong");
                        $response["data"] = (object) array();
                        $response["http_code"] = 500;
                        return Response::json($response, 500);
                    }
                    DB::commit();



                    $response = array();
                    $response["status"] = "success";
                    $response["msg"] = trans("Password Changed Successfully");
                    $response["data"] = (object) array();
                    $response["http_code"] = 200;
                    return Response::json($response, 200);

                }
            } else {
                $response = array();
                $response["status"] = "error";
                $response["msg"] = trans("Invalid request");
                $response["data"] = (object) array();
                $response["http_code"] = 500;
                return Response::json($response, 500);
            }

    }

    public function addAddress(Request $request)
    {
            $formData = $request->all();
            if (!empty($formData)) {
                $validator = Validator::make(
                    $request->all(),
                    array(
                        'name'      => 'required',
                        'email' => ['required','email'],
                        'phone_number' =>  ['required','numeric','digits:10'],
                        'country'      => 'required',
                        'address_line_1'      => 'required',
                        'postal_code' => 'required',
                        'city' => 'required',
                        'state' => 'required',
                    )
                );
                if ($validator->fails()) {
                    $response = $this->change_error_msg_layout($validator->errors()->getMessages());
                    return Response::json($response, 200);
                } else {
                   DB::beginTransaction();
                   $obj   = new UserAddress;
                   $obj->user_id = Auth::guard('customer')->user()->id;
                   $obj->name = !empty($request->name) ? $request->name : NULL;
                   $obj->email = !empty($request->email) ? $request->email : NULL;
                   $obj->phone_number = !empty($request->phone_number) ? $request->phone_number : NULL;
                   $obj->country = !empty($request->country) ? $request->country : NULL;
                   $obj->address_line_1 = !empty($request->address_line_1) ? $request->address_line_1 : NULL;
                   $obj->address_line_2 = !empty($request->address_line_2) ? $request->address_line_2 : NULL;
                   $obj->postal_code = !empty($request->postal_code) ? $request->postal_code : NULL;
                   $obj->city = !empty($request->city) ? $request->city : NULL;
                   $obj->state = !empty($request->state) ? $request->state : NULL;
                   $obj->landmark = !empty($request->landmark) ? $request->landmark : NULL;
                   $checkUserAddresses = UserAddress::where('user_id',Auth::guard('customer')->user()->id)->where('is_primary',1)->count();
                   if($checkUserAddresses == 0){
                    $obj->is_primary = 1;
                   }
                   $obj->save();

                    $lastId = $obj->id;
                    if (empty($lastId)) {
                        DB::rollback();
                        $response = array();
                        $response["status"] = "error";
                        $response["msg"] = trans("Something went wrong");
                        $response["data"] = (object) array();
                        $response["http_code"] = 500;
                        return Response::json($response, 500);
                    }
                    DB::commit();

                    $response = array();
                    $response["status"] = "success";
                    $response["msg"] = trans("Address added Successfully");
                    $response["data"] = (object) array();
                    $response["http_code"] = 200;
                    return Response::json($response, 200);

                }
            } else {
                $response = array();
                $response["status"] = "error";
                $response["msg"] = trans("Invalid request");
                $response["data"] = (object) array();
                $response["http_code"] = 500;
                return Response::json($response, 500);
            }

    }

    public function editAddress(Request $request,$addressId)
    {
            $formData = $request->all();
            if (!empty($formData)) {
                $validator = Validator::make(
                    $request->all(),
                    array(
                        'name'      => 'required',
                        'email' => ['required','email'],
                        'phone_number' =>  ['required','numeric','digits:10'],
                        'country'      => 'required',
                        'address_line_1'      => 'required',
                        'postal_code' => 'required',
                        'city' => 'required',
                        'state' => 'required',
                    )
                );
                if ($validator->fails()) {
                    $response = $this->change_error_msg_layout($validator->errors()->getMessages());
                    return Response::json($response, 200);
                } else {
                   DB::beginTransaction();
                   $obj   = UserAddress::find($addressId);
                   $obj->name = !empty($request->name) ? $request->name : NULL;
                   $obj->email = !empty($request->email) ? $request->email : NULL;
                   $obj->phone_number = !empty($request->phone_number) ? $request->phone_number : NULL;
                   $obj->country = !empty($request->country) ? $request->country : NULL;
                   $obj->address_line_1 = !empty($request->address_line_1) ? $request->address_line_1 : NULL;
                   $obj->address_line_2 = !empty($request->address_line_2) ? $request->address_line_2 : NULL;
                   $obj->postal_code = !empty($request->postal_code) ? $request->postal_code : NULL;
                   $obj->city = !empty($request->city) ? $request->city : NULL;
                   $obj->state = !empty($request->state) ? $request->state : NULL;
                   $obj->landmark = !empty($request->landmark) ? $request->landmark : NULL;
                   $obj->save();

                    $lastId = $obj->id;
                    if (empty($lastId)) {
                        DB::rollback();
                        $response = array();
                        $response["status"] = "error";
                        $response["msg"] = trans("Something went wrong");
                        $response["data"] = (object) array();
                        $response["http_code"] = 500;
                        return Response::json($response, 500);
                    }
                    DB::commit();

                    $response = array();
                    $response["status"] = "success";
                    $response["msg"] = trans("Address updated Successfully");
                    $response["data"] = (object) array();
                    $response["http_code"] = 200;
                    return Response::json($response, 200);

                }
            } else {
                $response = array();
                $response["status"] = "error";
                $response["msg"] = trans("Invalid request");
                $response["data"] = (object) array();
                $response["http_code"] = 500;
                return Response::json($response, 500);
            }

    }

    public function deleteAddress(Request $request,$addressId)
    {
        $checkIfAddressExists = UserAddress::where('id',$addressId)->first();
        if(!empty($checkIfAddressExists)){

            UserAddress::where('id',$addressId)->delete();
            if($checkIfAddressExists->is_primary == 1){
                $addressCount = UserAddress::where('user_id',$checkIfAddressExists->user_id)->count();
                if($addressCount > 0){

                    UserAddress::where('user_id',$checkIfAddressExists->user_id)->first()->update(['is_primary' => 1]);
                }
            }
            Session()->flash('flash_notice', 'Address deleted successfully');
            return Redirect::route('front-user.addresses');
        }else{
            Session()->flash('error', 'Invalid Request');
            return Redirect::route('front-user.addresses');
        }

    }
    public function makeAddressPrimary(Request $request,$addressId)
    {
        $checkIfAddressExists = UserAddress::where('id',$addressId)->first();
        if(!empty($checkIfAddressExists)){

            UserAddress::where('user_id',$checkIfAddressExists->user_id)->update(['is_primary' => 0]);
            UserAddress::where('id',$addressId)->update(['is_primary' => 1]);

            Session()->flash('flash_notice', 'Address status changed successfully');
            return Redirect::route('front-user.addresses');
        }else{
            Session()->flash('error', 'Invalid Request');
            return Redirect::route('front-user.addresses');
        }

    }


}
