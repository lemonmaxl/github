<?php
namespace Admin\Controller;
use Think\Controller;
class AttributeController extends Controller 
{
    public function add()
    {
    	if(IS_POST)
    	{
    		$model = D('Attribute');
    		if($model->create(I('post.'), 1))
    		{
    			if($id = $model->add())
    			{
    				$this->success('添加成功！', U('lst?type_id='.I('get.type_id')));
    				exit;
    			}
    		}
    		$this->error($model->getError());
    	}
        // 取出所有的类型
        $typeModel = M('Type');
    	$typeData = $typeModel->select();

		// 设置页面中的信息
		$this->assign(array(
            'typeData' => $typeData,
			'title_name' => '属性添加',
            'nav_pre_name' => '类型管理',
            'nav_next_name' => '属性添加',
		));
		$this->display();
    }
    public function edit()
    {
    	$id = I('get.id');
    	if(IS_POST)
    	{
    		$model = D('Attribute');
    		if($model->create(I('post.'), 2))
    		{
    			if($model->save() !== FALSE)
    			{
    				$this->success('修改成功！', U('lst?type_id='.I('get.type_id')));
    				exit;
    			}
    		}
    		$this->error($model->getError());
    	}
    	$model = M('Attribute');
    	$data = $model->find($id);
    	$this->assign('data', $data);

        // 取出所有的类型
        $typeModel = M('Type');
        $typeData = $typeModel->select();

		// 设置页面中的信息
		$this->assign(array(
		    'typeData' => $typeData,
			'title_name' => '属性修改',
            'nav_pre_name' => '类型管理',
            'nav_next_name' => '属性修改',
		));
		$this->display();
    }
    public function delete()
    {
    	$model = D('Attribute');
    	if($model->delete(I('get.id', 0)) !== FALSE)
    	{
    		$this->success('删除成功！', U('lst?type_id='.I('get.type_id')));
    		exit;
    	}
    	else 
    	{
    		$this->error($model->getError());
    	}
    }
    public function lst()
    {
    	$model = D('Attribute');
    	$data = $model->search();

    	// 取出所有的类型
        $typeModel = M('Type');
        $typeData = $typeModel->select();

    	$this->assign(array(
    		'data' => $data['data'],
    		'page' => $data['page'],
    	));

		// 设置页面中的信息
		$this->assign(array(
            'typeData' => $typeData,
			'title_name' => '属性列表',
            'nav_pre_name' => '类型管理',
            'nav_next_name' => '属性列表',
		));
    	$this->display();
    }
}