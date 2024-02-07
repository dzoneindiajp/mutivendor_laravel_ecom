<?php

namespace App\Http\Controllers\Admin;

use App\Config;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Category;
use App\Models\PriceDrop;
use App\Models\Product;
use App\Models\PriceDropAssign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Redirect,DB,Response,Str;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class PriceDropController extends Controller
{
    public $model = 'price-drops';
    public function __construct(Request $request)
    {
        $this->listRouteName = 'admin-price-drops.index';
        View()->share('model', $this->model);
        View()->share('listRouteName', $this->listRouteName);
        $this->request = $request;

    }

    public function index(Request $request)
    {
        $DB = PriceDrop::query();
        $sortBy = $request->input('sortBy') ? $request->input('sortBy') : 'price_drops.created_at';
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
                $DB->whereBetween('price_drops.created_at', [$dateS . " 00:00:00", $dateE . " 23:59:59"]);
            } elseif (!empty($searchData['date_from'])) {
                $dateS = $searchData['date_from'];
                $DB->where('price_drops.created_at', '>=', [$dateS . " 00:00:00"]);
            } elseif (!empty($searchData['date_to'])) {
                $dateE = $searchData['date_to'];
                $DB->where('price_drops.created_at', '<=', [$dateE . " 00:00:00"]);
            }
            foreach ($searchData as $fieldName => $fieldValue) {
                // if ($fieldValue != "") {

                // }
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

        $products = DB::table('products')->where('is_active', 1)
                    ->where('is_deleted', 0)
                    ->select('id','name')->get()->toArray();
        return view("admin.$this->model.add", ['categories' => $categoryHierarchy, 'products' => $products]);
    }

    public function edit(Request $request, $enuserid = null)
    {
        $user_id = '';
        if (!empty($enuserid)) {

            $user_id = base64_decode($enuserid);
            $userDetails = PriceDrop::where('price_drops.id', $user_id)->first();

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

            $products = DB::table('products')->where('is_active', 1)
                        ->where('is_deleted', 0)
                        ->select('id','name')->get()->toArray();

            $price_drop_assigned = PriceDropAssign::where('price_drop_id', $user_id)->pluck('reference_id')->toArray();

            return View("admin.$this->model.edit",['userDetails' => $userDetails, 'categories' => $categoryHierarchy, 'products' => $products, 'price_drop_assigned' => $price_drop_assigned]);
        }
    }
    public function save(Request $request)
    {

        $formData = $request->all();
        if (!empty($formData)) {
            $validator = Validator::make(
                $request->all(),
                array(
                    'assign_type' => 'required',
                    'drop_type' => 'required',
                    'gain_type' => 'required',
                    'amount' => 'required|numeric',
                    'start_date' => 'required|date|after_or_equal:today',
                    'end_date' => 'required|date|after_or_equal:start_date',
                ),
            );
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            } else {
                DB::beginTransaction();
                $obj                                = new PriceDrop;
                $obj->assign_type                   = $request->input('assign_type');
                $obj->drop_type                     = $request->input('drop_type');
                $obj->gain_type                     = $request->input('gain_type');
                $obj->amount                        = !empty($request->input('amount')) ? $request->input('amount') : 0;
                $obj->start_date                    = !empty($request->input('start_date')) ? $request->input('start_date') : null;
                $obj->end_date                      = !empty($request->input('end_date')) ? $request->input('end_date') : null;
                $obj->save();
                $lastId = $obj->id;
                if(!empty($lastId)){
                    if($request->input('assign_type') == "category" && !empty($request->categoryData)) {
                        PriceDropAssign::where('price_drop_id', $lastId)->delete();
                        foreach($request->categoryData as $cat_data) {
                            $obj1 = new PriceDropAssign;
                            $obj1->price_drop_id = $lastId;
                            $obj1->reference_id = $cat_data;
                            $obj1->save();
                        }
                    } elseif($request->input('assign_type') == "product" && !empty($request->productData)) {
                        PriceDropAssign::where('price_drop_id', $lastId)->delete();
                        foreach($request->productData as $pro_data) {
                            $obj1 = new PriceDropAssign;
                            $obj1->price_drop_id = $lastId;
                            $obj1->reference_id = $pro_data;
                            $obj1->save();
                        }
                    }
                    DB::commit();
                }else{
                    DB::rollback();
                    Session()->flash('flash_notice', 'Something Went Wrong');
                    return Redirect::route('admin-price-drops.index');
                }
                Session()->flash('flash_notice', trans("Price Drop saved successfully."));
                return Redirect::route('admin-price-drops.index');
            }
        }

    }
    public function update(Request $request, $enuserid = null)
    {

        $model = PriceDrop::find($enuserid);
        if (empty($model)) {
            return View("admin.$this->model.edit");
        } else {
            $formData = $request->all();
            if (!empty($formData)) {
                $validator = Validator::make(
                    $request->all(),
                    array(
                        'assign_type' => 'required',
                        'drop_type' => 'required',
                        'gain_type' => 'required',
                        'amount' => 'required|numeric',
                        'start_date' => 'required|date|after_or_equal:today',
                        'end_date' => 'required|date|after_or_equal:start_date',
                    ),
                );
                if ($validator->fails()) {
                    return Redirect::back()->withErrors($validator)->withInput();
                } else {
                    DB::beginTransaction();

                    $obj                      = $model;
                    $obj->assign_type                   = $request->input('assign_type');
                    $obj->drop_type                     = $request->input('drop_type');
                    $obj->gain_type                     = $request->input('gain_type');
                    $obj->amount                        = !empty($request->input('amount')) ? $request->input('amount') : 0;
                    $obj->start_date                    = !empty($request->input('start_date')) ? $request->input('start_date') : null;
                    $obj->end_date                      = !empty($request->input('end_date')) ? $request->input('end_date') : null;
                    $obj->save();
                    $lastId = $obj->id;
                    if(!empty($lastId)){
                        if($request->input('assign_type') == "category" && !empty($request->categoryData)) {
                            PriceDropAssign::where('price_drop_id', $lastId)->delete();
                            foreach($request->categoryData as $cat_data) {
                                $obj1 = new PriceDropAssign;
                                $obj1->price_drop_id = $lastId;
                                $obj1->reference_id = $cat_data;
                                $obj1->save();
                            }
                        } elseif($request->input('assign_type') == "product" && !empty($request->productData)) {
                            PriceDropAssign::where('price_drop_id', $lastId)->delete();
                            foreach($request->productData as $pro_data) {
                                $obj1 = new PriceDropAssign;
                                $obj1->price_drop_id = $lastId;
                                $obj1->reference_id = $pro_data;
                                $obj1->save();
                            }
                        }
                        DB::commit();
                    }else{
                        DB::rollback();
                        Session()->flash('flash_notice', 'Something Went Wrong');
                        return Redirect::route('admin-price-drops.index');
                    }
                    Session()->flash('flash_notice', trans("Price Drop updated successfully."));
                    return Redirect::route('admin-price-drops.index');
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
        $userDetails = PriceDrop::find($user_id);
        if (empty($userDetails)) {
            return Redirect::route('admin-price-drops.index');
        }
        if ($user_id) {
            PriceDrop::where('id', $user_id)->delete();

            Session()->flash('flash_notice', trans("Price Drop has been removed successfully."));
        }
        return back();
    }



    public function changeStatus($modelId = 0, $status = 0)
    {
        if ($status == 1) {
            $statusMessage = trans("Currency has been actvated successfully");
        } else {
            $statusMessage = trans("Currency has been deactivated successfully");
        }
        $user = PriceDrop::find($modelId);
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


    public function getPriceData()
    {
       $data = getDropPrices('52', 'selling', 'yes');
    }

}
