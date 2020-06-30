<?php
/*
 * @Author: DanceLynx
 * @Description:默认路由
 * @Date: 2020-06-20 16:58:26
 */

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

Route::get('/', "TopicsController@index")->name('root');

Route::get('permission-denied', 'PagesController@permissionDenied')->name('permission-denied');

Auth::routes(['verify' => true]);

Route::resource('users', 'UsersController', ['only' => ['show', 'update', 'edit']]);

Route::resource('topics', 'TopicsController', ['only' => ['index', 'create', 'store', 'update', 'edit', 'destroy']]);

Route::get('topics/{topic}/{slug?}', 'TopicsController@show')->name('topics.show');

Route::post('upload_image', 'TopicsController@uploadImage')->name('topics.upload_image');

Route::resource('categories', 'CategoriesController', ['only' => ['show']]);

Route::resource('replies', 'RepliesController', ['only' => ['store',  'destroy']]);

Route::resource('notifications', "NotificationsController", ['only' => ['index']]);

