<?php

use App\Http\Controllers\AuthManager;
use App\Http\Controllers\ProductManager;
use App\Http\Middleware\RoleAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return "hi";
});

Route::get('dashboard', function(){
    return "dashboard";
})->name('dashboard');

Route::get("login", [AuthManager::class, "login"])->name("login");
Route::post("login", [AuthManager::class, "loginPost"])->name("login.post");

Route::prefix("admin")->middleware(RoleAdmin::class)->group(function(){
    Route::get('dashboard', function(){
        return "dashboard";
    })->name('dashboard');
    Route::get('products', [ProductManager::class, "listProducts"])->name("products");
    Route::post('products', [ProductManager::class, "addProducts"])->name("product.add");
    Route::get('products/delete', [ProductManager::class, "deleteProducts"])->name("product.delete");
});
