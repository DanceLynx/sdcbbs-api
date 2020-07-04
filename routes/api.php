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
        });
        Route::middleware('throttle:' . config('api.rate_limits.access'))
            ->group(function () {

        });
    });
