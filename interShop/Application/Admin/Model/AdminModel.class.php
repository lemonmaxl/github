<?php
namespace Admin\Model;
use Think\Model;
class AdminModel extends Model 
{
	protected $insertFields = array('username','password','code');
	protected $updateFields = array('id','username','password');
	// 管理员登录是的验证规则
    public $_logo_validate = array(
        array('code','require','验证码不能为空!',1),
        array('code','chk_code','验证码不正确!',1,'callback'),
        array('username','require','用户名不能为空!',1),
        array('password','require','密码不能为空!',1),
    );
	// 添加和修改管理员是使用的验证规则
	protected $_validate = array(
		array('username', 'require', '帐号不能为空！', 1, 'regex', 3),
		array('username', '1,30', '帐号的值最长不能超过 30 个字符！', 1, 'length', 3),
		array('password', 'require', '密码不能为空！', 1, 'regex', 3),
		array('password', '1,32', '密码的值最长不能超过 32 个字符！', 1, 'length', 3),
	);

	// 1,判断是否有权限访问当前页面
    public function chk_pri(){
        // 2,后台首页可以直接访问
        if (CONTROLLER_NAME == 'Index')
            return true;
        $id = session('id'); //管理员Id
        // 3,超级管理员有所有的权限
        if ($id ==1)
            return true;
        // 4,查询一个管理员是否有权限访问的sql:1,根据管理员Id查询角色的Id,2.根据角色Id查询所用的权限,3.判断是否有一个权限和当前地址对应
        //select * from vip_admin_role a left join vip_role_pri b on a.role_id=b.role_id left join vip_privilege c on b.pri_id=c.id
        $sql = 'select count(c.id) has from vip_admin_role a';
        $sql .= ' LEFT JOIN vip_role_pri b ON a.role_id=b.role_id LEFT JOIN vip_privilege c ON b.pri_id=c.id';
        $sql .= ' where a.admin_id='.$id.' and c.module_name="'.MODULE_NAME.'" and c.controller_name="'.CONTROLLER_NAME.'" and c.action_name="'.ACTION_NAME.'"';

        //echo $sql;
        // 5,返回的是一个二维数组,同select方法一样,
        $has = $this->query($sql);
        //dump($has);
        return ($has[0]['has'] > 0);
    }
    // 1,取出当前管理员所拥有的前两级权限
    public function getBtns(){
        /****************取出当前管理员所拥有的前两级权限***********************/
        $id = session('id'); // 当前管理员Id
        $priModel = M('Privilege');
        // 2,判断是否是超级管理员
        if ($id == 1)
            $priData = $priModel -> select();
        else{
            // 通过管理员Id去角色Id,通过角色Id去权限
            $sql = 'select c.* from vip_admin_role a';
            $sql .= ' left join vip_role_pri b on a.role_id=b.role_id left join vip_privilege c on b.pri_id=c.id';
            $sql .= ' where a.admin_id='.$id;
            $priData = $this->query($sql);
        }
        //dump($priData);
        /***************从所有权限中取出前两级的权限****************************/
        $ret = array(); // 取出的两级权限放到空数组中
        // 3,循环当前管理员所有的权限
        foreach ($priData as $k => $v){
            // 4,取出顶级权限
            if($v['parent_id'] == 0){
                // 6,在循环取出顶级的子级权限
                foreach ($priData as $k1 => $v1) {
                    if($v['id'] == $v1['parent_id']){
                        // 7,把二级权限放到顶级权限的children数组中
                        $v['children'][] = $v1;
                    }
                }
                // 5,把顶级权限放到另一个数组中
                $ret[] = $v;
            }
        }
        return $ret;
    }

	// 验证码验证方法
    protected function chk_code($code){
        $verify = new \Think\Verify();
        return $verify->check($code);
    }
    // 登录的方法
    public function login(){
        // 1,现取出用户提交的用户名和密码
        // cereate方法会把表单的数据保存在模型中,所以直接在模型中取
        $username = $this->username;
        $pwd = $this->password;
        // 2,帐号是否存在
        $user = $this->where(array(
            'username' => array('eq',$username),
        ))->find();
        if ($user){
            // 3,验证密码是否正确
            if (md5($pwd) == $user['password']){
                // 4,把成功登录的信息存入session中
                session('username',$user['username']);
                session('id',$user['id']);
                return true;
            }else{
                $this->error = '密码错误';
                return false;
            }
        }else{
            $this->error = '用户名不存在';
            return false;
        }
    }
	public function search($pageSize = 20)
	{
		/**************************************** 搜索 ****************************************/
		$where = array();
		if($username = I('get.username'))
			$where['username'] = array('like', "%$username%");
		/************************************* 翻页 ****************************************/
		$count = $this->alias('a')->where($where)->count();
		$page = new \Think\Page($count, $pageSize);
		// 配置翻页的样式
		$page->setConfig('prev', '上一页');
		$page->setConfig('next', '下一页');
		$data['page'] = $page->show();
		/************************************** 取数据 ******************************************/
		$data['data'] = $this->alias('a')->where($where)->group('a.id')->limit($page->firstRow.','.$page->listRows)->select();
		return $data;
	}
	// 添加前
	protected function _before_insert(&$data, $option){
	    // 1,添加管理员是把密码加密
        $data['password'] = md5($data['password']);
	}

	// 添加后
    protected function _after_insert($data,$options){
	    /**************处理角色和管理员的表,在添加管理员之后写入角色数据***************/
	    // 1,获取添加的角色Id
        $rid = I('post.rid');
        // 2,如果有Id
        if($rid){
            $arModel = M('AdminRole');
            foreach ($rid as $v){
                $arModel->add(array(
                    'admin_id' => $data['id'],
                    'role_id' => $v,
                ));
            }
        }

    }
	// 修改前
	protected function _before_update(&$data, $option){
        // 1,添加管理员是把密码加密
        $data['password'] = md5($data['password']);

        /******************修改管理员时先删除原来的角色信息在添加新的角色信息*************/
        // 1,删除原来数据
        $arModel = M('AdminRole');
        $arModel->where(array(
            'admin_id' => $option['where']['id'],
        ))->delete();
        // 2,接受现在数据
        $rid = I('post.rid');
        // 3,判断是否有数据,然后循环写入
        if($rid){
            foreach ($rid as $v){
                $arModel->add(array(
                    'admin_id' => $option['where']['id'],
                    'role_id' => $v,
                ));
            }
        }
	}
	// 删除前
	protected function _before_delete($option){
        /*********************删除管理员之前处理管理员的角色信息***************************/
        // 1,获取管理员Id
        // 2,根据Id删除所有的角色信息
        $arModel = M('AdminRole');
        $arModel->where(array(
            'admin_id' => $option['where']['id'],
        ))->delete();

		if(is_array($option['where']['id']))
		{
			$this->error = '不支持批量删除';
			return FALSE;
		}
	}
	/************************************ 其他方法 ********************************************/
}