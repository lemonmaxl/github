<?php
namespace Admin\Controller;
//use Think\Controller;
/**
 * 商品控制器,对商品的增删改查
 */
class GoodsController extends BaseController {
//    商品添加方法
    public function add(){
//        判断表单是否提交
        if(IS_POST){
            //dump($_POST);die;
            // 实例化goods模型
            $model = D('Goods');
            if($model->create(I('post.'),1)){
                if($model->add()){
                    $this->success('商品添加成功',U('lst'));
                    exit;
                }
            }else{
                $this->error($model->getError());
            }
        }

        // 1,取出所有的分类
        $catModel = D('Category');
        $catData = $catModel->getTree();
        // 2,取出所有的类型
        $typeModel = M('Type');
        $typeData = $typeModel->select();
        // 3,取出会员级别
        $mlModel = M('MemberLevel');
        $mlData = $mlModel->select();
        $this->assign(array(
            'mlData' => $mlData,
            'typeData' => $typeData,
            'catData' => $catData,
            'lst' => 1,
            'title_name' => '商品添加',
            'nav_pre_name' => '商品管理',
            'nav_next_name' => '商品添加',
        ));
        $this ->display();
    }
    
    public function lst(){
        // 获取所有的分类
        $catModel = D('Category');
        $catData = $catModel->getTree();
        $this->assign('catData', $catData);

        // 获取所有的商品
        $model = D('Goods');
        $gdata = $model->search();
        //dump($gdata);
        
        $this->assign(array(
            'gdata'=> $gdata['data'],
            'show' => $gdata['show'],
            'title_name' => '商品列表',
            'nav_pre_name' => '商品管理',
            'nav_next_name' => '商品列表',
        ));
        $this->display();
    }
    
    public function edit(){
        // 获取id值
        $id = I('get.id');
        $model = D('Goods');
        // 表单提叫后
        if(IS_POST){
            if($model->create(I('post.'),2)){
                if(FALSE !== $model->save()){
                    $this->success('修改成功',U('lst'));
                    exit;
                }
            }else{
                $this->error($model->getError());
            }
        }

        // 获取所有的分类
        $catModel = D('Category');
        $catInfo = $catModel->getTree();
        // 取出商品所在的扩展分类Id
        $gcModel = D('GoodsCat');
        $extCatId = $gcModel->field('cat_id')->where(array(
            'goods_id' => array('eq',$id),
        ))->select();
        // 取出所有的类型
        $typeModel = M('Type');
        $typeData = $typeModel->select();
        $this->assign('typeData',$typeData);

        // 通过id获取商品的信息
        $ginfo = $model->find($id); 
        //dump($ginfo);
        // 取出当前商品所在类型下的所有属性以及属性值
        if($ginfo['type_id'] != 0){
            $attrModel = M('Attribute');
            $attrData = $attrModel->alias('a')->
            field('a.id,a.attr_name,a.attr_type,a.attr_option_value,b.*')
            ->join('left join vip_goods_attr b on (a.id=b.attr_id and b.goods_id='.$id.')')
            ->where(array(
                'type_id' => array('eq',$ginfo['type_id']),
            ))->select();
            $this->assign('attrData',$attrData);
            //dump($attrData);
        }
        // 取出商品相册信息
        $gpModel = M('GoodsPic');
        $gpData = $gpModel->field('id,mid_pic')->where(array(
            'goods_id' => array('eq',$id),
        ))->select();
        $this->assign('gpData',$gpData);
        // 3,取出会员级别
        $mlModel = M('MemberLevel');
        $mlData = $mlModel->select();
        // 4,取出已设置好的会员价格数据
        $mpModel = M('MemberPrice');
        $mpData = $mpModel->where('goods_id='.$id)->select();
        // 5,二维数组转一维数组
        $_mpData = array();
        foreach ($mpData as $k => $v){
            $_mpData[$v['level_id']] = $v['price'];
        }
        //dump($_mpData);
        $this->assign('mpData',$_mpData);
        $this->assign(array(
            'mlData' => $mlData,
            'extCatId' => $extCatId,
            'catInfo' => $catInfo,
            'ginfo' => $ginfo,
            'lst' => 1,
            'title_name' => '商品编辑',
            'nav_pre_name' => '商品管理',
            'nav_next_name' => '商品编辑',
        ));
        $this->display();
    }
    
    // 商品删除方法
    public function del(){
        // 获取要删除的ID
        $id = I('get.id');
        
        $model = D('Goods');
        if(FALSE !== $model->delete($id)){
            $this->success ('删除成功!', U('lst'));
            exit;
        }
        else {
            $this->error('删除失败!', U('lst'));
        }
    }
    // 库存量方法
    public function goods_number(){
        /*******获取提交的参数,进行组合存入数据库**********/
        $id = I('get.id');
        $gnModel = M('GoodsNumber');
        if (IS_POST){
            // 添加之前删除原数据
            $gnModel->where('goods_id='.$id)->delete();
            $gaid = I('post.gaid');
            $gn = I('post.gn');
            $gaidCount = count($gaid);
            $gnCount = count($gn);
            $rate = $gaidCount/$gnCount;
            $_i = 0;
            foreach($gn as $k => $v){
                $isempty=false;
                $_arr_list = array();
                for ($i=0;$i<$rate;$i++){
                    if(empty($gaid[$_i])){
                        $isempty = true;
                    }
                    $_arr_list[] = $gaid[$_i];
                    $_i++;
                }
                if (empty($v) || $isempty){
                    continue;
                }
                sort($_arr_list);
                $_arr_list = implode(',',$_arr_list);
                $gnModel->add(array(
                    'goods_id' => $id,
                    'goods_number' => $v,
                    'attr_list' => $_arr_list,
                ));
            }
            $this->success('添加库存成功!',U('lst'));
            exit;
        }
        // 先获取这件商品所有非单选的属性
        $gaModel = M('GoodsAttr');
        $gaInfo = $gaModel -> alias('a')->field('a.*,b.attr_name')
            ->join('left join vip_attribute b on a.attr_id=b.id')
            ->where(array(
                'a.goods_id' => $id,
                'b.attr_type' => '可选',
            ))->select();
        //dump($gaInfo);
        // 把同属性的Id的数据放到一起,转换为三位数组
        $_gaInfo = array();
        foreach ($gaInfo as $k => $v){
            $_gaInfo[$v['attr_id']][] = $v;
        }
        //dump($_gaInfo);

        // 取出已经设置好的库存量数据
        $gnData = $gnModel->where('goods_id='.$id)->select();
        $this->assign(array(
            'gnData' => $gnData,
            'gaInfo' => $_gaInfo,
            'lst' => 1,
            'title_name' => '库存量管理',
            'nav_pre_name' => '商品管理',
            'nav_next_name' => '库存量管理',
        ));
        $this->display();
    }

    // 处理ajax请求的方法(通过类型获得属性)
    public function ajaxGetAttr(){
        $typeId = I('get.type_id');
        $attrModel = M('Attribute');
        $attrData = $attrModel->where(array(
            'type_id' => array('eq',$typeId),
        ))->select();
        echo json_encode($attrData);
    }
    // ajax删除商品属性
    public function ajaxDelGoodsAttr()
    {
        $gaid = I('get.gaid');
        $gaModel = D('goods_attr');
        $gaModel->delete($gaid);
    }
    // ajax删除商品相册图片
    public function ajaxDelImage(){
        $pid = I('get.pic_id');
        $gpModel = M('GoodsPic');
        $pic = $gpModel->field('pic,sm_pic,mid_pic,big_pic')->find($pid);
        $gpModel->delete($pid);
    }

}
