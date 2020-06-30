<?php
/*
 * @Author: DanceLynx
 * @Description: 帖子分类模型
 * @Date: 2020-06-22 08:08:02
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fileable = [
        'name', 'description',
    ];
}
