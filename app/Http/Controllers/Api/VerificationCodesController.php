<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\VerificationCodeRequest;
use Carbon\Carbon;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Overtrue\EasySms\EasySms;
use Overtrue\EasySms\Exceptions\NoGatewayAvailableException;

class VerificationCodesController extends Controller
{
    public function stroe(VerificationCodeRequest $request,EasySms $easySms){
        $captchaData = \Cache::get($request->captcha_key);

        if (!$captchaData) {
            abort(403, '图片验证码已失效');
        }

        if (!hash_equals($captchaData['code'], $request->captcha_code)) {
            // 验证错误就清除缓存
            \Cache::forget($request->captcha_key);
            throw new AuthenticationException('验证码错误');
        }

        $phone = $request->phone;

        if(!app()->environment('production')){
            $rand_str = '1234';
        }else{
            $rand_str = str_pad(random_int(1,9999),4,0,STR_PAD_RIGHT);

            try{
                $easySms->send($phone,[
                    'template' => config('easysms.gateways.aliyun.templates.register'),
                    'data' => [
                        'code'=>$rand_str,
                    ],
                ]);
            }catch(NoGatewayAvailableException $exception){
                $message = $exception->getException('aliyun')->getMessage();
                abort(500,$message?:'短信发送异常');
            }
        }

        $key = 'verification_code_'. Str::random(15);
        $expired_at = Carbon::now()->addMinutes(5);

        \Cache::put($key, ['phone'=>$phone,'code'=>$rand_str], $expired_at);

        return response()->json([
            'key' => $key,
            'expired_at' => $expired_at->toDateTimeString(),
        ])->setStatusCode(201);

    }
}
