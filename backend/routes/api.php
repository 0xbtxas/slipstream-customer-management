<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CategoryController;

Route::apiResource('customers', CustomerController::class);
Route::controller(ContactController::class)
    ->prefix('customers/{customer}/contacts')
    ->as('customers.contacts.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('{contact}', 'show')->name('show');
        Route::put('{contact}', 'update')->name('update');
        Route::delete('{contact}', 'destroy')->name('destroy');
    });
Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
