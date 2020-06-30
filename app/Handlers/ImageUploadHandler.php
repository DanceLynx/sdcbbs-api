<?php
/*
* @Author: DanceLynx
* @Description文件上传处理器
* @Date: 2020-06-21 15:42:59
*/

namespace App\Handlers;

use Illuminate\Support\Str;
use Image;

class ImageUploadHandler
{
    protected $extenstions = ['jpg', 'png', 'gif'];

    public function save($file, $folder, $filePrefix, $maxWidth = false)
    {
        $folderName = "uploads/images/$folder/" . date("Y-m-d", time());

        $uploadPath = public_path() . "/" . $folderName;

        $extenstion = strtolower($file->getClientOriginalExtension()) ?: "png";

        $fileName = $filePrefix . "_" . time() . "_" . Str::random(10) . ".$extenstion";

        if (!in_array($extenstion, $this->extenstions)) {
            return false;
        }

        $file->move($uploadPath, $fileName);

        if ($maxWidth && $extenstion != 'gif') {
            $this->reduceSize($uploadPath . '/' . $fileName, $maxWidth);
        }

        return [
            'path' => config('app.url') . "/$folderName/$fileName",
        ];
    }

    public function reduceSize($filePath, $maxWidth)
    {
        $image = Image::make($filePath);

        $image->resize($maxWidth, null, function ($constraint) {
            // 设定宽度是 $max_width，高度等比例缩放
            $constraint->aspectRatio();

            // 防止裁图时图片尺寸变大
            $constraint->upsize();
        });
        $image->save();
    }
}
