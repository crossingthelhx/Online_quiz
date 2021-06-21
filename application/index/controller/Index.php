<?php
namespace app\index\controller; //命名空间，也说明了文件所在的文件夹
use think\Db; // 引用数据库操作类
use Think\Controller;
// Index既是类名，也是文件名，说明这个文件的名字为Index.php。
class Index extends Controller
{
    public function index()
    {
        $this->$this->display(); //获取数据表中第一条数据
    }
}