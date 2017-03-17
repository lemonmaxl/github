<?php
namespace Admin\Model;
use Think\Model;
class RoleModel extends Model 
{
	protected $insertFields = array('role_name');
	protected $updateFields = array('id','role_name');
	protected $_validate = array(
		array('role_name', 'require', '角色名称不能为空！', 1, 'regex', 3),
		array('role_name', '1,30', '角色名称的值最长不能超过 30 个字符！', 1, 'length', 3),
	);
	public function search($pageSize = 20)
	{
		/**************************************** 搜索 ****************************************/
		$where = array();
		if($role_name = I('get.role_name'))
			$where['role_name'] = array('like', "%$role_name%");
		/************************************* 翻页 ****************************************/
		$count = $this->alias('a')->where($where)->count();
		$page = new \Think\Page($count, $pageSize);
		// 配置翻页的样式
		$page->setConfig('prev', '上一页');
		$page->setConfig('next', '下一页');
		$data['page'] = $page->show();
		/************************************** 取数据 ******************************************/
		//$sql = "SELECT a.*,GROUP_CONCAT(c.pri_name) pri_name FROM vip_role a
        // left join vip_role_pri b on a.id=b.role_id left join vip_privilege c on c.id=b.pri_id GROUP BY a.id";
		$data['data'] = $this->alias('a')
            ->field('a.*,GROUP_CONCAT(c.pri_name) pri_name')
            ->join('left join vip_role_pri b on a.id=b.role_id left join vip_privilege c on c.id=b.pri_id')
            ->where($where)
            ->group('a.id')
            ->limit($page->firstRow.','.$page->listRows)
            ->select();
		//echo $this->getLastSql();
		return $data;
	}
	// 添加前
	protected function _before_insert(&$data, $option)
	{
	}
	// 添加后
    protected function _after_insert($data,$option){
	    /************ 添加角色之后处理权限数据****************/
	    // 1,接受权限Id数据
        $pri_id = I('post.pri_id');
        // 2,判断是否有数据
        if($pri_id){
            $rpModel = M('RolePri');
            foreach ($pri_id as $v){
                $rpModel->add(array(
                    'role_id' => $data['id'],
                    'pri_id' => $v,
                ));
            }
        }
    }
	// 修改前
	protected function _before_update(&$data, $option){
        /*************修改角色的权限之前先删除之前角色所有的权限,然后在添加新的数据*****************/
        // 1,删除原来的权限信息
        $rpModel = M('RolePri');
        $rpModel->where(array(
            'role_id' => $option['where']['id'],
        ))->delete();
        // 2,获取修改后的权限信息
        $pri_id = I('post.pri_id');
        // 3,如果存在信息,就循环写入数据
        if ($pri_id){
            foreach ($pri_id as $v){
                $rpModel->add(array(
                    'role_id' => $option['where']['id'],
                    'pri_id' => $v,
                ));
            }
        }
	}
	// 删除前
	protected function _before_delete($option){
	    /******************删除角色之前先把角色所拥有的权限删除**********************/
	    $rpModel = M('RolePri');
	    $rpModel->where(array(
	        'role_id' => $option['where']['id'],
        ))->delete();

		if(is_array($option['where']['id']))
		{
			$this->error = '不支持批量删除';
			return FALSE;
		}
	}
	/************************************ 其他方法 ********************************************/
}