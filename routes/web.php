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

Route::get('/', function () {
    return view('welcome');
});

Route::get('home', function () {
    return view('home');
});

Route::get('sell-guest-posts', function() {
	return view('pages.sellGuestPosts');
})->name('sell-guest-posts');

Route::get('marketplace')->name('marketplace');

Route::get('guest-posting-services')->name('guest-posting-services');

Route::get('da-dr-increase-service')->name('da-dr-increase-service');

Route::get('cart')->name('cart');

Auth::routes();