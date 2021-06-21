<?php


namespace app\index\controller;

use think\Request;
use app\common\model\Teacher;
use think\Controller;

class LoginController extends Controller
{
    public function index(){
        return $this->fetch();
    }

    // 处理用户提交的登录数据
    public function login()
    {
        // 接收post信息
        $postData = Request::instance()->post();
        // 直接调用M层方法，进行登录。
        if (Teacher::login($postData['username'], $postData['password'])) {
            return $this->success('login success', url('Teacher/index'));
        } else {
            return $this->error('username or password incorrent', url('index'));
        }
    }

}