<?php
namespace Home\Model;
use Think\Model;

class CommentModel extends Model{
    // 发表评论时允许接受的字段
    protected $insertFields = 'goods_id,content,star,yx_name';
    // 发表评论时的验证规则
    protected $_validate = array(
        array('content','require','评论不能为空!',1),
        array('star','require','分值不能为空!',1),
        array('star','1,2,3,4,5','分值只能是1-5分!',1,'in'),
    );
    // 发表评论是之前需要补上的字段
    protected function _before_insert(&$data,$option){
        $data['addtime'] = time();
        $data['member_id'] = session('id');
    }
    // 处理买家印象
    protected function _after_insert($data,$option){
        /**************插入评论后 处理印象数据*************************/
        $yxName = I('post.yx_name');
        if($yxName){
            $yxName = str_replace('，',',',$yxName); // 替换中文标点
            $yxName = explode(',',$yxName); // 字符串变为数组
            $yxName = array_unique($yxName); // 去除重复的元素
            $impModel = D('Impression');
            foreach ($yxName as $k => $v){
                // 判断是否为空
                if (empty($v)){
                    continue;
                }
                // 先判断这个商品是否已经有这个印象了
                $imp = $impModel->field('id')->where(array(
                    'goods_id' => $data['goods_id'],
                    'yx_name' => $v,
                ))->find();
                if ($imp)
                    $impModel->where(array(
                        'id' => array('eq',$imp['id']),
                    ))->setInc('yx_count');// 有的印象基础上增加印象
                else
                    $impModel->add(array(
                        'goods_id' => $data['goods_id'],
                        'yx_name' => $v,
                        'yx_count' => 1,
                    ));
            }
        }
    }

    // 获取评论实现翻页功能
    // @param $goodsId : 商品的Id
    public function search($goodsId){
        // 1,每页显示条数
        $perPage = 5;
        // 2,接受当前页
        $p = max(1, I('get.p',1));
        // 9,计算好评率,如果是第一页就计算***************************
        if($p == 1){
            //(1) 取出这件商品所有的打分
            $stars = $this->field('star')->where(array(
                'goods_id' => $goodsId,
            ))->select();
            // (2),设置三个评分级别
            $well = 0;
            $bad = 0;
            $can = 0;
            foreach ($stars as $k => $v){
                if($v['star'] <3)
                    $bad++;
                elseif($v['star'] ==3)
                    $can++;
                else
                    $well++;
            }
            //(3),算出百分数
            $total = $well+$can+$bad;
            $well = round($well / $total * 100,1);
            $can = round($can / $total *100,1);
            $bad = round($bad / $total *100 ,1);
            // (4),取出印象数据
            $impModel = D('impression');
            $impData = $impModel->where(array(
                'goods_id' => $goodsId,
                ))->select();
        }

        // 3,取出总的记录数
        $count = $this->where(array(
            'goods_id' => $goodsId,
        ))->count();
        // 4,计算偏移量
        $offset = ($p - 1)*$perPage;
        // 5,计算总的页数
        $pageNumber = ceil($count/$perPage);
        // 6,去某一页数据
        $data = $this->alias('a')
            ->field('a.id,a.content,FROM_UNIXTIME(a.addtime,"%Y-%m-%d %H:%i:%s") addtime,a.good_number,b.username')
            ->join('left join __MEMBER__ b on a.member_id=b.id')
            ->where(array(
                'goods_id' => array('eq',$goodsId),
            ))->limit("$offset,$perPage")
            ->order('id DESC')->select();
        // 7,调试打印sql
        //echo $this->getLastSql();
        // 8,返回数据
        return array(
            'data' => $data, // 品论数据
            'pageNumber' => $pageNumber, // 总的记录数
            'well' => $well,
            'can' => $can,
            'bad' => $bad,
            'impData' => $impData,
        );
    }
}