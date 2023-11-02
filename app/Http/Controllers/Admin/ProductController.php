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
use App\Service\FileUploadService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\OptionValueProductVariant;

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
            $DB = Product::leftJoin('categories', 'products.category_id', '=', 'categories.id')->leftJoin('sub_categories', 'products.sub_category_id', '=', 'sub_categories.id')->leftJoin('child_categories', 'products.child_category_id', '=', 'child_categories.id');
            $sortBy = $request->input('sortBy') ? $request->input('sortBy') : 'products.created_at';
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


            $results = $DB->select('products.*','categories.name as category_name','sub_categories.name as sub_category_name','child_categories.name as child_category_name')->orderBy($sortBy, $order)->offset($offset)->limit($limit)->get();
            $totalResults = $DB->count();
            if($request->ajax()){

                return  View("admin.products.load_more_data", compact('results','totalResults'));
            }else{
                
                $categories = Category::get();
                return view('admin.products.list', compact('results','categories','totalResults'));
            }
            
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }
    }

    public function create()
    {
        try {
            $categories = Category::get();
            $subCategories = SubCategory::get();
            $childCategories = ChildCategory::get();
            $productOptions = ProductOptions::whereHas('productOptionValues')->get();
            // dd($productOptions);
            $productOptionValues = ProductValues::get();
            $productOptionValuesDatas = $productOptionValues->groupBy('product_option_id');
            // dd($productOptionValuesDatas);
            return view('admin.products.create',compact('categories','subCategories','childCategories','productOptions','productOptionValues','productOptionValuesDatas'));
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        try {
            // dd($request->all());
            $frontSelectedFile = $request->front_image ?? "";
            $backSelectedFile = $request->back_image ?? "";
            $productImageFiles = $request->product_images ?? "";
            $productVideosFiles = $request->product_videos ?? "";
            $productOptionValueids = $request->product_option_value_id ?? [];

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

            if ($productImageFiles) {
                foreach ($request->file('product_images') as $productImage) {
                    $productImagePath = "products/variants/images";
                    $productImagesUploadedFiles[] = $this->fileUploadService->uploadFile($productImage, $productImagePath);
                }
            }

            if ($productVideosFiles) {
                foreach ($request->file('product_videos') as $productVideo) {
                    $productVideoPath = "products/variants/videos";
                    $productVideosUploadedFiles[] = $this->fileUploadService->uploadFile($productVideo, $productVideoPath);
                }
            }

            DB::beginTransaction();

            $product = Product::create([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'sub_category_id' => $request->sub_category_id ?? null,
                'child_category_id' => $request->child_category_id ?? null,
                
                
            ]);

            $productVariant = ProductVariants::create([
                'product_id' => $product->id,
                'short_description' => $request->short_description,
                'description' => $request->description ?? null,
                'front_image' => $frontUploadedFile,
                'back_image' => $backUploadedFile,
                'images' => json_encode($productImagesUploadedFiles) ?? null,
                'videos' => json_encode($productVideosUploadedFiles) ?? null,
                'price' => $request->price ?? 100,
                'meta_title' => $request->meta_title ?? null,
                'meta_description' => $request->meta_description ?? null,
                'meta_keywords' => $request->meta_keywords ?? null,
            ]);

            foreach ($productOptionValueids as $item) {
                $productOptionValuesVariant = OptionValueProductVariant::create([
                    'value_id' => $item,
                    'variant_id' => $productVariant->id,
                ]);
            }

            DB::commit();

            return redirect()->route('admin-product-list')->with('success', 'Product created successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }
    }

    public function view($token) {
        try {
            $productId = decrypt($token);
            $product = Product::find($productId);
            return view('admin.products.view', compact('product'));
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }
    }

    public function edit($token)
    {
        try {
            $productId = decrypt($token);

            $categories = Category::get();
            $subCategories = SubCategory::get();
            $childCategories = ChildCategory::get();
            $productId = decrypt($token);
            $product = Product::find($productId);
            $productOptions = ProductOptions::whereHas('productOptionValues')->get();
            // dd($productOptions);
            $productOptionValues = ProductValues::get();
            $productOptionValuesDatas = $productOptionValues->groupBy('product_option_id');
            return view('admin.products.edit', compact('categories','subCategories','childCategories','product','productOptions','productOptionValues','productOptionValuesDatas'));
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
            $subCategories = SubCategory::getSubCategoryByCategory($categoryId)->with(['category'])->get();

            return response()->json(['subCategories' => $subCategories, 'success' => true, 'message' => 'Data fetched'], 200);
        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json(['message' => 'Something is wrong', 'success' => false, 'error_msg' => $e->getMessage()], 500);
        }
    }

    public function getChildCategories(Request $request)
    {
        try {
            $subCategoryId = $request->sub_category_id ?? "";
            $childCategories = ChildCategory::getChildCategoryByCategory($subCategoryId)->with(['subCategory.category'])->get();

            return response()->json(['childCategories' => $childCategories, 'success' => true, 'message' => 'Data fetched'], 200);
        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json(['message' => 'Something is wrong', 'success' => false, 'error_msg' => $e->getMessage()], 500);
        }
    }
}