<?php
namespace Admin\Controller;
use Think\Controller;
class TypeController extends Controller 
{
    public function add()
    {
    	if(IS_POST)
    	{
    		$model = D('Type');
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

		// 设置页面中的信息
		$this->assign(array(
		    'lst' => 6,
			'title_name' => '类型添加',
            'nav_pre_name' => '商品管理',
            'nav_next_name' => '类型添加',
		));
		$this->display();
    }
    public function edit()
    {
    	$id = I('get.id');
    	if(IS_POST)
    	{
    		$model = D('Type');
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
    	$model = M('Type');
    	$data = $model->find($id);
    	$this->assign('data', $data);

		// 设置页面中的信息
		$this->assign(array(
            'lst' => 6,
			'title_name' => '类型修改',
            'nav_pre_name' => '商品管理',
            'nav_next_name' => '类型修改',
		));
		$this->display();
    }
    public function delete()
    {
    	$model = D('Type');
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
    	$model = D('Type');
    	$data = $model->search();
    	$this->assign(array(
    		'data' => $data['data'],
    		'page' => $data['page'],
    	));

		// 设置页面中的信息
		$this->assign(array(
			'title_name' => '类型列表',
            'nav_pre_name' => '商品管理',
            'nav_next_name' => '类型列表',
		));
    	$this->display();
    }
}