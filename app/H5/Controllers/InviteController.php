<?php
/**
 * Created by PhpStorm.
 * User: Alienware
 * Date: 2017/12/4
 * Time: 0:07
 */

namespace App\H5\Controllers;

use App\Api\components\WebController;
use App\Models\Invite;

class InviteController extends WebController
{
    /**
     * @SWG\Get(path="/api/invite/index",
     *   tags={"我的推广"},
     *   summary="推广主页",
     *   description="Author: OYYM",
     *   @SWG\Parameter(name="token", in="header", default="1", description="用户token" ,required=true,
     *     type="string",
     *   ),
     *   @SWG\Response(
     *       response=200,description="
     *          [total_users] => 2  （邀请总人数）
     *          [first_level] => 1   （一级邀请人数）
     *          [second_level] => 1    （二级邀请人数）
     *          [invite_code] =>  f4eed21cc611d4234466d08b5176fcf8    （推广码）
     *          [first_level_list] => Array （一级邀请人详细列表）
     *          (
     *              [0] => Array
     *              (
     *                  [nickname] => 佚名34
     *                  [created_at] => 2018-08-09 22:40:01
     *              )
     *          )
     *          [second_level_list] => Array （二级邀请人详细列表）
     *          (
     *              [0] => Array
     *              (
     *                  [nickname] => 佚名45
     *                  [created_at] => 2018-08-09 22:41:21
     *              )
     *          )
     *     "
     *   )
     * )
     */
    public function index()
    {
        $this->auth();
        $model = new Invite();
        $model->userEntity = $this->userIdent;

        $res = $model->detail($this->userId);
        self::showMsg($res);
    }

    /**
     * @SWG\Get(path="/api/invite/invite-list",
     *   tags={"我的推广"},
     *   summary="推广人加载更多接口",
     *   description="Author: OYYM",
     *   @SWG\Parameter(name="token", in="header", default="1", description="用户token" ,required=true,
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="type", in="query", default="1", description="1 =一级推广人，2 =二级推广人",
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="limit", in="query", default="20", description="个数",
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="pages", in="query", default="0", description="页数",
     *     type="string",
     *   ),
     *   @SWG\Response(
     *       response=200,description="successful operation"
     *   )
     * )
     */
    public function inviteList()
    {
        $this->auth();
        $model = new Invite();
        $model->limit = $this->limit;
        $model->offset = $this->offset;
        if ($this->request->type == 1) {
            $flag = 'first';
        } else {
            $flag = 'second';
        }
        list($count, $user) = $model->inviteList($this->userId, $flag);
        self::showMsg($user);
    }

    /**
     * @SWG\Get(path="/api/invite/detail",
     *   tags={"我的推广"},
     *   summary="推广说明",
     *   description="Author: OYYM",
     *   @SWG\Response(
     *       response=200,description="successful operation"
     *   )
     * )
     */
    public function detail()
    {
        $data = [
            'get_invite_currency' => [
                'id' => 1,
                'title' => '如何赚钱',
                'img' => '',
                'function' => 'html',
                'params' => [
                    'key' => 'url',
                    'type' => 'String',
                    'value' => 'https://' . $_SERVER["HTTP_HOST"] . '/api/make-money',
                ],
            ],
        ];
        self::showMsg($data);
    }
}