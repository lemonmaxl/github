<?php
namespace Home\Controller;
use Think\Controller;


class MemberController extends Controller{
    public function chkcode(){
        $Verify = new \Think\Verify(array(
            'fontSize'  => 18,
            'imageW'    => 124,
            'imageH'    => 44,
            'length'    => 4,
            'codeSet' => '0123456789',
            'useNoise'  => false,
        ));
        $Verify->entry();
    }
    public function regist(){
        if(IS_POST){
            //dump($_POST);die;
            $model = D('member');
            //dump($model);die;
            if($model->create(I('post.'),1)) {
                if ($model->add()) {
                    $this->success('注册成功!', U('login'));
                    exit;
                }
            }else {
                $this->error($model->getError());
            }
        }

        $this->assign(array(
           '_page_title' => '好家唯品网--用户注册',
            '_page_keywords' => '好家,唯品,生活空间',
            '_page_desc' => '给你缔造一个温馨的家',
        ));
        $this->display();
    }

    public function login(){
        if(IS_POST){
            $model = D("Member");
            if($model -> validate($model->login_validate)->create()){
                if($model -> chk_login()){
                    $return = session('returnUrl');
                    if($return){
                        session('returnUrl',null);
                        $this->success('登录成功!',$return);
                        exit;
                    }
                    $this->success('登录成功!',U('/'));
                    exit;
                }
            }
            $this->error($model->getError());
        }
        $this->assign(array(
            '_page_title' => '好家唯品网--用户登录',
            '_page_keywords' => '好家,唯品,生活空间',
            '_page_desc' => '给你缔造一个温馨的家',
        ));
        $this->display();
    }

    // ajax处理生成静态缓存后的登录问题
    public function chkLogin(){
        if(session('id')){
            echo json_encode(array(
                'login' => 1,
                'username' => session('username'),
            ));
        }else{
            echo json_encode(array(
                'login' => 0,
            ));
        }
    }
    // 处理会员价
    public function ajaxGetMemberPrice(){
        // 接受商品Id
        $id = I('get.id');
        // 计算会员价
        $gModel = D('Admin/Goods');
        echo $gModel->getMemberPrice($id);
    }
    // 退出功能
    public function loginOut(){
        session(null);
        redirect('/');
    }
}