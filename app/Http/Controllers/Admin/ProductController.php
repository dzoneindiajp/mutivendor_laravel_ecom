<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\ChildCategory;
use App\Models\ProductValues;
use App\Models\ProductOptions;
use App\Models\ProductVariants;
use App\Models\CategorySpecification;
use App\Service\FileUploadService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\OptionValueProductVariant;
use App\Models\Brand;
use App\Models\SpecificationValue;
use App\Models\ProductSpecification;
use App\Models\VariantValue;
use App\Models\Variant;
use App\Models\CategoryVariant;
use App\Models\ProductImage;
use App\Models\ProductShippingSpecification;
use App\Models\ProductVariant;
use App\Models\ProductVariantValue;
use App\Models\ProductVariantCombination;
use App\Models\ProductVariantCombinationImage;
use App\Models\ProductDescription;
use Validator, Response, Redirect, Str, View, File;

class ProductController extends Controller
{
    public $fileUploadService;
    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
        $this->listRouteName = 'admin-product-list';
        View()->share('listRouteName', $this->listRouteName);
    }

    public function index(Request $request)
    {
        try {
            $DB = Product::leftJoin('categories', 'products.category_id', '=', 'categories.id')
                ->leftJoin('categories as sub_categories', 'products.sub_category_id', '=', 'sub_categories.id')
                ->leftJoin('categories as child_categories', 'products.child_category_id', '=', 'child_categories.id');
            $sortBy = $request->input('sortBy') ? $request->input('sortBy') : 'products.created_at';
            $order = $request->input('order') ? $request->input('order') : 'desc';
            $offset = !empty($request->input('offset')) ? $request->input('offset') : 0;
            $limit = !empty($request->input('limit')) ? $request->input('limit') : Config("Reading.records_per_page");

            if ($request->all()) {
                $searchData = $request->all();
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
                    $DB->whereBetween('products.created_at', [$dateS . " 00:00:00", $dateE . " 23:59:59"]);
                } elseif (!empty($searchData['date_from'])) {
                    $dateS = $searchData['date_from'];
                    $DB->where('products.created_at', '>=', [$dateS . " 00:00:00"]);
                } elseif (!empty($searchData['date_to'])) {
                    $dateE = $searchData['date_to'];
                    $DB->where('products.created_at', '<=', [$dateE . " 00:00:00"]);
                }
                foreach ($searchData as $fieldName => $fieldValue) {
                    if ($fieldValue != "") {
                        if ($fieldName == "name") {
                            $DB->where("products.name", 'like', '%' . $fieldValue . '%');
                        }

                        if ($fieldName == "category_id") {
                            $DB->where("products.category_id", $fieldValue);
                        }
                        if ($fieldName == "sub_category_id") {
                            $DB->where("products.sub_category_id", $fieldValue);
                        }
                        if ($fieldName == "child_category_id") {
                            $DB->where("products.child_category_id", $fieldValue);
                        }
                    }
                }
            }


            $results = $DB->with('frontProductImage')->select('products.*', 'categories.name as category_name', 'sub_categories.name as sub_category_name', 'child_categories.name as child_category_name')->orderBy($sortBy, $order)->offset($offset)->limit($limit)->get();

            $totalResults = $DB->count();
            if ($request->ajax()) {

                return View("admin.products.load_more_data", compact('results', 'totalResults'));
            } else {

                $categories = Category::whereNull('parent_id')->where('is_deleted', 0)->get();
                return view('admin.products.list', compact('results', 'categories', 'totalResults'));

            }

        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }
    }

    public function create(Request $request)
    {

        try {
            $categories = Category::whereNull('parent_id')->where('is_active', 1)->where('is_deleted', 0)->get();
            $brands = Brand::where('is_active', 1)->where('is_deleted', 0)->get();

            if ($request->session()->has('currentProductId')) {
                $request->session()->forget('currentProductId');
            }
            $type = 'create';
            return view('admin.products.create', compact('categories', 'brands','type'));
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }
    }

    public function generateProductNumber($lastId = 0)
    {
        if (!empty($lastId)) {
            $productNumber = "JJ-" . ($lastId + 10000);
            return $productNumber;

        }

    }

    public function store(Request $request)
    {
        $formData = $request->all();
        $response = array();
        if (!empty($formData)) {

            $basicInformationValidationArray = [
                'name' => 'required',
                // 'bar_code' => 'required',
                'category_id' => 'required',
                // 'brand_id' => 'required'
            ];

            $detailsValidationArray = [
                // 'long_description' => 'required',
            ];
            $pricesValidationArray = [
                'buying_price' => 'required|numeric|gt:0',
                'selling_price' => 'required|numeric|gt:0',
            ];
            $specificationsValidationArray = [
                // 'specificationDataArr' => 'required|array|at_least_one_value'
            ];
            $shippingSpecificationsValidationArray = [
                // 'height' => 'required',
                // 'weight' => 'required',
                // 'width' => 'required',
                // 'length' => 'required',
                // 'dc' => 'required'
            ];
            $variantsTabFirstStepArray = [
                // 'variantsDataArr' => 'required|array|at_least_one_value_variant'
            ];
            $variantsTabSecondStepArray = [
                // 'variantsDataArr' => 'required|array|at_least_one_value_variant',
                // 'variantCombinationArr' => 'required|array'
            ];
            $mediasValidationArray = [];
            $advanceSeoValidationArray = [];
            Validator::extend('at_least_one_value', function ($attribute, $value, $parameters, $validator) {
                foreach ($value as $item) {
                    if (!empty($item['specification_values'][0])) {
                        return true;
                    }
                }
                return false;
            });
            Validator::extend('at_least_one_value_variant', function ($attribute, $value, $parameters, $validator) {
                foreach ($value as $item) {
                    if (!empty($item['variant_values'][0]) && !empty($item['variant_id'])) {
                        return true;
                    }
                }
                return false;
            });



            $validator = Validator::make(
                $request->all(),
                (!empty($request->current_tab) && $request->current_tab == 'basicInformationTab') ? $basicInformationValidationArray : ((!empty($request->current_tab) && $request->current_tab == 'detailsTab') ? $detailsValidationArray : ((!empty($request->current_tab) && $request->current_tab == 'pricesTab') ? $pricesValidationArray : ((!empty($request->current_tab) && $request->current_tab == 'specificationsTab') ? $specificationsValidationArray : ((!empty($request->current_tab) && $request->current_tab == 'shippingSpecificationsTab') ? $shippingSpecificationsValidationArray : ((!empty($request->current_tab) && $request->current_tab == 'mediasTab') ? $mediasValidationArray : ((!empty($request->current_tab) && $request->current_tab == 'variantsTab' && !empty($request->current_action) && $request->current_action == 'first_step') ? $variantsTabFirstStepArray : ((!empty($request->current_tab) && $request->current_tab == 'variantsTab' && !empty($request->current_action) && $request->current_action == 'second_step') ? $variantsTabSecondStepArray : ((!empty($request->current_tab) && $request->current_tab == 'advanceSeoTab') ? $advanceSeoValidationArray : [])))))))),

                array(
                    "specificationDataArr.required" => trans("The specifications fields are required."),
                    "specificationDataArr.array" => trans("The specifications should be array."),
                    "specificationDataArr.at_least_one_value" => trans("Please select atleast one values."),
                    "variantsDataArr.at_least_one_value_variant" => trans("Please select atleast one variant and its values. "),
                )
            );

            if ($validator->fails()) {
                $response = $this->change_error_msg_layout($validator->errors()->getMessages());
                return Response::json($response, 200);
            } else {

                if ((!empty($request->current_tab) && $request->current_tab == 'basicInformationTab')) {

                    if (!empty($request->session()->has('currentProductId'))) {
                        $obj = Product::find($request->session()->get('currentProductId'));
                    } else {
                        $obj = new Product;
                    }
                    $originalString = $request->name ?? "";
                    $lowercaseString = Str::lower($originalString);
                    $slug = Str::slug($lowercaseString, '-');

                    if((!empty($request->session()->has('currentProductId')) && ($obj->name != $request->name)) || ( empty($request->session()->has('currentProductId')))){
                        $alreadyAddedName = Product::where('name', $originalString)->first();

                        if (!is_null($alreadyAddedName)) {
                            $response = array();
                            $response["status"] = "error";
                            $response["msg"] = trans("Slug is already added");
                            $response["data"] = (object) array();
                            $response["http_code"] = 500;
                            return Response::json($response, 500);
                        }


                    }

                    $obj->slug = $slug;

                    $obj->name = !empty($request->name) ? $request->name : NULL;
                    ;
                    $obj->product_number = '00';
                    $obj->bar_code = $request->bar_code ?? Null;
                    $obj->category_id = $request->category_id;
                    $obj->brand_id = $request->brand_id ?? Null;
                    $obj->sub_category_id = !empty($request->sub_category_id) ? $request->sub_category_id : NULL;
                    $obj->child_category_id = !empty($request->child_category_id) ? $request->child_category_id : NULL;
                    $obj->save();
                    $lastId = $obj->id;
                    if (empty($lastId)) {
                        $response = array();
                        $response["status"] = "error";
                        $response["msg"] = trans("Something Went Wrong");
                        $response["data"] = (object) array();
                        $response["http_code"] = 500;
                        return Response::json($response, 500);
                    } else {
                        // Putting data into session
                        $request->session()->put('currentProductId', $lastId);

                        //Update Product Number
                        Product::where('id', $lastId)->update(['product_number' => $this->generateProductNumber($lastId)]);

                        $response = array();
                        $response["status"] = "success";
                        $response["msg"] = "";
                        $response["data"] = (object) array();
                        $response["http_code"] = 200;
                        return Response::json($response, 200);

                    }

                } else if ((!empty($request->current_tab) && $request->current_tab == 'detailsTab')) {
                    if (!empty($request->session()->has('currentProductId'))) {
                        ProductDescription::where('product_id',$request->session()->get('currentProductId'))->delete();
                        if(!empty($request->productDetailsArr)){
                            foreach($request->productDetailsArr as $productDetailKey => $productDetail){
                                if(!empty($productDetail['name']) && !empty($productDetail['value'])){

                                    $obj = new ProductDescription;
                                    $obj->product_id = $request->session()->get('currentProductId');
                                    $obj->name = $productDetail['name'];
                                    $obj->value = $productDetail['value'];
                                    $obj->save();
                                    $lastDetailId = $obj->id;
                                    if (empty($lastDetailId)) {
                                        $response = array();
                                        $response["status"] = "error";
                                        $response["msg"] = trans("Something Went Wrong");
                                        $response["data"] = (object) array();
                                        $response["http_code"] = 500;
                                        return Response::json($response, 500);
                                    }
                                }
                            }
                        }
                        $response = array();
                        $response["status"] = "success";
                        $response["msg"] = "";
                        $response["data"] = (object) array();
                        $response["http_code"] = 200;
                        return Response::json($response, 200);

                    } else {
                        $response = array();
                        $response["status"] = "error";
                        $response["msg"] = trans("messages.Invalid_Request");
                        $response["data"] = (object) array();
                        $response["http_code"] = 500;
                        return Response::json($response, 500);
                    }
                } else if ((!empty($request->current_tab) && $request->current_tab == 'pricesTab')) {
                    if (!empty($request->session()->has('currentProductId'))) {
                        $obj = Product::find($request->session()->get('currentProductId'));
                        $obj->buying_price = !empty($request->buying_price) ? $request->buying_price : '0.00';
                        $obj->selling_price = !empty($request->selling_price) ? $request->selling_price : '0.00';
                        $obj->is_including_taxes = !empty($request->is_including_taxes) ? 1 : 0;

                        $obj->save();
                        $lastId = $obj->id;
                        if (empty($lastId)) {
                            $response = array();
                            $response["status"] = "error";
                            $response["msg"] = trans("Something Went Wrong");
                            $response["data"] = (object) array();
                            $response["http_code"] = 500;
                            return Response::json($response, 500);
                        } else {
                            $productData = Product::where('id', $lastId)->first();

                            $specificationsData = CategorySpecification::select('specifications.id', 'specifications.name')
                                ->leftJoin('specifications', 'category_specifications.specification_id', '=', 'specifications.id')
                                ->where(function ($query) use ($productData) {
                                    $query->where('category_specifications.category_id', $productData->category_id)
                                        ->orWhere('category_specifications.category_id', $productData->sub_category_id)
                                        ->orWhere('category_specifications.category_id', $productData->child_category_id);
                                })
                                ->distinct()
                                ->get()->toArray();
                            if (!empty($specificationsData)) {
                                foreach ($specificationsData as &$dataVal) {
                                    $dataVal['specification_values'] = SpecificationValue::where('specification_id', $dataVal['id'])->get()->toArray();
                                }
                            }
                            $productSpecifications = ProductSpecification::where('product_id',$request->session()->get('currentProductId'))->pluck('specification_value_id')->toArray();
                            $htmlData = View::make("admin.products.specifications_data", compact('specificationsData','productSpecifications'))->render();

                            $response = array();
                            $response["status"] = "success";
                            $response["msg"] = "";
                            $response["data"] = $htmlData;
                            $response["http_code"] = 200;
                            return Response::json($response, 200);

                        }

                    } else {
                        $response = array();
                        $response["status"] = "error";
                        $response["msg"] = trans("messages.Invalid_Request");
                        $response["data"] = (object) array();
                        $response["http_code"] = 500;
                        return Response::json($response, 500);
                    }
                } else if ((!empty($request->current_tab) && $request->current_tab == 'specificationsTab')) {
                    if (!empty($request->session()->has('currentProductId'))) {

                        if (!empty($request->specificationDataArr)) {
                            ProductSpecification::where('product_id', $request->session()->get('currentProductId'))->delete();
                            foreach ($request->specificationDataArr as $specValue) {
                                if (!empty($specValue['name']) && !empty($specValue['specification_id']) && !empty($specValue['specification_values'][0])) {
                                    foreach ($specValue['specification_values'] as $dataVal) {
                                        $obj2 = new ProductSpecification;
                                        $obj2->product_id = $request->session()->get('currentProductId');
                                        $obj2->specification_id = $specValue['specification_id'];
                                        $obj2->specification_value_id = $dataVal;
                                        $obj2->save();
                                    }

                                }
                            }
                            $response = array();
                            $response["status"] = "success";
                            $response["msg"] = "";
                            $response["data"] = (object) array();
                            $response["http_code"] = 200;
                            return Response::json($response, 200);
                        } else {
                            $response = array();
                            $response["status"] = "error";
                            $response["msg"] = trans("Something went wrong");
                            $response["data"] = (object) array();
                            $response["http_code"] = 500;
                            return Response::json($response, 500);
                        }

                    } else {
                        $response = array();
                        $response["status"] = "error";
                        $response["msg"] = trans("messages.Invalid_Request");
                        $response["data"] = (object) array();
                        $response["http_code"] = 500;
                        return Response::json($response, 500);
                    }
                } else if ((!empty($request->current_tab) && $request->current_tab == 'shippingSpecificationsTab')) {
                    if (!empty($request->session()->has('currentProductId'))) {
                        $shippingSpecifications = ProductShippingSpecification::where('product_id', $request->session()->get('currentProductId'))->first();
                        if (!empty($shippingSpecifications)) {
                            $obj = ProductShippingSpecification::find($shippingSpecifications->id);
                        } else {
                            $obj = new ProductShippingSpecification;
                        }

                        $obj->product_id = $request->session()->get('currentProductId');
                        $obj->height = !empty($request->height) ? $request->height : NULL;
                        $obj->weight = !empty($request->weight) ? $request->weight : NULL;
                        $obj->width = !empty($request->width) ? $request->width : NULL;
                        $obj->length = !empty($request->length) ? $request->length : NULL;
                        $obj->dc = !empty($request->dc) ? $request->dc : NULL;
                        $obj->save();
                        $lastId = $obj->id;
                        if (empty($lastId)) {
                            $response = array();
                            $response["status"] = "error";
                            $response["msg"] = trans("Something Went Wrong");
                            $response["data"] = (object) array();
                            $response["http_code"] = 500;
                            return Response::json($response, 500);
                        } else {

                            $response = array();
                            $response["status"] = "success";
                            $response["msg"] = "";
                            $response["data"] = (object) array();
                            $response["http_code"] = 200;
                            return Response::json($response, 200);

                        }

                    } else {
                        $response = array();
                        $response["status"] = "error";
                        $response["msg"] = trans("messages.Invalid_Request");
                        $response["data"] = (object) array();
                        $response["http_code"] = 500;
                        return Response::json($response, 500);
                    }
                } else if ((!empty($request->current_tab) && $request->current_tab == 'mediasTab')) {
                    if (!empty($request->session()->has('currentProductId'))) {
                        $checkIfAnyMediaExists = ProductImage::where('product_id', $request->session()->get('currentProductId'))->count();
                        if ($checkIfAnyMediaExists == 0) {
                            $response = array();
                            $response["status"] = "error";
                            $response["msg"] = trans("Please upload atleast one image to continue.");
                            $response["data"] = (object) array();
                            $response["http_code"] = 500;
                            return Response::json($response, 500);

                        } else {
                            $productData = Product::where('id', $request->session()->get('currentProductId'))->first();

                            $variantsData = CategoryVariant::select('variants.id', 'variants.name')
                                ->leftJoin('variants', 'category_variants.variant_id', '=', 'variants.id')
                                ->where(function ($query) use ($productData) {
                                    $query->where('category_variants.category_id', $productData->category_id)
                                        ->orWhere('category_variants.category_id', $productData->sub_category_id)
                                        ->orWhere('category_variants.category_id', $productData->child_category_id);
                                })
                                ->distinct()
                                ->get()->toArray();

                            $productVariants = ProductVariant::where('product_id',$request->session()->get('currentProductId'))->pluck('variant_id')->toArray();
                            // print_r($productVariants);die;

                            $htmlData = View::make("admin.products.variants_data", compact('variantsData','productVariants'))->render();
                            $response = array();
                            $response["status"] = "success";
                            $response["msg"] = "";
                            $response["data"] = $htmlData;
                            $response["http_code"] = 200;
                            return Response::json($response, 200);

                        }
                    } else {
                        $response = array();
                        $response["status"] = "error";
                        $response["msg"] = trans("messages.Invalid_Request");
                        $response["data"] = (object) array();
                        $response["http_code"] = 500;
                        return Response::json($response, 500);
                    }

                } else if ((!empty($request->current_tab) && $request->current_tab == 'variantsTab' && $request->current_action == 'first_step')) {

                    if (!empty($request->session()->has('currentProductId'))) {
                        $productDetails = Product::where('id', $request->session()->get('currentProductId'))->first();

                       $response =  $this->variantsFirstStepAction($request,$productDetails);
                       return $response;
                    } else {
                        $response = array();
                        $response["status"] = "error";
                        $response["msg"] = trans("messages.Invalid_Request");
                        $response["data"] = (object) array();
                        $response["http_code"] = 500;
                        return Response::json($response, 500);
                    }
                } else if ((!empty($request->current_tab) && $request->current_tab == 'variantsTab' && $request->current_action == 'second_step')) {

                    if (!empty($request->session()->has('currentProductId'))) {
                        $productDetails = Product::where('id', $request->session()->get('currentProductId'))->first();

                        $this->variantsFirstStepAction($request,$productDetails);

                        $variantCombinationArr = $request->variantCombinationArr;

                        if (!empty($variantCombinationArr)) {

                            $getProductVariantCombinations = ProductVariantCombination::where('product_id', $request->session()->get('currentProductId'))->get();
                            if ($getProductVariantCombinations->isNotEmpty()) {
                                foreach ($getProductVariantCombinations as $pVarValue) {
                                    ProductVariantCombinationImage::where('product_variant_combination_id', $pVarValue->id)->delete();
                                }
                            }
                            ProductVariantCombination::where('product_id', $request->session()->get('currentProductId'))->delete();

                            DB::beginTransaction();
                            foreach ($variantCombinationArr as $variantCombVal) {
                                if (!empty($variantCombVal['image_ids']) && !empty($variantCombVal['main_variant_id']) && !empty($variantCombVal['variant_value_ids'])) {
                                    foreach ($variantCombVal['variant_value_ids'] as $variantValIdData) {
                                        if (!empty($variantValIdData['buying_price']) && !empty($variantValIdData['selling_price'])) {
                                            $getVariantValueName = VariantValue::where('id', $variantCombVal['main_variant_id'])->first()->name;
                                            $originalString = $getVariantValueName ?? "";
                                            $lowercaseString = Str::lower($originalString);
                                            $slug = Str::slug($lowercaseString, '-');

                                            $obj = new ProductVariantCombination;
                                            if(!empty($variantValIdData['value_id'])){

                                                $getVariantValueName2 = VariantValue::where('id', $variantValIdData['value_id'])->first()->name;
                                                $originalString2 = $getVariantValueName2 ?? "";
                                                $lowercaseString2 = Str::lower($originalString2);
                                                $slug2 = Str::slug($lowercaseString2, '-');
                                                $obj->slug = $productDetails->slug . "-" . $slug."-".$slug2;
                                            }else{

                                                $obj->slug = $productDetails->slug . "-" . $slug;
                                            }
                                            $obj->product_id = $productDetails->id;
                                            $obj->variant1_value_id = $variantCombVal['main_variant_id'];
                                            $obj->variant2_value_id = !empty($variantValIdData['value_id']) ? $variantValIdData['value_id'] : NULL;
                                            $obj->buying_price = $variantValIdData['buying_price'] ?? 0.00;
                                            $obj->selling_price = $variantValIdData['selling_price'] ?? 0.00;
                                            $obj->height = $variantValIdData['height'] ?? Null;
                                            $obj->weight = $variantValIdData['weight'] ?? Null;
                                            $obj->width = $variantValIdData['width'] ?? Null;
                                            $obj->length = $variantValIdData['length'] ?? Null;
                                            $obj->dc = $variantValIdData['dc'] ?? Null;
                                            $obj->bar_code = $variantValIdData['bar_code'] ?? Null;
                                            $obj->product_number = ' ';
                                            $obj->save();
                                            $lastId = $obj->id;
                                            if (empty($lastId)) {
                                                DB::rollback();
                                                $response = array();
                                                $response["status"] = "error";
                                                $response["msg"] = trans("Something Went Wrong");
                                                $response["data"] = (object) array();
                                                $response["http_code"] = 500;
                                                return Response::json($response, 500);
                                            }
                                            ProductVariantCombination::where('id',$lastId)->update(['product_number' =>$productDetails->product_number.'V'.$lastId ]);

                                            foreach ($variantCombVal['image_ids'] as $imageVal) {
                                                $obj2 = new ProductVariantCombinationImage;
                                                $obj2->product_variant_combination_id = $lastId;
                                                $obj2->product_image_id = $imageVal;
                                                $obj2->save();
                                                if (empty($obj2->id)) {
                                                    DB::rollback();
                                                    $response = array();
                                                    $response["status"] = "error";
                                                    $response["msg"] = trans("Something Went Wrong");
                                                    $response["data"] = (object) array();
                                                    $response["http_code"] = 500;
                                                    return Response::json($response, 500);
                                                }
                                            }

                                        } else {
                                            DB::rollback();
                                            $response = array();
                                            $response["status"] = "error";
                                            $response["msg"] = trans("Please fill all the details before submitting the combinations.");
                                            $response["data"] = (object) array();
                                            $response["http_code"] = 500;
                                            return Response::json($response, 500);
                                        }
                                    }


                                } else {
                                    DB::rollback();
                                    $response = array();
                                    $response["status"] = "error";
                                    $response["msg"] = trans("Please fill all the details before submitting the combinations.");
                                    $response["data"] = (object) array();
                                    $response["http_code"] = 500;
                                    return Response::json($response, 500);
                                }
                            }
                            DB::commit();
                        }


                        $response = array();
                        $response["status"] = "success";
                        $response["msg"] = "";
                        $response["data"] = (object) array();
                        $response["http_code"] = 200;
                        return Response::json($response, 200);
                    } else {
                        $response = array();
                        $response["status"] = "error";
                        $response["msg"] = trans("Something Went Wrong");
                        $response["data"] = (object) array();
                        $response["http_code"] = 500;
                        return Response::json($response, 500);
                    }


                } else if ((!empty($request->current_tab) && $request->current_tab == 'advanceSeoTab')) {
                    if (!empty($request->session()->has('currentProductId'))) {
                        $obj = Product::find($request->session()->get('currentProductId'));
                        $obj->meta_title = !empty($request->meta_title) ? $request->meta_title : '';
                        $obj->meta_description = !empty($request->meta_description) ? $request->meta_description : '';
                        $obj->meta_keywords = !empty($request->meta_keywords) ? $request->meta_keywords : '';

                        $obj->save();
                        $lastId = $obj->id;
                        if (empty($lastId)) {
                            $response = array();
                            $response["status"] = "error";
                            $response["msg"] = trans("Something Went Wrong");
                            $response["data"] = (object) array();
                            $response["http_code"] = 500;
                            return Response::json($response, 500);
                        } else {
                            $request->session()->forget('currentProductId');

                            $response = array();
                            $response["status"] = "success";
                            $response["msg"] = "Product added successfully.";
                            $response["data"] = (object) array();
                            $response["http_code"] = 200;
                            return Response::json($response, 200);

                        }

                    } else {
                        $response = array();
                        $response["status"] = "error";
                        $response["msg"] = trans("messages.Invalid_Request");
                        $response["data"] = (object) array();
                        $response["http_code"] = 500;
                        return Response::json($response, 500);
                    }



                } else {
                    $response = array();
                    $response["status"] = "error";
                    $response["msg"] = trans("messages.Invalid_Request");
                    $response["data"] = (object) array();
                    $response["http_code"] = 500;
                    return Response::json($response, 500);
                }


            }
        } else {
            $response = array();
            $response["status"] = "error";
            $response["msg"] = trans("messages.Invalid_Request");
            $response["data"] = (object) array();
            $response["http_code"] = 500;
            return Response::json($response, 500);
        }
        return json_encode($response);
    }

    function variantsFirstStepAction($request,$productDetails){
        $variantsDataArr = $request->variantsDataArr;
        if (!empty($variantsDataArr)) {

            $getProductVariants = ProductVariant::where('product_id', $request->session()->get('currentProductId'))->get();
            if ($getProductVariants->isNotEmpty()) {
                foreach ($getProductVariants as $pVarValue) {
                    ProductVariantValue::where('product_veriant_id', $pVarValue->id)->delete();
                }
            }
            ProductVariant::where('product_id', $request->session()->get('currentProductId'))->delete();

            foreach ($variantsDataArr as $variantValue) {
                if ( !empty($variantValue['variant_id']) && !empty($variantValue['variant_values'][0])) {
                    $obj2 = new ProductVariant;
                    $obj2->product_id = $request->session()->get('currentProductId');
                    $obj2->variant_id = $variantValue['variant_id'];
                    $obj2->save();
                    $pVariantId = $obj2->id;
                    if (empty($pVariantId)) {
                        $response = array();
                        $response["status"] = "error";
                        $response["msg"] = trans("Something Went Wrong");
                        $response["data"] = (object) array();
                        $response["http_code"] = 500;
                        return Response::json($response, 500);
                    }
                    foreach ($variantValue['variant_values'] as $dataVal) {
                        $obj3 = new ProductVariantValue;
                        $obj3->product_veriant_id = $pVariantId;
                        $obj3->veriant_value_id = $dataVal;
                        $obj3->save();
                    }

                }
            }

            // Inserting main product entry in ProductVariantCombinations Table
            $checkIfMainProductCombinationExists = ProductVariantCombination::where('product_id',$productDetails->id)->where('is_main_product',1)->first();
            if(!empty($checkIfMainProductCombinationExists)){

                $obj =  ProductVariantCombination::find($checkIfMainProductCombinationExists->id);
            }else{

                $obj = new ProductVariantCombination;
            }
            $obj->is_main_product = 1;
            $obj->slug = $productDetails->slug ?? Null;
            $obj->product_id = $productDetails->id ?? Null;
            $obj->variant1_value_id = Null;
            $obj->variant2_value_id = Null;
            $obj->buying_price = $productDetails->buying_price ?? 0.00;
            $obj->selling_price = $productDetails->selling_price ?? 0.00;
            $obj->height = $productDetails->height ?? Null;
            $obj->weight = $productDetails->weight ?? Null;
            $obj->width = $productDetails->width ?? Null;
            $obj->length = $productDetails->length ?? Null;
            $obj->dc = $productDetails->dc ?? Null;
            $obj->bar_code = $productDetails->bar_code ?? Null;
            $obj->product_number = $productDetails->product_number ?? Null;
            $obj->save();
            $variantCombId = $obj->id;

            // Inserting main product Images entry in ProductVariantCombinationImages Table
            if(!empty($variantCombId)){
                $productImages = ProductImage::where('product_id',$productDetails->id)->get();
                if($productImages->isNotEmpty()){
                    ProductVariantCombinationImage::where('product_variant_combination_id',$variantCombId)->delete();
                    foreach($productImages as $productImageData){
                        $obj = new ProductVariantCombinationImage;
                        $obj->product_variant_combination_id = $variantCombId;
                        $obj->product_image_id = $productImageData->id;
                        $obj->save();
                    }
                }
            }


            foreach ($variantsDataArr as $key => $variantData) {
                if (!empty($variantData['variant_id']) && !empty($variantData['variant_values'][0])) {
                    $variantName = $this->getVariantName($variantData['variant_id']);
                    $variantsDataArr[$key]['variant_name'] = $variantName;

                    $variantValuesNames = $this->getVariantValuesNames($variantData['variant_values']);
                    $variantValuesStoredData = $this->getVariantValuesStoredData($variantData['variant_values']);

                    // if(!empty($variantValuesStoredData)){
                    //     $selectedImages = ProductVariantCombinationImage::where('product_variant_combination_id',$variantValuesStoredData->id)->pluck('product_image_id')->toArray();
                    //     $variantsDataArr[$key]['selected_images'] = $selectedImages;
                    // }
                    $variantsDataArr[$key]['variant_values_names'] = $variantValuesNames;
                    $variantsDataArr[$key]['variant_values_data'] = $variantValuesStoredData;
                }else{
                    unset($variantsDataArr[$key]);
                }

            }
            // print_r($variantsDataArr);die;

            $productImages = ProductImage::where('product_id', $request->session()->get('currentProductId'))->get();
            // if($productImages->isNotEmpty()){
            //     foreach ($productImages as $key => $productImage) {
            //         $checkIfItIsSelected = ProductVariantCombinationImage::where('product_variant_combination_id')
            //     }
            // }
            $htmlData = View::make("admin.products.variants_combinations", compact('variantsDataArr', 'productImages'))->render();

            $response = array();
            $response["status"] = "success";
            $response["msg"] = "";
            $response["data"] = $htmlData;
            $response["http_code"] = 200;
            return Response::json($response, 200);
        } else {
            $response = array();
            $response["status"] = "error";
            $response["msg"] = trans("Something Went Wrong");
            $response["data"] = (object) array();
            $response["http_code"] = 500;
            return Response::json($response, 500);
        }
    }


    function getVariantName($variantId)
    {

        $variant = Variant::find($variantId); // Fetching variant data from the database
        return $variant->name; // Returning the variant name
    }
    function getVariantValuesNames($variantValues)
    {

        $variantValuesNames = VariantValue::whereIn('id', $variantValues)->pluck('name')->toArray();
        return $variantValuesNames; // Return the variant values names
    }
    function getVariantValuesStoredData($variantValues)
    {
        $returnData = [];
        if (!empty(request()->session()->has('currentProductId'))) {
            foreach($variantValues as $variantValue){
                $variantValueData = ProductVariantCombination::where('product_id',request()->session()->get('currentProductId'))->where(function ($query) use ($variantValue) {
                    $query->where('product_variant_combinations.variant1_value_id', $variantValue)
                        ->orWhere('product_variant_combinations.variant2_value_id', $variantValue);

                })->first();
                if(!empty($variantValueData)){

                    $returnData[] = $variantValueData;
                }
            }

        }
        return $returnData;
    }

    public function uploadImages(Request $request)
    {
        if (!empty($request->session()->has('currentProductId'))) {
            $productDetails = Product::where('id', $request->session()->get('currentProductId'))->first();
            if (!empty($productDetails)) {
                $formData = $request->all();
                if (!empty($formData)) {
                    $validator = Validator::make(
                        $request->all(),
                        array(

                            'file' => 'required',
                            'file.*' => 'required|mimes:jpg,jpeg,png',

                        ),
                        array(

                            "file.required" => trans("messages.The_image_field_is_required"),
                            "file.*.mimes" => trans("messages.The_images_must_be_a_file_of_type_jpg_jpeg_png"),

                        )
                    );
                    if ($validator->fails()) {
                        $response = $this->change_error_msg_layout($validator->errors()->getMessages());
                        return Response::json($response, 200);
                    } else {


                        $successMsg = 'Images added successfully';


                        if (!empty($request->file)) {
                            DB::beginTransaction();
                            $checkIfFrontBackImageExists = ProductImage::where('product_id', $productDetails->id)->where(function ($query) {

                                $query->where("product_images.is_front", 1);
                                $query->orWhere("product_images.is_back", 1);

                            })->count();
                            foreach ($request->file as $imageKey => $imageVal) {
                                if (!empty($imageVal)) {

                                    $obj = new ProductImage;
                                    $obj->product_id = $productDetails->id;

                                    $extension = $imageVal->getClientOriginalExtension();
                                    $originalName = $imageVal->getClientOriginalName();
                                    $fileName = time() . '-product_image-' . $productDetails->id . $imageKey . '.' . $extension;

                                    $folderName = strtoupper(date('M') . date('Y')) . "/";
                                    $folderPath = Config('constant.PRODUCT_IMAGE_ROOT_PATH') . $folderName;
                                    if (!File::exists($folderPath)) {
                                        File::makeDirectory($folderPath, $mode = 0777, true);
                                    }
                                    if ($imageVal->move($folderPath, $fileName)) {
                                        $obj->image = $folderName . $fileName;
                                        // $obj->original_image_name = $originalName;
                                    }
                                    if (($checkIfFrontBackImageExists == 0) && ($imageKey == 0)) {
                                        $obj->is_front = 1;
                                        $obj->is_back = 1;
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
                                }
                            }
                        }
                        DB::commit();

                        $getData = ProductImage::where('product_id', $productDetails->id)->orderBy('created_at', 'desc')->get();


                        $getData = View::make('admin.products.load_images', compact('getData'))->render();

                        $response = array();
                        $response["status"] = "success";
                        $response["msg"] = trans($successMsg);
                        $response["data"] = $getData;
                        $response["http_code"] = 200;
                        return Response::json($response, 200);
                    }
                } else {
                    $response = array();
                    $response["status"] = "error";
                    $response["msg"] = trans("Invalid Request");
                    $response["data"] = (object) array();
                    $response["http_code"] = 500;
                    return Response::json($response, 500);
                }
            } else {
                $response = array();
                $response["status"] = "error";
                $response["msg"] = trans("Something went wrong");
                $response["data"] = (object) array();
                $response["http_code"] = 500;
                return Response::json($response, 500);
            }
        } else {
            $response = array();
            $response["status"] = "error";
            $response["msg"] = trans("Invalid Request");
            $response["data"] = (object) array();
            $response["http_code"] = 500;
            return Response::json($response, 500);
        }



    }
    public function deleteImage(Request $request)
    {
        if (!empty($request->session()->has('currentProductId'))) {
            $productDetails = Product::where('id', $request->session()->get('currentProductId'))->first();
            if (!empty($productDetails)) {
                if (!empty($request->id)) {
                    $recordId = base64_decode($request->id);
                    $getRecordData = ProductImage::where('id', $recordId)->where('product_id', $productDetails->id)->first();
                    if (!empty($getRecordData)) {
                        $filePath = Config('constant.PRODUCT_IMAGE_ROOT_PATH') . $getRecordData->image;
                        if (File::exists($filePath)) {
                            File::delete($filePath);
                        }
                        ProductImage::where('id', $recordId)->where('product_id', $productDetails->id)->delete();
                    }

                    // $getData = ProductImage::where('product_id', $productDetails->id)->orderBy('created_at', 'desc')->get();

                    // $getData = View::make('admin.products.load_images', compact('getData'))->render();

                    $response = array();
                    $response["status"] = "success";
                    $response["msg"] = trans("messages.Image deleted successfully.");
                    $response["data"] = (object) array();
                    $response["http_code"] = 200;
                    return Response::json($response, 200);
                } else {
                    $response = array();
                    $response["status"] = "error";
                    $response["msg"] = trans("messages.Invalid_Request");
                    $response["data"] = (object) array();
                    $response["http_code"] = 500;
                    return Response::json($response, 500);
                }
            } else {
                $response = array();
                $response["status"] = "error";
                $response["msg"] = trans("messages.Something_went_wrong");
                $response["data"] = (object) array();
                $response["http_code"] = 500;
                return Response::json($response, 500);
            }
        } else {
            $response = array();
            $response["status"] = "error";
            $response["msg"] = trans("messages.Invalid_Request");
            $response["data"] = (object) array();
            $response["http_code"] = 500;
            return Response::json($response, 500);
        }


    }

    public function updateImageMetaValues(Request $request)
    {
        if (!empty($request->session()->has('currentProductId'))) {
            $productDetails = Product::where('id', $request->session()->get('currentProductId'))->first();
            if (!empty($productDetails)) {
                if (!empty($request->id) && !empty($request->type)) {
                    $recordId = base64_decode($request->id);
                    ProductImage::where('product_id', $productDetails->id)->update(['is_' . $request->type => 0]);
                    ProductImage::where('id', $recordId)->where('product_id', $productDetails->id)->update(['is_' . $request->type => 1]);

                    $response = array();
                    $response["status"] = "success";
                    $response["msg"] = trans("Updated successfully.");
                    $response["data"] = (object) array();
                    $response["http_code"] = 200;
                    return Response::json($response, 200);
                } else {
                    $response = array();
                    $response["status"] = "error";
                    $response["msg"] = trans("messages.Invalid_Request");
                    $response["data"] = (object) array();
                    $response["http_code"] = 500;
                    return Response::json($response, 500);
                }
            } else {
                $response = array();
                $response["status"] = "error";
                $response["msg"] = trans("messages.Something_went_wrong");
                $response["data"] = (object) array();
                $response["http_code"] = 500;
                return Response::json($response, 500);
            }
        } else {
            $response = array();
            $response["status"] = "error";
            $response["msg"] = trans("messages.Invalid_Request");
            $response["data"] = (object) array();
            $response["http_code"] = 500;
            return Response::json($response, 500);
        }


    }

    public function view($token)
    {
        try {
            $productId = decrypt($token);
            $product = Product::find($productId);
            return view('admin.products.view', compact('product'));
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }
    }

    public function edit($token,Request $request)
    {
        try {
            $productId = decrypt($token);
            $productDetails = Product::leftJoin('product_shipping_specifications','product_shipping_specifications.product_id','products.id')->where('products.id',$productId)->select('products.*','product_shipping_specifications.height','product_shipping_specifications.weight','product_shipping_specifications.width','product_shipping_specifications.length','product_shipping_specifications.dc')->first();
            if(!empty($productDetails)){
                $categories = Category::where('is_active', 1)->where('is_deleted', 0)->get();
                $brands = Brand::where('is_active', 1)->where('is_deleted', 0)->get();

                $request->session()->put('currentProductId',$productId);

                $productDetails->product_images = ProductImage::where('product_id',$productId)->get();
                $type = 'edit';
                $productDescriptionsData = ProductDescription::where('product_id',$productId)->get()->toArray();
                return view('admin.products.create', compact('categories', 'brands', 'productDetails','productId','type','productDescriptionsData'));
            }else{
                return redirect()->back()->with(['error' => 'Invalid Request']);
            }

        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $token)
    {
        try {
            $productId = decrypt($token);
            $product = Product::find($productId);
            $oldFrontImage = $product->front_image;
            $oldBackImage = $product->back_image;
            $oldProductsImages = $product->images;
            $oldProductsVideos = $product->videos;

            $frontSelectedFile = $request->front_image ?? "";
            $backSelectedFile = $request->back_image ?? "";
            $editProductImageFiles = $request->edit_product_images ?? "";
            $productVideosFiles = $request->product_videos ?? "";

            if ($frontSelectedFile) {
                $frontImage = $request->file('front_image');
                $frontImagePath = "products/variants/front-images";
                $frontUploadedFile = $this->fileUploadService->uploadFile($frontImage, $frontImagePath);
            }

            if ($backSelectedFile) {
                $backImage = $request->file('back_image');
                $backImagePath = "products/variants/back-images";
                $backUploadedFile = $this->fileUploadService->uploadFile($backImage, $backImagePath);
            }

            if ($editProductImageFiles) {
                foreach ($request->file('edit_product_images') as $editProductImage) {
                    $productImagePath = "products/variants/images";
                    $editProductImagesUploadedFile[] = $this->fileUploadService->uploadFile($editProductImage, $productImagePath);
                }
            }

            if ($productVideosFiles) {
                foreach ($request->file('product_videos') as $productVideo) {
                    $productVideoPath = "products/variants/videos";
                    $editProductVideosUploadedFiles[] = $this->fileUploadService->uploadFile($productVideo, $productVideoPath);
                }
            }

            $product = tap($product)->update([

                'name' => $request->name,
                'category_id' => $request->category_id,
                'sub_category_id' => $request->sub_category_id ?? null,
                'child_category_id' => $request->child_category_id ?? null,

            ]);

            // $productVariant = ProductVariants::where('product_id',$product->id)->first();
            $productVariant = ProductVariants::create([
                'product_id' => $product,
                'short_description' => $request->short_description,
                'description' => $request->description ?? null,
                'front_image' => $frontUploadedFile ?? $oldFrontImage,
                'back_image' => $backUploadedFile ?? $oldBackImage,
                'images' => json_encode($editProductImagesUploadedFile) ?? $oldProductsImages,
                'videos' => json_encode($editProductVideosUploadedFiles) ?? null,
                'price' => $request->price,
                'meta_title' => $request->meta_title ?? null,
                'meta_description' => $request->meta_description ?? null,
                'meta_keywords' => $request->meta_keywords ?? null,
            ]);
            return redirect()->route('admin-product-list')->with('success', 'Product updated successfully');
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }
    }

    public function destory($token)
    {
        try {
            $productId = decrypt($token);
            $product = Product::find($productId);
            $product->delete();
            return redirect()->route('admin-product-list')->with('success', 'Product deleted successfully');
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }
    }

    public function getSubCategories(Request $request)
    {
        try {
            $categoryId = $request->category_id ?? "";
            $subCategories = Category::where('parent_id', $categoryId)->where('is_active', 1)->where('is_deleted', 0)->get();

            return response()->json(['subCategories' => $subCategories, 'success' => true, 'message' => 'Data fetched'], 200);
        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json(['message' => 'Something is wrong', 'success' => false, 'error_msg' => $e->getMessage()], 500);
        }
    }
    public function getVariantValues(Request $request)
    {
        try {
            if (!empty($request->session()->has('currentProductId'))) {
                $variantId = $request->variant_id ?? "";
                $variantValues = VariantValue::where('variant_id', $variantId)->where('is_deleted', 0)->get();
                $productVariant = ProductVariant::where('variant_id', $variantId)->where('product_id',$request->session()->get('currentProductId'))->first();
                $productVariantValues = [];
                if(!empty($productVariant)){

                    $productVariantValues = ProductVariantValue::where('product_veriant_id',$productVariant->id)->pluck('veriant_value_id');
                }

                return response()->json(['variantValues' => $variantValues,'productVariantValues' => $productVariantValues, 'success' => true, 'message' => 'Data fetched'], 200);
            }else{
                $response = array();
                $response["status"] = "error";
                $response["msg"] = trans("messages.Invalid_Request");
                $response["data"] = (object) array();
                $response["http_code"] = 500;
                return Response::json($response, 500);
            }


        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json(['message' => 'Something is wrong', 'success' => false, 'error_msg' => $e->getMessage()], 500);
        }
    }

    public function getChildCategories(Request $request)
    {
        try {
            $subCategoryId = $request->sub_category_id ?? "";
            $childCategories = Category::where('parent_id', $subCategoryId)->where('is_active', 1)->where('is_deleted', 0)->get();

            return response()->json(['childCategories' => $childCategories, 'success' => true, 'message' => 'Data fetched'], 200);
        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json(['message' => 'Something is wrong', 'success' => false, 'error_msg' => $e->getMessage()], 500);
        }
    }

    // app/Http/Controllers/Admin/ProductController.php

    public function updateStock(Request $request)
    {
        $productId = $request->input('productId');
        $inStock = $request->input('inStock');
        // Update the product in the database
        Product::where('id', $productId)->update(['in_stock' => $inStock]);

        return response()->json(['success' => true]);
    }


    public function updateFeatured(Request $request)
    {
        $productId = $request->input('productId');
        $isFeatured = $request->input('isFeatured');
        // Update the product in the database
        Product::where('id', $productId)->update(['is_featured' => $isFeatured]);

        return response()->json(['success' => true]);
    }

}