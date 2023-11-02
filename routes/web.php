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

         /** Department routes **/
         Route::resource('departments', App\Http\Controllers\Admin\DepartmentsController::class);
         Route::get('departments/update-status/{id}/{status}', [App\Http\Controllers\Admin\DepartmentsController::class, 'changeStatus'])->name('departments.status');
         Route::get('departments/destroy/{endepid?}', [App\Http\Controllers\Admin\DepartmentsController::class, 'destroy'])->name('departments.delete');
         // /* Department routes */

         /**  Designations routes **/
         Route::match(['get', 'post'], '/designations/{endesid?}', [App\Http\Controllers\Admin\DesignationsController::class, 'index'])->name('designations.index');
         Route::match(['get', 'post'], 'designations/add/{endesid?}', [App\Http\Controllers\Admin\DesignationsController::class, 'add'])->name('designations.add');
         Route::match(['get', 'post'], 'designations/edit/{endesid?}', [App\Http\Controllers\Admin\DesignationsController::class, 'update'])->name('designations.edit');
         Route::get('designations/update-status/{id}/{status}', [App\Http\Controllers\Admin\DesignationsController::class, 'changeStatus'])->name('designations.status');
         Route::get('designations/delete/{endesid?}', [App\Http\Controllers\Admin\DesignationsController::class, 'delete'])->name('designations.delete');
         /* Designations routes */

         /* staff routes */
         Route::resource('staff', App\Http\Controllers\Admin\StaffController::class);
         Route::get('staff/update-status/{id}/{status}', [App\Http\Controllers\Admin\StaffController::class, 'changeStatus'])->name('staff.status');
         Route::get('staff/destroy/{enstfid?}', [App\Http\Controllers\Admin\StaffController::class, 'destroy'])->name('staff.delete');
         Route::match(['get', 'post'], 'staff/changed-password/{enstfid?}', [App\Http\Controllers\Admin\StaffController::class, 'changedPassword'])->name('staff.changerpassword');
         Route::match(['get', 'post'], 'staff/get-designations', [App\Http\Controllers\Admin\StaffController::class, 'getDesignations'])->name('staff.getDesignations');
         Route::match(['get', 'post'], 'staff/get-staff-permission', [App\Http\Controllers\Admin\StaffController::class, 'getStaffPermission'])->name('staff.getStaffPermission');


          /** Access Control Routes Starts **/
         Route::resource('acl', App\Http\Controllers\Admin\AclController::class);
         Route::get('acl/destroy/{enaclid?}', [App\Http\Controllers\Admin\AclController::class, 'destroy'])->name('acl.delete');
         Route::get('acl/update-status/{id}/{status}', [App\Http\Controllers\Admin\AclController::class, 'changeStatus'])->name('acl.status');
         Route::post('acl/add-more/add-more', [App\Http\Controllers\Admin\AclController::class, 'addMoreRow'])->name('acl.addMoreRow');
         Route::get('acl/delete-function/{id}', [App\Http\Controllers\Admin\AclController::class, 'delete_function'])->name('acl.delete_function');
         /** Access Control Routes Ends **/


          /* users routes */
          Route::match(['get', 'post'], '/users', [App\Http\Controllers\Admin\UsersController::class, 'index'])->name('admin_users.index');
          Route::match(['get', 'post'], '/users/create', [App\Http\Controllers\Admin\UsersController::class, 'create'])->name('admin_users.create');
          Route::match(['get', 'post'], '/users/save', [App\Http\Controllers\Admin\UsersController::class, 'save'])->name('admin_users.save');
          Route::match(['get', 'post'], '/users/edit/{enuserid}', [App\Http\Controllers\Admin\UsersController::class, 'edit'])->name('admin_users.edit');
          Route::match(['get', 'post'], '/users/update/{enuserid}', [App\Http\Controllers\Admin\UsersController::class, 'update'])->name('admin_users.update');
          Route::get('users/show/{enuserid}', [App\Http\Controllers\Admin\UsersController::class, 'show'])->name('admin_users.show');
          Route::get('users/destroy/{enuserid?}', [App\Http\Controllers\Admin\UsersController::class, 'destroy'])->name('admin_users.delete');
          Route::get('users/update-status/{id}/{status}', [App\Http\Controllers\Admin\UsersController::class, 'changeStatus'])->name('admin_users.status');
          Route::match(['get', 'post'], 'users/changed-password/{enuserid?}', [App\Http\Controllers\Admin\UsersController::class, 'changedPassword'])->name('admin_users.changedPassword');
          
          /* users routes */

          /** FooterCategory routes **/
         Route::resource('footer-category', App\Http\Controllers\Admin\FooterCategoryController::class);
         Route::get('footer-category/update-status/{id}/{status}', [App\Http\Controllers\Admin\FooterCategoryController::class, 'changeStatus'])->name('footer-category.status');
         Route::get('footer-category/destroy/{endepid?}', [App\Http\Controllers\Admin\FooterCategoryController::class, 'destroy'])->name('footer-category.delete');
         // /* FooterCategory routes */

         /**  footer-subcategory routes **/
         Route::match(['get', 'post'], '/footer-subcategory/{endesid?}', [App\Http\Controllers\Admin\FooterSubCategoryController::class, 'index'])->name('footer-subcategory.index');
         Route::match(['get', 'post'], 'footer-subcategory/add/{endesid?}', [App\Http\Controllers\Admin\FooterSubCategoryController::class, 'add'])->name('footer-subcategory.add');
         Route::match(['get', 'post'], 'footer-subcategory/edit/{endesid?}', [App\Http\Controllers\Admin\FooterSubCategoryController::class, 'update'])->name('footer-subcategory.edit');
         Route::get('footer-subcategory/update-status/{id}/{status}', [App\Http\Controllers\Admin\FooterSubCategoryController::class, 'changeStatus'])->name('footer-subcategory.status');
         Route::get('footer-subcategory/delete/{endesid?}', [App\Http\Controllers\Admin\FooterSubCategoryController::class, 'delete'])->name('footer-subcategory.delete');
         /* footer-subcategory routes */

         /* Lookups manager  module  routing start here */
         Route::match(['get', 'post'], '/lookups-manager/{type}', [App\Http\Controllers\vrihatcpmaster\LookupsController::class, 'index'])->name('lookups-manager.index');
         Route::match(['get', 'post'], '/lookups-manager/add/{type}', [App\Http\Controllers\vrihatcpmaster\LookupsController::class, 'add'])->name('lookups-manager.add');
         Route::get('lookups-manager/destroy/{enlokid?}', [App\Http\Controllers\vrihatcpmaster\LookupsController::class, 'destroy'])->name('lookups-manager.delete');
         Route::get('lookups-manager/update-status/{id}/{status}', [App\Http\Controllers\vrihatcpmaster\LookupsController::class, 'changeStatus'])->name('lookups-manager.status');
         Route::match(['get', 'post'], 'lookups-manager/{type?}/edit/{enlokid?}', [App\Http\Controllers\vrihatcpmaster\LookupsController::class, 'update'])->name('lookups-manager.edit');
         /* Lookups manager  module  routing start here */

         /* Lookups manager  module  routing start here */
         Route::match(['get','post'],'seo-page-manager', [App\Http\Controllers\vrihatcpmaster\SeoPageController::class, 'index'])->name('SeoPage.index');
         // Route::post('seo-page-manager', [App\Http\Controllers\vrihatcpmaster\SeoPageController::class, 'index'])->name('SeoPage.index');
         Route::get('seo-page-manager/add-doc', [App\Http\Controllers\vrihatcpmaster\SeoPageController::class, 'addDoc'])->name('SeoPage.create');
         Route::post('seo-page-manager/add-doc', [App\Http\Controllers\vrihatcpmaster\SeoPageController::class, 'saveDoc'])->name('SeoPage.save');
         Route::get('seo-page-manager/edit-doc/{id}', [App\Http\Controllers\vrihatcpmaster\SeoPageController::class, 'editDoc'])->name('SeoPage.edit');
         Route::post('seo-page-manager/edit-doc/{id}', [App\Http\Controllers\vrihatcpmaster\SeoPageController::class, 'updateDoc'])->name('SeoPage.update');
         Route::any('seo-page-manager/delete-page/{id}', [App\Http\Controllers\vrihatcpmaster\SeoPageController::class, 'deletePage'])->name('SeoPage.delete');

          /** settings routing**/
          Route::resource('settings', App\Http\Controllers\vrihatcpmaster\SettingsController::class);
          Route::match(['get', 'post'], '/settings/prefix/{enslug?}', [App\Http\Controllers\vrihatcpmaster\SettingsController::class, 'prefix'])->name('settings.prefix');
          Route::get('settings/destroy/{ensetid?}', [App\Http\Controllers\vrihatcpmaster\SettingsController::class, 'destroy'])->name('settings.delete');
          /** settings routing**/

          /* cms manager routes */
          Route::resource('cms-manager', App\Http\Controllers\vrihatcpmaster\CmspagesController::class);
          Route::get('cms-manager/destroy/{encmsid?}', [App\Http\Controllers\vrihatcpmaster\CmspagesController::class, 'destroy'])->name('cms-manager.delete');
          //  cms manager routes

          /*Banner Route*/
          Route::get('banner', [App\Http\Controllers\vrihatcpmaster\BannerController::class, 'index'])->name('Banner.index');
          Route::get('slider-add', [App\Http\Controllers\vrihatcpmaster\BannerController::class, 'create'])->name('Banner.create');
          Route::post('slider-save', [App\Http\Controllers\vrihatcpmaster\BannerController::class, 'save'])->name('Banner.save');
          Route::get('slider-status/{id}/{status}', [App\Http\Controllers\vrihatcpmaster\BannerController::class, 'changeStatus'])->name('Banner.status');
          Route::get('banner/{id}', [App\Http\Controllers\vrihatcpmaster\BannerController::class, 'edit'])->name('Banner.edit');
          Route::post('slider-update/{id}', [App\Http\Controllers\vrihatcpmaster\BannerController::class, 'update'])->name('Banner.update');
          Route::get('slider-delete/{id}', [App\Http\Controllers\vrihatcpmaster\BannerController::class, 'destroy'])->name('Banner.delete');
          Route::get('sliders/show/{enuserid}', [App\Http\Controllers\vrihatcpmaster\BannerController::class, 'show'])->name('Banner.show');
          /*Banner Route*/

          /* Testimonial routes */
          Route::match(['get', 'post'], '/testimonials', [App\Http\Controllers\vrihatcpmaster\TestimonialController::class, 'index'])->name('testimonials.index');
          Route::match(['get', 'post'], '/testimonials/create', [App\Http\Controllers\vrihatcpmaster\TestimonialController::class, 'create'])->name('testimonials.create');
          Route::match(['get', 'post'], '/testimonials/save', [App\Http\Controllers\vrihatcpmaster\TestimonialController::class, 'save'])->name('testimonials.save');
          Route::match(['get', 'post'], '/testimonials/edit/{enuserid}', [App\Http\Controllers\vrihatcpmaster\TestimonialController::class, 'edit'])->name('testimonials.edit');
          Route::match(['get', 'post'], '/testimonials/update/{enuserid}', [App\Http\Controllers\vrihatcpmaster\TestimonialController::class, 'update'])->name('testimonials.update');
          Route::get('testimonials/show/{enuserid}', [App\Http\Controllers\vrihatcpmaster\TestimonialController::class, 'show'])->name('testimonials.show');
          Route::get('testimonials/destroy/{enuserid?}', [App\Http\Controllers\vrihatcpmaster\TestimonialController::class, 'destroy'])->name('testimonials.delete');
          Route::get('testimonials/update-status/{id}/{status}', [App\Http\Controllers\vrihatcpmaster\TestimonialController::class, 'changeStatus'])->name('testimonials.status');
          /* Testimonial routes */
    });
});
