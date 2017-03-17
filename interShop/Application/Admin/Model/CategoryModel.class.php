<?php
namespace Admin\Model;
use Think\Model;

class CategoryModel extends Model{
    // 1,设置允许接受的字段
    protected $insertFields = 'cat_name,parent_id,is_rec';
    // 设置修改时允许接受的字段
    protected $updateFields = 'id,cat_name,parent_id,is_rec';
    // 2,设置表单数句的验证规则
    protected $_validate =array(
        array('cat_name','require','分类名称不能为空!',1),
    );
    // 3,获取树形结构的数据
    public function getTree(){
        $data = $this->select();
        return $this->_getTree($data);
    }
    // 4,递归排序成树形
    private function _getTree($data,$parent_id=0,$level=0){
        static $_ret = array();
        foreach ($data as $k => $v){  // 循环数据
            if ($v['parent_id'] == $parent_id) {  
                $v['level'] = $level; // 判断parent_id=0就是最高级别
                $_ret[] = $v; // 把$v赋给空数组
                $this->_getTree($data,$v['id'],$level+1);
            }
        }
        return $_ret;
    }
    
    // 1,定义方法获得主分类下的所有子分类
    public function getChildren($catId){
        $data = $this->select();
        return $this->_getChildren($data,$catId,true);
    }
    // 2,递归获取子分类
    private function _getChildren($data,$parent_id,$isClear = false){
        static $_ret =array();
        if ($isClear) 
            $_ret = array();
        foreach ($data as $k => $v){
            if ($v['parent_id'] == $parent_id) {
                $_ret[] = $v['id']; // 如果删除的ID与父级ID相等,就把次分类ID存入空数组
                $this->_getChildren($data, $v['id']);
            }
        }
        return $_ret;
    }
    // 3,删除之前把子分类删除
    protected function _before_delete($options) {
        $children = $this->getChildren($options['where']['id']);
        if ($children) {
            $children = implode(',', $children);
            $this->execute("delete from vip_category where id in($children)");
        }
    }

    // 获取分类数据
    public function getNavData(){
        $data = $this->select();
        $ret = array();
       //dump($data);
        // 找出顶级分类
        foreach($data as $k => $v){
            // 父类Id为0就是顶级分类,存到空数组中
            if($v['parent_id'] == 0){
                // 找出二级分类
                foreach ($data as $k1 => $v1){
                    //父类Id为顶级分类的Id时,存到$v的children字段
                    if($v1['parent_id'] == $v['id']){
                        // 找出三级分类
                        foreach($data as $k2 => $v2){
                            // 二级分类的父类Id为二级的Id是,存到二级分类的children字段中
                            if($v2['parent_id'] == $v1['id']){
                                $v1['children'][] = $v2;
                            }
                        }
                        $v['children'][] = $v1;
                    }
                }
                $ret[] = $v;
            }
        }
        return $ret;
    }

    // 获取推荐的分类楼层
    public function getRecCat(){
         $data = $this->where(array(
            'is_rec' => array('eq','是'),
            'parent_id' => array('eq',0),
        ))->select();
        // 循环每个楼层取出二级分类,并保存到subCat字段中
        foreach($data as $k => $v){
            $data[$k]['subCat'] = $this->where(array(
                'parent_id' => array('eq',$v['id']),
            ))->select();
            // 取出每个推荐的二级分类的八件商品
            foreach($data[$k]['subCat'] as $k1 => $v1){
                $data[$k]['subCat'][$k1]['goods'] = $this->getGoodsByCatId($v1['id'],6);
            }
        }

        return $data;
    }

    // 取出一个分类下的商品
    public function getGoodsByCatId($catId,$limit){
        // 1,获取一个分类下的所有子分类
        $children = $this->getChildren($catId);
        // 2,把分类Id组合在$children字段中
        $children[] = $catId;
        // 3,链表查询
        $gModel = D('Goods');
        return $gModel->field('id,goods_name,logo,sm_logo,shop_price')->where(array(
            'cat_id' => array('in',$children),
            'is_on_sale' => array('eq',1),
        ))->limit($limit)->select();

    }
    /**
     *获取当前分类的上级分类,面包屑导航
     * @param  $catId 当前分类Id
     */
    public function getParentCatByCatId($catid){
        // 1,静态变量保存信息
        static $ret = array();
        // 2,获取当前分类的所有信息,(分类表)
        $info = $this->find($catid);
        // 3,把获取的分类信息插入空数组的开头位置
        array_unshift($ret,$info);// 入栈开头
        // 4,如果当前分类的父级Id不为零,说明他还有上级分类,就继续调用此方法
        if($info['parent_id'] > 0){
            $this->getParentCatByCatId($info['parent_id']);
        }
        // 5,返回数据
        return $ret;

    }
}
