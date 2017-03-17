<?php
namespace Home\Controller;
use Think\Controller;

class AddressController extends Controller{
    // 修改地址
    public function edit(){
        dump($_POST);
        $this->display();
    }
    // 添加地址
    public function add(){
        // 获取会员Id
        $memberId = session('id');
        if(!$memberId){
            $this->error('请先登录!',U('Member/login'));
        }
        // 判断表单提交动作
        if(IS_POST){
            //dump($_POST);die;
            $model = D('Address');
            if($model->create(I('post.'),1)){
                if($model -> add()){
                    $this->redirect('Order/add');
                    exit;
                }
            }
            $this->error($model->getError());
        }

        $this->assign(array(
            'memberId' => $memberId,
            '_page_title' => '好家唯品--地址添加',
        ));
        $this->display();
    }
    // 地址列表
    public function lst(){
        $this->display();
    }
    // 删除地址
    public function del(){

    }


}