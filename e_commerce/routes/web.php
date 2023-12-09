<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('home.layouts.template');
});

Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home');
});

Route::controller(ClientController::class)->group(function () {
    Route::get('/category/{id}/{slug}', 'categoryPage')->name('category');
    Route::get('/product-details/{id}/{slug}', 'singleProduct')->name('single-product');
});

Route::middleware(['auth', 'role:user|admin'])->group(function () {
    Route::controller(ClientController::class)->group(function () {
        Route::get('/add-to-cart', 'addToCart')->name('add-to-cart');
        Route::post('/add-product-to-cart', 'addProductToCart')->name('add-product-to-cart');
        Route::get('/check-out', 'checkOut')->name('checkout');
        Route::get('/shipping-address', 'getShippingAddress')->name('shipping-address');
        Route::post('/add-shipping-address', 'addShippingAddress')->name('add-shipping-address');
        Route::post('/place-order', 'placeOrder')->name('place-order');
        Route::get('/user-profile/pending-orders', 'pendingOrders')->name('user-pending-orders');
        Route::get('/remove-cart-item/{id}', 'removeCartItem')->name('remove-cart-item');
    });
});

Route::get('/admin/dashboard', function () {
    return view('admin.pending-orders');
})->middleware(['auth', 'verified', 'role:admin'])->name('dashboard');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::controller(OrderController::class)->group(function () {
        Route::get('/admin/dashboard', 'index')->name('admin-dashboard');
    });

    Route::controller(CategoryController::class)->group(function () {
        Route::get('/admin/all-categories', 'index')->name('all-categories');
        Route::get('/admin/add-category', 'addCategory')->name('add-category');
        Route::post('/admin/store-category', 'storeCategory')->name('store-category');
        Route::get('/admin/edit-category/{id}', 'editCategory')->name('edit-category');
        Route::post('/admin/update-category', 'updateCategory')->name('update-category');
        Route::get('/admin/delete-category/{id}', 'deleteCategory')->name('delete-category');
    });

    Route::controller(SubCategoryController::class)->group(function () {
        Route::get('/admin/all-subcategories', 'index')->name('all-subcategories');
        Route::get('/admin/add-subcategory', 'addSubCategory')->name('add-subcategory');
        Route::post('/admin/store-subcategory', 'storeSubCategory')->name('store-subcategory');
        Route::get('/admin/edit-subcategory/{id}', 'editSubCategory')->name('edit-subcategory');
        Route::post('/admin/update-subcategory', 'updateSubCategory')->name('update-subcategory');
        Route::get('/admin/delete-subcategory/{id}', 'deleteSubCategory')->name('delete-subcategory');
    });

    Route::controller(ProductController::class)->group(function () {
        Route::get('/admin/all-products', 'index')->name('all-products');
        Route::get('/admin/add-product', 'addProduct')->name('add-product');
        Route::post('/admin/store-product', 'storeProduct')->name('store-product');
        Route::get('/admin/edit-product-image/{id}', 'editProductImage')->name('edit-product-image');
        Route::post('/admin/update-product-image', 'updateProductImage')->name('update-product-image');
        Route::get('/admin/edit-product/{id}', 'editProduct')->name('edit-product');
        Route::post('/admin/update-product', 'updateProduct')->name('update-product');
        Route::get('/admin/delete-product/{id}', 'deleteProduct')->name('delete-product');
    });

    Route::controller(OrderController::class)->group(function () {
        Route::get('/admin/pending-orders', 'index')->name('pending-orders');
    });

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

require __DIR__ . '/auth.php';
