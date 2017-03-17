<?php
namespace Home\Controller;
use Think\Controller;

class SearchController extends Controller{
    public function cat_search(){
        // 调用后台商品模型的方法,获取分类搜索
        $goodsModel = D('Admin/Goods');
        $data = $goodsModel->home_search();
        // ***********获取当前分类的上级分类
        $catModel = D('Admin/Category');
        $catData =$catModel->getParentCatByCatId(I('get.cat_id'));
        //dump($catData);
        //dump($data);
        $this->assign($data);
        $this->assign(array(
            'catData' => $catData,
           '_page_title' => '好家唯品--商品查询',
            '_page_keywords' => '好家唯品,一个温馨的家',
            '_page_desc' => '好家唯品,一个温馨的家',
        ));
        $this->display();
    }
}