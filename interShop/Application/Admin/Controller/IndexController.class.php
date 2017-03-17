<?php
namespace Admin\Controller;
//use Think\Controller;
class IndexController extends BaseController {
    // 后台首页控制器
    public function index(){

        $this->display();
    }
    
    public function welcome(){
        $this->display();
    }
}