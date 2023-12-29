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
            Route::match(['get', 'post'],'list', [ProductController::class, 'index'])->name('list');
            Route::get('create', [ProductController::class, 'create'])->name('create');
            Route::post('store', [ProductController::class, 'store'])->name('store');
            Route::get('view/{token}', [ProductController::class, 'view'])->name('view');
            Route::get('edit/{token}', [ProductController::class, 'edit'])->name('edit');
            Route::post('update/{token}', [ProductController::class, 'update'])->name('update');
            Route::delete('delete/{token}', [ProductController::class, 'destory'])->name('delete');
            Route::get('sub-category-list', [ProductController::class, 'getSubCategories'])->name('sub-category-list');
            Route::get('variant-values-list', [ProductController::class, 'getVariantValues'])->name('variant-values-list');
            Route::get('child-category-list', [ProductController::class, 'getChildCategories'])->name('child-category-list');
            Route::match(['get', 'post'], 'upload-images', [ProductController::class, 'uploadImages'])->name('upload-images');
            Route::get('delete-image', [ProductController::class, 'deleteImage'])->name('delete-image');
            Route::get('update-image-meta-values', [ProductController::class, 'updateImageMetaValues'])->name('update-image-meta-values');
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

            // Route::name('categories-')->group(function () {


            //     // Route::prefix('sub-category')->name('sub-category-')->group(function () {
            //     //     Route::get('list', [SubCategoryController::class, 'index'])->name('list');
            //     //     Route::get('create', [SubCategoryController::class, 'create'])->name('create');
            //     //     Route::post('store', [SubCategoryController::class, 'store'])->name('store');
            //     //     Route::get('edit/{token}', [SubCategoryController::class, 'edit'])->name('edit');
            //     //     Route::post('update/{token}', [SubCategoryController::class, 'update'])->name('update');
            //     //     Route::delete('delete/{token}', [SubCategoryController::class, 'destory'])->name('delete');
            //     // });

            //     Route::prefix('child-category')->name('child-category-')->group(function () {
            //         Route::get('list', [ChildCategoryController::class, 'index'])->name('list');
            //         Route::get('create', [ChildCategoryController::class, 'create'])->name('create');
            //         Route::post('store', [ChildCategoryController::class, 'store'])->name('store');
            //         Route::get('edit/{token}', [ChildCategoryController::class, 'edit'])->name('edit');
            //         Route::post('update/{token}', [ChildCategoryController::class, 'update'])->name('update');
            //         Route::delete('delete/{token}', [ChildCategoryController::class, 'destory'])->name('delete');
            //         Route::get('child-sub-category-list', [ChildCategoryController::class, 'childSubCategories'])->name('child-sub-category-list');
            //     });


            // });
        });

         /** category routes **/
         Route::match(['get', 'post'], '/category', [App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('category.index');
         Route::match(['get', 'post'], '/category/create', [App\Http\Controllers\Admin\CategoryController::class, 'create'])->name('category.create');
         Route::match(['get', 'post'], '/category/save', [App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('category.store');
         Route::match(['get', 'post'], '/category/edit/{enuserid}', [App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('category.edit');
         Route::match(['get', 'post'], '/category/update/{enuserid}', [App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('category.update');
         Route::get('category/show/{enuserid}', [App\Http\Controllers\Admin\CategoryController::class, 'show'])->name('category.show');
        //  Route::resource('category', App\Http\Controllers\Admin\CategoryController::class);
         Route::get('category/update-status/{id}/{status}', [App\Http\Controllers\Admin\CategoryController::class, 'changeStatus'])->name('category.status');
         Route::get('category/destroy/{endepid?}', [App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('category.delete');
         Route::post('category/update-order', [App\Http\Controllers\Admin\CategoryController::class, 'updateCategoryOrder'])->name('category.updateCategoryOrder');
         // /* category routes */

         /**  SubCategory routes **/
         Route::match(['get', 'post'], '/sub-category/{endesid?}', [App\Http\Controllers\Admin\SubCategoryController::class, 'index'])->name('sub-category.index');
         Route::match(['get', 'post'], 'sub-category/add/{endesid?}', [App\Http\Controllers\Admin\SubCategoryController::class, 'add'])->name('sub-category.add');
         Route::match(['get', 'post'], 'sub-category/edit/{endesid?}', [App\Http\Controllers\Admin\SubCategoryController::class, 'update'])->name('sub-category.edit');
         Route::get('sub-category/update-status/{id}/{status}', [App\Http\Controllers\Admin\SubCategoryController::class, 'changeStatus'])->name('sub-category.status');
         Route::get('sub-category/delete/{endesid?}', [App\Http\Controllers\Admin\SubCategoryController::class, 'delete'])->name('sub-category.delete');
         /* SubCategory routes */

         /**  ChildCategory routes **/
         Route::match(['get', 'post'], '/child-category/{endesid?}', [App\Http\Controllers\Admin\ChildCategoryController::class, 'index'])->name('child-category.index');
         Route::match(['get', 'post'], 'child-category/add/{endesid?}', [App\Http\Controllers\Admin\ChildCategoryController::class, 'add'])->name('child-category.add');
         Route::match(['get', 'post'], 'child-category/edit/{endesid?}', [App\Http\Controllers\Admin\ChildCategoryController::class, 'update'])->name('child-category.edit');
         Route::get('child-category/update-status/{id}/{status}', [App\Http\Controllers\Admin\ChildCategoryController::class, 'changeStatus'])->name('child-category.status');
         Route::get('child-category/delete/{endesid?}', [App\Http\Controllers\Admin\ChildCategoryController::class, 'delete'])->name('child-category.delete');
         /* ChildCategory routes */

         /** shipping companies routes **/
         Route::match(['get', 'post'], '/plans', [App\Http\Controllers\Admin\PlansController::class, 'index'])->name('plans.index');
         Route::match(['get', 'post'], '/plans/create', [App\Http\Controllers\Admin\PlansController::class, 'create'])->name('plans.create');
         Route::match(['get', 'post'], '/plans/save', [App\Http\Controllers\Admin\PlansController::class, 'store'])->name('plans.store');
         Route::match(['get', 'post'], '/plans/edit/{enuserid}', [App\Http\Controllers\Admin\PlansController::class, 'edit'])->name('plans.edit');
         Route::match(['get', 'post'], '/plans/update/{enuserid}', [App\Http\Controllers\Admin\PlansController::class, 'update'])->name('plans.update');
         Route::get('plans/show/{enuserid}', [App\Http\Controllers\Admin\PlansController::class, 'show'])->name('plans.show');
         Route::get('plans/update-status/{id}/{status}', [App\Http\Controllers\Admin\PlansController::class, 'changeStatus'])->name('plans.status');
         Route::get('plans/destroy/{endepid?}', [App\Http\Controllers\Admin\PlansController::class, 'destroy'])->name('plans.delete');
        /* shipping companies routes */

         /** shipping companies routes **/
         Route::match(['get', 'post'], '/shipping-companies', [App\Http\Controllers\Admin\ShippingCompanyController::class, 'index'])->name('shipping-companies.index');
         Route::match(['get', 'post'], '/shipping-companies/create', [App\Http\Controllers\Admin\ShippingCompanyController::class, 'create'])->name('shipping-companies.create');
         Route::match(['get', 'post'], '/shipping-companies/save', [App\Http\Controllers\Admin\ShippingCompanyController::class, 'store'])->name('shipping-companies.store');
         Route::match(['get', 'post'], '/shipping-companies/edit/{enuserid}', [App\Http\Controllers\Admin\ShippingCompanyController::class, 'edit'])->name('shipping-companies.edit');
         Route::match(['get', 'post'], '/shipping-companies/update/{enuserid}', [App\Http\Controllers\Admin\ShippingCompanyController::class, 'update'])->name('shipping-companies.update');
         Route::get('shipping-companies/show/{enuserid}', [App\Http\Controllers\Admin\ShippingCompanyController::class, 'show'])->name('shipping-companies.show');
         Route::get('shipping-companies/update-status/{id}/{status}', [App\Http\Controllers\Admin\ShippingCompanyController::class, 'changeStatus'])->name('shipping-companies.status');
         Route::get('shipping-companies/destroy/{endepid?}', [App\Http\Controllers\Admin\ShippingCompanyController::class, 'destroy'])->name('shipping-companies.delete');
        /* shipping companies routes */

         /**  SubCategory routes **/
         Route::match(['get', 'post'], '/shipping-areas/{endesid?}', [App\Http\Controllers\Admin\ShippingAreasController::class, 'index'])->name('shipping-areas.index');
         Route::match(['get', 'post'], 'shipping-areas/add/{endesid?}', [App\Http\Controllers\Admin\ShippingAreasController::class, 'add'])->name('shipping-areas.add');
         Route::match(['get', 'post'], 'shipping-areas/edit/{endesid?}', [App\Http\Controllers\Admin\ShippingAreasController::class, 'update'])->name('shipping-areas.edit');
         Route::get('shipping-areas/update-status/{id}/{status}', [App\Http\Controllers\Admin\ShippingAreasController::class, 'changeStatus'])->name('shipping-areas.status');
         Route::get('shipping-areas/delete/{endesid?}', [App\Http\Controllers\Admin\ShippingAreasController::class, 'delete'])->name('shipping-areas.delete');
         /* SubCategory routes */

        /** brand routes **/
        Route::match(['get', 'post'], '/brand', [App\Http\Controllers\Admin\BrandController::class, 'index'])->name('brand.index');
        Route::match(['get', 'post'], '/brand/create', [App\Http\Controllers\Admin\BrandController::class, 'create'])->name('brand.create');
        Route::match(['get', 'post'], '/brand/save', [App\Http\Controllers\Admin\BrandController::class, 'store'])->name('brand.store');
        Route::match(['get', 'post'], '/brand/edit/{enuserid}', [App\Http\Controllers\Admin\BrandController::class, 'edit'])->name('brand.edit');
        Route::match(['get', 'post'], '/brand/update/{enuserid}', [App\Http\Controllers\Admin\BrandController::class, 'update'])->name('brand.update');
        Route::get('brand/show/{enuserid}', [App\Http\Controllers\Admin\BrandController::class, 'show'])->name('brand.show');
        //  Route::resource('brand', App\Http\Controllers\Admin\BrandController::class);
         Route::get('brand/update-status/{id}/{status}', [App\Http\Controllers\Admin\BrandController::class, 'changeStatus'])->name('brand.status');
         Route::get('brand/destroy/{id?}', [App\Http\Controllers\Admin\BrandController::class, 'destroy'])->name('brand.delete');
         // /* brand routes */

         /** Department routes **/
        //  Route::resource('departments', App\Http\Controllers\Admin\DepartmentsController::class);
        Route::match(['get', 'post'], '/departments', [App\Http\Controllers\Admin\DepartmentsController::class, 'index'])->name('departments.index');
        Route::match(['get', 'post'], '/departments/create', [App\Http\Controllers\Admin\DepartmentsController::class, 'create'])->name('departments.create');
        Route::match(['get', 'post'], '/departments/save', [App\Http\Controllers\Admin\DepartmentsController::class, 'store'])->name('departments.store');
        Route::match(['get', 'post'], '/departments/edit/{enuserid}', [App\Http\Controllers\Admin\DepartmentsController::class, 'edit'])->name('departments.edit');
        Route::match(['get', 'post'], '/departments/update/{enuserid}', [App\Http\Controllers\Admin\DepartmentsController::class, 'update'])->name('departments.update');
        Route::get('departments/show/{enuserid}', [App\Http\Controllers\Admin\DepartmentsController::class, 'show'])->name('departments.show');
        Route::get('departments/update-status/{id}/{status}', [App\Http\Controllers\Admin\DepartmentsController::class, 'changeStatus'])->name('departments.status');
        Route::get('departments/destroy/{endepid?}', [App\Http\Controllers\Admin\DepartmentsController::class, 'destroy'])->name('departments.delete');
         // /* Department routes */

         /** taxes routes **/
          Route::match(['get', 'post'], '/taxes', [App\Http\Controllers\Admin\TaxesController::class, 'index'])->name('taxes.index');
          Route::match(['get', 'post'], '/taxes/create', [App\Http\Controllers\Admin\TaxesController::class, 'create'])->name('taxes.create');
          Route::match(['get', 'post'], '/taxes/save', [App\Http\Controllers\Admin\TaxesController::class, 'store'])->name('taxes.store');
          Route::match(['get', 'post'], '/taxes/edit/{enuserid}', [App\Http\Controllers\Admin\TaxesController::class, 'edit'])->name('taxes.edit');
          Route::match(['get', 'post'], '/taxes/update/{enuserid}', [App\Http\Controllers\Admin\TaxesController::class, 'update'])->name('taxes.update');
          Route::get('taxes/show/{enuserid}', [App\Http\Controllers\Admin\TaxesController::class, 'show'])->name('taxes.show');
          Route::get('taxes/update-status/{id}/{status}', [App\Http\Controllers\Admin\TaxesController::class, 'changeStatus'])->name('taxes.status');
          Route::get('taxes/destroy/{endepid?}', [App\Http\Controllers\Admin\TaxesController::class, 'destroy'])->name('taxes.delete');

         // /* taxes routes */

         /** cities routes **/
         Route::match(['get', 'post'], '/cities', [App\Http\Controllers\Admin\CityController::class, 'index'])->name('cities.index');
         Route::match(['get', 'post'], '/cities/create', [App\Http\Controllers\Admin\CityController::class, 'create'])->name('cities.create');
         Route::match(['get', 'post'], '/cities/save', [App\Http\Controllers\Admin\CityController::class, 'store'])->name('cities.store');
         Route::match(['get', 'post'], '/cities/edit/{enuserid}', [App\Http\Controllers\Admin\CityController::class, 'edit'])->name('cities.edit');
         Route::match(['get', 'post'], '/cities/update/{enuserid}', [App\Http\Controllers\Admin\CityController::class, 'update'])->name('cities.update');
         Route::get('cities/show/{enuserid}', [App\Http\Controllers\Admin\CityController::class, 'show'])->name('cities.show');
         Route::get('cities/update-status/{id}/{status}', [App\Http\Controllers\Admin\CityController::class, 'changeStatus'])->name('cities.status');
         Route::get('cities/destroy/{endepid?}', [App\Http\Controllers\Admin\CityController::class, 'destroy'])->name('cities.delete');

        // /* taxes routes */

         /**  Designations routes **/
         Route::match(['get', 'post'], '/designations/{endesid?}', [App\Http\Controllers\Admin\DesignationsController::class, 'index'])->name('designations.index');
         Route::match(['get', 'post'], 'designations/add/{endesid?}', [App\Http\Controllers\Admin\DesignationsController::class, 'add'])->name('designations.add');
         Route::match(['get', 'post'], 'designations/edit/{endesid?}', [App\Http\Controllers\Admin\DesignationsController::class, 'update'])->name('designations.edit');
         Route::get('designations/update-status/{id}/{status}', [App\Http\Controllers\Admin\DesignationsController::class, 'changeStatus'])->name('designations.status');
         Route::get('designations/delete/{endesid?}', [App\Http\Controllers\Admin\DesignationsController::class, 'delete'])->name('designations.delete');
         /* Designations routes */

         /* staff routes */
        //  Route::resource('staff', App\Http\Controllers\Admin\StaffController::class);
        Route::match(['get', 'post'], '/staff', [App\Http\Controllers\Admin\StaffController::class, 'index'])->name('staff.index');
        Route::match(['get', 'post'], '/staff/create', [App\Http\Controllers\Admin\StaffController::class, 'create'])->name('staff.create');
        Route::match(['get', 'post'], '/staff/save', [App\Http\Controllers\Admin\StaffController::class, 'store'])->name('staff.store');
        Route::match(['get', 'post'], '/staff/edit/{enuserid}', [App\Http\Controllers\Admin\StaffController::class, 'edit'])->name('staff.edit');
        Route::match(['get', 'post'], '/staff/update/{enuserid}', [App\Http\Controllers\Admin\StaffController::class, 'update'])->name('staff.update');
        Route::get('staff/show/{enuserid}', [App\Http\Controllers\Admin\StaffController::class, 'show'])->name('staff.show');
         Route::get('staff/update-status/{id}/{status}', [App\Http\Controllers\Admin\StaffController::class, 'changeStatus'])->name('staff.status');
         Route::get('staff/destroy/{enstfid?}', [App\Http\Controllers\Admin\StaffController::class, 'destroy'])->name('staff.delete');
         Route::match(['get', 'post'], 'staff/changed-password/{enstfid?}', [App\Http\Controllers\Admin\StaffController::class, 'changedPassword'])->name('staff.changerpassword');
         Route::match(['get', 'post'], 'staff/get-designations', [App\Http\Controllers\Admin\StaffController::class, 'getDesignations'])->name('staff.getDesignations');
         Route::match(['get', 'post'], 'staff/get-staff-permission', [App\Http\Controllers\Admin\StaffController::class, 'getStaffPermission'])->name('staff.getStaffPermission');


          /** Access Control Routes Starts **/
        //  Route::resource('acl', App\Http\Controllers\Admin\AclController::class);
         Route::match(['get', 'post'], '/acl', [App\Http\Controllers\Admin\AclController::class, 'index'])->name('acl.index');
         Route::match(['get', 'post'], '/acl/create', [App\Http\Controllers\Admin\AclController::class, 'create'])->name('acl.create');
         Route::match(['get', 'post'], '/acl/save', [App\Http\Controllers\Admin\AclController::class, 'store'])->name('acl.store');
         Route::match(['get', 'post'], '/acl/edit/{enuserid}', [App\Http\Controllers\Admin\AclController::class, 'edit'])->name('acl.edit');
         Route::match(['get', 'post'], '/acl/update/{enuserid}', [App\Http\Controllers\Admin\AclController::class, 'update'])->name('acl.update');
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
         Route::match(['get', 'post'], '/lookups-manager/{type}', [App\Http\Controllers\Admin\LookupsController::class, 'index'])->name('lookups-manager.index');
         Route::match(['get', 'post'], '/lookups-manager/add/{type}', [App\Http\Controllers\Admin\LookupsController::class, 'add'])->name('lookups-manager.add');
         Route::get('lookups-manager/destroy/{enlokid?}', [App\Http\Controllers\Admin\LookupsController::class, 'destroy'])->name('lookups-manager.delete');
         Route::get('lookups-manager/update-status/{id}/{status}', [App\Http\Controllers\Admin\LookupsController::class, 'changeStatus'])->name('lookups-manager.status');
         Route::match(['get', 'post'], 'lookups-manager/{type?}/edit/{enlokid?}', [App\Http\Controllers\Admin\LookupsController::class, 'update'])->name('lookups-manager.edit');
         /* Lookups manager  module  routing start here */

         /* Lookups manager  module  routing start here */
         Route::match(['get','post'],'seo-page-manager', [App\Http\Controllers\Admin\SeoPageController::class, 'index'])->name('SeoPage.index');
         // Route::post('seo-page-manager', [App\Http\Controllers\Admin\SeoPageController::class, 'index'])->name('SeoPage.index');
         Route::get('seo-page-manager/add-doc', [App\Http\Controllers\Admin\SeoPageController::class, 'addDoc'])->name('SeoPage.create');
         Route::post('seo-page-manager/add-doc', [App\Http\Controllers\Admin\SeoPageController::class, 'saveDoc'])->name('SeoPage.save');
         Route::get('seo-page-manager/edit-doc/{id}', [App\Http\Controllers\Admin\SeoPageController::class, 'editDoc'])->name('SeoPage.edit');
         Route::post('seo-page-manager/edit-doc/{id}', [App\Http\Controllers\Admin\SeoPageController::class, 'updateDoc'])->name('SeoPage.update');
         Route::any('seo-page-manager/delete-page/{id}', [App\Http\Controllers\Admin\SeoPageController::class, 'deletePage'])->name('SeoPage.delete');

          /** settings routing**/
        //   Route::resource('settings', App\Http\Controllers\Admin\SettingsController::class);
          Route::match(['get', 'post'], '/settings', [App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings.index');
          Route::match(['get', 'post'], '/settings/create', [App\Http\Controllers\Admin\SettingsController::class, 'create'])->name('settings.create');
          Route::match(['get', 'post'], '/settings/save', [App\Http\Controllers\Admin\SettingsController::class, 'store'])->name('settings.store');
          Route::match(['get', 'post'], '/settings/edit/{enuserid}', [App\Http\Controllers\Admin\SettingsController::class, 'edit'])->name('settings.edit');
          Route::match(['get', 'post'], '/settings/update/{enuserid}', [App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('settings.update');
          Route::get('settings/show/{enuserid}', [App\Http\Controllers\Admin\SettingsController::class, 'show'])->name('cms-manager.show');
          Route::match(['get', 'post'], '/settings/prefix/{enslug?}', [App\Http\Controllers\Admin\SettingsController::class, 'prefix'])->name('settings.prefix');
          Route::get('settings/destroy/{ensetid?}', [App\Http\Controllers\Admin\SettingsController::class, 'destroy'])->name('settings.delete');
          /** settings routing**/

          /* cms manager routes */
        //   Route::resource('cms-manager', App\Http\Controllers\Admin\CmspagesController::class);
          Route::match(['get', 'post'], '/cms-manager', [App\Http\Controllers\Admin\CmspagesController::class, 'index'])->name('cms-manager.index');
          Route::match(['get', 'post'], '/cms-manager/create', [App\Http\Controllers\Admin\CmspagesController::class, 'create'])->name('cms-manager.create');
          Route::match(['get', 'post'], '/cms-manager/save', [App\Http\Controllers\Admin\CmspagesController::class, 'store'])->name('cms-manager.store');
          Route::match(['get', 'post'], '/cms-manager/edit/{enuserid}', [App\Http\Controllers\Admin\CmspagesController::class, 'edit'])->name('cms-manager.edit');
          Route::match(['get', 'post'], '/cms-manager/update/{enuserid}', [App\Http\Controllers\Admin\CmspagesController::class, 'update'])->name('cms-manager.update');
          Route::get('cms-manager/show/{enuserid}', [App\Http\Controllers\Admin\CmspagesController::class, 'show'])->name('cms-manager.show');
          Route::get('cms-manager/destroy/{encmsid?}', [App\Http\Controllers\Admin\CmspagesController::class, 'destroy'])->name('cms-manager.delete');
          //  cms manager routes

          /*Banner Route*/
          Route::get('banner', [App\Http\Controllers\Admin\BannerController::class, 'index'])->name('Banner.index');
          Route::get('slider-add', [App\Http\Controllers\Admin\BannerController::class, 'create'])->name('Banner.create');
          Route::post('slider-save', [App\Http\Controllers\Admin\BannerController::class, 'save'])->name('Banner.save');
          Route::get('slider-status/{id}/{status}', [App\Http\Controllers\Admin\BannerController::class, 'changeStatus'])->name('Banner.status');
          Route::get('banner/{id}', [App\Http\Controllers\Admin\BannerController::class, 'edit'])->name('Banner.edit');
          Route::post('slider-update/{id}', [App\Http\Controllers\Admin\BannerController::class, 'update'])->name('Banner.update');
          Route::get('slider-delete/{id}', [App\Http\Controllers\Admin\BannerController::class, 'destroy'])->name('Banner.delete');
          Route::get('sliders/show/{enuserid}', [App\Http\Controllers\Admin\BannerController::class, 'show'])->name('Banner.show');
          /*Banner Route*/

          /* Testimonial routes */
          Route::match(['get', 'post'], '/testimonials', [App\Http\Controllers\Admin\TestimonialController::class, 'index'])->name('testimonials.index');
          Route::match(['get', 'post'], '/testimonials/create', [App\Http\Controllers\Admin\TestimonialController::class, 'create'])->name('testimonials.create');
          Route::match(['get', 'post'], '/testimonials/save', [App\Http\Controllers\Admin\TestimonialController::class, 'save'])->name('testimonials.save');
          Route::match(['get', 'post'], '/testimonials/edit/{enuserid}', [App\Http\Controllers\Admin\TestimonialController::class, 'edit'])->name('testimonials.edit');
          Route::match(['get', 'post'], '/testimonials/update/{enuserid}', [App\Http\Controllers\Admin\TestimonialController::class, 'update'])->name('testimonials.update');
          Route::get('testimonials/show/{enuserid}', [App\Http\Controllers\Admin\TestimonialController::class, 'show'])->name('testimonials.show');
          Route::get('testimonials/destroy/{enuserid?}', [App\Http\Controllers\Admin\TestimonialController::class, 'destroy'])->name('testimonials.delete');
          Route::get('testimonials/update-status/{id}/{status}', [App\Http\Controllers\Admin\TestimonialController::class, 'changeStatus'])->name('testimonials.status');
          /* Testimonial routes */

        /** Variant routes **/
        Route::match(['get', 'post'],'/variants', [App\Http\Controllers\Admin\VariantController::class, 'index'])->name('variants.index');
        Route::post('/variants/add', [App\Http\Controllers\Admin\VariantController::class, 'store'])->name('variants.store');
        Route::resource('variants', App\Http\Controllers\Admin\VariantController::class)->except(['index', 'store']);
         Route::get('variants/update-status/{id}/{status}', [App\Http\Controllers\Admin\VariantController::class, 'changeStatus'])->name('variants.status');
         Route::get('variants/destroy/{endepid?}', [App\Http\Controllers\Admin\VariantController::class, 'destroy'])->name('variants.delete');
         Route::get('allspecification/del', [App\Http\Controllers\Admin\VariantController::class, 'DelAllspecifications'])->name('variants.DelAllspecifications');
         /* Variant routes */

         /** Specification Group routes **/
         Route::match(['get', 'post'],'/specification-groups', [App\Http\Controllers\Admin\SpecificationGroupController::class, 'index'])->name('specification_groups.index');
         Route::post('/specification-groups/add', [App\Http\Controllers\Admin\SpecificationGroupController::class, 'store'])->name('specification_groups.store');
         Route::resource('specification-groups', App\Http\Controllers\Admin\SpecificationGroupController::class)->except(['index', 'store']);
         Route::get('specification-groups/update-status/{id}/{status}', [App\Http\Controllers\Admin\SpecificationGroupController::class, 'changeStatus'])->name('specification_groups.status');
         Route::get('specification-groups/destroy/{endepid?}', [App\Http\Controllers\Admin\SpecificationGroupController::class, 'destroy'])->name('specification_groups.delete');
         Route::get('allspecificationGroups/remove', [App\Http\Controllers\Admin\SpecificationGroupController::class, 'removeSpeGroups'])->name('specification_groups.removeSpeGroups');
         /* Specification Group routes */

         /**  Specification routes **/
         Route::match(['get', 'post'], '/specifications/{endesid?}', [App\Http\Controllers\Admin\SpecificationController::class, 'index'])->name('specifications.index');
         Route::match(['get', 'post'], 'specifications/add/{endesid?}', [App\Http\Controllers\Admin\SpecificationController::class, 'add'])->name('specifications.add');
         Route::match(['get', 'post'], 'specifications/edit/{endesid?}', [App\Http\Controllers\Admin\SpecificationController::class, 'update'])->name('specifications.edit');
         Route::get('specifications/update-status/{id}/{status}', [App\Http\Controllers\Admin\SpecificationController::class, 'changeStatus'])->name('specifications.status');
         Route::get('specifications/delete/{endesid?}', [App\Http\Controllers\Admin\SpecificationController::class, 'delete'])->name('specifications.delete');
         /* Specification routes */

    });
});
