<?php
/**
 * Created by PhpStorm.
 * User: Alienware
 * Date: 2018/8/4
 * Time: 23:25
 */

namespace App\Models;


use zgldh\QiniuStorage\QiniuStorage;

class Upload extends Common
{
    public static function manyImg($file, $min = 3, $max = 9)
    {
        $filePath = [];  // 定义空数组用来存放图片路径
        if (count($file) < $min) {
            self::showMsg('至少传' . $min . '张图片!', self::CODE_ERROR);
        }
        foreach ($file as $key => $value) {
            if ($key >= $max) {
                continue;
            }
            // 判断图片上传中是否出错
            if (!$value->isValid()) {
                self::showMsg("上传图片出错，请重试！", self::CODE_ERROR);
            }

            if (!empty($value)) {//此处防止没有多文件上传的情况
                $allowed_extensions = ["png", "jpg", "gif"];
                if ($value->getClientOriginalExtension() && !in_array($value->getClientOriginalExtension(), $allowed_extensions)) {
                    self::showMsg('您只能上传PNG、JPG或GIF格式的图片！', self::CODE_ERROR);
                }
                // 初始化
                $disk = QiniuStorage::disk('qiniu');
                // 重命名文件
                $fileName = md5($value->getClientOriginalName() . time() . rand()) . '.' . $value->getClientOriginalExtension();
                // 上传到七牛
                $bool = $disk->put($fileName, file_get_contents($value->getRealPath()));
                // 判断是否上传成功
                if ($bool) {
                    $filePath[] = $fileName;
                }
            }
        }
        return $filePath;
    }


    public static function oneImg($file)
    {
        // 判断是否有文件上传
        if ($file) {
            $allowedExtensions = ["png", "jpg", "gif"];
            if ($file->getClientOriginalExtension() && !in_array($file->getClientOriginalExtension(), $allowedExtensions)) {
                self::showMsg('您只能上传PNG、JPG或GIF格式的图片！', self::CODE_ERROR);
            }
            // 初始化
            $disk = QiniuStorage::disk('qiniu');
            // 重命名文件
            $fileName = md5($file->getClientOriginalName() . time() . rand()) . '.' . $file->getClientOriginalExtension();
            // 上传到七牛
            $bool = $disk->put($fileName, file_get_contents($file->getRealPath()));
            // 判断是否上传成功
            if ($bool) {
                $path = $fileName;
                return $path;
            }
            return '';
        }
        return '';
    }
}