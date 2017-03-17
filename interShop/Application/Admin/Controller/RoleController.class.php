<?php
namespace Admin\Controller;
//use Think\Controller;
class RoleController extends BaseController{

    public function add(){
    	if(IS_POST) {
    		$model = D('Role');
    		if($model->create(I('post.'), 1)) {
    			if($id = $model->add()) {
    				$this->success('添加成功！', U('lst'));
    				exit;
    			}
    		}
    		$this->error($model->getError());
    	}

    	// 1,取出所有的权限
        $priModel = D('Privilege');
    	$priData = $priModel->getTree();

		// 设置页面中的信息
		$this->assign(array(
		    'priData' => $priData,
		    'lst' => 5,
			'title_name' => '角色添加',
            'nav_pre_name' => '管理员管理',
            'nav_next_name' => '角色添加',
		));
		$this->display();
    }

    public function edit(){
    	$id = I('get.id');
    	if(IS_POST) {
    		$model = D('Role');
    		if($model->create(I('post.'), 2)) {
    			if($model->save() !== FALSE) {
    				$this->success('修改成功！', U('lst'));
    				exit;
    			}
    		}
    		$this->error($model->getError());
    	}
    	$model = M('Role');
    	$data = $model->find($id);
    	$this->assign('data', $data);

        // 1,取出所有的权限
        $priModel = D('Privilege');
        $priData = $priModel->getTree();
        // 2,根据角色权限表取出当前角色所拥有的所有的权限Id
        $rpModel = M('RolePri');
        $pri_id = $rpModel->field('GROUP_CONCAT(pri_id) pri_id')->where(array(
            'role_id' => array('eq', $id),
        ))->find();
        //dump($pri_id);
        // 3,把获取的权限Id字符串,转化为数组
        $pri_id = explode(',',$pri_id['pri_id']);
        //dump($pri_id);
		// 设置页面中的信息
		$this->assign(array(
		    'pri_id' => $pri_id,
		    'priData' => $priData,
		    'lst' => 5,
			'title_name' => '角色修改',
            'nav_pre_name' => '管理员管理',
            'nav_next_name' => '角色修改',
		));
		$this->display();
    }

    public function delete(){
    	$model = D('Role');
    	if($model->delete(I('get.id', 0)) !== FALSE) {
    		$this->success('删除成功！', U('lst'));
    		exit;
    	} else {
    		$this->error($model->getError());
    	}
    }

    public function lst(){
    	$model = D('Role');
    	$data = $model->search();
    	//dump($data);
    	$this->assign(array(
    		'data' => $data['data'],
    		'page' => $data['page'],
    	));
        // 1,获取所有的角色权限信息,然后组合
		// 设置页面中的信息
		$this->assign(array(
			'title_name' => '角色列表',
            'nav_pre_name' => '管理员管理',
            'nav_next_name' => '角色列表',
		));
    	$this->display();
    }
}