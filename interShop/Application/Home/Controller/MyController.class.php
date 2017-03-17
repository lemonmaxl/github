<?php
namespace Home\Controller;
use Think\Controller;

class MyController extends Controller{
    private $_memberId;
    public function __construct(){
        parent::__construct();
        // 判断登录状态
        $this->_memberId = session('id');
        if(!$this->_memberId){
            // 先把要跳回的地址保存到session中
            session('returnUrl',U('My/order'));
            $this->error('请先登录!',U('Member/login'));
        }
    }
    public function order(){
        // 取得订单列表分页
        $orderModel = D('Order');
        $data = $orderModel ->my_order();
        $this->assign(array(
            'data' => $data,
            'page' => $data['page'],
            '_page_title' => '好家唯品--会员中心',
            '_page_keywords' => '好家,唯品,生活空间',
            '_page_desc' => '给你缔造一个温馨的家',
        ));
        $this->display();
    }

    // 会员中心地址列表
    public function add_lst(){
        $this->assign(array(
            '_page_title' => '好家唯品--会员中心',
            '_page_keywords' => '好家,唯品,生活空间',
            '_page_desc' => '给你缔造一个温馨的家',
        ));
        $this->display();
    }
}