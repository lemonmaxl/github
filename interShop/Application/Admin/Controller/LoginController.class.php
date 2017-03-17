<?php

namespace Admin\Controller;
use Think\Controller;


class LoginController extends Controller{
    // 登录方法
    public function login(){
        if (IS_POST){
            $model = D('Admin');
            if($model->validate($model->_logo_validate)->create()){
                if($model->login()){
                    $this->success('登录成功!',U('Index/index'));
                    exit;
                }
            }
            $this->error($model->getError());
        }
        $this->display();
    }

    // 验证码
    public function chk_code(){
        $Verify = new \Think\Verify(array(
            'length' => 4,
            'useNoise' => false,
            'imageW' => 0,
            'imageH' => 40,
            'fontSize' => 18,
            'codeSet' => '0123456789',
        ));
        $Verify->entry();
    }

    // 退出功能
    public function l_out(){
        session('id',null);
        session(null);
        $this->success('成功退出,正在返回登录页...',U('Login/login'));
    }
}
