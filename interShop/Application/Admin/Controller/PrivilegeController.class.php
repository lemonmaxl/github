<?php
namespace Admin\Controller;
//use Think\Controller;
class PrivilegeController extends BaseController
{
    public function add()
    {
    	if(IS_POST)
    	{
    		$model = D('Privilege');
    		if($model->create(I('post.'), 1))
    		{
    			if($id = $model->add())
    			{
    				$this->success('添加成功！', U('lst'));
    				exit;
    			}
    		}
    		$this->error($model->getError());
    	}
		$parentModel = D('Privilege');
		$parentData = $parentModel->getTree();
		$this->assign('parentData', $parentData);

		// 设置页面中的信息
		$this->assign(array(
		    'lst' => 4,
			'title_name' => '权限添加',
            'nav_pre_name' => '管理员管理',
            'nav_next_name' => '权限添加',
		));
		$this->display();
    }
    public function edit()
    {
    	$id = I('get.id');
    	if(IS_POST)
    	{
    		$model = D('Privilege');
    		if($model->create(I('post.'), 2))
    		{
    			if($model->save() !== FALSE)
    			{
    				$this->success('修改成功！', U('lst'));
    				exit;
    			}
    		}
    		$this->error($model->getError());
    	}
    	$model = M('Privilege');
    	$data = $model->find($id);
    	$this->assign('data', $data);
		$parentModel = D('Privilege');
		$parentData = $parentModel->getTree();
		$children = $parentModel->getChildren($id);
		$this->assign(array(
			'parentData' => $parentData,
			'children' => $children,
		));

		// 设置页面中的信息
		$this->assign(array(
            'lst' => 4,
			'title_name' => '权限修改',
            'nav_pre_name' => '管理员管理',
            'nav_next_name' => '权限修改',
		));
		$this->display();
    }
    public function delete()
    {
    	$model = D('Privilege');
    	if($model->delete(I('get.id', 0)) !== FALSE)
    	{
    		$this->success('删除成功！', U('lst'));
    		exit;
    	}
    	else 
    	{
    		$this->error($model->getError());
    	}
    }
    public function lst()
    {
    	$model = D('Privilege');
		$data = $model->getTree();
    	$this->assign(array(
    		'data' => $data,
    	));

		// 设置页面中的信息
		$this->assign(array(
			'title_name' => '权限列表',
            'nav_pre_name' => '管理员管理',
            'nav_next_name' => '权限列表',
		));
    	$this->display();
    }
}