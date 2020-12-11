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

use App\Http\Controllers\AssignmentsController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\PostsController;

Route::get('/', 'PagesController@home')->name('posts.home');

Auth::routes();

Route::get('profiles/{id}', 'ProfilesController@show')->name('profile.show');
Route::get('profiles', 'ProfilesController@index')->name('profile.index');
Route::get('event/show/{event}', 'EventsController@show')->name('event.show');
Route::get('post/show/{post}', 'PostsController@show')->name('post.show');
Route::get('posts/{visibility_name?}', 'PostsController@index')->name('posts.index');
Route::get('events/{visibility_name?}', 'EventsController@index')->name('events.index');
Route::get('albums/{visibility_name?}', 'AlbumsController@index')->name('albums.index');
Route::get('album/{id}/show', 'AlbumsController@show')->name('albums.show');
Route::get('album/{sheetMusic}/showPhoto', 'AlbumsController@showPhoto')->name('albums.showPhoto');


Route::middleware(['auth'])->group(function () {
    Route::get('/approval', 'HomeController@approval')->name('approval');

    //approved routes
    Route::middleware(['approved'])->group(function () {
        Route::get('/home', 'HomeController@index')->name('home');
        Route::resource('post', 'PostsController', ['except' => ['index', 'show']]);
        Route::resource('event', 'EventsController', ['except' => ['index', 'show']]);
        Route::get('event/{id}/attachUser', 'EventsController@attachUser')->name('event.attachUser');
        Route::get('event/{id}/detachUser', 'EventsController@detachUser')->name('event.detachUser');
        Route::post('post/comments', 'CommentsController@store')->name('comments.store');
        Route::resource('profiles', 'ProfilesController', ['except' => ['index', 'show']]);
        Route::post('profiles/uploadPhoto', 'ProfilesController@uploadPhoto')->name('profiles.uploadPhoto');
        Route::resource('sheetMusic', 'SheetMusicsController', ['except' => 'create']);
        Route::get('sheetMusic/{sheetMusic}/download', 'SheetMusicsController@download')->name('sheetMusic.download');
        Route::post('album', 'AlbumsController@store')->name('albums.store');
        Route::get('album/{id}/destroy', 'AlbumsController@destroy')->name('albums.destroy');
        Route::post('album/uploadPhoto', 'AlbumsController@uploadPhoto')->name('albums.uploadPhoto');
        Route::get('assignments/{composition_id?}', 'AssignmentsController@index')->name('assignments.index');
        Route::post('assignment', 'AssignmentsController@store')->name('assignments.store');
        Route::get('assignment/{id}/delete', 'AssignmentsController@destroy')->name('assignments.delete');

    });

    //admin routes
    Route::middleware(['admin'])->group(function () {
        Route::get('admin/usersToApprove', 'UsersToApproveController@index')->name('admin.usersToApprove.index');
        Route::get('admin/usersToApprove/{user_id}/approve', 'UsersToApproveController@approve')->name('admin.usersToApprove.approve');
        Route::get('admin/users', 'UsersAdminController@index')->name('admin.users.index');
        Route::post('admin/users/update', 'UsersAdminController@update')->name('admin.users.update');
        Route::get('profiles/{id}/delete', 'UsersAdminController@destroy')->name('profile.delete');
        Route::get('admin/compositions', 'CompositionsController@index')->name('compositions.index');
        Route::post('admin/compositions', 'CompositionsController@store')->name('compositions.store');
        Route::post('admin/compositions/update', 'CompositionsController@update')->name('compositions.update');
        Route::get('admin/compositions/{id}/destroy', 'CompositionsController@destroy')->name('compositions.destroy');
    });
});


Route::get('/about', function () {
    return view('pages/about');
});

