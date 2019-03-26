<?php
/**
 * Created by PhpStorm.
 * User: Alienware
 * Date: 2017/8/18
 * Time: 16:12
 */

namespace App\Api\Controllers;


class UserPointCardController
{
    /** 用户积分 */
    public function index()
    {
        return view('api.user-point-card.index', ['name' => 'James']);
    }
}