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
    ->name('api.v1,')
    ->group(function () {
    });
