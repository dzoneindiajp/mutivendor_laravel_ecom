<?php

use App\Models\Acl;
use  App\Models\Department;
use  App\Models\Designation;
use  App\Models\ProductVariantCombination;
use  App\Models\ProductVariantCombinationImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Cart;
use App\Models\Wishlist;
use App\Models\PriceDrop;
use App\Models\Currency;
use Carbon\Carbon;

  function sideBarNavigation($menus, $children2Data = ""){

    $website_url  = Config('constant.WEBSITE_URL');
    $treeView	=	"";
    $segment3	=	Request()->segment(2);
    $segment4	=	Request()->segment(2);
    $segment5	=	Request()->segment(3);
    $segment6	=	Request()->segment(4);

    if(!empty($menus)){

      // dd($menus);
      $treeView	.=	empty($children2Data) ? "<ul class='main-menu'>" : "<ul class='slide-menu child2'>" ;
      foreach($menus as $record){
        // dd($menus);
        $currentSection	=	"";
        $currentPlugin	=	"";
        $plugin			=	explode('/',$record->path);
        $pluginSlug3	=	isset($plugin[1])?$plugin[1]:'';
        $myArray		=	[];
        $myArray1		=	[];
        if(!empty($record->children)){
          $plugin_array	=	"";
          $plugin_array1	=	"";
          foreach($record->children as $li_record){
            $plugin			=	explode('/',$li_record->path);
            $slug			=	isset($plugin[0])?$plugin[0]:'';
            $slug1			=	isset($plugin[1])?$plugin[1]:'';
            $plugin_array 	.= 	"".$slug.",";
            $plugin_array1 	.= 	"".$slug1.",";
          }
          $myArray = explode(',', $plugin_array);
          $myArray1 = explode(',', $plugin_array1);
        }
        $class = (in_array($segment3,$myArray1) && ($segment3 != '')) ? 'open':''; #*

        $classActive		=	($pluginSlug3 == $segment3)?"active":'';
        $style = (in_array($segment3,$myArray1) && ($segment3 != '')) ? 'display:block;':'display:none;';
        $classActive1 = "";


        $path	=	((!empty($record->path) && ($record->path != 'javascript::void()') && ($record->path != 'javascript::void(0)') && ($record->path != 'javascript:void()') && ($record->path != 'javascript::void();') && ($record->path != 'javascript:void(0);'))?URL($record->path):'javascript:void(0)');

        $second_icon	=	((!empty($record->path) && ($record->path == 'javascript::void()') || ($record->path == 'javascript::void(0)') || ($record->path == 'javascript:void()') || ($record->path == 'javascript::void();') || ($record->path == 'javascript:void(0);'))?'fe fe-chevron-right side-menu__angle':'');


        if((!empty($record->path) && ($record->path != 'javascript::void()') && ($record->path != 'javascript::void(0)') )){
          $pluginData			=	explode('/',$record->path);
          $plugin				=	isset($pluginData[0])?$pluginData[0]:'';
          $plugin1			=	isset($pluginData[1])?$pluginData[1]:'';
          $classActive1		=	((($plugin == $segment3 && ($plugin1 == "")) || ($plugin1 == $segment3) || ($plugin == $segment3 && ($plugin1 == "user-chat")))?'active':'');
        }
        $treeView .= "<li class='slide ".(!empty($record->children)? 'has-sub '.$class:' ').' '.$classActive1."' ><a href='".$path."' class='side-menu__item ".$classActive1."'>"."<i class='".$record->icon."'></i><span class='menu-text'>$record->title</span><i class='".$second_icon."'></i></a>";

        if(!empty($record->children)){
          $treeView	.= "<ul class='slide-menu child1'>";
          // <li class='slide has-sub' >
          // <span class='menu-link'>
          //   <span class='menu-text'>".$record->title."</span>
          // </span>
          // </li>";

          foreach($record->children as $li_record){

            $path	=	((!empty($li_record->path) && ($li_record->path != 'javascript::void()') && ($li_record->path != 'javascript::void(0)') && ($li_record->path != 'javascript:void()') && ($li_record->path != 'javascript:void(0);'))?URL($li_record->path):'javascript:void(0)');
            $second_icon	=	((!empty($li_record->path) && ($li_record->path == 'javascript::void()') || ($li_record->path == 'javascript::void(0)') || ($li_record->path == 'javascript:void()') || ($li_record->path == 'javascript::void();') || ($li_record->path == 'javascript:void(0);'))?'fe fe-chevron-right side-menu__angle':'');
            $classss = (in_array($segment3,$myArray1) && ($segment3 != '')) ? 'open':'';
            $plugin			=	explode('/',$li_record->path);
            $currentPlugin	=	isset($plugin[1])?$plugin[1]:'';

            $currentPlugin1	=	isset($plugin[2])?$plugin[2]:'';

            $currentPlugin2	=	isset($plugin[3])?$plugin[3]:'';

            $activeClass = "";

            if(  (!empty($segment5) && $segment5 == $currentPlugin1 && $segment5 =='Speaker' ) || (!empty($segment6) && $segment6 == $currentPlugin1 && $segment6=='Speaker' ) ){

              $activeClass =  "active";
            }elseif( (!empty($segment5) && $segment5 == $currentPlugin1  && $segment5 =='Assistant' ) ||  (!empty($segment6) && $segment6 == $currentPlugin1 && $segment6=='Assistant' )){
              $activeClass =  "active";
            }elseif( $segment4=='lookups-manager'){
              if(!empty($segment5) && $segment4=='lookups-manager' ){

              }
            }elseif($segment4=='settings'){

                if( $currentPlugin2 == $segment6 ){
                  $activeClass =  "active";

                }elseif( $currentPlugin2 == $segment6 ){
                  $activeClass =  "active";

                }elseif( $currentPlugin2 == $segment6 ){
                  $activeClass =  "active";

                }

            }else{
              if( $currentPlugin == $segment4 && $segment4 !='settings' && $segment4!='lookups-manager' && $segment5 !='Speaker' && $segment6 !='Speaker' && $segment5 !='Assistant' && $segment6 !='Assistant'  )
              $activeClass =  "active";
            }


                $treeView .= "<li class='slide ".(!empty($li_record->children)? 'has-sub '.$classss:' ').' '.$activeClass."' >
                <a href='".$path."' class='side-menu__item'>".$li_record->title."
                <i class='".$second_icon."'></i></a>";
            if(!empty($li_record->children)){
              $treeView  .= sideBarNavigation($li_record->children,"Yes");
            }
            $treeView  .= "</li>";
          }
          $treeView  .= "</ul>";
        }
        $treeView  .= "</li>";
      }
      $treeView  .= "</ul>";
    }

    return $treeView;
}

  function functionCheckPermission($function_name = ""){
    if( Auth::user()->id != 1){


    $user_id				  =	Auth::user()->id;

    $permissionData			=	DB::table("user_permission_actions")
                              ->select("user_permission_actions.is_active")
                              ->leftJoin("acl_admin_actions","acl_admin_actions.id","=","user_permission_actions.admin_module_action_id")
                              ->where('user_permission_actions.user_id',$user_id)
                              ->where('user_permission_actions.is_active',1)
                              ->where('acl_admin_actions.function_name',$function_name)
                              ->first();

      if(!empty($permissionData)){
          return 1;
        }else{
          return 0;
        }
      }else {
        return 1;
      }
}

 function  getActiveLanguages() {

  $languages		=	DB::table("languages")->get()->toArray();
  return $languages;
}

if(!function_exists('AclParnentByName'))
{
    function AclparentByName($parentid=Null)
    {
      $parentidname='';
        if(!empty($parentid))
        {

        $parentidname=Acl::where('id',$parentid)->value('title');
        return $parentidname;
        }
    }
}

if(!function_exists('DepartmentbyName'))
{
    function DepartmentbyName($Departid=Null)
    {
      $Departmentname='';
        if(!empty($Departid))
        {

        $Departmentname=Department::where('id',$Departid)->value('name');
        return $Departmentname;
        }
    }
}

if(!function_exists('DesignationbyName'))
{
    function DesignationbyName($Desid=Null)
    {
        if(!empty($Desid))
        {
          $Desginationname='';
        $Desginationname=Designation::where('id',$Desid)->value('name');
        return $Desginationname;
        }
    }
}
if(!function_exists('getCartData'))
{
  function getCartData(){
    if(auth()->guard('customer')->check()){
      $cartData = Cart::where('user_id',auth()->guard('customer')->user()->id)->select('product_id','quantity')->get()->toArray();
    }else{

      $cartData = session()->get('cartData', []);
    }
    if(!empty($cartData)){
      foreach($cartData as &$cartVal){
        $productDetails = ProductVariantCombination::where('product_variant_combinations.id',$cartVal['product_id'] ?? 0)->leftJoin('products','products.id','product_variant_combinations.product_id')->select('product_variant_combinations.*','products.name')->first();
        $cartVal['product_name'] = $productDetails->name ?? '';
        $cartVal['product_price'] = ($productDetails->selling_price?? 0) * ($cartVal['quantity'] ?? 0) ;
        $cartVal['buying_price'] = ($productDetails->buying_price?? 0) * ($cartVal['quantity'] ?? 0) ;
        $productImage = ProductVariantCombinationImage::where('product_variant_combination_images.product_variant_combination_id',$productDetails->id)->leftJoin('product_images','product_images.id','product_variant_combination_images.product_image_id')->value('product_images.image');
        $cartVal['product_image'] = (!empty($productImage)) ? Config('constant.PRODUCT_IMAGE_URL') . $productImage : Config('constant.IMAGE_URL') . "noimage.png";
      }
    }

    return $cartData;
  }
}

function isCouponValid($coupon_code = "") {
  $response = array();
  // Check if session data exists
  if (!Session::has('cartData')) {
      $response["status"] = "error";
      $response["msg"] = "Cart is empty!";
      $response["price"] = "";
      return $response;
  }

  // Retrieve coupon details from the database
  $coupon = Coupon::where('coupon_code', $coupon_code)
                   ->leftjoin('coupon_assigns', 'coupon_assigns.coupon_id', 'coupons.id')
                   ->whereDate('start_date', '<=', now())
                   ->whereDate('end_date', '>=', now())
                   ->select('coupons.*', 'coupon_assigns.reference_id')
                   ->first();

  if (!$coupon) {
      $response["status"] = "error";
      $response["msg"] = "coupon code does not exist!";
      $response["price"] = "";
      return $response;
  }

  if(auth()->guard('customer')->check()){
    $cartData = Cart::where('user_id',auth()->guard('customer')->user()->id)->select('product_id','quantity')->get()->toArray();
    $cart_total = 0;
    if( $coupon->is_assign == 1) {
      if ($coupon->assign_type == "user" && $coupon->reference_id == auth()->guard('customer')->user()->id) {
        if(!empty($cartData)){
          foreach($cartData as $cart_data) {
            $cart_total_product = getDropPrices($cart_data['product_id']);
            $cart_total = $cart_total+$cart_total_product*$cart_data['quantity'];
          }
        }

        if ($cart_total < $coupon->min_amount) {
          $more_amount = $coupon->min_amount - $cart_total;
            $response["status"] = "error";
            $response["msg"] = "Cart value is low for this coupon code. Please add $more_amount amount of product.";
            $response["price"] = "";
            return $response;
        }

        $discounted_price = 0;
        if ($coupon->coupon_type == "flat"){
          $discounted_price = $coupon->amount;
          $cart_total = $cart_total - $discounted_price;
        } else {
          $discounted_price = $coupon->amount;
          $cart_total = $cart_total - ($cart_total*$discounted_price)/100;
        }

        $response["status"] = "error";
        $response["msg"] = "Coupon applied successfully.";
        $response["price"] = $cart_total;
        $response["discounted_price"] = $discounted_price;

        return $response;
      }

    } else {
      if(!empty($cartData)){
        foreach($cartData as $cart_data) {
          $cart_total_product = getDropPrices($cart_data['product_id']);
          $cart_total = $cart_total+$cart_total_product*$cart_data['quantity'];
        }
      }

      if ($cart_total < $coupon->min_amount) {
        $more_amount = $coupon->min_amount - $cart_total;
          $response["status"] = "error";
          $response["msg"] = "Cart value is low for this coupon code. Please add $more_amount amount of product.";
          $response["price"] = "";
          return $response;
      }
      $discounted_price = 0;
      if ($coupon->coupon_type == "flat"){
        $discounted_price = $coupon->amount;
        $cart_total = $cart_total - $discounted_price;
      } else {
        $discounted_price = $coupon->amount;
        $cart_total = $cart_total - ($cart_total*$discounted_price)/100;
      }

      $response["status"] = "error";
      $response["msg"] = "Coupon applied successfully.";
      $response["price"] = $cart_total;
      $response["discounted_price"] = $discounted_price;
    }

  }

  return $response;
}

if(!function_exists('getDropPrices')){
  function getDropPrices($id = "", $type = "", $with_sign = "") {
    $response = array();
    $product_variant_combinations = ProductVariantCombination::where('product_variant_combinations.id', $id ?? 0)
      ->leftJoin('products', 'products.id', 'product_variant_combinations.product_id')
      ->select('product_variant_combinations.*', 'products.category_id', 'products.sub_category_id', 'products.child_category_id')
      ->first();

    $price = ($type == "buying") ? $product_variant_combinations->buying_price : $product_variant_combinations->selling_price;

    $now = Carbon::now();
    $endOfDay = $now->copy()->endOfDay();

    $drop_prices_data = PriceDrop::leftJoin('price_drop_assigns', 'price_drop_assigns.price_drop_id', 'price_drops.id')
                                ->whereDate('price_drops.start_date', '<=', $now)
                                ->whereDate('price_drops.end_date', '>=', $endOfDay)

                                ->where(function ($query) use ($product_variant_combinations) {
                                    $query->where(function ($innerQuery) use ($product_variant_combinations) {
                                        $innerQuery->where(function ($query) use ($product_variant_combinations) {
                                                      $query->where('reference_id', $product_variant_combinations->category_id)
                                                          ->orWhere('reference_id', $product_variant_combinations->sub_category_id)
                                                          ->orWhere('reference_id', $product_variant_combinations->child_category_id);
                                                  })
                                                  ->where('price_drops.assign_type', 'category');
                                    })->orWhere(function ($innerQuery) use ($product_variant_combinations) {
                                        $innerQuery->where('reference_id', $product_variant_combinations->product_id)
                                                  ->where('price_drops.assign_type', 'product');
                                    });
                                })
                                ->select('price_drops.*', 'price_drop_assigns.reference_id')
                                ->first();

    if($drop_prices_data->drop_type == "flat") {
      if($drop_prices_data->gain_type == "gain"){
        $price = $price + $drop_prices_data->amount;
      } else {
        $price = $price - $drop_prices_data->amount;
      }
    } else {
      $percentage_amount = ($price*$drop_prices_data->amount)/100;
      if($drop_prices_data->gain_type == "gain"){
        $price = $price + $percentage_amount;
      } else {
        $price = $price - $percentage_amount;
      }

    }

    if(Session::has('currency')) {
      $currency = Session::get('currency');
      $default_currency = Currency::where('is_default', 1)->where('is_active', 1)->first();

      if($currency != $default_currency->currency_code ) {
        $user_currency_data = Currency::where('currency_code', $currency)->where('is_active', 1)->first();

        $price = ($user_currency_data->amount*$price)/$default_currency->amount;

      }

      if ($with_sign == "yes") {
        $user_currency_data = Currency::where('currency_code', $currency)->where('is_active', 1)->first();
        $price = $user_currency_data->symbol.$price;
      }
    }

    return $price;
  }
}




if(!function_exists('getCheckoutData'))
{
  function getCheckoutData(){
    $checkoutData = session()->get('checkoutData', []);
    if(!empty($checkoutData)){
      foreach($checkoutData as &$cartVal){
        $productDetails = ProductVariantCombination::where('product_variant_combinations.id',$cartVal['product_id'] ?? 0)->leftJoin('products','products.id','product_variant_combinations.product_id')->select('product_variant_combinations.*','products.name')->first();
        $cartVal['product_name'] = $productDetails->name ?? '';
        $cartVal['product_price'] = ($productDetails->selling_price?? 0) * ($cartVal['quantity'] ?? 0) ;
        $cartVal['buying_price'] = ($productDetails->buying_price?? 0) * ($cartVal['quantity'] ?? 0) ;
        $productImage = ProductVariantCombinationImage::where('product_variant_combination_images.product_variant_combination_id',$productDetails->id)->leftJoin('product_images','product_images.id','product_variant_combination_images.product_image_id')->value('product_images.image');
        $cartVal['product_image'] = (!empty($productImage)) ? Config('constant.PRODUCT_IMAGE_URL') . $productImage : Config('constant.IMAGE_URL') . "noimage.png";
      }
    }

    return $checkoutData;
  }
}

if(!function_exists('isProductAddedInCart'))
{
  function isProductAddedInCart($productId){
    if(auth()->guard('customer')->check()){
      $cartData = Cart::where('user_id',auth()->guard('customer')->user()->id)->select('product_id','quantity')->get()->toArray();
    }else{

      $cartData = session()->get('cartData', []);
    }
    if(!empty($cartData)){
      foreach($cartData as $cartVal){
        if($productId == $cartVal['product_id']){
          return true;
        }
      }
    }

    return false;
  }
}

if(!function_exists('isProductAddedInWishlist'))
{
  function isProductAddedInWishlist($productId){
    if(auth()->guard('customer')->check()){
      
      $cartData = Wishlist::where('user_id',auth()->guard('customer')->user()->id)->select('product_id')->get()->toArray();
      
      if(!empty($cartData)){
        foreach($cartData as $cartVal){
          if($productId == $cartVal['product_id']){
            return true;
          }
        }
      }
    }
    
    return false;
  }
}



