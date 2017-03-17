<?php
namespace Admin\Controller;
//use Think\Controller;
class AdminController extends BaseController{
    public function add(){
    	if(IS_POST) {
    		$model = D('Admin');
    		if($model->create(I('post.'), 1)) {
    			if($model->add()) {
    				$this->success('添加成功！', U('lst'));
    				exit;
    			}
    		}
    		$this->error($model->getError());
    	}
        // 管理员与角色的关系
        // 1,取出所有的角色
        $rModel = M('Role');
    	$rData = $rModel->select();
    	//dump($rData);
		// 设置页面中的信息
		$this->assign(array(
		    'rData' => $rData,
		    'lst' => 3,
			'title_name' => '管理员添加',
            'nav_pre_name' => '管理员管理',
            'nav_next_name' => '管理员添加',
		));
		$this->display();
    }
    public function edit(){
    	$id = I('get.id');
    	if(IS_POST) {
    		$model = D('Admin');
    		if($model->create(I('post.'),2)) {
    			if($model->save() !== FALSE) {
    				$this->success('修改成功！', U('lst'));
    				exit;
    			}
    		}
    		$this->error($model->getError());
    	}
    	$model = M('Admin');
    	$data = $model->find($id);
    	$this->assign('data', $data);
        // 管理员与角色的关系
        // 1,取出所有的角色
        $rModel = M('Role');
        $rData = $rModel->select();

        // 2,取出当前管理员所在的角色的Id
        $arModel = M('AdminRole');
        $role_id = $arModel->field('GROUP_CONCAT(role_id) rid')->where(array(
            'admin_id' => array('eq',$id),
        ))->find();
        //dump($role_id);
        // 3,取出的字符串角色Id,变为数组
        $role_id = explode(',',$role_id['rid']);
        //dump($role_id);
		// 设置页面中的信息
		$this->assign(array(
		    'role_id' => $role_id,
		    'rData' => $rData,
		    'lst' => 3,
			'title_name' => '管理员修改',
            'nav_pre_name' => '管理员管理',
            'nav_next_name' => '管理员修改',
		));
		$this->display();
    }
    public function delete(){
    	$model = D('Admin');
    	if($model->delete(I('get.id', 0)) !== FALSE) {
    		$this->success('删除成功！', U('lst'));
    		exit;
    	} else {
    		$this->error($model->getError());
    	}
    }
    public function lst(){
    	$model = D('Admin');
    	$data = $model->search();
    	$this->assign(array(
    		'data' => $data['data'],
    		'page' => $data['page'],
    	));

		// 设置页面中的信息
		$this->assign(array(
			'title_name' => '管理员列表',
            'nav_pre_name' => '管理员管理',
            'nav_next_name' => '管理员列表',
		));
    	$this->display();
    }



}