<?php
namespace Home\Controller;
use Think\Controller;

class CommentController extends Controller{
    // ajax添加评论
    public function add(){
        $memberId = session('id');
        // 第三个参数设为true,返回json数据
        if(!$memberId){
            $this->error('请先登录!','',TRUE);
        }
        $model = D('Comment');
        if($model->create(I('post.'),1)){
            if($model -> add()){
                $this->success(array(
                    'username' => session('username'),
                    'face' => session('face'),
                    'content' => I('post.content'),
                    'addtime' => date('Y-m-d H:i:s'),
                    'star' => I('post.star'),
                ),'',TRUE);
                exit;
            }
        }
        $this->error($model->getError(),'',TRUE);
    }
    // 评论列表
    public function lst(){
        $model = D('Comment');
        $data = $model -> search(I('get.id'));
        $data['member_id'] = session('id');
        //dump($data);
        echo json_encode($data);
    }

    // 处理有用的方法
    public function ding(){
        $commentId = I('get.comment_id');
        $comModel = D('Comment');
        $comModel->where(array(
            'id' => array('eq',$commentId),
        ))->setInc('good_number');
    }
}