<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('products', function() {
    return view('layouts.product');
});

// Routes category
Route::resource('category_view','CategoryController');
Route::post('category', 'CategoryController@store')->name('category.store');
Route::get('category/destroy/{id}', 'CategoryController@destroy'); 
Route::get('category/edit/{id}', 'CategoryController@edit');
Route::post('category/update', 'CategoryController@update')->name('category.update');

// Routes provider
Route::resource('providers_view','ProviderController');
Route::post('providers', 'ProviderController@store')->name('providers.store');
Route::get('providers/destroy/{id}', 'ProviderController@destroy'); 
Route::get('providers/edit/{id}', 'ProviderController@edit');
Route::post('providers/update', 'ProviderController@update')->name('providers.update');

// Routes product
Route::resource('products_view','ProductController');
Route::post('products', 'ProductController@store')->name('products.store');
Route::get('products/destroy/{id}', 'ProductController@destroy'); 
Route::get('products/edit/{id}', 'ProductController@edit');
Route::post('products/update', 'ProductController@update')->name('products.update');

// Routes home
Route::resource('/','SaleController');
Route::post('home', 'SaleController@store')->name('home.store');
Route::get('home/destroy/{id}', 'SaleController@destroy'); 
Route::get('home/edit/{id}', 'SaleController@edit');
Route::post('home/update', 'SaleController@update')->name('home.update');