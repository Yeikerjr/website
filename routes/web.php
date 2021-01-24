<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\PublisherController;
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

//PRINCIPAL ROUTES

Route::get('sell-guest-posts', function() {
	return view('pages.sellGuestPosts');
})->name('sell-guest-posts');

Route::get('marketplace', function() {
	return view('pages.marketplace');
})->name('marketplace');

Route::get('guest-posting-services', function() {
	return view('pages.guestPostingServices');
})->name('guest-posting-services');

Route::get('da-dr-increase-service', function() {
	return view('pages.da-dr');
})->name('da-dr-increase-service');

//END PRINCIPAL ROUTES

Route::get('cart')->name('cart');

Route::get('contact', [ContactController::class, 'index'])->name('contact.index');

Route::get('faqs', function() {
	return view('subpages.faqs');
})->name('faqs');

Route::get('term', function() {
	return view('subpages.term');
})->name('term');

Route::get('privacy', function() {
	return view('subpages.privacy');
})->name('privacy');

Route::get('refound-policy', function() {
	return view('subpages.refoundPolicy');
})->name('refound-policy');

Route::get('publisher/websiteAdd', [PublisherController::class, 'websiteAdd'])->name('publisher.websiteAdd');

Auth::routes();

Route::resource('categories', App\Http\Controllers\CategoryController::class);

Route::resource('websites', App\Http\Controllers\WebsiteController::class);

Route::resource('carts', App\Http\Controllers\CartController::class);