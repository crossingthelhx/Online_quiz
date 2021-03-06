<?php
namespace app\index\controller;
use app\common\model\Teacher; // 教师模型
use think\Controller;
use think\Request;

/**
 * 教师管理
 */
class TeacherController extends Controller{
    public function index()
    {
        $Teacher = new Teacher;
        $teachers = $Teacher->select();

        $this->assign('teachers',$teachers);

        $htmls=$this->fetch();

        return $htmls;
    }

    public function insert(){
        // 接收传入数据
        $postData = Request::instance()->post();
        // 实例化Teacher空对象
        $Teacher = new Teacher();
        // 为对象赋值
        $Teacher->name = $postData['name'];
        $Teacher->username = $postData['username'];
        $Teacher->sex = $postData['sex'];
        $Teacher->email = $postData['email'];
        $Teacher->create_time = $postData['create_time'];

        // 新增对象至数据表
        $result = $Teacher->validate(true)->save($Teacher->getData());
        // 反馈结果
        if (false === $result)
        {
            return '新增失败:' . $Teacher->getError();
        } else {
            return '新增成功。新增ID为:' . $Teacher->id;
        }
    }

    public function add()
    {
        $htmls = $this->fetch();
        return $htmls;
    }

    public function delete()
    {
        // 获取pathinfo传入的ID值.
        $id = Request::instance()->param('id/d'); // “/d”表示将数值转化为“整形”
        if (is_null($id) || 0 === $id) {
            return $this->error('未获取到ID信息');
        }
        // 获取要删除的对象
        $Teacher = Teacher::get($id);
        // 要删除的对象不存在
        if (is_null($Teacher)) {
            return $this->error('不存在id为' . $id . '的教师，删除失败');
        }
        // 删除对象
        if (!$Teacher->delete()) {
            return $this->error('删除失败:' . $Teacher->getError());
        }
        // 进行跳转
        return $this->success('删除成功', url('index'));
    }

    public function edit(){
        // 获取传入ID
        $id = Request::instance()->param('id/d');
        // 在Teacher表模型中获取当前记录
        if (is_null($Teacher = Teacher::get($id))) {
            return '系统未找到ID为' . $id . '的记录';
        }
        // 将数据传给V层
        $this->assign('Teacher', $Teacher);
        // 获取封装好的V层内容
        $htmls = $this->fetch();
        // 将封装好的V层内容返回给用户
        return $htmls;
    }

    public function update()
    {
        // 接收数据
        $teacher = Request::instance()->post();
        // 将数据存入Teacher表
        $Teacher = new Teacher();
        $message = '更新成功';

        // 依据状态定制提示信息
        try {
            if (false === $Teacher->validate(true)->isUpdate()->save($teacher))
            {
                $message = '更新失败：' . $Teacher->getError();
            }
        } catch (\Exception $e) {
            $message = '更新失败:' . $e->getMessage();
        }
        return $message;
    }
}