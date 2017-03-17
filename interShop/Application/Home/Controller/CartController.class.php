<?php
namespace Home\Controller;
use Think\Controller;


class CartController extends Controller{
    public function add(){
        $model = D('Cart');
        // 接受并验证表单
        if($model->create()){
            $model->add();
            $this->success('添加成功!',U('lst'));
            exit;
        }
        $this->error($model->getError());
    }

    // 调用购物车模型获取购物车列表信息
    public function lst(){
        $model = D('Cart');
        $data = $model->cartList();
        //dump($data);
        //dump(unserialize($_COOKIE['cart']));
        $this->assign(array(
            'data' => $data,
            '_page_title' => '我的购物车-好家唯品',
        ));
        $this->display();
    }

    // 调用模型方法进行数量的修改
    public function ajaxUpdateCartData(){
        $model = D('Cart');
        $model -> updataCart(I('get.goods_id'),I('get.goods_attr_id_list'),I('get.goods_number'));
        $data =  I('get.goods_attr_id_list');
        dump($data);
    }
    // 获取前台首页购物车的商品列表
    public function ajaxGetCartList(){
        $model = D('Cart');
        $data = $model -> cartList();
        echo json_encode($data);
    }
}