<?php
namespace Home\Controller;
use Think\Controller;

class OrderController extends Controller{
    public function add(){
        $memberId = session('id');
        if(!$memberId){
            // 登录之前把调回的地址存入session
            session('returnUrl',U('Order/add'));
            $this->error('请先登录!',U('Member/login'));
        }
        // 2,处理提交的表单
        if (IS_POST){
            //dump($_POST);die;
            $model = D('Order');
            if($model -> create(I('post.'),1)){
                if($orderId = $model->add()){
                    $this->redirect('Order/detail', array('order_id' => $orderId));
                    exit;
                }
            }
            $this->error($model->getError());
        }
        // 3,取出购物车中的商品
        $cartModel = D('Cart');
        $data = $cartModel->cartList();
        $this->assign('data',$data);
        // 取出会员所有地址信息
        $adrModel = D('Address');
        $addrData = $adrModel->getAddrLst();
        //dump($addrData);
        // 4,设置页面信息
        $this->assign(array(
            'addrData' => $addrData,
           '_page_title' => '订单确认--好家唯品',
        ));
        $this->display();
    }
    // 订单详情
    public function detail(){
        $memberId = session('id');
        if(!$memberId){
            // 登录之前把调回的地址存入session
            session('returnUrl',U('Order/detail'));
            $this->error('请先登录!',U('Member/login'));
        }
        // 订单Id
        $orderId = I('get.order_id');
        $this->assign(array(
            'oreder_id' => $orderId,
            '_page_title' => '提交订单--好家唯品',
        ));
        $this->display();
    }
    // 删除未支付的订单
    public function delete(){
        $memberId = session('id');
        if(!$memberId){
            // 登录之前把调回的地址存入session
            session('returnUrl',U('Order/delete'));
            $this->error('请先登录!',U('Member/login'));
        }
        $model = D('Order');
        if($model -> del()){
            $this->success('订单删除成功!');
        }
    }
    // 下单成功
    public function succe(){
        // 生成支付按钮
        echo makeAlipayBtn(I('get.order_id'));
    }
    // 接受支付宝返回的消息
    public function receive(){
        require_once('./alipay/notify_url.php');
    }
}