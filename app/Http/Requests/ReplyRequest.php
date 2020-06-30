<?php
/*
 * @Author: DanceLynx
 * @Description: 回复验证
 * @Date: 2020-06-25 23:12:51
 */

namespace App\Http\Requests;

class ReplyRequest extends Request
{
    public function rules()
    {
        return [
            'content' => 'required|min:2'
        ];
    }

    public function messages()
    {
        return [
            // Validation messages
        ];
    }
}
