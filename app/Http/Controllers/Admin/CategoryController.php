<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        try {
            $categories = Category::get();
            return view('admin.category.list', compact('categories'));
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
            $originalString = $request->name ?? "";
            $lowercaseString = Str::lower($originalString);
            $slug = Str::slug($lowercaseString, '-');


            $alreadyAddedName = Category::where('name', $originalString)->first();

            if (!is_null($alreadyAddedName)) {
                return redirect()->back()->with(['error' => 'Slug is already added']);
            }
            $category = Category::create([
                'name' => $request->name,
                'slug' => $slug,
                'meta_title' => $request->meta_title ?? null,
                'meta_description' => $request->meta_description ?? null,
                'meta_keywords' => $request->meta_keywords ?? null,
            ]);

            return redirect()->route('admin-product-categories-category-list')->with('success', 'Category created successfully');
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }
    }

    public function edit($token)
    {
        try {
            $categoryId = decrypt($token);
            $category = Category::find($categoryId);
            return view('admin.category.edit', compact('category'));
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $token)
    {
        try {
            $categoryId = decrypt($token);
            $category = Category::find($categoryId);
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
            $category = tap($category)->update([
                'name' => $request->name,
                'slug' => $slug,
                'meta_title' => $request->meta_title ?? null,
                'meta_description' => $request->meta_description ?? null,
                'meta_keywords' => $request->meta_keywords ?? null,
            ]);

            return redirect()->route('admin-product-categories-category-list')->with('success', 'Category updated successfully');
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }
    }

    public function destory($token)
    {
        try {
            $categoryId = decrypt($token);
            $category = Category::find($categoryId);
            $category->delete();
            return redirect()->route('admin-product-categories-category-list')->with('success', 'Category deleted successfully');
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }
    }
}
