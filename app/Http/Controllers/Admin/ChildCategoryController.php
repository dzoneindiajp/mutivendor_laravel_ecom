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
use App\Models\Variant;
use App\Models\CategoryVariant;
use App\Models\CategorySpecification;
use App\Models\Specification;

class ChildCategoryController extends Controller
{
    public $model =    'child-category';
    public function __construct(Request $request)
    {   
        $this->listRouteName = 'admin-child-category.index';
        View()->share('model', $this->model);
        View()->share('listRouteName', $this->listRouteName);
        $this->request = $request;
    }

    public function index(Request $request, $endesid = null)
    {
        if (!empty($endesid)) {
            $dep_id = base64_decode($endesid);
        }
        $SubcategoryDetails  =  Category::where('categories.id', $dep_id)->first();
        if (empty($dep_id) || empty($SubcategoryDetails)) {
            return Redirect()->back();
        }
        $DB                    =    Category::query();
        $searchVariable        =    array();
        $inputGet            =    $request->all();
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
            if (isset($searchData['page'])) {
                unset($searchData['page']);
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
                $searchVariable    =    array_merge($searchVariable, array($fieldName => $fieldValue));
            }
        }
        $DB->where("is_deleted", 0);
        $DB->where("parent_id", $dep_id);
        $DB->select("categories.*");
        $sortBy = ($request->input('sortBy')) ? $request->input('sortBy') : 'category_order';
        $order  = ($request->input('order')) ? $request->input('order')   : 'ASC';
        $offset = !empty($request->input('offset')) ? $request->input('offset') : 0 ;
        $limit =  !empty($request->input('limit')) ? $request->input('limit') : Config("Reading.records_per_page"); 

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

            return  View("admin.$this->model.load_more_data", compact('results','totalResults','dep_id','SubcategoryDetails'));
        }else{
            return  View("admin.$this->model.index", compact('results','totalResults','dep_id','SubcategoryDetails'));
        }
    }

    public function add(Request $request, $endesid = null)
    {   
        if (!empty($endesid)) {
            $dep_id = base64_decode($endesid);
        }
        if (empty($endesid)) {
            return Redirect()->back();
        }
        $formData =    $request->all();
        $SubcategoryDetails  =  Category::where('id', $dep_id)->first();
        if ($request->isMethod('POST')) {
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
                    $totalChildCategoryCount = Category::where('parent_id', $dep_id)->count();
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
                        'parent_id' => $dep_id,
                        'slug' => $slug,
                        'image' => $imagePath,
                        'category_order' => (!empty($totalChildCategoryCount) ? $totalChildCategoryCount + 1 : 1),
                        'meta_title' => $request->meta_title ?? null,
                        'meta_description' => $request->meta_description ?? null,
                        'meta_keywords' => $request->meta_keywords ?? null,
                    ]);

                    $lastId = $category->id;
                    if(!empty($lastId)){
                        if(!empty($request->variantsData) && is_array($request->variantsData)){
                            foreach($request->variantsData as $variantKey => $variantVal){
                                // $checkIfvarientExists = Variant::where('id',$variantVal)->first();
                                $variantId = $variantVal;
                                
                                // if(empty($checkIfvarientExists)){
                                    
                                //     $variantObj   = new Variant;
                                //     $variantObj->name = $variantVal;
                                //     $variantObj->save();
                                    
                                //     $variantId = $variantObj->id;
                                   
                                //     if(empty($variantId)){
                                //         DB::rollback();
                                //         Session()->flash('flash_notice', 'Something Went Wrong');
                                //         return Redirect::route('admin-category.index');
                                //     }
                                // }
                                $obj2    =   new CategoryVariant;
                                $obj2->category_id = $lastId;
                                $obj2->variant_id = $variantId;
                                $obj2->save();
                               
                            }
                        }
    
                        if(!empty($request->specificationsData) && is_array($request->specificationsData)){
                            foreach($request->specificationsData as $specificationVal){
                                // $checkIfspecificationExists = Specification::where('id',$specificationVal)->first();
                                $specificationId = $specificationVal;
                                // if(empty($checkIfspecificationExists)){
                                //     $specificationObj   = new Specification;
                                //     $specificationObj->name = $specificationVal;
                                //     $specificationObj->name = $specificationVal;
                                //     $specificationObj->save();
                                //     $specificationId = $specificationObj->id;
                                //     if(empty($specificationId)){
                                //         DB::rollback();
                                //         Session()->flash('flash_notice', 'Something Went Wrong');
                                //         return Redirect::route('admin-category.index');
                                //     }
                                // }
                                $obj2    =   new CategorySpecification;
                                $obj2->category_id = $lastId;
                                $obj2->specification_id = $specificationId;
                                $obj2->save();
                               
    
                            }
                        }
                    }

                    return redirect()->route('admin-child-category.index', $endesid)->with('success', 'Child Category created successfully');
                }
            }
        }
        $variants = Variant::select('id', 'name')->get();
        $specifications = Specification::leftJoin('specification_groups', 'specifications.specification_group_id', '=', 'specification_groups.id')->select('specifications.id', DB::raw("CONCAT(specification_groups.name, ' > ', specifications.name) as name"))->get();
        return  View("admin.$this->model.create", compact('dep_id', 'SubcategoryDetails','variants','specifications'));
    }

    public function update(Request $request, $endesid = null)
    {
        $des_id = '';
        if (!empty($endesid)) {
            $des_id = base64_decode($endesid);
        }
        $category =    Category::where('categories.id', $des_id)->first();
        $SubcategoryDetails  =  Category::where('id', $category->parent_id)->first();
        if (empty($category)) {
            return Redirect()->back();
        }
        if(!empty($category->image)){
            $category->image = Config('constant.CATEGORY_IMAGE_URL').$category->image;
        }
        if ($request->isMethod('POST')) {
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
                    $obj                                = Category::find($des_id);
                    $obj->name                          = $request->input('name');
                    $obj->parent_id                     = $category->parent_id;
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
                        CategoryVariant::where('category_id',$lastId)->delete();
                        CategorySpecification::where('category_id',$lastId)->delete();
                        if(!empty($request->variantsData) && is_array($request->variantsData)){
                            foreach($request->variantsData as $variantKey => $variantVal){
                                // $checkIfvarientExists = Variant::where('id',$variantVal)->first();
                                $variantId = $variantVal;
                                
                                $obj2    =   new CategoryVariant;
                                $obj2->category_id = $lastId;
                                $obj2->variant_id = $variantId;
                                $obj2->save();
                                if(empty($obj2->id)){
                                    DB::rollback();
                                    Session()->flash('flash_notice', 'Something Went Wrong');
                                    return Redirect::route('admin-category.index');
                                }

                            }
                        }

                        if(!empty($request->specificationsData) && is_array($request->specificationsData)){
                            foreach($request->specificationsData as $specificationVal){
                                // $checkIfspecificationExists = Specification::where('id',$specificationVal)->first();
                                $specificationId = $specificationVal;
                                
                                $obj2    =   new CategorySpecification;
                                $obj2->category_id = $lastId;
                                $obj2->specification_id = $specificationId;
                                $obj2->save();
                                if(empty($obj2->id)){
                                    DB::rollback();
                                    Session()->flash('flash_notice', 'Something Went Wrong');
                                    return Redirect::route('admin-category.index');
                                }

                            }
                        }
                        
                        DB::commit();
                    }else{
                        DB::rollback();
                        Session()->flash('flash_notice', 'Something Went Wrong');
                        return Redirect::route('admin-child-category.index', base64_encode($category->parent_id));
                    }
                    Session()->flash('flash_notice', trans("Child category updated successfully."));
                    return Redirect::route('admin-child-category.index', base64_encode($category->parent_id));
                }
            }
        }
        $variants = Variant::select('id', 'name')->get();
        $specifications = Specification::leftJoin('specification_groups', 'specifications.specification_group_id', '=', 'specification_groups.id')->select('specifications.id', DB::raw("CONCAT(specification_groups.name, ' > ', specifications.name) as name"))->get();
        $categoryVariants = CategoryVariant::where('category_id',$des_id)->pluck('variant_id')->toArray();
        $categorySpecifications = CategorySpecification::where('category_id',$des_id)->pluck('specification_id')->toArray();
        
        return  View("admin.$this->model.edit", compact('category', 'SubcategoryDetails','variants','specifications','categoryVariants','categorySpecifications'));
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
                CategoryVariant::where('category_id',$categoryId)->delete();
                CategorySpecification::where('category_id',$categoryId)->delete();
    
    
                Session()->flash('flash_notice', trans("Child category has been removed successfully."));
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
            $statusMessage = trans("Child category has been actvated successfully");
        } else {
            $statusMessage = trans("Child category has been deactivated successfully");
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
