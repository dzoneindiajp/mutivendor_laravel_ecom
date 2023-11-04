<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Redirect,DB,Response;

class CategoryController extends Controller
{
    public $model = 'category';
    public function __construct(Request $request)
    {
        $this->listRouteName = 'admin-category.index';
        View()->share('model', $this->model);
        View()->share('listRouteName', $this->listRouteName);
        $this->request = $request;
        
    }

    public function index(Request $request)
    {
        try {
            $DB = Category::whereNull('parent_id');
            $sortBy = $request->input('sortBy') ? $request->input('sortBy') : 'categories.created_at';
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
                    $DB->whereBetween('categories.created_at', [$dateS . " 00:00:00", $dateE . " 23:59:59"]);
                } elseif (!empty($searchData['date_from'])) {
                    $dateS = $searchData['date_from'];
                    $DB->where('categories.created_at', '>=', [$dateS . " 00:00:00"]);
                } elseif (!empty($searchData['date_to'])) {
                    $dateE = $searchData['date_to'];
                    $DB->where('categories.created_at', '<=', [$dateE . " 00:00:00"]);
                }
                foreach ($searchData as $fieldName => $fieldValue) {
                    if ($fieldValue != "") {
                        if ($fieldName == "name") {
                            $DB->where("categories.name", 'like', '%' . $fieldValue . '%');
                        }
                        if ($fieldName == "is_active") {
                            $DB->where("categories.is_active", $fieldValue);
                        }
                    }
                }
            }

            $DB->where("categories.is_deleted", 0);
        
            $results = $DB->orderBy($sortBy, $order)->offset($offset)->limit($limit)->get();
            $totalResults = $DB->count();

            if(!empty($results)) {
                foreach($results as &$result) {
                    if(!empty($result->image)){
                        $result->image = Config('constant.CATEGORY_IMAGE_URL').$result->image;
                    }
                }
            }
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
            return view('admin.category.create');
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
                        'image' => 'nullable|mimes:jpg,jpeg,png,webp',
                    ),
                    array(
                        "name.required" => trans("The name field is required."),
                        "image.mimes" => trans("The profile image should be of type jpeg,jpg,png."),
                    )
                );
                if ($validator->fails()) {
                    return Redirect::back()->withErrors($validator)->withInput();
                } else {
                    $originalString = $request->name ?? "";
                    $lowercaseString = Str::lower($originalString);
                    $slug = Str::slug($lowercaseString, '-');


                    $alreadyAddedName = Category::where('name', $originalString)->first();

                    if (!is_null($alreadyAddedName)) {
                        return redirect()->back()->with(['error' => 'Slug is already added']);
                    }
                    $totalCategoryCount = Category::whereNull('parent_id')->count();
                    $imagePath = "";
                    if ($request->hasFile('image')) {
                        $extension = $request->file('image')->getClientOriginalExtension();
                        $originalName = $request->file('image')->getClientOriginalName();
                        $fileName = time() . '-image.' . $extension;

                        $folderName = strtoupper(date('M') . date('Y')) . "/";
                        $folderPath = Config('constant.CATEGORY_IMAGE_ROOT_PATH') . $folderName;
                        if (!File::exists($folderPath)) {
                            File::makeDirectory($folderPath, $mode = 0777, true);
                        }
                        if ($request->file('image')->move($folderPath, $fileName)) {
                            $imagePath = $folderName . $fileName;
                        }
                    }
                    $category = Category::create([
                        'name' => $request->name,
                        'slug' => $slug,
                        'image' => $imagePath,
                        'category_order' => (!empty($totalCategoryCount) ? $totalCategoryCount + 1 : 1),
                        'meta_title' => $request->meta_title ?? null,
                        'meta_description' => $request->meta_description ?? null,
                        'meta_keywords' => $request->meta_keywords ?? null,
                    ]);

                    return redirect()->route('admin-category.index')->with('success', 'Category created successfully');
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
                
                $category = Category::find($categoryId);

                if(!empty($category->image)){
                    $category->image = Config('constant.CATEGORY_IMAGE_URL').$category->image;
                }

                return View("admin.$this->model.edit", compact('category'));
            }
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $token)
    {
        try {

            $categoryId = '';
            if (!empty($token)) {
                $categoryId = base64_decode($token);
            } else {
                return redirect()->route('admin-'.$this->model . ".index");
            }

            $category = Category::find($categoryId);
            if (empty($category)) {
                return View("admin.$this->model.edit");
            } else {
                $formData = $request->all();
                if (!empty($formData)) {
                    $validator = Validator::make(
                        $request->all(),
                        array(
                            'name' => 'required',
                            'image' => 'nullable|mimes:jpg,jpeg,png,webp',
                        ),
                        array(
                            "name.required" => trans("The name field is required."),
                            "image.mimes" => trans("The profile image should be of type jpeg,jpg,png."),
                        )
                    );
                    if ($validator->fails()) {
                        return Redirect::back()->withErrors($validator)->withInput();
                    } else {
                        $oldSlug = $category->slug;

                        $originalString = $request->name ?? "";
                        $lowercaseString = Str::lower($originalString);
                        $slug = Str::slug($lowercaseString, '-');

                        $alreadyAddedName = Category::where('name', $originalString)
                        ->where('id', '!=', $category->id)
                        ->first();

                        if (!is_null($alreadyAddedName)) {
                            return redirect()->back()->with(['error' => 'Slug is already added']);
                        }

                        DB::beginTransaction();
                        $obj                                = $category;
                        $obj->name                          = $request->input('name');
                        $obj->slug                          = $slug;
                        $obj->meta_title                    = $request->input('meta_title');
                        $obj->meta_description              = $request->input('meta_description');
                        $obj->meta_keywords                 = $request->input('meta_keywords');
                        if ($request->hasFile('image')) {
                            $extension = $request->file('image')->getClientOriginalExtension();
                            $originalName = $request->file('image')->getClientOriginalName();
                            $fileName = time() . '-image.' . $extension;

                            $folderName = strtoupper(date('M') . date('Y')) . "/";
                            $folderPath = Config('constant.CATEGORY_IMAGE_ROOT_PATH') . $folderName;
                            if (!File::exists($folderPath)) {
                                File::makeDirectory($folderPath, $mode = 0777, true);
                            }
                            if ($request->file('image')->move($folderPath, $fileName)) {
                                $obj->image = $folderName . $fileName;
                            }
                        }
                        $obj->save();
                        $lastId = $obj->id;
                        if(!empty($lastId)){
                            DB::commit();
                        }else{
                            DB::rollback();
                            Session()->flash('flash_notice', 'Something Went Wrong');
                            return Redirect::route('admin-category.index');
                        }
                        Session()->flash('flash_notice', trans("Category updated successfully."));
                        return Redirect::route('admin-category.index');
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
            $category = Category::find($categoryId);
            if (empty($category)) {
                return Redirect()->route($this->model . '.index');
            }
            if ($category) {
                Category::where('id', $categoryId)->update(array(
                    'is_deleted' => 1
                ));
    
                Session()->flash('flash_notice', trans("Category has been removed successfully."));
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
            $statusMessage = trans("Category has been actvated successfully");
        } else {
            $statusMessage = trans("Category has been deactivated successfully");
        }
        $category = Category::find($modelId);
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
