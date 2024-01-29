<?php

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

Route::group(['namespace' => 'App\Http\Controllers\Currency'], function() {
    Route::get('/', 'IndexController')->name('currency.index');
    Route::get('/update', 'UpdateController')->name('currency.update');
    Route::get('/json', 'StoreController')->name('currency.store');
    Route::post('/json', 'StoreController')->name('currency.filter');
    Route::get('/json/{code}', 'ShowController')->name('currency.show');
});
