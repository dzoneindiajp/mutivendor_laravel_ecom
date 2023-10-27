<?php

use App\Models\ChildCategory;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\ChildCategoryController;
use App\Http\Controllers\Admin\ProductOptionsController;
use App\Http\Controllers\Admin\ProductValuesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// File upload
Route::prefix('file')->name('file-')->group(function () {
    Route::post('upload', [FileUploadController::class, 'store'])->name('upload');
    Route::post('remove', [FileUploadController::class, 'destroy'])->name('remove');
});


Route::prefix('admin')->name('admin-')->group(function () {

    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/verify-login', [AuthController::class, 'verifyLogin'])->name('verify-login');
    Route::middleware('auth')->group(function () {
        Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::prefix('product')->name('product-')->group(function () {
            Route::get('list', [ProductController::class, 'index'])->name('list');
            Route::get('create', [ProductController::class, 'create'])->name('create');
            Route::post('store', [ProductController::class, 'store'])->name('store');
            Route::get('view/{token}', [ProductController::class, 'view'])->name('view');
            Route::get('edit/{token}', [ProductController::class, 'edit'])->name('edit');
            Route::post('update/{token}', [ProductController::class, 'update'])->name('update');
            Route::delete('delete/{token}', [ProductController::class, 'destory'])->name('delete');
            Route::get('sub-category-list', [ProductController::class, 'getSubCategories'])->name('sub-category-list');
            Route::get('child-category-list', [ProductController::class, 'getChildCategories'])->name('child-category-list');

            Route::prefix('options')->name('options-')->group(function () {
                Route::get('list', [ProductOptionsController::class, 'index'])->name('list');
                Route::get('create', [ProductOptionsController::class, 'create'])->name('create');
                Route::post('store', [ProductOptionsController::class, 'store'])->name('store');
                Route::get('edit/{token}', [ProductOptionsController::class, 'edit'])->name('edit');
                Route::post('update/{token}', [ProductOptionsController::class, 'update'])->name('update');
                Route::delete('delete/{token}', [ProductOptionsController::class, 'destory'])->name('delete');
            });

            Route::prefix('options-values')->name('options-values-')->group(function () {
                Route::get('list', [ProductValuesController::class, 'index'])->name('list');
                Route::get('create', [ProductValuesController::class, 'create'])->name('create');
                Route::post('store', [ProductValuesController::class, 'store'])->name('store');
                Route::get('edit/{token}', [ProductValuesController::class, 'edit'])->name('edit');
                Route::post('update/{token}', [ProductValuesController::class, 'update'])->name('update');
                Route::delete('delete/{token}', [ProductValuesController::class, 'destory'])->name('delete');
            });

            Route::name('categories-')->group(function () {
                Route::prefix('category')->name('category-')->group(function () {
                    Route::get('list', [CategoryController::class, 'index'])->name('list');
                    Route::get('create', [CategoryController::class, 'create'])->name('create');
                    Route::post('store', [CategoryController::class, 'store'])->name('store');
                    Route::get('edit/{token}', [CategoryController::class, 'edit'])->name('edit');
                    Route::post('update/{token}', [CategoryController::class, 'update'])->name('update');
                    Route::delete('delete/{token}', [CategoryController::class, 'destory'])->name('delete');
                });

                Route::prefix('sub-category')->name('sub-category-')->group(function () {
                    Route::get('list', [SubCategoryController::class, 'index'])->name('list');
                    Route::get('create', [SubCategoryController::class, 'create'])->name('create');
                    Route::post('store', [SubCategoryController::class, 'store'])->name('store');
                    Route::get('edit/{token}', [SubCategoryController::class, 'edit'])->name('edit');
                    Route::post('update/{token}', [SubCategoryController::class, 'update'])->name('update');
                    Route::delete('delete/{token}', [SubCategoryController::class, 'destory'])->name('delete');
                });

                Route::prefix('child-category')->name('child-category-')->group(function () {
                    Route::get('list', [ChildCategoryController::class, 'index'])->name('list');
                    Route::get('create', [ChildCategoryController::class, 'create'])->name('create');
                    Route::post('store', [ChildCategoryController::class, 'store'])->name('store');
                    Route::get('edit/{token}', [ChildCategoryController::class, 'edit'])->name('edit');
                    Route::post('update/{token}', [ChildCategoryController::class, 'update'])->name('update');
                    Route::delete('delete/{token}', [ChildCategoryController::class, 'destory'])->name('delete');
                    Route::get('child-sub-category-list', [ChildCategoryController::class, 'childSubCategories'])->name('child-sub-category-list');
                });
            });
        });
    });
});
