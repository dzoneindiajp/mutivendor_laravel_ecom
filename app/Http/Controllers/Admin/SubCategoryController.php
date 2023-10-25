<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class SubCategoryController extends Controller
{
    public function index()
    {
        try {
            $subCategories = SubCategory::with(['category'])->get();
            return view('admin.sub-category.list', compact('subCategories'));
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }
    }

    public function create()
    {
        try {
            $categories = Category::get();
            return view('admin.sub-category.create', compact('categories'));
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        try {
            $originalString = $request->sub_category ?? "";
            $lowercaseString = Str::lower($originalString);
            $slug = Str::slug($lowercaseString, '-');

            $alreadyAddedName = SubCategory::where('slug', $slug)->first();

            if (!is_null($alreadyAddedName)) {
                return redirect()->back()->with(['error' => 'Slug is already added']);
            } else {
                $subCategory = SubCategory::create([
                    'category_id' => $request->category_id,
                    'name' => $request->sub_category,
                    'slug' => $slug,
                    'meta_title' => $request->meta_title ?? null,
                    'meta_description' => $request->meta_description ?? null,
                    'meta_keywords' => $request->meta_keywords ?? null,
                ]);
            }

            return redirect()->route('admin-product-categories-sub-category-list')->with('success', 'Sub Category created successfully');
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }
    }

    public function edit($token)
    {
        try {
            $subCategoryId = decrypt($token);
            $subCategory = SubCategory::find($subCategoryId);
            $categories = Category::get();
            return view('admin.sub-category.edit', compact('subCategory', 'categories'));
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $token)
    {
        try {
            $subCategoryId = decrypt($token);
            $subCategory = SubCategory::find($subCategoryId);

            $originalString = $request->sub_category ?? "";
            $lowercaseString = Str::lower($originalString);
            $slug = Str::slug($lowercaseString, '-');

            $alreadyAddedName = SubCategory::where('slug', $slug)
            ->where('id', '!=', $subCategory->id)
            ->first();

            if (!is_null($alreadyAddedName)) {
                return redirect()->back()->with(['error' => 'Slug is already added']);
            } else {
                $subCategory = tap($subCategory)->update([
                    'category_id' => $request->category_id,
                    'name' => $request->sub_category,
                    'slug' => $slug,
                    'meta_title' => $request->meta_title ?? null,
                    'meta_description' => $request->meta_description ?? null,
                    'meta_keywords' => $request->meta_keywords ?? null,
                ]);
            }
            return redirect()->route('admin-product-categories-sub-category-list')->with('success', 'Sub Category updated successfully');
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }
    }

    public function destory($token)
    {
        try {
            $subCategoryId = decrypt($token);
            $subCategory = SubCategory::find($subCategoryId);
            $subCategory->delete();
            return redirect()->route('admin-product-categories-sub-category-list')->with('success', 'Sub Category deleted successfully');
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }
    }
}
