<?php
namespace Admin\Controller;
use Think\Controller;
class MemberLevelController extends Controller 
{
    public function add()
    {
    	if(IS_POST)
    	{
    		$model = D('MemberLevel');
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
		    'lst' => 7,
			'title_name' => '会员级别添加',
            'nav_pre_name' => '会员管理',
            'nav_next_name' => '会员级添加',
		));
		$this->display();
    }
    public function edit()
    {
    	$id = I('get.id');
    	if(IS_POST)
    	{
    		$model = D('MemberLevel');
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
    	$model = M('MemberLevel');
    	$data = $model->find($id);
    	$this->assign('data', $data);

		// 设置页面中的信息
		$this->assign(array(
		    'lst' => 7,
			'title_name' => '会员级别修改',
            'nav_pre_name' => '会员管理',
            'nav_next_name' => '会员级别修改',
		));
		$this->display();
    }
    public function delete()
    {
    	$model = D('MemberLevel');
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
    	$model = D('MemberLevel');
    	$data = $model->search();
    	$this->assign(array(
    		'data' => $data['data'],
    		'page' => $data['page'],
    	));

		// 设置页面中的信息
		$this->assign(array(
			'title_name' => '会员级别列表',
            'nav_pre_name' => '会员管理',
            'nav_next_name' => '会员级别列表',
		));
    	$this->display();
    }
}