<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class BindMobilePost extends FormRequest
{
    //验证规则可自己添加需要验证的字段
    protected $rules = [
        'Student.userName' => 'required|between:2,4',
        'Student.userAge' => 'required|integer',
        'Student.userSex' => 'required|integer',
        'Student.addr' => 'required',
    ];

    //这里我只写了部分字段，可以定义全部字段
    protected $strings_key = [
        'userName' => '用户名',
        'Student.userAge' => '年龄',
        'Student.userSex' => '性别',
        'Student.addr' => '地址',
    ];

    protected $strings_val = [
        'required' => '为必填项',
        'min' => '最小为:min',
        'max' => '最大为:max',
        'between' => '长度在:min和:max之间',
        'integer' => '必须为整数',
        'sometimes' => '',
    ];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'bind_mobile' => 'required|unique:user_info|digits:11',
            'code' => 'required|digits:6',
        ];
    }

    /**
     * 获取被定义验证规则的错误消息
     *
     * @return array
     * @translator laravelacademy.org
     */
    public function messages()
    {

//        $rules = $this->rules();
//        $k_array = $this->strings_key;
//        $v_array = $this->strings_val;
//        foreach ($rules as $key => $value) {
//            $new_arr = explode('|', $value);//分割成数组
//            foreach ($new_arr as $k => $v) {
//                $head = strstr($v, ':', true);//截取:之前的字符串
//                if ($head) {
//                    $v = $head;
//                }
//                $array[$key . '.' . $v] = $k_array[$key] . $v_array[$v];
//            }
//        }
//        return $array;
        return [

            'bind_mobile.required' => '请填写手机号码',
            'bind_mobile.unique' => '该手机号已注册过账号，请重新填写',
            'bind_mobile.digits' => '请填写正确手机号码',

            'code.required' => '请填写验证码',
            'code.digits' => '请填写正确验证码格式',

        ];
    }
}
