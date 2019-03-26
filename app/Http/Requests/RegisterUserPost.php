<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class RegisterUserPost extends FormRequest
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
            'name' => 'required|max:30',
            //'email' => 'email|max:50',
            //'birthday' => 'required',
            'sex_select' => 'required|digits_between:1,3',
            'bind_mobile' => 'required|unique:user_info|digits:11',
            'code' => 'required|digits:6',
            'id_card' => 'required|alpha_num|digits:18',
            // 'invite_mobile' => 'required|exists:user_info,bind_mobile|digits:11',
            //'invite_mobile' => 'required|digits:11',
            //  'agree' => 'accepted',
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
            'name.required' => '请填写您的姓名',
            'name.max' => '姓名过长，请重新填写',
            'bind_mobile.required' => '请填写手机号码',
            'bind_mobile.unique' => '该手机号已注册过账号，请重新填写',
            'bind_mobile.digits' => '请填写正确手机号码',
            //'birthday.required' => '请填写您的生日',
            'sex_select.digits_between' => '请填您的性别',
            'code.required' => '请填写验证码',
            'code.digits' => '请填写正确验证码格式',
            'id_card.alpha_num' => '请输入正确身份证位号码格式',
            'id_card.required' => '请输入您本人身份证号',
            'id_card.digits' => '身份证位号码位数不正确',
            //'invite_mobile.required' => '请填写推荐人手机号',
            //'invite_mobile.exists' => '该推荐人手机号未注册账号',
            //'invite_mobile.digits' => '请输入正确手机号位数',
            //'email.email' => '请填写正确的邮箱格式',
            //'email.max' => '此邮箱地址过长，请选择新的邮箱',
            //'agree.accepted' => '请同意相关条款',
        ];
    }
}
