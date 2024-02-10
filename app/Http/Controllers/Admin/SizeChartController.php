<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\SizeChart;
use App\Models\SizeChartDetail;
use App\Models\SizeChartDetailValue;
use App\Models\SizeChartAssign;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Redirect,DB,Response;

class SizeChartController extends Controller
{
    public $model = 'size-charts';
    public function __construct(Request $request)
    {
        $this->listRouteName = 'admin-size-charts.index';
        View()->share('model', $this->model);
        View()->share('listRouteName', $this->listRouteName);
        $this->request = $request;

    }

    public function index(Request $request)
    {
        try {
            $DB = SizeChart::query();
            $sortBy = $request->input('sortBy') ? $request->input('sortBy') : 'size_charts.created_at';
            $order = $request->input('order') ? $request->input('order') : 'DESC';
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
                    $DB->whereBetween('size_charts.created_at', [$dateS . " 00:00:00", $dateE . " 23:59:59"]);
                } elseif (!empty($searchData['date_from'])) {
                    $dateS = $searchData['date_from'];
                    $DB->where('size_charts.created_at', '>=', [$dateS . " 00:00:00"]);
                } elseif (!empty($searchData['date_to'])) {
                    $dateE = $searchData['date_to'];
                    $DB->where('size_charts.created_at', '<=', [$dateE . " 00:00:00"]);
                }
                foreach ($searchData as $fieldName => $fieldValue) {
                    if ($fieldValue != "") {
                        if ($fieldName == "name") {
                            $DB->where("size_charts.name", 'like', '%' . $fieldValue . '%');
                        }
                        if ($fieldName == "is_active") {
                            $DB->where("size_charts.is_active", $fieldValue);
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

        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }

    }

    public function create()
    {
        try {
            $categories = Category::whereNull('parent_id')
                        ->where('is_active', 1)
                        ->where('is_deleted', 0)
                        ->get();

            $products = DB::table('products')->where('is_active', 1)
                        ->where('is_deleted', 0)
                        ->select('id','name')->get()->toArray();
            return view('admin.size-charts.create',['categories' => $categories, 'products' => $products]);
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        try {
            $formData = $request->all();
            if (!empty($formData)) {
                $validator = Validator::make(
                    $request->all(),
                    array(
                        'name' => 'required',
                        'file' => 'nullable|mimes:jpg,jpeg,png,pdf',
                    ),
                    array(
                        "name.required" => trans("The name field is required."),
                    )
                );
                if ($validator->fails()) {
                    return Redirect::back()->withErrors($validator)->withInput();
                } else {
                    DB::beginTransaction();
                    $obj                                = new SizeChart;
                    $obj->name                          = $request->input('name');
                    $obj->description                   = !empty($request->input('description')) ? $request->input('description') : "";

                    if ($request->hasFile('file')) {
                        $extension = $request->file('file')->getClientOriginalExtension();
                        $originalName = $request->file('file')->getClientOriginalName();
                        $fileName = time() . '-file.' . $extension;

                        $folderName = strtoupper(date('M') . date('Y')) . "/";
                        $folderPath = Config('constant.SIZECHART_IMAGE_ROOT_PATH') . $folderName;
                        if (!File::exists($folderPath)) {
                            File::makeDirectory($folderPath, $mode = 0777, true);
                        }
                        if ($request->file('file')->move($folderPath, $fileName)) {
                            $obj->file = $folderName . $fileName;
                        }
                    }
                    $obj->save();

                    $lastId = $obj->id;

                    if(!empty($lastId)){
                        if(!empty($request->categoryData)) {
                            SizeChartAssign::where('size_chart_id', $lastId)->delete();
                            foreach($request->categoryData as $cat_data) {
                                $obj1 = new SizeChartAssign;
                                $obj1->size_chart_id = $lastId;
                                $obj1->category_id = $cat_data;
                                $obj1->product_id = 0;
                                $obj1->save();
                            }
                        }
                        if(!empty($request->productData)) {
                            SizeChartAssign::where('size_chart_id', $lastId)->delete();
                            foreach($request->productData as $pro_data) {
                                $obj1 = new SizeChartAssign;
                                $obj1->size_chart_id = $lastId;
                                $obj1->product_id = $pro_data;
                                $obj1->category_id = 0;
                                $obj1->save();
                            }
                        }
                        DB::commit();
                    }else{
                        DB::rollback();
                        Session()->flash('flash_notice', 'Something Went Wrong');
                        return Redirect::route('admin-size-charts.index');
                    }

                    return redirect()->route('admin-size-charts.index')->with('success', 'Size Chart created successfully');
                }
            }
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }
    }

    public function edit(Request $request, $token = null)
    {
        try {
            $categoryId = '';
            if (!empty($token)) {

                $categoryId = base64_decode($token);

                $size_charts = SizeChart::find($categoryId);

                $categories = Category::whereNull('parent_id')
                        ->where('is_active', 1)
                        ->where('is_deleted', 0)
                        ->get();

                $products = DB::table('products')->where('is_active', 1)
                            ->where('is_deleted', 0)
                            ->select('id','name')->get()->toArray();
                $category_assigned = SizeChartAssign::where('size_chart_id', $categoryId)->pluck('category_id')->toArray();
                $product_assigned = SizeChartAssign::where('size_chart_id', $categoryId)->pluck('product_id')->toArray();
                return View("admin.$this->model.edit",['size_charts' => $size_charts,'categories' => $categories, 'products' => $products, 'category_assigned' => $category_assigned, 'product_assigned' => $product_assigned]);
            }
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $token)
    {//echo "<pre>"; print_r($request->all()); die;
        try {

            $categoryId = '';
            if (!empty($token)) {
                $categoryId = base64_decode($token);
            } else {
                return redirect()->route('admin-'.$this->model . ".index");
            }

            $size_charts = SizeChart::find($categoryId);
            if (empty($size_charts)) {
                return View("admin.$this->model.edit");
            } else {
                $formData = $request->all();
                if (!empty($formData)) {
                    $validator = Validator::make(
                        $request->all(),
                        array(
                            'name' => 'required',
                            'file' => 'nullable|mimes:jpg,jpeg,png,pdf',
                        ),
                        array(
                            "name.required" => trans("The name field is required."),
                        )
                    );
                    if ($validator->fails()) {
                        return Redirect::back()->withErrors($validator)->withInput();
                    } else {
                        DB::beginTransaction();
                        $obj                                = $size_charts;
                        $obj->name                          = $request->input('name');
                        $obj->description                   = !empty($request->input('description')) ? $request->input('description') : "";

                        if ($request->hasFile('file')) {
                            $extension = $request->file('file')->getClientOriginalExtension();
                            $originalName = $request->file('file')->getClientOriginalName();
                            $fileName = time() . '-file.' . $extension;

                            $folderName = strtoupper(date('M') . date('Y')) . "/";
                            $folderPath = Config('constant.SIZECHART_IMAGE_ROOT_PATH') . $folderName;
                            if (!File::exists($folderPath)) {
                                File::makeDirectory($folderPath, $mode = 0777, true);
                            }
                            if ($request->file('file')->move($folderPath, $fileName)) {
                                $obj->file = $folderName . $fileName;
                            }
                        }
                        $obj->save();
                        $lastId = $obj->id;
                        if(!empty($lastId)){
                            if(!empty($request->categoryData)) {
                                SizeChartAssign::where('size_chart_id', $lastId)->where('category_id', '!=', 0)->delete();
                                foreach($request->categoryData as $cat_data) {
                                    $obj1 = new SizeChartAssign;
                                    $obj1->size_chart_id = $lastId;
                                    $obj1->category_id = $cat_data;
                                    $obj1->product_id = 0;
                                    $obj1->save();
                                }
                            }

                            if(!empty($request->productData)) {
                                SizeChartAssign::where('size_chart_id', $lastId)->where('product_id', '!=', 0)->delete();
                                foreach($request->productData as $pro_data) {
                                    $obj1 = new SizeChartAssign;
                                    $obj1->size_chart_id = $lastId;
                                    $obj1->product_id = $pro_data;
                                    $obj1->category_id = 0;
                                    $obj1->save();
                                }
                            }
                            DB::commit();
                        }else{
                            DB::rollback();
                            Session()->flash('flash_notice', 'Something Went Wrong');
                            return Redirect::route('admin-size-charts.index');
                        }
                        Session()->flash('flash_notice', trans("Size Chart updated successfully."));
                        return Redirect::route('admin-size-charts.index');
                    }
                }
            }
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }
    }

    public function destroy($token)
    {
        try {
            $categoryId = '';
            if (!empty($token)) {
                $categoryId = base64_decode($token);
            }
            $category = SizeChart::find($categoryId);
            if (empty($category)) {
                return Redirect()->route($this->model . '.index');
            }
            if ($category) {
                SizeChart::where('id', $categoryId)->delete();
                SizeChartDetail::where('size_chart_id',$categoryId)->delete();

                Session()->flash('flash_notice', trans("Size chart has been removed successfully."));
            }
            return back();
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }
    }

    public function changeStatus($modelId = 0, $status = 0)
    {
        if ($status == 1) {
            $statusMessage = trans("Size chart has been actvated successfully");
        } else {
            $statusMessage = trans("Size chart has been deactivated successfully");
        }
        $category = SizeChart::find($modelId);
        if ($category) {
            $currentStatus = $category->is_active;
            if (isset($currentStatus) && $currentStatus == 0) {
                $NewStatus = 1;
            } else {
                $NewStatus = 0;
            }
            $category->is_active = $NewStatus;
            $ResponseStatus = $category->save();
        }
        Session()->flash('flash_notice', $statusMessage);
        return back();
    }

}
