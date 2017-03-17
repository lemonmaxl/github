<?php
namespace Admin\Controller;
//use Think\Controller;

/**
 * Description of CategoryController
 *
 * @author Administrator
 */
class CategoryController extends BaseController{
    // 获取分类列表
    public function lst(){
        $model = D('Category');
        $data = $model->getTree();
        //dump($data);
        $this->assign(array(
            'data' => $data,
            'title_name' => '分类列表',
            'nav_pre_name' => '商品管理',
            'nav_next_name' => '分类列表',
        ));
        $this->display();
    }
    
    // 删除分类方法
    public function del(){
        // 1,获取分类ID
        $catId = I('get.id');
        // 2,删除分类,触发删除之前钩子函数
        $model = D('Category');
        if (false !== $model->delete($catId)) {
            $this->success('删除分类成功!');
            exit;
        } else {
            $this->error('删除失败!');
        }
    }
    
    // 添加分类
    public function add(){
        $model = D('Category');
        // 判断表单提交动作
        if (IS_POST) {
            
            if($model->create(I('post.'),1)){
                if($model->add()){
                    $this->success('添加分类成功!',U('lst'));
                    exit;
                }
            }else{
                $this->error($model->getError());
            }
        }
        // 取出所有的分类
        $data = $model->getTree();
        
        // 设置页面信息
        $this->assign(array(
            'data' => $data,
            'lst' => 2,
            'title_name' => '分类添加',
            'nav_pre_name' => '商品管理',
            'nav_next_name' => '分类添加',
        ));
        $this->display();
    }
    
    // 修改分类
    public function edit(){
        // 1,接收修改的ID
        $id = I('get.id');
        // 2,处理表单数据
        if (IS_POST) {
            $model = D('Category');
            if ($model->create(I('post.'),2)) {
                if (false !== $model->save()) {
                    $this->success('修改成功',U('lst'));
                    exit;
                }
            }else{
                $this->error($model->getError());
            }   
        }
        // 3,根据ID取出信息
        $catModel = D('Category');
        $info = $catModel->find($id);
        //dump($info);
        // 4,取出所有的分类
        $data = $catModel->getTree();
        // 5,取出当前ID的所有子分类ID,在下拉框中不显示
        $children = $catModel->getChildren($id);
        // 6,显示在模板中
        $this->assign('info',$info);
        $this->assign('data',$data);
        $this->assign('children',$children);
        
        
        $this->assign(array(
            'lst' => 2,
            'title_name' => '分类修改',
            'nav_pre_name' => '商品管理',
            'nav_next_name' => '分类修改',
        ));
        $this->display();
    }
}
