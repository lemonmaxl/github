<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        /***************取出促销的商品******************/
        $gModel = D('Admin/Goods');
        $pro_data = $gModel->getPromoteGoods();
        //dump($pro_data);
        /********************取出热卖推荐的商品***************/
        $hgoods = $gModel->getRecGoods('is_hot');
        $rgoods = $gModel->getRecGoods('is_rec');
        $ngoods = $gModel->getRecGoods('is_new');
        /********* 楼层分类推荐***********************/
        $catModel = D('Admin/Category');
        $recCat = $catModel->getRecCat();
        //dump($recCat);die;
        $this->assign(array(
            'recCat' => $recCat,
            'hgoods' => $hgoods,
            'rgoods' => $rgoods,
            'ngoods' => $ngoods,
            'pro_data' => $pro_data,
            '_page_title' => '好家唯品网',
            '_page_keywords' => '好家,唯品,生活空间',
            '_page_desc' => '给你缔造一个温馨的家',
        ));
        $this->display();
    }

    public function goods(){
        // 接受Id
        $id = I('get.id');
        $gModel = D('Admin/Goods');
        $info = $gModel->find($id);
        // 商品详情页取出相册
        $gpModel = D('GoodsPic');
        $gpData = $gpModel->where(array(
            'goods_id' => array('eq',$id),
        ))->select();

        // ******************取出所有的属性*******************
        $gaModel = D('GoodsAttr');
        // 1,链表查询,商品属性表,和属性表
        $gaData = $gaModel->alias('a')->field('a.*,b.attr_name,b.attr_type')->join('left join vip_attribute b on a.attr_id=b.id')
            ->where(array(
            'a.goods_id' => $id,
        ))->select();
        //dump($gaData);
        // 2,把属性分为两组,可选属性和唯一属性
        $uniArr = array();
        $raiArr = array();
        // 3,遍历获得的当前商品所拥有的可选和唯一属性的综合数据$gaData
        foreach($gaData as $k => $v){
            // 4,根据条件判断,唯一属性和多选属性,分离出来
            if($v['attr_type'] == '唯一'){
                $uniArr[] = $v;
            }else{
                // 用属性名作为下标$k,
                $raiArr[$v['attr_name']][] = $v;
            }
        }
        // ***********获取当前分类的上级分类
        $catModel = D('Admin/Category');
        $catData =$catModel->getParentCatByCatId($info['cat_id']);
        //dump($catData);
        //dump($uniArr);die;
        /***************取出浏览了这件商品的用户还浏览了那些商品*************************/
        $dhModel = D('DisplayHistory');
        $sql = 'select id,goods_name,shop_price,logo from vip_goods where id in (select goods_id from vip_display_history where member_id in(select member_id from vip_display_history where goods_id='.$id.'))';
        $goodsHis = $dhModel->query($sql);

        // 取出这个分类下商品的销量排行
        $xlGoods = $gModel->getTopGoods($info['cat_id']);
        $this->assign('xlGoods',$xlGoods);

        $this->assign(array(
            'goodsHis' => $goodsHis,
            'catData' => $catData,
            'uniArr' => $uniArr,
            'raiArr' => $raiArr,
            'info' => $info,
            'gpData' => $gpData,
            'imgpre' => C('IMAGE_PREFIX'),
            '_page_title' => '商品详情页',
            '_page_keywords' => '商品详情页',
            '_page_desc' => '商品详情页',
        ));
        $this->display();
    }

    // 取出最近浏览的商品
    public function ajaxDisplayHistory(){
        // 1,接受商品的Id
        $id = I('get.id');
        // 8,获取登录会员的Id
        $memberId = session('id');
        // 9,判断是否登录
        if ($memberId){
            $dhModel = D('DisplayHistory');
            // 登录就查找数据
            $viewd = $dhModel->field('id')->where(array(
                'goods_id' => $id,
                'member_id' => $memberId,
            ))->find();
            // 10,有数据,就写入浏览时间
            if($viewd){
                $dhModel->field('id')->where(array(
                    'id' => array('eq',$viewd['id']),
                ))->setField('view_time',time());
            }else{
                $dhModel->add(array('goods_id' => $id, 'member_id' => $memberId, 'view_time' => time(),));
            }
        }
        // 2,从cookies中取出最近浏览的商品Id的数组
        $viewGoodsId = isset($_COOKIE['viewGoodsId']) ? unserialize($_COOKIE['viewGoodsId']) : array();
        // 3,把信浏览的商品Id加到历史中
        array_unshift($viewGoodsId,$id);
        // 4,取出重复记录
        $viewGoodsId = array_unique($viewGoodsId);
        if(count($viewGoodsId) > 4){
            $viewGoodsId = array_slice($viewGoodsId,0,4);
        }
        // 5,把数组存回cookies
        setcookie('viewGoodsId',serialize($viewGoodsId),time()+30*86400,'/');
        // 6,返回最近浏览的七件商品的详细信息
        $viewGoodsId = implode(',',$viewGoodsId);
        // 7,查询商品信息(Id,在cookie中)
        $goodsModel = D('Goods');
        $data = $goodsModel->field('id,goods_name,logo,shop_price')->where(array(
            'id' => array('in',$viewGoodsId),
        ))->order("FIELD(id,$viewGoodsId)")->select();
        echo json_encode($data);
    }

}