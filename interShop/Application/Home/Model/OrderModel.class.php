<?php
namespace Home\Model;
use Think\Model;

class OrderModel extends Model{
    // 1,下单时表单中允许接受的字段
//    protected $insertFields = 'or_name,or_province,or_ciity,or_area,or_address,or_tel';
    protected $insertFields = 'address_id,payment_id,user_remark,token_order';
    // 2,下单时表单验证规则
    protected $_validate = array(
//        array('or_name','require','收货人姓名不能为空!',1),
//        array('or_province','require','收货人省份不能为空!',1),
//        array('or_city','require','收货人城市不能为空!',1),
//        array('or_area','require','收货人地区不能为空!',1),
//        array('or_address','require','收货人详细地址不能为空!',1),
//        array('or_tel','require','收货人联系电话不能为空!',1),
        array('address_id','require','收货人地址不能为空!',1),
        array('payment_id','require','请选择支付方式!',1),
        array('user_remark', '0,140', '备注信息最长不能超过140个字符！', 1, 'length', 3),
    );
    // 3,填写之前先登录
    protected function _before_insert(&$data,$option){
        $memberId = session('id');
        if(!$memberId){
            $this->error = '请先登录!';
            return false;
        }
        // 4,************购物车中是否有商品******************/
        $cartModel = D('Cart');
        $cartData = $cartModel->cartList();
        if(!$cartData){
            $this->error = '购物车中没有商品,快去挑选吧!';
            return false;
        }
        // 5,****************购物车中的每件商品的库存量是否充足*************************/
        // 循环购物车每件商品检查库存量
        $gnModel = D('GoodsNumber');
        $totalPrice = 0;
        foreach ($cartData as $k => $v){
            $goodsNumber = $gnModel->field('goods_number')->where(array(
                'goods_id' => $v['goods_id'],
                'attr_list' => $v['goods_attr_id_list'],
            ))->find();
            if($v['goods_number'] > $goodsNumber['goods_number']){
                $this->error = '抱歉,商品库存量不足,无法下单!';
                return false;
            }
            $totalPrice += $v['price'] * $v['goods_number'];
        }
        // 6,写入其他字段的值
        $data['total_price'] = $totalPrice;
        $data['member_id'] = $memberId;
        $data['addtime'] = time();
    }

    protected function _after_insert($data,$option){
        /****************把购物车中的商品插入到订单商品表中*******************************/
        // 1,现取出购物车中的数据
        $cartModel = D('Cart');
        $cartData = $cartModel->cartList();
        // 2,写入订单商品表
        $ogModel = D('OrderGoods');
        // 循环购物车数据
        foreach ($cartData as $k => $v){
            $ogModel->add(array(
                'order_id' => $data['id'],
                'goods_id' => $v['goods_id'],
                'goods_attr_id' => $v['goods_attr_id_list'],
                'goods_number' => $v['goods_number'],
                'price' => $v['price'],
            ));
        }
        // 3,清空购物车
        $cartModel->clear();
    }

    // 用户中心订单列表
    public function my_order($pageSize = 10){
        /**********************搜索*******************/
        $where['member_id'] = array('eq',session('id'));
        /**********************翻页**************************/
        $count = $this->alias('a')->where($where)->count();
        //echo $count;
        $Page       = new \Think\Page($count,$pageSize);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $Page -> setConfig('prev','上一页');
        $Page -> setConfig('next','下一页');
        $data['page'] = $Page->show();// 分页显示输出
        /************************取数据***********************************/
        $data['data'] = $this->where($where)->limit($Page->firstRow.','.$Page->listRows)->select();
        $addrModel = D('Address');
        $info = $addrModel->alias('a')->field('a.shr_name,a.id')
            ->join('inner join vip_order b on a.id=b.address_id')
            ->where(array(
                'a.member_id' => session('id'),
            ))->select();
        $_ret = array();
        foreach ($data['data'] as $k => $v){
            foreach ($info as $k1 => $v1){
                if($v['address_id'] == $v1['id']){
                    $v['shr_name'] = $v1['shr_name'];
                }
            }
            $_ret[] = $v;
        }
        //dump($_ret);
        return $_ret;
    }
    /**
     * 设置订单为支付状态
     * @param $orderId : 订单号
     */
    public function setPaid($orderId){
        // 1,设置订单状态
        $this->where(array(
            'id' => array('eq',$orderId),
        ))->setField('pay_status',1);
        // 2,增加会员积分
        $info = $this->field('member_id,total_price')->find($orderId);
        $memberModel = D('Member');
        $memberModel->field('jifen')->where(array(
            'id' => $info['member_id'],
        ))->setInc('jifen',$info['total_price']);
    }

    // 删除未支付的订单
    public function del(){
        $memberId = session('id');
        if(!$memberId){
            $this->error = '请先登录!';
            return false;
        }
        $orderId = I('get.order_id');
        if($orderId){
            $this->where(array(
                'member_id' => $memberId,
                'order_id' => $orderId,
                'pay_status' => 0,
            ))->delete();
            return true;
        }
    }
}