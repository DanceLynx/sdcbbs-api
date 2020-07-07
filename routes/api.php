<?php
/*
 * @Author: DanceLynx
 * @Description: API 接口路由
 * @Date: 2020-07-02 20:38:12
 */

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::prefix('v1')
    ->name('api.v1.')
    ->namespace('Api')
    ->group(function () {
        Route::middleware('throttle:' . config('api.rate_limits.sign'))
            ->group(function () {
                Route::post('verificationCodes','VerificationCodesController@stroe')
                    ->name('verificationCodes.store');

                Route::post('users','UsersController@store')
                ->name('users.store');

                // 图片验证码
                Route::post('captchas', 'CaptchasController@store')
                    ->name('captchas.store');

                // 第三方登录
                Route::post('socials/{social_type}/authorizations', 'AuthorizationsController@socialStore')
                    ->where('social_type', 'weixin')
                    ->name('socials.authorizations.store');

                // 登录
                Route::post('authorizations', 'AuthorizationsController@store')
                    ->name('api.authorizations.store');

                // 刷新token
                Route::put('authorizations/current', 'AuthorizationsController@update')
                    ->name('authorizations.update');
                // 删除token
                Route::delete('authorizations/current', 'AuthorizationsController@destroy')
                    ->name('authorizations.destroy');
        });
        Route::middleware('throttle:' . config('api.rate_limits.access'))
            ->group(function () {
                // 某个用户的详情
                Route::get('users/{user}', 'UsersController@show')
                    ->name('users.show');

                // 分类列表
                Route::get('categories', 'CategoriesController@index')
                    ->name('categories.index');
                // 话题列表，详情
                Route::resource('topics', 'TopicsController')->only([
                    'index', 'show'
                ]);
                // 列出某个用户下的所有话题
                Route::get('users/{user}/topics', 'TopicsController@userIndex')
                    ->name('users.topics.index');
                // 登录后可以访问的接口
                Route::middleware('auth:api')->group(function() {
                    // 当前登录用户信息
                    Route::get('user', 'UsersController@me')
                        ->name('user.show');

                    // 上传图片
                    Route::post('images', 'ImagesController@store')
                        ->name('images.store');

                    // 编辑登录用户信息
                    Route::patch('user', 'UsersController@update')
                        ->name('user.update');

                    // 发布话题
                    Route::resource('topics', 'TopicsController')->only([
                        'store', 'update', 'destroy'
                    ]);

                    // 发布回复
                    Route::post('topics/{topic}/replies', 'RepliesController@store')
                        ->name('topics.replies.store');

                    // 删除回复
                    Route::delete('topics/{topic}/replies/{reply}', 'RepliesController@destroy')
                        ->name('topics.replies.destroy');
                });

        });
    });
