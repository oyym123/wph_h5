<?php

namespace App\H5\Controllers;

use App\Api\components\WebController;

class SwaggerController extends WebController
{
    /**
     * 返回JSON格式的Swagger定义
     *
     * 这里需要一个主`Swagger`定义：
     * @SWG\Swagger(
     *   @SWG\Info(
     *     title="《微拍行》API文档",
     *     version="1.0.0",
     *      description="
    [code] => 0=正常; 1=需要登入; 2=没有数据;3=账号已被冻结
    [message] => 返回的报错信息
    [data] => 返回的数据",
     *   )
     * )
     */
    public function getJSON()
    {
        // 你可以将API的`Swagger Annotation`写在实现API的代码旁，从而方便维护，
        // `swagger-php`会扫描你定义的目录，自动合并所有定义。这里我们直接用`Controller/`
        // 文件夹。
        $swagger = \Swagger\scan(app_path('Api/Controllers/'));

        return response()->json($swagger, 200);
    }

}
