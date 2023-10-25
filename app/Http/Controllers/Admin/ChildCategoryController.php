<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ChildCategory;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class ChildCategoryController extends Controller
{
    public function index()
    {
        try {
            $childCategories = ChildCategory::with(['subCategory', 'category'])->get();
            return view('admin.child-category.list', compact('childCategories'));
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
            return view('admin.child-category.create', compact('categories', 'subCategories'));
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        try {
            $originalString = $request->child_category ?? "";
            $lowercaseString = Str::lower($originalString);
            $slug = Str::slug($lowercaseString, '-');

            $alreadyAddedName = ChildCategory::where('slug', $slug)->first();

            if (!is_null($alreadyAddedName)) {
                return redirect()->back()->with(['error' => 'Slug is already added']);
            }
            $childCategory = ChildCategory::create([
                'category_id' => $request->category_id,
                'sub_category_id' => $request->sub_category_id,
                'name' => $request->child_category,
                'slug' => $slug,
                'meta_title' => $request->meta_title ?? null,
                'meta_description' => $request->meta_description ?? null,
                'meta_keywords' => $request->meta_keywords ?? null,
            ]);

            return redirect()->route('admin-product-categories-child-category-list')->with('success', 'Child category created successfully');
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }
    }

    public function edit($token)
    {
        try {
            $categories = Category::get();
            $subCategories = SubCategory::get();
            $childbCategoryId = decrypt($token);
            $childCategory = ChildCategory::find($childbCategoryId);
            return view('admin.child-category.edit', compact('childCategory', 'categories', 'subCategories'));
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $token)
    {
        try {
            $childbCategoryId = decrypt($token);
            $childCategory = ChildCategory::find($childbCategoryId);

            $originalString = $request->child_category ?? "";
            $lowercaseString = Str::lower($originalString);
            $slug = Str::slug($lowercaseString, '-');

            $alreadyAddedName = ChildCategory::where('slug', $slug)
            ->where('id', '!=', $childCategory->id)
            ->first();

            if (!is_null($alreadyAddedName)) {
                return redirect()->back()->with(['error' => 'Slug is already added']);
            }

            $childCategory = tap($childCategory)->update([
                'category_id' => $request->category_id,
                'sub_category_id' => $request->sub_category_id,
                'name' => $request->child_category,
                'slug' => $slug,
                'meta_title' => $request->meta_title ?? null,
                'meta_description' => $request->meta_description ?? null,
                'meta_keywords' => $request->meta_keywords ?? null,
            ]);
            return redirect()->route('admin-product-categories-child-category-list')->with('success', 'Child category updated successfully');
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }
    }

    public function destory($token)
    {
        try {
            $childbCategoryId = decrypt($token);
            $childCategory = ChildCategory::find($childbCategoryId);
            $childCategory->delete();
            return redirect()->route('admin-product-categories-child-category-list')->with('success', 'Child category deleted successfully');
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }
    }

    public function childSubCategories(Request $request)
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
}
