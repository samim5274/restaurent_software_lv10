<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Food\FoodController;
use App\Http\Controllers\Food\CartController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Kitchen\KitchenController;
use App\Http\Controllers\Stock\StockController;
use App\Http\Controllers\Expenses\ExpensesController;

Auth::routes();

Route::get('/clear-all', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Artisan::call('optimize:clear');

    return response()->json(['message' => 'All Laravel caches cleared successfully']);
});

Route::get('/login', [AdminController::class, 'login'])->name('login');
Route::get('/logout', [AdminController::class, 'logout'])->name('logout');
Route::post('/user-login', [AdminController::class, 'userLogin']);
Route::post('/new-user', [AdminController::class, 'createUser']);

Route::group(['middleware' => ['admin']], function (){

    Route::get('/users', [AdminController::class, 'users'])->name('all-user');
    Route::get('/live-search-employee', [AdminController::class, 'SearchEmp']);
    Route::get('/update-employee-status/{id}', [AdminController::class, 'updateStatus']);
    Route::get('/profile', [AdminController::class, 'profile'])->name('user-profile-view');
    Route::post('/edit-profile/{id}', [AdminController::class, 'editProfile']);

    Route::get('/', [HomeController::class, 'index'])->name('dashboard');
    // ========================= Food Controller =========================
    Route::get('/foods', [FoodController::class, 'index'])->name('foods');
    Route::get('/live-search-food-menu', [FoodController::class, 'liveSearch']);
    Route::get('/specific-food-view/{id}', [FoodController::class, 'editFood']);
    Route::get('/create-food', [FoodController::class, 'create'])->name('create-foods');
    Route::post('/create-new-food', [FoodController::class, 'createFood']);
    Route::post('/update-food/{id}', [FoodController::class, 'update'])->name('food.update');

    Route::get('/add-to-cart/{id}', [CartController::class, 'addCart']);
    Route::post('/add-to-cart-2', [CartController::class, 'addCart2']);
    Route::get('/cart', [CartController::class, 'cartView'])->name('cart-view');
    Route::post('/cart/update-quantity', [CartController::class, 'updateQuantity']);
    Route::get('/edit/cart/{reg}', [CartController::class, 'editInvoice'])->name('edit-invoice-products');
    Route::post('/edit/cart/update', [CartController::class, 'UpdateInvoice']);
    Route::post('/modify/order', [CartController::class, 'modifyOrder']);
    Route::get('/remove-to-cart/{foodId}/{invoice}', [CartController::class, 'removeToCart']);

    Route::post('/confirm-order', [OrderController::class, 'confirmOrder'])->name('confirm-order');
    Route::get('/order-invoice-print/{reg}', [OrderController::class, 'printInvoice']);
    Route::get('/print-total-daily-order', [OrderController::class, 'printOrder'])->name('print-total-daily-order');
    Route::get('/print-due-list', [OrderController::class, 'printDuelist'])->name('print-total-daily-due-list');
    Route::get('/order-details', [OrderController::class, 'orderDetails'])->name('order-details-list');
    Route::post('/due-collection/{reg}', [OrderController::class, 'dueCollection']);
    Route::get('/due-details', [OrderController::class, 'dueDetails'])->name('due-list-view');

    Route::get('/kitchen', [KitchenController::class, 'index'])->name('kitchen-view');
    Route::get('/order-item/{reg}', [KitchenController::class, 'orderItem'])->name('view-order-item');
    Route::post('/update-kitchen-status/{reg}', [KitchenController::class, 'updateStatus'])->name('update-kitchen-status');

    Route::get('/stock', [StockController::class, 'index'])->name('food-stock-view');
    Route::get('/live-search-food-stock', [StockController::class, 'liveSearch']);
    Route::post('/insert/stock', [StockController::class, 'insert']);

    Route::get('/expenses', [ExpensesController::class, 'index'])->name('daily-expenses');
    Route::get('/get-subcategories/{categoryId}', [ExpensesController::class, 'getSubcategories']);
    Route::post('/create-expenses', [ExpensesController::class, 'create']);
    Route::get('/expenses-setting', [ExpensesController::class, 'setting'])->name('expenses-setting-view');
    Route::post('/create-expenses-category', [ExpensesController::class, 'createCategory']);
    Route::post('/create-sub-category-expenses', [ExpensesController::class, 'createSubCategory']);
    Route::get('/print-expenses-invoice/{id}', [ExpensesController::class, 'printExInv']);
});