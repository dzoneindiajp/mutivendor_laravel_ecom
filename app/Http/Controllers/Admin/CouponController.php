<?php

namespace App\Http\Controllers\Admin;

use App\Config;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Category;
use App\Models\User;
use App\Models\Product;
use App\Models\CouponAssign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Redirect,DB,Response,Str;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class CouponController extends Controller
{
    public $model = 'coupons';
    public function __construct(Request $request)
    {
        $this->listRouteName = 'admin-coupons.index';
        View()->share('model', $this->model);
        View()->share('listRouteName', $this->listRouteName);
        $this->request = $request;

    }

    public function index(Request $request)
    {
        $DB = Coupon::query();
        $sortBy = $request->input('sortBy') ? $request->input('sortBy') : 'coupons.created_at';
        $order = $request->input('order') ? $request->input('order') : 'desc';
        $offset = !empty($request->input('offset')) ? $request->input('offset') : 0 ;
        $limit =  !empty($request->input('limit')) ? $request->input('limit') : Config("Reading.records_per_page");

        if ($request->all()) {
            $searchData            =    $request->all();
            unset($searchData['display']);
            unset($searchData['_token']);
            if (isset($searchData['order'])) {
                unset($searchData['order']);
            }
            if (isset($searchData['sortBy'])) {
                unset($searchData['sortBy']);
            }
            if (isset($searchData['offset'])) {
                unset($searchData['offset']);
            }
            if (isset($searchData['limit'])) {
                unset($searchData['limit']);
            }
            if ((!empty($searchData['date_from'])) && (!empty($searchData['date_to']))) {
                $dateS = $searchData['date_from'];
                $dateE = $searchData['date_to'];
                $DB->whereBetween('coupons.created_at', [$dateS . " 00:00:00", $dateE . " 23:59:59"]);
            } elseif (!empty($searchData['date_from'])) {
                $dateS = $searchData['date_from'];
                $DB->where('coupons.created_at', '>=', [$dateS . " 00:00:00"]);
            } elseif (!empty($searchData['date_to'])) {
                $dateE = $searchData['date_to'];
                $DB->where('coupons.created_at', '<=', [$dateE . " 00:00:00"]);
            }
            foreach ($searchData as $fieldName => $fieldValue) {
                if ($fieldValue != "") {
                    if ($fieldName == "name") {
                        $DB->where("coupons.name", 'like', '%' . $fieldValue . '%');
                    }
                    if ($fieldName == "is_active") {
                        $DB->where("coupons.is_active", $fieldValue);
                    }
                }
            }
        }

        $results = $DB->orderBy($sortBy, $order)->offset($offset)->limit($limit)->get();
        $totalResults = $DB->count();

        if($request->ajax()){

            return  View("admin.$this->model.load_more_data", compact('results','totalResults'));
        }else{

            return  View("admin.$this->model.index", compact('results','totalResults'));
        }
    }

    public function create(Request $request)
    {
        $categories = Category::whereNull('parent_id')
                        ->where('is_active', 1)
                        ->where('is_deleted', 0)
                        ->with('children') // Eager load the children relationship
                        ->get();

        $categoryHierarchy = [];

        foreach ($categories as $category) {
            $categoryHierarchy[] = [
                'id' => $category->id,
                'name' => $category->name
            ];

            // Check if the children relationship is not null and not empty
            if ($category->children && !$category->children->isEmpty()) {
                foreach ($category->children as $subCategory) {
                    $subCategoryName = $category->name . '->' . $subCategory->name;

                    // Check if sub category name already exists
                    $exists = false;
                    foreach ($categoryHierarchy as $cat) {
                        if ($cat['name'] === $subCategoryName) {
                            $exists = true;
                            break;
                        }
                    }

                    // If sub category name doesn't exist, add it
                    if (!$exists) {
                        $categoryHierarchy[] = [
                            'id' => $subCategory->id,
                            'name' => $subCategoryName
                        ];
                    }
                }
            }
        }
        $users = User::where('user_role_id', 2)
                    ->where('is_active', 1)
                    ->where('is_deleted', 0)
                    ->select('id','name')->get()->toArray();
                    // $products = array();
        $products = DB::table('products')->where('is_active', 1)
                    ->where('is_deleted', 0)
                    ->select('id','name')->get()->toArray();
        // echo "<pre>"; print_r($products); die;
        return view("admin.$this->model.add", ['categories' => $categoryHierarchy, 'users' => $users, 'products' => $products]);
    }





    public function edit(Request $request, $enuserid = null)
    {
        $user_id = '';
        if (!empty($enuserid)) {

            $user_id = base64_decode($enuserid);
            $userDetails = Coupon::where('coupons.id',$user_id)->first();

            $categories = Category::whereNull('parent_id')
                        ->where('is_active', 1)
                        ->where('is_deleted', 0)
                        ->with('children') // Eager load the children relationship
                        ->get();

            $categoryHierarchy = [];

            foreach ($categories as $category) {
                $categoryHierarchy[] = [
                    'id' => $category->id,
                    'name' => $category->name
                ];

                // Check if the children relationship is not null and not empty
                if ($category->children && !$category->children->isEmpty()) {
                    foreach ($category->children as $subCategory) {
                        $subCategoryName = $category->name . '->' . $subCategory->name;

                        // Check if sub category name already exists
                        $exists = false;
                        foreach ($categoryHierarchy as $cat) {
                            if ($cat['name'] === $subCategoryName) {
                                $exists = true;
                                break;
                            }
                        }

                        // If sub category name doesn't exist, add it
                        if (!$exists) {
                            $categoryHierarchy[] = [
                                'id' => $subCategory->id,
                                'name' => $subCategoryName
                            ];
                        }
                    }
                }
            }
            $users = User::where('user_role_id', 2)
                        ->where('is_active', 1)
                        ->where('is_deleted', 0)
                        ->select('id','name')->get()->toArray();
                        // $products = array();
            $products = DB::table('products')->where('is_active', 1)
                        ->where('is_deleted', 0)
                        ->select('id','name')->get()->toArray();

            $coupon_assigned = CouponAssign::where('coupon_id', $user_id)->pluck('reference_id')->toArray();
            return View("admin.$this->model.edit",['userDetails' => $userDetails, 'categories' => $categoryHierarchy, 'users' => $users, 'products' => $products, 'coupon_assigned' => $coupon_assigned]);
        }
    }
    public function save(Request $request)
    {

        $formData = $request->all();
        if (!empty($formData)) {
            $validator = Validator::make(
                $request->all(),
                array(
                    'name' => 'required',
                    'coupon_type' => 'required',
                    'start_date' => 'required|date|after_or_equal:today',
                    'end_date' => 'required|date|after_or_equal:start_date',
                    'amount' => 'required|numeric',
                    'min_amount' => 'numeric',
                    // 'max_amount' => 'numeric',
                    'is_assign' => 'nullable|boolean',
                    'assign_type' => $request->input('is_assign') == 1 ? 'required' : 'nullable',
                ),
                array(
                    "name.required" => trans("The name field is required."),
                    "coupon_type.required" => trans("The coupon type field is required."),
                    "amount.numeric" => trans("The amount should be numeric."),
                    "amount.required" => trans("The amount field is required."),
                    "start_date.required" => trans("The start date field is required."),
                    "start_date.date" => trans("The start date should be in date format."),
                    "end_date.required" => trans("The end date field is required."),
                    "end_date.date" => trans("The end date should be in date format."),
                    'start_date.after_or_equal' => 'The start date must be greater than or equal to today\'s date.',
                    'end_date.after_or_equal' => 'The end date must be greater than or equal to the start date.',
                )
            );
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            } else {
                DB::beginTransaction();
                $obj                                = new Coupon;
                $obj->name                          = $request->input('name');
                $obj->coupon_code                   = !empty($request->input('coupon_code')) ? $request->input('coupon_code') : "";
                $obj->coupon_type                   = $request->input('coupon_type');
                $obj->amount                        = !empty($request->input('amount')) ? $request->input('amount') : 0;
                $obj->min_amount                    = !empty($request->input('min_amount')) ? $request->input('min_amount') : 0;
                $obj->max_amount                    = !empty($request->input('max_amount')) ? $request->input('max_amount') : 0;
                $obj->start_date                    = !empty($request->input('start_date')) ? $request->input('start_date') : null;
                $obj->end_date                      = !empty($request->input('end_date')) ? $request->input('end_date') : null;
                $obj->description                   = !empty($request->input('description')) ? $request->input('description') : null;
                $obj->is_assign                     = !empty($request->input('is_assign')) ? $request->input('is_assign') : 0;
                if($request->input('is_assign') == 1) {
                    $obj-> assign_type               = !empty($request->input('assign_type')) ? $request->input('assign_type') : null;
                }
                $obj->save();
                $lastId = $obj->id;
                if(!empty($lastId)){
                    if($request->input('is_assign') == 1 && $request->input('assign_type') == "category" && !empty($request->categoryData)) {
                        CouponAssign::where('coupon_id', $lastId)->delete();
                        foreach($request->categoryData as $cat_data) {
                            $obj1 = new CouponAssign;
                            $obj1->coupon_id = $lastId;
                            $obj1->reference_id = $cat_data;
                            $obj1->save();
                        }
                    } elseif($request->input('is_assign') == 1 && $request->input('assign_type') == "product" && !empty($request->productData)) {
                        CouponAssign::where('coupon_id', $lastId)->delete();
                        foreach($request->productData as $pro_data) {
                            $obj1 = new CouponAssign;
                            $obj1->coupon_id = $lastId;
                            $obj1->reference_id = $pro_data;
                            $obj1->save();
                        }
                    } elseif($request->input('is_assign') == 1 && $request->input('assign_type') == "user" && !empty($request->userData)) {
                        CouponAssign::where('coupon_id', $lastId)->delete();
                        foreach($request->userData as $user_data) {
                            $obj1 = new CouponAssign;
                            $obj1->coupon_id = $lastId;
                            $obj1->reference_id = $user_data;
                            $obj1->save();
                        }
                    }
                    DB::commit();
                }else{
                    DB::rollback();
                    Session()->flash('flash_notice', 'Something Went Wrong');
                    return Redirect::route('admin-coupons.index');
                }
                Session()->flash('flash_notice', trans("Coupon saved successfully."));
                return Redirect::route('admin-coupons.index');
            }
        }

    }
    public function update(Request $request, $enuserid = null)
    {

        $model = Coupon::find($enuserid);
        if (empty($model)) {
            return View("admin.$this->model.edit");
        } else {
            $formData = $request->all();
            if (!empty($formData)) {
                $validator = Validator::make(
                    $request->all(),
                    array(
                        'name' => 'required',
                        'coupon_type' => 'required',
                        'start_date' => 'required|date|after_or_equal:today',
                        'end_date' => 'required|date|after_or_equal:start_date',
                        'amount' => 'required|numeric',
                        'min_amount' => 'numeric',
                        // 'max_amount' => 'numeric',
                        'is_assign' => 'nullable|boolean',
                        'assign_type' => $request->input('is_assign') == 1 ? 'required' : 'nullable',
                    ),
                    array(
                        "name.required" => trans("The name field is required."),
                        "coupon_type.required" => trans("The coupon type field is required."),
                        "amount.numeric" => trans("The amount should be numeric."),
                        "amount.required" => trans("The amount field is required."),
                        "start_date.required" => trans("The start date field is required."),
                        "start_date.date" => trans("The start date should be in date format."),
                        "end_date.required" => trans("The end date field is required."),
                        "end_date.date" => trans("The end date should be in date format."),
                        'start_date.after_or_equal' => 'The start date must be greater than or equal to today\'s date.',
                        'end_date.after_or_equal' => 'The end date must be greater than or equal to the start date.',
                    )
                );
                if ($validator->fails()) {
                    return Redirect::back()->withErrors($validator)->withInput();
                } else {
                    DB::beginTransaction();

                    $obj                                = $model;
                    $obj->name                          = $request->input('name');
                    $obj->coupon_code                   = !empty($request->input('coupon_code')) ? $request->input('coupon_code') : "";
                    $obj->coupon_type                   = $request->input('coupon_type');
                    $obj->amount                        = !empty($request->input('amount')) ? $request->input('amount') : 0;
                    $obj->min_amount                    = !empty($request->input('min_amount')) ? $request->input('min_amount') : 0;
                    $obj->max_amount                    = !empty($request->input('max_amount')) ? $request->input('max_amount') : 0;
                    $obj->start_date                    = !empty($request->input('start_date')) ? $request->input('start_date') : null;
                    $obj->end_date                      = !empty($request->input('end_date')) ? $request->input('end_date') : null;
                    $obj->description                   = !empty($request->input('description')) ? $request->input('description') : null;
                    $obj->is_assign                     = !empty($request->input('is_assign')) ? $request->input('is_assign') : 0;
                    if($request->input('is_assign') == 1) {
                        $obj-> assign_type               = !empty($request->input('assign_type')) ? $request->input('assign_type') : null;
                    }
                    $obj->save();
                    $lastId = $obj->id;
                    if(!empty($lastId)){
                        if($request->input('is_assign') == 1 && $request->input('assign_type') == "category" && !empty($request->categoryData)) {
                            CouponAssign::where('coupon_id', $lastId)->delete();
                            foreach($request->categoryData as $cat_data) {
                                $obj1 = new CouponAssign;
                                $obj1->coupon_id = $lastId;
                                $obj1->reference_id = $cat_data;
                                $obj1->save();
                            }
                        } elseif($request->input('is_assign') == 1 && $request->input('assign_type') == "product" && !empty($request->productData)) {
                            CouponAssign::where('coupon_id', $lastId)->delete();
                            foreach($request->productData as $pro_data) {
                                $obj1 = new CouponAssign;
                                $obj1->coupon_id = $lastId;
                                $obj1->reference_id = $pro_data;
                                $obj1->save();
                            }
                        } elseif($request->input('is_assign') == 1 && $request->input('assign_type') == "user" && !empty($request->userData)) {
                            CouponAssign::where('coupon_id', $lastId)->delete();
                            foreach($request->userData as $user_data) {
                                $obj1 = new CouponAssign;
                                $obj1->coupon_id = $lastId;
                                $obj1->reference_id = $user_data;
                                $obj1->save();
                            }
                        }
                        DB::commit();
                    }else{
                        DB::rollback();
                        Session()->flash('flash_notice', 'Something Went Wrong');
                        return Redirect::route('admin-coupons.index');
                    }
                    Session()->flash('flash_notice', trans("Coupon updated successfully."));
                    return Redirect::route('admin-coupons.index');
                }
            }
        }
    }

    public function destroy($enuserid)
    {
        $user_id = '';
        if (!empty($enuserid)) {
            $user_id = base64_decode($enuserid);
        }
        $userDetails = Coupon::find($user_id);
        if (empty($userDetails)) {
            return Redirect()->route($this->model . '.index');
        }
        if ($user_id) {
            Coupon::where('id', $user_id)->delete();

            Session()->flash('flash_notice', trans("Coupon has been removed successfully."));
        }
        return back();
    }

    public function changeStatus($modelId = 0, $status = 0)
    {
        if ($status == 1) {
            $statusMessage = trans("Partner has been actvated successfully");
        } else {
            $statusMessage = trans("Partner has been deactivated successfully");
        }
        $user = Coupon::find($modelId);
        if ($user) {
            $currentStatus = $user->is_active;
            if (isset($currentStatus) && $currentStatus == 0) {
                $NewStatus = 1;
            } else {
                $NewStatus = 0;
            }
            $user->is_active = $NewStatus;
            $ResponseStatus = $user->save();
        }
        Session()->flash('flash_notice', $statusMessage);
        return back();
    }




    public function show(Request $request, $enuserid = null)
    {
        $user_id = '';
        if (!empty($enuserid)) {

            $user_id = base64_decode($enuserid);
            $userDetails = Coupon::where('users.id',$user_id)->first();

            $data = compact('user_id', 'userDetails');

            return View("admin.$this->model.view", $data);
        }
    }
    public function fetchPlanDetails(Request $request, $planId = null)
    {
        $payout_period = Plan::where('id',$planId)->value('payout_period');
        $planDetailsData = PlanDetail::where('plan_id',$planId)->get()->toArray();
        $data = compact('planDetailsData');
        $htmlData = View("admin.$this->model.plan_details",$data )->render();
        return response()->json(['htmlData' => $htmlData, 'payout_period' => $payout_period]);
    }

}
