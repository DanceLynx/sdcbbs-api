<?php

namespace App\Http\Requests;

class TopicRequest extends Request
{
    public function rules()
    {
        switch($this->method())
        {
            // CREATE
            case 'POST':
            {
                return [
                    'title'=>'required|min:2',
                    'body'=>'required|min:3',
                    'category_id'=>'required|numeric',
                ];
            }
            // UPDATE
            case 'PUT':
            case 'PATCH':
            {
                return [
                    // UPDATE ROLES
                ];
            }
            case 'GET':
            case 'DELETE':
            default:
            {
                return [];
            }
        }
    }

    public function messages()
    {
        return [
            'title.required' => '标题不能为空',
            'title:min' => '标题不能小于:min位',
            'body.required' => '内容不能为空',
            'body.min' => '内容不能小于:min位',
            'category_id.required' => '分类必须选择',
            'category_id.numeric' => '分类必须为数字',
        ];
    }
}
