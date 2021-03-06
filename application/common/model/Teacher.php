<?php

namespace app\common\model;
use think\Model;
class Teacher extends Model
{

    /**
     * 用户登录
     * @param string $username 用户名
     * @param string $password 密码
     * @return bool 成功返回true，失败返回false。
     */
    static public function login($username, $password)
    {
        // 验证用户是否存在
        $map = array('username' => $username);
        $Teacher = self::get($map);
        if (!is_null($Teacher)) {
            // 验证密码是否正确
            if ($Teacher->checkPassword($password)) {
            // 登录
                session('teacherId', $Teacher->getData('id'));
                return true;
            }
        }
        return false;
    }

    public function checkPassword($password){
        if ($this->getData('password') === $this::encryptPassword($password))
        {
            return true;
        } else {
            return false;
        }
    }

    static public function encryptPassword($password)
    {
        // 实际的过程中，我还还可以借助其它字符串算法，来实现不同的加密。
        return sha1(md5($password) . 'mengyunzhi');
    }
}