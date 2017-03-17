<?php
namespace Home\Model;
use Think\Model;


class CartModel extends Model{
    protected $_validate = array(
        array('goods_id','require','必须选择商品!',1),
        array('goods_number','_chk_goods_number','库存量不足',1,'callback'),
    );
    protected function _chk_goods_number($goodsNumber){
        if($goodsNumber>0){
            $goodsAttrId = I('post.goods_attr_id_list');
            sort($goodsAttrId);// 从低到高排序
            $goodsAttrId = implode(',',$goodsAttrId);
            //dump($goodsAttrId);die;
            $gnModel = D('GoodsNumber');
            $gn = $gnModel -> field('goods_number')->where(array(
                'goods_id' => array('eq',I('post.goods_id')),
                'attr_list' => array('eq',$goodsAttrId),
            ))->find();
            if ($gn && $gn['goods_number'] >$goodsNumber)
                return true;
        }
        return false;
    }
    // 添加到购物车
    public function add(){
        // 1,获取会员Id
        $memberId = session('id');
        // 2,把属性Id转化为字符串
        $goodsAttrIdList = $this->goods_attr_id_list;
        sort($goodsAttrIdList,SORT_NUMERIC);
        $goodsAttrIdList = (string)implode(',',$goodsAttrIdList);
        if($memberId) {
            // 3,通过验证库存量后写入数据
            parent::add(array(
                'goods_id' => $this->goods_id,
                'goods_number' => $this->goods_number,
                'goods_attr_id_list' => $goodsAttrIdList,
                'member_id' => $memberId,
            ));
        }else{
            /*************把商品添加到cookie的一位数组中****************/
            // 1,先从COOKIE中取出购物车的一位数组
            $cart = isset($_COOKIE['cart']) ? unserialize($_COOKIE['cart']) : array();
            // 2,把商品添加进去
            $cart[$this->goods_id.'-'.$goodsAttrIdList] = $this->goods_number;
            // 3,把数组存回COOKIE
            setcookie('cart',serialize($cart),time()+30*86400,'/');
        }
    }

    // 购物车列表
    public function cartList(){
        /**************先从购物车中取出所有商品的Id****************/
        // 1,取会员Id
        $memberId = session('id');
        // 2,判断是否登录,登录就从数据库取,未登录就从COOKIE中取
        if($memberId){
            $cartData = $this->where(array(
                'member_id' => $memberId,
            ))->select();
        }else{
            // 3,判断COOKIE是否存在
            $_cartData = isset($_COOKIE['cart'])? unserialize($_COOKIE['cart']) : array();
            // 4,把一维数组转成二位,和上面的$cartDate一样
            $cartData = array();
            foreach($_cartData as $k => $v){
                // 5,从下标中取出Id
                // 下标组合为:goods_id-goods_attr_id_list[] == 43-6,7
                $_k = explode('-',$k);
                $cartData[] = array(
                    'goods_id' => $_k[0],
                    'goods_attr_id_list' => $_k[1],
                    'goods_number' => $v,
                );
            }
        }
        /**************根据购物车中商品的Id取出商品的详细信息******************/
        // 1,循环购物车中每件商品,根据Id取出信息
        $gaModel = D('GoodsAttr');
        $gModel  = D('Admin/Goods');
        foreach ($cartData as $k => $v){
                // 2,取出商品名称,logo图片
            $ginfo = $gModel->field('goods_name,sm_logo')->find($v['goods_id']);
            // 3,把取出来的信息放到购物车中
            $cartData[$k]['goods_name'] = $ginfo['goods_name'];
            $cartData[$k]['sm_logo'] = $ginfo['sm_logo'];
            // 4,取出商品的会员价格
            $cartData[$k]['price'] = $gModel->getMemberPrice($v['goods_id']);
            // 把商品属性Id转化为:属性名:属性值的字符串
            $cartData[$k]['gaData'] = $gaModel->alias('a')
                ->field('a.attr_value,b.attr_name')
                ->join('left join vip_attribute b on a.attr_id=b.id')
                ->where(array(
                    'a.id' => array('in',$v['goods_attr_id_list']),
                ))->select();
        }
        return $cartData;
    }
    /**
     * 用户登陆时,把购物车中的数据移动到数据库中
     * @param viod;
     */
    public function moveDataToDb(){
        // 1,接受会员Id
        $memberId = session('id');
        if($memberId){
            // 2,从COOKIE中取出购物车中的商品
            $cart = isset($_COOKIE['cart'])? unserialize($_COOKIE['cart']) : array();
            // 3,循环把每个商品移动到数据库中
            foreach($cart as $k => $v){
                // 4,从下标中获取商品Id和属性
                $_k = explode('-',$k);
                // 5,父类调用add方法写入数据库
                parent::add(array(
                    'member_id' => $memberId,
                    'goods_id' => $_k[0],
                    'goods_attr_id_list' => $_k[1],
                    'goods_number' => $v,
                ));
            }
            // 6,清理COOKIE
            setcookie('cart','',time()-1,'/');
        }
    }
    /**
     * 购物车列表页,ajax无刷新修改购买数量
     * @param $goods_id
     * @param $goods_attr_id
     * @param $goods_number;如果修改的数量为0 就是删除
     */
    public function updataCart($goodsId,$goodsAttrId = '' , $goodsNumber=0){
        $memberId = session('id');
        if($memberId){
            if($goodsNumber == 0){
                $this->where(array(
                    'goods_id' => $goodsId,
                    'goods_attr_id_list' => $goodsAttrId,
                ))->delete();
            }else{
                $this->where(array(
                    'goods_id' => $goodsId,
                    'goods_attr_id_list' => $goodsAttrId,
                ))->setField('goods_number',$goodsNumber);
            }
        }else{
            // 先从COOKIE中取出购物车的一位数组
            $cart = isset($_COOKIE['cart'])? unserialize($_COOKIE['cart']) : array();
            // 拼出下标
            $key = $goodsId . '-' . $goodsAttrId;
            if($goodsNumber == 0)
                unset($cart[$key]);
            else
                $cart[$key] = $goodsNumber;
            // 把数组存回COOKIE
            setcookie('cart',serialize($cart),time()+30*86400,'/');
        }
    }

    // 购物车清空方法,下订单成功后调用
    public function clear(){
        $memberId = session('id');
        $this->where(array(
            'member_id' => $memberId,
        ))->delete();
    }
}