<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//UNIT
Route::prefix('unit')->group(function () {
    Route::get('', ['App\Http\Controllers\UnitController', 'index']);
    Route::get('jsonIndex/{filterText?}', ['App\Http\Controllers\UnitController', 'jsonIndex']);
    Route::get('jsonCreate', ['App\Http\Controllers\UnitController', 'jsonCreate']);
    Route::post('store', ['App\Http\Controllers\UnitController', 'store']);
    Route::get('jsonDetail/{idUnit}', ['App\Http\Controllers\UnitController', 'jsonDetail']);
});

//CUSTOMER
Route::prefix('customer')->group(function () {
    Route::get('', ['App\Http\Controllers\CustomerController', 'index']);
    Route::get('jsonIndex/{filterText?}', ['App\Http\Controllers\CustomerController', 'jsonIndex']);
    Route::get('jsonCreate', ['App\Http\Controllers\CustomerController', 'jsonCreate']);
    Route::post('store', ['App\Http\Controllers\CustomerController', 'store']);
    Route::get('jsonDetail/{idCustomer}', ['App\Http\Controllers\CustomerController', 'jsonDetail']);
});

//EXPENSE
Route::prefix('expense')->group(function () {
    Route::get('', ['App\Http\Controllers\ExpenseController', 'index']);
    Route::get('jsonIndex/{filterText?}', ['App\Http\Controllers\ExpenseController', 'jsonIndex']);
    Route::get('jsonCreate', ['App\Http\Controllers\ExpenseController', 'jsonCreate']);
    Route::post('store', ['App\Http\Controllers\ExpenseController', 'store']);
    Route::get('jsonDetail/{idExpense}', ['App\Http\Controllers\ExpenseController', 'jsonDetail']);
});

//PRODUCT
Route::prefix('product')->group(function () {
    Route::get('', ['App\Http\Controllers\ProductController', 'index']);
    Route::get('jsonIndex/{filterText?}', ['App\Http\Controllers\ProductController', 'jsonIndex']);
    Route::get('jsonCreate', ['App\Http\Controllers\ProductController', 'jsonCreate']);
    Route::post('store', ['App\Http\Controllers\ProductController', 'store']);
    Route::get('jsonDetail/{idProduct}', ['App\Http\Controllers\ProductController', 'jsonDetail']);
});

//SUPPLIER
Route::prefix('supplier')->group(function () {
    Route::get('', ['App\Http\Controllers\SupplierController', 'index']);
    Route::get('jsonIndex/{filterText?}', ['App\Http\Controllers\SupplierController', 'jsonIndex']);
    Route::get('jsonCreate', ['App\Http\Controllers\SupplierController', 'jsonCreate']);
    Route::post('store', ['App\Http\Controllers\SupplierController', 'store']);
    Route::get('jsonDetail/{idSupplier}', ['App\Http\Controllers\SupplierController', 'jsonDetail']);
});

//PURCHASE
Route::prefix('purchase')->group(function () {
    Route::get('', ['App\Http\Controllers\PurchaseController', 'index']);
    Route::get('jsonIndex/{filterText?}', ['App\Http\Controllers\PurchaseController', 'jsonIndex']);
    Route::get('jsonCreate', ['App\Http\Controllers\PurchaseController', 'jsonCreate']);
    Route::post('store', ['App\Http\Controllers\PurchaseController', 'store']);
    Route::get('jsonDetail/{idPurchase}', ['App\Http\Controllers\PurchaseController', 'jsonDetail']);
    Route::post('checkFormDetail', ['App\Http\Controllers\PurchaseController', 'checkFormDetail']);
});

//SALE
Route::prefix('sale')->group(function () {
    Route::get('', ['App\Http\Controllers\SaleController', 'index']);
    Route::get('jsonIndex/{filterText?}', ['App\Http\Controllers\SaleController', 'jsonIndex']);
    Route::get('jsonCreate', ['App\Http\Controllers\SaleController', 'jsonCreate']);
    Route::post('store', ['App\Http\Controllers\SaleController', 'store']);
    Route::get('jsonDetail/{idPurchase}', ['App\Http\Controllers\SaleController', 'jsonDetail']);
    Route::post('checkFormDetail', ['App\Http\Controllers\SaleController', 'checkFormDetail']);
});
