<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhotoController;

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

Route::get('/login', function () {
    return view('users/index');
});


Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home')->middleware('auth');

// Route::prefix('user')->group(function () {
Route::get('/', ['as' => 'index', 'uses' =>'App\Http\Controllers\Front\FrontController@index']);
Route::get('detail/{photoData}', ['as' => 'users.detail', 'uses' => 'App\Http\Controllers\Front\FrontController@detailShow']);
Route::get('search', ['as' => 'users.search', 'uses' => 'App\Http\Controllers\Front\FrontController@searchPhotos']);
// });

Route::prefix('cms')->group(function () {
	Route::group(['middleware' => 'auth'], function () {

		// Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
		Route::get('users', ['as' => 'user.index', 'uses' => 'App\Http\Controllers\UserController@index']);
		Route::get('userCreate', ['as' => 'user.create', 'uses' => 'App\Http\Controllers\UserController@userCreate']);
		Route::post('userStore', ['as' => 'user.store', 'uses' => 'App\Http\Controllers\UserController@userStore']);
		Route::get('userEdit/{user}', ['as' => 'user.edit', 'uses' => 'App\Http\Controllers\UserController@userEdit']);
		Route::put('userUpdate/{user}', ['as' => 'user.update', 'uses' => 'App\Http\Controllers\UserController@userUpdate']);
		Route::delete('userDestroy/{user}', ['as' => 'user.destroy', 'uses' => 'App\Http\Controllers\UserController@userDestroy']);

		Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
		Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
		Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
		
		// Route::get('icons', ['as' => 'pages.icons', 'uses' => 'App\Http\Controllers\PageController@icons']);
		// Route::get('maps', ['as' => 'pages.maps', 'uses' => 'App\Http\Controllers\PageController@maps']);
		// Route::get('notifications', ['as' => 'pages.notifications', 'uses' => 'App\Http\Controllers\PageController@notifications']);
		// Route::get('rtl', ['as' => 'pages.rtl', 'uses' => 'App\Http\Controllers\PageController@rtl']);
		// Route::get('tables', ['as' => 'pages.tables', 'uses' => 'App\Http\Controllers\PageController@tables']);
		// Route::get('typography', ['as' => 'pages.typography', 'uses' => 'App\Http\Controllers\PageController@typography']);
		// Route::get('upgrade', ['as' => 'pages.upgrade', 'uses' => 'App\Http\Controllers\PageController@upgrade']);

		Route::get('photos', ['as' => 'pages.main', 'uses' => 'App\Http\Controllers\PhotoController@main']);
		Route::get('create', ['as' => 'pages.create', 'uses' => 'App\Http\Controllers\PhotoController@create']);
		Route::get('search', ['as' => 'pages.search', 'uses' => 'App\Http\Controllers\PhotoController@search']);
		Route::post('store', ['as' => 'pages.store', 'uses' => 'App\Http\Controllers\PhotoController@store']);
		Route::get('show/{photo}', ['as' => 'pages.show', 'uses' => 'App\Http\Controllers\PhotoController@show']);
		Route::get('edit/{photo}', ['as' => 'pages.edit', 'uses' => 'App\Http\Controllers\PhotoController@edit']);
		Route::put('update/{photo}', ['as' => 'pages.update', 'uses' => 'App\Http\Controllers\PhotoController@update']);
		Route::delete('destroy/{photo}', ['as' => 'pages.destroy', 'uses' => 'App\Http\Controllers\PhotoController@destroy']);
		
		Route::get('setting', ['as' => 'photos.setting', 'uses' => 'App\Http\Controllers\PhotoController@setting']);
		Route::get('categoryCreate', ['as' => 'photos.categoryCreate', 'uses' => 'App\Http\Controllers\PhotoController@categoryCreate']);
		Route::post('categoryStore', ['as' => 'photos.categoryStore', 'uses' => 'App\Http\Controllers\PhotoController@categoryStore']);
		Route::get('categoryList', ['as' => 'photos.categoryList', 'uses' => 'App\Http\Controllers\PhotoController@categoryList']);
		Route::get('categoryEdit/{category}', ['as' => 'photos.categoryEdit', 'uses' => 'App\Http\Controllers\PhotoController@categoryEdit']);
		Route::put('categoryUpdate', ['as' => 'photos.categoryUpdate', 'uses' => 'App\Http\Controllers\PhotoController@categoryUpdate']);
		Route::delete('categoryDestroy/{category}', ['as' => 'photos.categoryDestroy', 'uses' => 'App\Http\Controllers\PhotoController@categoryDestroy']);
	});
});


// Route::group(['middleware' => 'auth'], function () {
	// Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	// Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	// Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	// Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
// });
