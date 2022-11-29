<?php

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

use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileUpload;
use App\Http\Controllers\PostController;

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
	Route::resource('/', 'Auth\LoginController@login');
	Route::get('/home', 'HomeController@index')->name('home');

	Route::resource('users', 'UserController');

	Route::resource('roles', 'RoleController');

	Route::post('attendances/export', 'AttendanceController@export')->name('attendances.export');
	Route::resource('attendances', 'AttendanceController');

	Route::resource('profile', 'ProfileController');
	// Route::get('/file/file-upload', [FileUpload::class, 'createForm']);
	// Route::get('/file/file-upload', [FileUpload::class, 'downloadFile']);
	// Route::post('/file/file-upload', [FileUpload::class, 'fileUpload'])->name('fileUpload');
	Route::get('/file', 'FileController@index')->name('viewfile');
	Route::get('/file/upload', 'FileController@create')->name('formfile');
	Route::post('/file/upload', 'FileController@store')->name('uploadfile');
	Route::get('/file/download/{id}', 'FileController@show')->name('downloadfile');
	Route::delete('/file/{id}', 'FileController@destroy')->name('deletefile');
	Route::get('/file/notulensi', 'FileController@getNotulensi')->name('fileNotulensi');
	Route::get('/file/memo', 'FileController@getMemo')->name('fileMemo');
	Route::get('/file/sop', 'FileController@getSOP')->name('fileSOP');
	Route::get('/file/dokumen', 'FileController@getDokument')->name('fileDoku');
	Route::resource('post', 'PostController');
	Route::get('/post/{id}', 'PostController@index')->name('postIndex');
	Route::post('/post', 'PostController@store')->name('post');
	// Route::get('/post/show', 'PostController@getPost')->name('showPost');
	// Route::post('/post', 'PostController@store')->name('Store');
	// Route::post('/post/show', 'PostController@getPost')->name('get');
	Route::post('/comment/store', 'CommentController@store')->name('comment');

});
