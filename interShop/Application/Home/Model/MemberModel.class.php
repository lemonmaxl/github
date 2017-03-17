<?php
namespace Home\Model;
use Think\Model;
class MemberModel extends Model{
    // 1,定义允许接受的字段
    protected $insertFields = 'username,password,cpassword,code';
    // 定义注册表单验证
    protected $_validate = array(
        array('username','require','用户名不能为空!',1),
        array('code','require','验证码不能为空!',1),
        array('code','chkcode','验证码不正确!',1,'callback'),
        array('password','require','密码不能为空!',1),
        array('cpassword','password','两次密码输入不一致!',1,'confirm'),
        array('username','','该用户名已存在!',1,'unique'),
    );
    // 登陆时的验证规则(要用公共的方法)
    public $login_validate = array(
      array('username','require','请填写用户名!',1),
      array('password','require','密码不能为空!',1),
        array('code','require','验证码不能为空!',1),
        array('code','chkcode','验证码输入不正确!',1,'callback'),
    );
    // 控制器调用模型login方法来验证用户名和密码的正确性
    public function chk_login(){
        $username = $this->username;
        $password = $this->password;
        $user = $this->where(array(
            'username' => array('eq',$username),
        ))->find();
        //dump($user);die;
        if($user){
            // 用户名存在验证密码
            if( $user['password'] == md5($password)){
                // 验证通过持久化
                session('id',$user['id']);
                session('username',$user['username']);
                // 登录成功时把购物车中的数据移动到数据库
                $cartModel = D('Cart');
                $cartModel->moveDataToDb();
                return true;
            }else{
                $this->error= '密码不正确!';
                return false;
            }
        }else{
            $this->error = '用户名不存在!';
            return false;
        }
    }
    // 验证验证码
    public function chkcode($code){
        $verify = new \Think\Verify();
        return $verify->check($code);
    }
    // 用户密码写入前加密
    protected function _before_insert(&$data,$option){
        $data['password'] = md5($data['password']);
    }
}