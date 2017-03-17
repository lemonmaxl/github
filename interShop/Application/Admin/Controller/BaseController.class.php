<?php

namespace Admin\Controller;
use Think\Controller;

// 基础控制器,所有的控制器都要继承
class BaseController extends Controller{
    // 构造函数
    public function __construct(){
        // 1,现调用父类的构造函数
        parent::__construct();
        // 2,判断登录
        $id = session('id');
        if (!$id)
            $this->error('必须先登录!',U('Login/login'));
        // 3,验证权限
        $adminModel = D('Admin');
        if (!$adminModel -> chk_pri())
            //$this->error('无权访问!');
            $this->redirect('','','','无权访问...');

    }
}