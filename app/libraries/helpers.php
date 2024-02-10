<?php

use App\Models\Acl;
use App\Models\CityPostalCode;
use App\Models\Department;
use App\Models\Designation;
use App\Models\ProductVariantCombination;
use App\Models\ProductVariantCombinationImage;
use App\Models\ShippingArea;
use App\Models\ShippingAreaCity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Cart;
use App\Models\Wishlist;
use App\Models\PriceDrop;
use App\Models\Currency;
use App\Models\Coupon;
use App\Models\ShippingCost;
use App\Models\CategoryTax;
use Carbon\Carbon;

function sideBarNavigation($menus, $children2Data = "")
{

  $website_url = Config('constant.WEBSITE_URL');
  $treeView = "";
  $segment3 = Request()->segment(2);
  $segment4 = Request()->segment(2);
  $segment5 = Request()->segment(3);
  $segment6 = Request()->segment(4);

  if (!empty($menus)) {

    // dd($menus);
    $treeView .= empty($children2Data) ? "<ul class='main-menu'>" : "<ul class='slide-menu child2'>";
    foreach ($menus as $record) {
      // dd($menus);
      $currentSection = "";
      $currentPlugin = "";
      $plugin = explode('/', $record->path);
      $pluginSlug3 = isset($plugin[1]) ? $plugin[1] : '';
      $myArray = [];
      $myArray1 = [];
      if (!empty($record->children)) {
        $plugin_array = "";
        $plugin_array1 = "";
        foreach ($record->children as $li_record) {
          $plugin = explode('/', $li_record->path);
          $slug = isset($plugin[0]) ? $plugin[0] : '';
          $slug1 = isset($plugin[1]) ? $plugin[1] : '';
          $plugin_array .= "" . $slug . ",";
          $plugin_array1 .= "" . $slug1 . ",";
        }
        $myArray = explode(',', $plugin_array);
        $myArray1 = explode(',', $plugin_array1);
      }
      $class = (in_array($segment3, $myArray1) && ($segment3 != '')) ? 'open' : ''; #*

      $classActive = ($pluginSlug3 == $segment3) ? "active" : '';
      $style = (in_array($segment3, $myArray1) && ($segment3 != '')) ? 'display:block;' : 'display:none;';
      $classActive1 = "";


      $path = ((!empty($record->path) && ($record->path != 'javascript::void()') && ($record->path != 'javascript::void(0)') && ($record->path != 'javascript:void()') && ($record->path != 'javascript::void();') && ($record->path != 'javascript:void(0);')) ? URL($record->path) : 'javascript:void(0)');

      $second_icon = ((!empty($record->path) && ($record->path == 'javascript::void()') || ($record->path == 'javascript::void(0)') || ($record->path == 'javascript:void()') || ($record->path == 'javascript::void();') || ($record->path == 'javascript:void(0);')) ? 'fe fe-chevron-right side-menu__angle' : '');


      if ((!empty($record->path) && ($record->path != 'javascript::void()') && ($record->path != 'javascript::void(0)'))) {
        $pluginData = explode('/', $record->path);
        $plugin = isset($pluginData[0]) ? $pluginData[0] : '';
        $plugin1 = isset($pluginData[1]) ? $pluginData[1] : '';
        $classActive1 = ((($plugin == $segment3 && ($plugin1 == "")) || ($plugin1 == $segment3) || ($plugin == $segment3 && ($plugin1 == "user-chat"))) ? 'active' : '');
      }
      $treeView .= "<li class='slide " . (!empty($record->children) ? 'has-sub ' . $class : ' ') . ' ' . $classActive1 . "' ><a href='" . $path . "' class='side-menu__item " . $classActive1 . "'>" . "<i class='" . $record->icon . "'></i><span class='menu-text'>$record->title</span><i class='" . $second_icon . "'></i></a>";

      if (!empty($record->children)) {
        $treeView .= "<ul class='slide-menu child1'>";
        // <li class='slide has-sub' >
        // <span class='menu-link'>
        //   <span class='menu-text'>".$record->title."</span>
        // </span>
        // </li>";

        foreach ($record->children as $li_record) {

          $path = ((!empty($li_record->path) && ($li_record->path != 'javascript::void()') && ($li_record->path != 'javascript::void(0)') && ($li_record->path != 'javascript:void()') && ($li_record->path != 'javascript:void(0);')) ? URL($li_record->path) : 'javascript:void(0)');
          $second_icon = ((!empty($li_record->path) && ($li_record->path == 'javascript::void()') || ($li_record->path == 'javascript::void(0)') || ($li_record->path == 'javascript:void()') || ($li_record->path == 'javascript::void();') || ($li_record->path == 'javascript:void(0);')) ? 'fe fe-chevron-right side-menu__angle' : '');
          $classss = (in_array($segment3, $myArray1) && ($segment3 != '')) ? 'open' : '';
          $plugin = explode('/', $li_record->path);
          $currentPlugin = isset($plugin[1]) ? $plugin[1] : '';

          $currentPlugin1 = isset($plugin[2]) ? $plugin[2] : '';

          $currentPlugin2 = isset($plugin[3]) ? $plugin[3] : '';

          $activeClass = "";

          if ((!empty($segment5) && $segment5 == $currentPlugin1 && $segment5 == 'Speaker') || (!empty($segment6) && $segment6 == $currentPlugin1 && $segment6 == 'Speaker')) {

            $activeClass = "active";
          } elseif ((!empty($segment5) && $segment5 == $currentPlugin1 && $segment5 == 'Assistant') || (!empty($segment6) && $segment6 == $currentPlugin1 && $segment6 == 'Assistant')) {
            $activeClass = "active";
          } elseif ($segment4 == 'lookups-manager') {
            if (!empty($segment5) && $segment4 == 'lookups-manager') {

            }
          } elseif ($segment4 == 'settings') {

            if ($currentPlugin2 == $segment6) {
              $activeClass = "active";

            } elseif ($currentPlugin2 == $segment6) {
              $activeClass = "active";

            } elseif ($currentPlugin2 == $segment6) {
              $activeClass = "active";

            }

          } else {
            if ($currentPlugin == $segment4 && $segment4 != 'settings' && $segment4 != 'lookups-manager' && $segment5 != 'Speaker' && $segment6 != 'Speaker' && $segment5 != 'Assistant' && $segment6 != 'Assistant')
              $activeClass = "active";
          }


          $treeView .= "<li class='slide " . (!empty($li_record->children) ? 'has-sub ' . $classss : ' ') . ' ' . $activeClass . "' >
                <a href='" . $path . "' class='side-menu__item'>" . $li_record->title . "
                <i class='" . $second_icon . "'></i></a>";
          if (!empty($li_record->children)) {
            $treeView .= sideBarNavigation($li_record->children, "Yes");
          }
          $treeView .= "</li>";
        }
        $treeView .= "</ul>";
      }
      $treeView .= "</li>";
    }
    $treeView .= "</ul>";
  }

  return $treeView;
}

function functionCheckPermission($function_name = "")
{
  if (Auth::user()->id != 1) {


    $user_id = Auth::user()->id;

    $permissionData = DB::table("user_permission_actions")
      ->select("user_permission_actions.is_active")
      ->leftJoin("acl_admin_actions", "acl_admin_actions.id", "=", "user_permission_actions.admin_module_action_id")
      ->where('user_permission_actions.user_id', $user_id)
      ->where('user_permission_actions.is_active', 1)
      ->where('acl_admin_actions.function_name', $function_name)
      ->first();

    if (!empty($permissionData)) {
      return 1;
    } else {
      return 0;
    }
  } else {
    return 1;
  }
}

function getActiveLanguages()
{

  $languages = DB::table("languages")->get()->toArray();
  return $languages;
}

if (!function_exists('AclParnentByName')) {
  function AclparentByName($parentid = Null)
  {
    $parentidname = '';
    if (!empty($parentid)) {

      $parentidname = Acl::where('id', $parentid)->value('title');
      return $parentidname;
    }
  }
}

if (!function_exists('DepartmentbyName')) {
  function DepartmentbyName($Departid = Null)
  {
    $Departmentname = '';
    if (!empty($Departid)) {

      $Departmentname = Department::where('id', $Departid)->value('name');
      return $Departmentname;
    }
  }
}

if (!function_exists('DesignationbyName')) {
  function DesignationbyName($Desid = Null)
  {
    if (!empty($Desid)) {
      $Desginationname = '';
      $Desginationname = Designation::where('id', $Desid)->value('name');
      return $Desginationname;
    }
  }
}
if (!function_exists('getCartData')) {
  function getCartData()
  {
    if (auth()->guard('customer')->check()) {
      $cartData = Cart::where('user_id', auth()->guard('customer')->user()->id)->select('product_id', 'quantity')->get()->toArray();
    } else {

      $cartData = session()->get('cartData', []);
    }
    if (!empty($cartData)) {
      foreach ($cartData as &$cartVal) {
        $productDetails = ProductVariantCombination::where('product_variant_combinations.id', $cartVal['product_id'] ?? 0)->leftJoin('products', 'products.id', 'product_variant_combinations.product_id')->select('product_variant_combinations.*', 'products.name',DB::raw('(SELECT name from variant_values WHERE id = product_variant_combinations.variant1_value_id ) as variant_value1_name'),DB::raw('(SELECT name from variant_values WHERE id = product_variant_combinations.variant2_value_id ) as variant_value2_name'))->first();
        $cartVal['product_name'] = $productDetails->name ?? '';
        $cartVal['variant_value1_name'] = $productDetails->variant_value1_name ?? '';
        $cartVal['variant_value2_name'] = $productDetails->variant_value2_name ?? '';
        $cartVal['product_price'] = ($productDetails->selling_price ?? 0) * ($cartVal['quantity'] ?? 0);
        $cartVal['buying_price'] = ($productDetails->buying_price ?? 0) * ($cartVal['quantity'] ?? 0);
        $productImage = ProductVariantCombinationImage::where('product_variant_combination_images.product_variant_combination_id', $productDetails->id)->leftJoin('product_images', 'product_images.id', 'product_variant_combination_images.product_image_id')->value('product_images.image');
        $cartVal['product_image'] = (!empty($productImage)) ? Config('constant.PRODUCT_IMAGE_URL') . $productImage : Config('constant.IMAGE_URL') . "noimage.png";
      }
    }

    return $cartData;
  }
}

function isCouponValid($coupon_code = "")
{
  $response = array();
  // Check if session data exists
  if (!Session::has('checkoutItemData')) {
    $response["status"] = "error";
    $response["msg"] = "Cart is empty!";
    $response["price"] = "";
    return $response;
  }

  $coupon = Coupon::where('coupon_code', $coupon_code)->where('is_active', 1)->first();

  if (!$coupon) {
    $response["status"] = "error";
    $response["msg"] = "Coupon code does not exist!";
    $response["price"] = "";
    return $response;
  }
  $updatedPrice = 0;
  $now = Carbon::now();
  $endOfDay = $now->copy()->endOfDay();

  $couponApplicable = false;
  if (auth()->guard('customer')->check()) {
    $checkoutItemData = session()->get('checkoutItemData') ?? [];
    if (!empty($checkoutItemData)) {
      $cartTotal = array_reduce($checkoutItemData, function($carry, $item) {
        return $carry + $item['sub_total'];
      }, 0);
      $productIds = [];
      foreach ($checkoutItemData as $checkout) {
        $product_variant_combinations = ProductVariantCombination::where('product_variant_combinations.id', $checkout['product_id'] ?? 0)
          ->leftJoin('products', 'products.id', 'product_variant_combinations.product_id')
          ->select('product_variant_combinations.*', 'products.category_id', 'products.sub_category_id', 'products.child_category_id')
          ->first();
        $checkIfCouponApplicableOnThisProduct = Coupon::where('coupons.is_active', 1)->where('coupons.coupon_code', $coupon_code)->where('coupons.min_amount','<=',$cartTotal)->leftJoin('coupon_assigns', 'coupon_assigns.coupon_id', 'coupons.id')
          ->whereDate('coupons.start_date', '<=', $now)
          ->whereDate('coupons.end_date', '>=', $endOfDay)

          ->where(function ($query) use ($product_variant_combinations) {
            $query->where(function ($innerQuery) use ($product_variant_combinations) {
              $innerQuery->where(function ($query) use ($product_variant_combinations) {
                $query->where('coupon_assigns.reference_id', $product_variant_combinations['category_id'])
                  ->orWhere('coupon_assigns.reference_id', $product_variant_combinations['sub_category_id'])
                  ->orWhere('coupon_assigns.reference_id', $product_variant_combinations['child_category_id']);
              })
                ->where('coupons.assign_type', 'category')->where('coupons.is_assign', 1);
            })->orWhere(function ($innerQuery) use ($product_variant_combinations) {
              $innerQuery->where('coupon_assigns.reference_id', $product_variant_combinations['product_id'])
                ->where('coupons.assign_type', 'product')->where('coupons.is_assign', 1);
            })->orWhere(function ($innerQuery) use ($product_variant_combinations) {
              $innerQuery->where('coupon_assigns.reference_id', auth()->guard('customer')->user()->id)
                ->where('coupons.assign_type', 'user')->where('coupons.is_assign', 1);
            })->orWhere(function ($innerQuery) {
              $innerQuery->where('coupons.is_assign', 0);
            });
          })
          ->select('coupons.*', 'coupon_assigns.reference_id')
          ->first();
          if(!empty($checkIfCouponApplicableOnThisProduct)){
            $productIds[] = $checkout['product_id'];
          }
      }

      if(!empty($productIds)){

          foreach($checkoutItemData as &$checkout1){
            if(in_array($checkout1['product_id'],$productIds)){

              if($coupon->coupon_type == 'flat'){

                $checkout1['total'] = (($checkout1['sub_total'] - ($coupon->amount/count($productIds))) > 0) ? $checkout1['sub_total'] - ($coupon->amount/count($productIds)) : 0;
                $checkout1['coupon_name'] = $coupon['coupon_code'] ?? '';
                $checkout1['coupon_discount'] = $coupon->amount/count($productIds) ?? 0;
              }else{
                $checkout1['total'] = (($checkout1['sub_total'] - ($checkout1['sub_total'] * ($coupon->amount/count($productIds)))) > 0) ? $checkout1['sub_total'] - ($checkout1['sub_total'] * ($coupon->amount/count($productIds))) : 0;
                $checkout1['coupon_name'] = $coupon['coupon_code'] ?? '';
                $checkout1['coupon_discount'] =$checkout1['sub_total'] * ($coupon->amount/count($productIds)) ?? 0;
              }
            }

          }

      }else{
        $response["status"] = "error";
        $response["msg"] = "Coupon code is not applicable on current cart items.";
        $response["price"] = "";
        return $response;
      }


    }else{
      $response["status"] = "error";
      $response["msg"] = "Cart is empty";
      $response["price"] = "";
      return $response;
    }


  }

  return $response;
}


function setDeliveryChargesIntoCheckoutSession($postalCode = "",$addressId = 0)
{
  $psotalCodeCity = CityPostalCode::where('postal_code',$postalCode)->value('city_id');
  if(!empty($psotalCodeCity)){
    $shippingAreaByCity = ShippingAreaCity::where('city_id',$psotalCodeCity)->value('shipping_area_id');
    if(!empty($shippingAreaByCity)){
      $shippingCompanyByShippingArea = ShippingArea::where('id',$shippingAreaByCity)->value('shipping_company_id');
      if(!empty($shippingCompanyByShippingArea)){
        $checkoutItemData = session()->get('checkoutItemData') ?? [];
        if (!empty($checkoutItemData)) {
          foreach ($checkoutItemData as &$checkout) {

            $productWeight = ProductVariantCombination::where('product_variant_combinations.id', $checkout['product_id'] ?? 0)
            ->value('weight');
            if(!empty($productWeight)){
              $getDeliveryAmount = ShippingCost::where('shipping_company_id',$shippingCompanyByShippingArea)->where('shipping_area_id',$shippingAreaByCity)->whereRaw('ROUND(weight) = ROUND(?)', [$productWeight])->value('amount');

              if(!empty($getDeliveryAmount)){
                $checkout['delivery'] = currencyConversionPrice($getDeliveryAmount);
                $checkout['total'] = $checkout['total'] + $checkout['delivery'];
              }
            }


          }
          // print_r($checkoutItemData);die;
          session::put('checkoutItemData',$checkoutItemData);
          $totalDeliveryCharge = array_reduce($checkoutItemData, function($carry, $item) {
            return $carry + (!empty($item['delivery']) ?  $item['delivery'] : 0);
          }, 0);
          $checkoutData = session::get('checkoutData') ?? [];
          $checkoutData['delivery'] = $totalDeliveryCharge ?? 0;
          $checkoutData['address_id'] = $addressId ?? 0;
          $checkoutData['total'] = $checkoutData['default_total'] + ($checkoutData['delivery'] ?? 0);
          session::put('checkoutData',$checkoutData);

        }
      }
    }
  }

}


if (!function_exists('getDropPrices')) {
  function getDropPrices($id = "", $hasProductData = [], $type = "", $with_sign = "")
  {
    $response = array();
    if (!empty($hasProductData)) {
      $product_variant_combinations = $hasProductData;
    } else {
      $product_variant_combinations = ProductVariantCombination::where('product_variant_combinations.id', $id ?? 0)
        ->leftJoin('products', 'products.id', 'product_variant_combinations.product_id')
        ->select('product_variant_combinations.*', 'products.category_id', 'products.sub_category_id', 'products.child_category_id')
        ->first();
    }

    $price = ($type == "buying") ? $product_variant_combinations['buying_price'] : $product_variant_combinations['selling_price'];


    $now = Carbon::now();
    $endOfDay = $now->copy()->endOfDay();

    $drop_prices_data = PriceDrop::leftJoin('price_drop_assigns', 'price_drop_assigns.price_drop_id', 'price_drops.id')
      ->whereDate('price_drops.start_date', '<=', $now)
      ->whereDate('price_drops.end_date', '>=', $endOfDay)

      ->where(function ($query) use ($product_variant_combinations) {
        $query->where(function ($innerQuery) use ($product_variant_combinations) {
          $innerQuery->where(function ($query) use ($product_variant_combinations) {
            $query->where('reference_id', $product_variant_combinations['category_id'])
              ->orWhere('reference_id', $product_variant_combinations['sub_category_id'])
              ->orWhere('reference_id', $product_variant_combinations['child_category_id']);
          })
            ->where('price_drops.assign_type', 'category');
        })->orWhere(function ($innerQuery) use ($product_variant_combinations) {
          $innerQuery->where('reference_id', $product_variant_combinations['product_id'])
            ->where('price_drops.assign_type', 'product');
        });
      })
      ->select('price_drops.*', 'price_drop_assigns.reference_id')
      ->first();
      if(!empty($drop_prices_data)){

        if ($drop_prices_data->drop_type == "flat") {
          if ($drop_prices_data->gain_type == "gain") {
            $price = $price + $drop_prices_data->amount;
          } else {
            $price = $price - $drop_prices_data->amount;
          }
        } else {
          $percentage_amount = ($price * $drop_prices_data->amount) / 100;
          if ($drop_prices_data->gain_type == "gain") {
            $price = $price + $percentage_amount;
          } else {
            $price = $price - $percentage_amount;
          }

        }
      }

    if (Session::has('currency')) {
      $currency = Session::get('currency');
      $default_currency = Currency::where('is_default', 1)->where('is_active', 1)->first();

      if ($currency != $default_currency->currency_code) {
        $user_currency_amount = Currency::where('currency_code', $currency)->where('is_active', 1)->value('amount');

        $price = ($user_currency_amount * $price) / $default_currency->amount;

      }

      if ($with_sign == "yes") {
        $userCurrencySymbol = Currency::where('currency_code', $currency)->where('is_active', 1)->value('symbol');
        $price = ($userCurrencySymbol ?? '') . $price;

      }
    }

    return $price;
  }
}


if (!function_exists('currencyConversionPrice')) {
  function currencyConversionPrice($price = "",$with_sign = "")
  {

    if (Session::has('currency')) {
      $currency = Session::get('currency');
      $default_currency = Currency::where('is_default', 1)->where('is_active', 1)->first();

      if ($currency != $default_currency->currency_code) {
        $user_currency_amount = Currency::where('currency_code', $currency)->where('is_active', 1)->value('amount');

        $price = ($user_currency_amount * $price) / $default_currency->amount;

      }

      if ($with_sign == "yes") {
        $userCurrencySymbol = Currency::where('currency_code', $currency)->where('is_active', 1)->value('symbol');
        $price = ($userCurrencySymbol ?? '') . $price;

      }
    }

    return $price;
  }
}



if (!function_exists('getCurrencySymbol')) {
  function getCurrencySymbol($currency_code = "")
  {
    $currency = Currency::where('currency_code', $currency_code)->where('is_active', 1)->value('symbol');

    return $currency;
  }
}

if (!function_exists('getStatusValue')) {
  function getStatusValue($status = "")
  {
    $statusValue = "";

    if ($status == "received"){
        $statusValue = "Received";
    } elseif ($status == "confirmed"){
        $statusValue = "Confirmed";
    } elseif ($status == "shipped") {
        $statusValue = "Shipped";
    } elseif ($status == "delivered") {
      $statusValue = "Delivered";
    } elseif ($status == "cancelled") {
      $statusValue = "Cancelled";
    } elseif ($status == "returned") {
      $statusValue = "Returned";
    } else {
        $statusValue = "Out For Delivery";
    }

    return $statusValue;
  }
}




if (!function_exists('getCheckoutItemData')) {
  function getCheckoutItemData()
  {
    $checkoutItemData = session()->get('checkoutItemData', []);
    if (!empty($checkoutItemData)) {
      foreach ($checkoutItemData as &$cartVal) {
        $productDetails = ProductVariantCombination::where('product_variant_combinations.id', $cartVal['product_id'] ?? 0)->leftJoin('products', 'products.id', 'product_variant_combinations.product_id')->select('product_variant_combinations.*', 'products.name')->first();
        $cartVal['product_name'] = $productDetails->name ?? '';
        $cartVal['product_price'] = ($productDetails->selling_price ?? 0) * ($cartVal['quantity'] ?? 0);
        $cartVal['buying_price'] = ($productDetails->buying_price ?? 0) * ($cartVal['quantity'] ?? 0);
        $productImage = ProductVariantCombinationImage::where('product_variant_combination_images.product_variant_combination_id', $productDetails->id)->leftJoin('product_images', 'product_images.id', 'product_variant_combination_images.product_image_id')->value('product_images.image');
        $cartVal['product_image'] = (!empty($productImage)) ? Config('constant.PRODUCT_IMAGE_URL') . $productImage : Config('constant.IMAGE_URL') . "noimage.png";
      }
    }

    return $checkoutItemData;
  }
}

if (!function_exists('isProductAddedInCart')) {
  function isProductAddedInCart($productId)
  {
    if (auth()->guard('customer')->check()) {
      $cartData = Cart::where('user_id', auth()->guard('customer')->user()->id)->select('product_id', 'quantity')->get()->toArray();
    } else {

      $cartData = session()->get('cartData', []);
    }
    if (!empty($cartData)) {
      foreach ($cartData as $cartVal) {
        if ($productId == $cartVal['product_id']) {
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

if (!function_exists('moveCartDataFromSession')) {
  function moveCartDataFromSession()
  {
    if (auth()->guard('customer')->check()) {
      if (session()->has('cartData')) {
        $cartData = session()->get('cartData', []);
        if (!empty($cartData)) {
          foreach ($cartData as $cart) {
            $isProductAddedInCartAlready = Cart::where('user_id', auth()->guard('customer')->user()->id)->where('product_id', $cart['product_id'])->first();
            if (!empty($isProductAddedInCartAlready)) {
              Cart::where('user_id', auth()->guard('customer')->user()->id)->where('product_id', $cart['product_id'])->update(['quantity' => $isProductAddedInCartAlready->quantity + $cart['quantity']]);
            } else {
              $obj = new Cart;
              $obj->user_id = auth()->guard('customer')->user()->id;
              $obj->product_id = $cart['product_id'];
              $obj->quantity = $cart['quantity'];
              $obj->save();
            }
          }
        }
        session()->forget('cartData');
      }

    }
  }
}
if (!function_exists('getCurrentCurrency')) {
  function getCurrentCurrency()
  {
    if (session()->has('currency')) {
      $currency = session()->get('currency');
    } else {
      $currency = 'INR';
    }
    return $currency;
  }
}
if (!function_exists('getDefaultCurrencySymbol')) {
  function getDefaultCurrencySymbol()
  {
    if (session()->has('currency')) {
      $currency = session()->get('currency');
    } else {
      $currency = 'INR';
    }
    $currencySymbol = Currency::where('currency_code',$currency)->value('symbol');
    return $currencySymbol;
  }
}

if (!function_exists('setCheckoutItemDataProperty')) {
  function setCheckoutItemDataProperty()
  {
    $checkoutItemData = session()->get('checkoutItemData', []);
    if (!empty($checkoutItemData)) {
      foreach ($checkoutItemData as &$checkouItem) {
        $productDetails = ProductVariantCombination::where('product_variant_combinations.id', $checkouItem['product_id'] ?? 0)->leftJoin('products', 'products.id', 'product_variant_combinations.product_id')->select('product_variant_combinations.*')->first();
        $cartVal['product_name'] = $productDetails->name ?? '';
        $cartVal['product_price'] = ($productDetails->selling_price ?? 0) * ($cartVal['quantity'] ?? 0);
        $cartVal['buying_price'] = ($productDetails->buying_price ?? 0) * ($cartVal['quantity'] ?? 0);
        $productImage = ProductVariantCombinationImage::where('product_variant_combination_images.product_variant_combination_id', $productDetails->id)->leftJoin('product_images', 'product_images.id', 'product_variant_combination_images.product_image_id')->value('product_images.image');
        $cartVal['product_image'] = (!empty($productImage)) ? Config('constant.PRODUCT_IMAGE_URL') . $productImage : Config('constant.IMAGE_URL') . "noimage.png";
      }
    }

    return $checkoutItemData;
  }
}

if (!function_exists('moveCartSessionDataToCheckoutSessionData')) {
  function moveCartSessionDataToCheckoutSessionData($cartData = [],$checkoutFrom = "")
  {
    $totalPrice = 0;
    $subTotalPrice = 0;
    $checkoutTaxArr = [];

    if(!empty($cartData)){
        foreach($cartData as &$cart){
            $productVariantCombination = new ProductVariantCombination;
            $productDetails = $productVariantCombination->fetchProductDetailsByProductId($cart['product_id']);
            if(!empty($productDetails)){
                $cart['sub_total'] = $productDetails['product_price'] * $cart['quantity'];
                $subTotalPrice += $cart['sub_total'];
                $cart['total'] =  $productDetails['product_price'] * $cart['quantity'];
                // $totalPrice = $cart['total'];
                // print_r($productDetails);die;
                $categoryTaxes = CategoryTax::where('category_taxes.category_id',$productDetails['category_id'] ?? 0)->leftJoin('taxes','taxes.id','category_taxes.tax_id')->select('category_taxes.*','taxes.name as tax_name')->get();
                if($categoryTaxes->isNotEmpty()){
                  foreach($categoryTaxes as $taxKey => $tax){
                    $cart['tax'][$taxKey]['category_tax_id'] = $tax->id;
                    $cart['tax'][$taxKey]['tax_id'] = $tax->tax_id;
                    $cart['tax'][$taxKey]['tax_val'] = $tax->tax_value ?? 0;

                      $cart['tax'][$taxKey]['tax_price'] = ($cart['tax'][$taxKey]['tax_val'] > 0) ? $cart['total'] * ($cart['tax'][$taxKey]['tax_val']/100) : 0;
                      $cart['tax'][$taxKey]['tax_name'] = $tax->tax_name;

                      $existKey = array_search($tax->tax_id, array_column($checkoutTaxArr, 'tax_id'));
                      if ($existKey !== false) {
                          $checkoutTaxArr[$existKey]['tax_val'] += $cart['tax'][$taxKey]['tax_val'];
                          $checkoutTaxArr[$existKey]['tax_price'] += $cart['tax'][$taxKey]['tax_price'];

                      } else {

                          $checkoutTaxArr[$taxKey] = $cart['tax'][$taxKey];
                      }
                      $cart['total'] += $cart['tax'][$taxKey]['tax_price'];
                  }
                }
                $cart['product'] = $productDetails;
                $totalPrice += $cart['total'];
            }

        }
        session()->put('checkoutItemData',$cartData);
    }
    $checkoutData = [];
    $checkoutData['checkoutFrom'] = $checkoutFrom;
    $checkoutData['sub_total'] = $subTotalPrice;
    $checkoutData['total'] = $totalPrice;
    $checkoutData['default_total'] = $totalPrice;
    $checkoutData['tax'] = $checkoutTaxArr;
    session()->put('checkoutData',$checkoutData);
  }
}







