<?php
namespace Admin\Model;
use Think\Model;


class GoodsModel extends Model{
   // 设置允许接受的字段
   protected $insertFields = "goods_name,shop_price,market_price,goods_desc,is_on_sale,logo,cat_id,type_id,attr_id,promote_price,promote_start_date,promote_end_date,is_new,is_rec,is_hot";
   // 设置修改是接受字段
   protected $updateFields = "id,goods_name,shop_price,market_price,goods_desc,is_on_sale,logo,cat_id,type_id,attr_id,promote_price,promote_start_date,promote_end_date,is_new,is_rec,is_hot";
    // 添加商品表单的验证规则
    protected $_validate = array(
        array('goods_name','require','商品名称不能为空!',1),
        array('cat_id','require','必须要选择一个主分类!',1),
        array('shop_price','require','本店价格不能为空!',1),
        array('shop_price','currency','本店价格必须是货币格式!',1),
        array('market_price','currency','市场价格必须是货币格式!',1),
    );
    
    public function search($pagelist=10){
        /****************拼接搜索条件*************************/
        // 根据商品的名称搜索
        // 接受参数
        $where = array();
        $gName = I('get.gn');
        if($gName)
            $where['goods_name'] = array('like', "%$gName%");
        
        // 根据价格搜索
        // 接受价格参数
        $minP = I('get.minP'); // 最低价格
        $maxP = I('get.maxP'); // 最高价格
        
        // 判断是否最低价和最高级是否都有值
        if($minP && $maxP)
            $where['shop_price'] = array('BETWEEN',array($minP,$maxP));
        elseif($minP)
            $where['shop_price'] = array('EGT', $minP);
        elseif($maxP)
            $where['shop_price'] = array('ELT', $maxP);
        
        // 根据是否上架搜索
        // 接受参数
        $sale = I('get.sale');
        // 判断参数的值，进行筛选
        if($sale == '0' || $sale == '1')
            $where['is_on_sale'] = array('EQ' , $sale);

        // 根据分类搜索
        // 1,获取传参Id
        $cat_id = I('get.cat_id');
        if ($cat_id){
            // 2,现取出这个分类的所有子分类id
            $catModel = D('Category');
            $children = $catModel->getChildren($cat_id);
            // 3,分类Id和自分类Id放到一起
            $children[] = $cat_id;
            // 4,将数组转换为字符串
            $children = implode(',',$children);
            // 主分类或扩展分类在$children下的商品
            // 5,先从商品分类表中取出扩展分类下的商品id,组合为字符串
            $gcModel = M('GoodsCat');
            $extGoodsId = $gcModel->field('GROUP_CONCAT(goods_id) gid')->where(array(
                'cat_id' => array('in', $children),
            ))->find();
            // 6,组装查询的条件
            if ($extGoodsId['gid']){
                $orwhere = " or id in({$extGoodsId['gid']})";
            }else{
                $orwhere = '';
            }
            $where['cat_id'] = array('exp', "in ($children) $orwhere");
        }
       /****************实现排序*************************/ 
        // 接受参数
        $ob = I('get.ob');
        // id升序/降序，价格升序/降序
        $orderBy = 'id'; // 排序条件
        $orderWay = 'asc'; // 排序方法,默认升序
        if($ob == 'id_desc')
            $orderWay = 'desc';
        elseif($ob == 'price_desc'){
            $orderBy = 'shop_price';
            $orderWay = 'desc';
        }elseif($ob == 'price_asc')
            $orderBy = 'shop_price';
            
        /****************翻页功能*************************/
        $count      = $this->where($where)->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,$pagelist);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $show       = $Page->show();// 分页显示输出
        /****************取出数据*************************/
        $data = $this->alias('a')
                ->where($where)
                ->order("$orderBy $orderWay")
                ->limit($Page->firstRow.','.$Page->listRows)
                ->select();
        return array(
            'data' => $data,
            'show' => $show,
        );
    }
    
     // 插入数据前的回调方法
    protected function _before_insert(&$data,$options) {
        // 添加商品的描述时有选择的过滤
        $data['goods_desc'] = clearXSS($_POST['goods_desc']);
        // $data存的是表单的数据
        // 添加商品是的时间戳
        $data['addtime'] = time();
        //dump($_FILES);die;
        /**************处理表单中的logo图片***************************/
        // 判断用户有没有上传图片
        if (isset($_FILES['logo']) && $_FILES['logo']['error'] == 0) {
            $upload = new \Think\Upload();// 实例化上传类    
            $upload->maxSize   = 2*1024*1024;// 设置附件上传大小    
            $upload->exts      = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型   
            $upload->rootPath =  './Public/Uploads/';  // 文件上传保存的根路径
            $upload->savePath  = 'Goods/'; // 文件上传的保存路径（相对于根路径）
            
            // 上传文件
            $info   =   $upload->upload();  // 上传文件的信息的保存--数组
            //dump($info);die;
            if ($info) {
                /*****************生成缩略图*********************************/
                // 1,取出上传图片的路径和名称
                $logo = $info['logo']['savepath'] . $info['logo']['savename'];
                // 2,拼出缩略图的名字
                $sm_logo = $info['logo']['savepath'] . 'sm_' . $info['logo']['savename'];
                // 3,生成缩略图
                $image = new \Think\Image(); 
                $image->open('./Public/Uploads/'.$logo);
                $image->thumb(130, 130)->save('./Public/uploads/'.$sm_logo);
                //$image->thumb(320, 320)->save('./Public/uploads/'.$mid_logo);
                // 4,把生成好的图片路径放到表单中
                $data['logo'] = $logo;
                $data['sm_logo'] = $sm_logo;
            }else{
                // 把错误信息保存到模型中,再返回给控制器
                $this->error = $upload->getError();
                return false;
            }
        }
        
    }
    // 插入成功后的回调方法
    protected function _after_insert($data,$options) {
        /**************处理会员价格(添加数据之后写入)****************/
        // 1,接受价格和会员级别Id
        $mprice = I('post.mp');
        $level_id = I('post.level_id');
        $mpModel = M('MemberPrice');
        foreach ($mprice as $k => $v){
            $_v = (float)$v;
            if ($_v > 0){
                $mpModel->add(array(
                   'goods_id' => $data['id'],
                    'level_id' => $level_id[$k],
                    'price' => $v,
                ));
            }
        }

        /**************处理商品相册(添加数据之后写入图片地址)****************/
        if(hasImage('pic')) {
            // 1,处理$_FILES信息,把每一张图片的信息放在一个数组中
            $pics = array();
            foreach ($_FILES['pic']['name'] as $k => $v) {
                if (empty($v))
                    continue;
                $pics[] = array(
                    'name' => $v,
                    'type' => $_FILES['pic']['type'][$k],
                    'tmp_name' => $_FILES['pic']['tmp_name'][$k],
                    'error' => $_FILES['pic']['error'][$k],
                    'size' => $_FILES['pic']['size'][$k],
                );
            }
            $_FILES = $pics;// 2,uploadOne函数回到$_FILES数组中找图片,所以把处理好的图片信息赋值给$_FILES
            // 3,上传并生成缩略图
            $gpModel = D('GoodsPic');
            foreach ($pics as $k => $v) {
                $ret = uploadOne($k, 'Goods', array(
                    array(650, 650),
                    array(330, 330),
                    array(50, 50),
                ));
                //dump($ret);die;
                $gpModel->add(array(
                    'goods_id' => $data['id'],
                    'pic' => $ret['images'][0],
                    'sm_pic' => $ret['images'][3],
                    'mid_pic' => $ret['images'][2],
                    'big_pic' => $ret['images'][1],
                ));
            }
        }
            /**************处理商品属性(添加数据之后写入商品属性)****************/
            $attr_id = I('post.attr_id');
            $goods_attr = I('post.goods_attr');
            if ($goods_attr){
                $gaModel = M('GoodsAttr');
                foreach ($goods_attr as $k => $v){
                    $gaModel->add(array(
                       'goods_id' => $data['id'],
                        'attr_id' => $attr_id[$k],
                        'attr_value' => $v,
                    ));
                }
            }

        /**************处理扩展分类****************/
        $extCatId = I('ext_cat_id');
        //dump($extCatId);一位数组
        if ($extCatId){
            // 生成商品分类模型
            $gcModel = D('GoodsCat');
            foreach ($extCatId as $v){
                // 如果没有选择就跳过
                if (empty($extCatId)){
                    continue;
                }else{
                    $gcModel->add(array(
                       'goods_id' => $data['id'],
                        'cat_id' => $v,
                    ));
                }
            }
        }
    }
    // 更新数据前的回调方法
    protected function _before_update(&$data,$options) {
        /**************处理会员价****************/
        $mp = I('post.mp'); // 修改后的会员价
        $lid = I('post.level_id'); // 级别Id和会员价绑定在一块
        $mpModel = M('MemberPrice');
        $mpModel->where('goods_id='.$options['where']['id'])->delete();
        foreach($mp as $k => $v){
            $_v =(float)$v; // 价钱转为浮点型
            if ($_v > 0) {  // 如果有价格
                $mpModel->add(array(
                    'goods_id' => $options['where']['id'],
                    'level_id' => $lid[$k],
                    'price' => $v,
                ));
            }
        }
        /**************处理商品相册(添加数据之后写入图片地址)****************/
        if(hasImage('pic')) {
            // 1,处理$_FILES信息,把每一张图片的信息放在一个数组中
            $pics = array();
            foreach ($_FILES['pic']['name'] as $k => $v) {
                if (empty($v))
                    continue;
                $pics[] = array(
                    'name' => $v,
                    'type' => $_FILES['pic']['type'][$k],
                    'tmp_name' => $_FILES['pic']['tmp_name'][$k],
                    'error' => $_FILES['pic']['error'][$k],
                    'size' => $_FILES['pic']['size'][$k],
                );
            }
            $_FILES = $pics;// 2,uploadOne函数回到$_FILES数组中找图片,所以把处理好的图片信息赋值给$_FILES
            // 3,上传并生成缩略图
            $gpModel = D('GoodsPic');
            foreach ($pics as $k => $v) {
                $ret = uploadOne($k, 'Goods', array(
                    array(650, 650),
                    array(330, 330),
                    array(150, 150),
                ));
                //dump($ret);die;
                $gpModel->add(array(
                    'goods_id' => $options['where']['id'],
                    'pic' => $ret['images'][0],
                    'sm_pic' => $ret['images'][3],
                    'mid_pic' => $ret['images'][2],
                    'big_pic' => $ret['images'][1],
                ));
            }
        }
        //dump($options);
        /********************修改之前处理商品和属性的对应关系********************************/
        // 添加新属性
        $attrId = I('post.attr_id');
        $goodsAttr = I('post.goods_attr');
        //dump($attrId);
        //dump($goodsAttr);
        $gaModel = M('GoodsAttr');
        if($goodsAttr)
        {
            foreach ($goodsAttr as $k => $v)
            {
                $gaModel->add(array(
                    'goods_id' => $options['where']['id'],
                    'attr_id' => $attrId[$k],
                    'attr_value' => $v,
                ));
            }
        }
        // 修改旧属性
        $gaid = I('post.gaid');
        $oga = I('post.old_goods_attr');
        //dump($gaid);
        //dump($oga);
        foreach ($oga as $k => $v)
        {
            $gaModel->where(array(
                'id' => array('eq', $gaid[$k]),
            ))->save(array(
                'attr_value' => $v,
            ));
        }
        /********************修改之前处理扩展分类********************************/
        // 0,获得新的扩展Id
        $extCatId = I('ext_cat_id');
        //dump($extCatId);
        // 1,先删除原来的数据
        $gcModel = M('GoodsCat');
        $gcModel->where(array(
            'goods_id' => array('eq',$options['where']['id']),
        ))->delete();
        // 2,删除原来的之后判断用户是否选择了扩展,有就循环并且过滤掉空的扩展
        if ($extCatId){
            foreach($extCatId as $v){
                if(empty($v))
                    continue;
                $gcModel->add(array(
                    'goods_id' => $options['where']['id'],
                    'cat_id' => $v,
                ));
            }
        }
        // 商品描述有选择的过滤
        $data['goods_desc'] = clearXSS($_POST['goods_desc']);
        
        /********************处理上传的logo图片********************************/
        //1,判断用户有没有上传图片
        if (isset($_FILES['logo']) && $_FILES['logo']['error']==0) {
            // 2,存在就处理图片
            $upload = new \Think\Upload();// 实例化上传类    
            $upload->maxSize   = 2*1024*1024;// 设置附件上传大小    
            $upload->exts      = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型   
            $upload->rootPath =  './Public/Uploads/';  // 文件上传保存的根路径
            $upload->savePath  = 'Goods/'; // 文件上传的保存路径（相对于根路径）
            
            // 3,上传文件
            $info   =   $upload->upload();  // 上传文件的信息的保存--数组
            if ($info) {
                /*****************生成缩略图*********************************/
                // 1,取出上传图片的路径和名称
                $logo = $info['logo']['savepath'] . $info['logo']['savename'];
                // 2,拼出缩略图的名字
                $sm_logo = $info['logo']['savepath'] . 'sm_' . $info['logo']['savename'];
                // 3,生成缩略图
                $image = new \Think\Image(); 
                $image->open('./Public/Uploads/'.$logo);
                $image->thumb(130, 130)->save('./Public/uploads/'.$sm_logo);
                // 4,把生成好的图片路径放到表单中
                $data['logo'] = $logo;
                $data['sm_logo'] = $sm_logo;
                
                /*****************删除原图**********************/
                // 1,取出原图的路径
                $oldLogo = $this->field('logo,sm_logo')->find($options['where']['id']);
                // 2,删除原图
                unlink('./Public/Uploads/'.$oldLogo['logo']);
                unlink('./Public/Uploads/'.$oldLogo['sm_logo']);
            }else{
                $this->error = $upload->getError();
                return false;
            }
        }
    }

    
    // 删除数据前的回调方法
    protected function _before_delete($options) {
        /******************删除数据前处理图片************************/
        // 1,取出原图的路径
        $oldLogo = $this->field('logo,sm_logo')->find($options['where']['id']);
        // 2,删除原图
        @unlink('./Public/Uploads/'.$oldLogo['logo']);
        @unlink('./Public/Uploads/'.$oldLogo['sm_logo']);

        /******************删除商品前删除他的扩展分类************************/
        $gcModel = M('GoodsCat');
        $gcModel->where(array(
           'goods_id' => array('eq', $options['where']['id']),
        ))->delete();
        /******************删除商品前删除他的属性************************/
        $gaModel = M('GoodsAttr');
        $gaModel->where('goods_id='.$options['where']['id'])->delete();
        /******************删除商品前删除他的相册************************/
        $gpModel = M('GoodsPic');
        // 1,从硬盘删除图片,获取图片地址
        $pics = $gpModel->field('pic,sm_pic,mid_pic,big_pic')->where('goods_id='.$options['where']['id'])->select();
        foreach ($pics as $k => $v){
            deleteImage($v);
        }
        // 2,从数据库删除图片
        $gpModel->where('goods_id='.$options['where']['id'])->delete();

    }    

    // 取出当前促销中的商品
    public function getPromoteGoods($limit = 5){
        $today = date('Y-m-d H:i:s',time());
        // 指定字段提高查询速度
        return $this->field('id,logo,sm_logo,goods_name,promote_price')
        ->where(array(
            'is_on_sale' => array('eq',1),
            'promote_price' => array('neq',0),
            'promote_start_date' => array('elt',$today),
            'promote_end_date' => array('egt',$today),
        ))->limit($limit)->select();
    }
    // 获取推荐的商品
    public function getRecGoods($type,$limit = 5){
        return $this->field('id,goods_name,logo,sm_logo,promote_price')
        ->where(array(
            'is_on_sale' => array('eq',1),
            "$type" => array('eq','是'),
        ))->limit($limit)->select();
    }
    /**
     * 计算商品的会员价
     * @param $goods_id, 商品的Id
     */
    public function getMemberPrice($goodsId){
        // 1,获取登录会员的Id
        $memberId = session('id');
        if(!$memberId){
            // 2,如果未登录就显示本店家
            $sp = $this->field('shop_price')->find($goodsId);
            return $sp['shop_price'];
        }else{
            // 3,计算会员级别
            // (1)先找出登录会员的积分
            // (2)根据会员积分,进行比较,获得会员的级别
            $memberModel = D('Member');
            $jifen = $memberModel->field('jifen')->find($memberId);
            $mlModel = D('MemberLevel');
            $levelId = $mlModel->field('id')->where(array(
                'jifen_bottom' => array('elt',$jifen['jifen']),
                'jifen_top' => array('egt',$jifen['jifen']),
            ))->find();
            // 4,找到会员级别对应的会员价格
            $mpModel = D('MemberPrice');
            $price = $mpModel->field('price')->where(array(
                'goods_id' => $goodsId,
                'level_id' => $levelId['id'],
            ))->find();
            // 5,如果设置了会员价就返回,否则就返回本店价格
            if($price['price']){
                return $price['price'];
            }else{
                $sp = $this->field('shop_price')->find($goodsId);
                return $sp['shop_price'];
            }
        }
    }
    /**
     * 取出当前浏览的同类商品的销量排行
     * @param $catId : 分类Id,
     * @param $limit : 取出数量
     */
    public function getTopGoods($catId,$limit = 5){
        // 1,取出这个分类的所有自分类Id
        $catModel = D('Admin/Category');
        $children = $catModel->getChildren($catId);
        $children[] = $catId;
        // 2,取出这些分类下的商品信息以及销量并排序
        return $this->alias('a')
            ->field('a.id,a.goods_name,a.shop_price,a.sm_logo,SUM(b.goods_number) xl')
            ->join('left join vip_order_goods b on a.id=b.goods_id left join vip_order c on b.order_id=c.id')
            ->where(array(
                'a.cat_id' => array('in',$children),
                'c.pay_status' => array('eq',1),
            ))->order('xl DESC')
            ->group('a.id')
            ->limit($limit)
            ->select();
    }
    /**
     * 根据分类Id取出商品并翻页
     * @param $cat_id ; 分类Id
     */
    public function home_search(){
        /****************搜索******************/
        // 1,获取分类Id
        $catId = I('get.cat_id');
        $catModel = D('Admin/Category');
        // 2,获得当前分类下所有的子分类
        $children = $catModel->getChildren($catId);
        // 3,把当前分类入栈
        $children[] = $catId;
        //dump($children);
        // 4,搜索数据库条件,取出所有在children中的分类下的所有商品
        $where['a.cat_id'] = array('in',$children);

        // ***************价格搜索==============================================------------/
        $price = I('get.price');
        //echo $price;
        if($price){
            $price = explode('-',$price);// 变为数组
            $where['a.shop_price'] = array('BETWEEN',$price);
        }

        // ******************属性条件搜索===========-----------============-------------=====/
        // 1,属性值 -----> 取出满足所有属性条件的商品Id,再根据Id搜索商品
        // 循环提交过来的所有的参数
        $get = I('get.');
        //dump($get);
        /*
        array()
            'cat_id' => string '1' (length=1)
            'price' => string '24.00-2019' (length=10)
            'attr_1' => string '双核_cpu' (length=10)
            'attr_2' => string '5.5_屏幕尺寸' (length=16)
            'attr_3' => string '4G全网通_网络类型' (length=24)
            'attr_6' => string '灰_颜色' (length=10)
        */
        $gattrModel = D('GoodsAttr');
        $gids_attr = array(); // 满足每个属性值的商品Id
        foreach($get as $k => $v){
            // 2,找出属性值的变量
            if(strpos($k,'attr_')===0){
                //3,从名称中提取出属性Id
                $_k = explode('_',$k);
                // 4,提取出属性值
                $_v = explode('_',$v);
                // 5,根据属性Id和属性值查询商品Id,并拼成字符串,如:1,2,3,4
                $gids = $gattrModel ->field('GROUP_CONCAT(goods_id) gids')->where(array(
                    'attr_id' => $_k[1],
                    'attr_value' => $_v[0],
                ))->find();
                //dump($gids);
                $_attr = explode(',',$gids['gids']); // 得到的商品Id字符串,变为数组
                //dump($_attr);
                // 6,如果这是第一个属性就站存起来,否则就和上一个属性值的商品Id求交集
                if (empty($gids_attr))
                    $gids_attr = $_attr;
                else{
                    // 7,和上一次的值求交集
                    $gids_attr = array_intersect($gids_attr,$_attr);
                    // 8,取完交集之后如果没有满足条件的就说明取不出商品
                    if(empty($gids_attr)){
                        $where['a.id'] = array('eq',0);
                        break;
                    }
                }
            }
        }
        // 9,如果还不为空说明的确又满足条件的商品
        if($gids_attr)
            $where['a.id'] = array('in',$gids_attr);
        /********************翻页*****************************/
        $count = $this->alias('a')->where($where)->count();// 查询满足要求的总记录数
        $Page  = new \Think\Page($count,40);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $Page->setConfig('pre','上一页');
        $Page->setConfig('next','下一页');
        $pageString  = $Page->show();// 分页显示输出
        /*************************排序(价格,销量,最新)****************************************/
        // 1,初始话排序规则
        $orderby = 'xl';
        $orderway = 'desc';
        // 2,接受排序规则
        $odby = I('get.odby');
        // 3,判断排序规则
        if($odby){
            if($odby == 'price-desc')
                $orderby = 'a.shop_price';
            elseif($odby == 'price-asc'){
                $orderby = 'a.shop_price';
                $orderway = 'asc';
            }elseif ($odby == 'time-desc')
                $orderby = 'a.addtime';
            elseif ($odby == 'pl-desc')
                $orderby = 'plcount';
        }
        /**********************去数据*************************************/
        $data = $this->alias('a')->
            field('a.id,a.goods_name,a.sm_logo,a.shop_price,(SELECT COUNT(b.id) FROM vip_comment b where a.id=b.goods_id) plcount,(SELECT SUM(c.goods_number) FROM vip_order_goods c LEFT JOIN vip_order d ON c.order_id=d.id WHERE a.id=c.goods_id AND d.pay_status=1) xl')
            ->where($where)
            ->limit($Page->firstRow.','.$Page->listRows)
            ->order("$orderby $orderway")
            ->select();
        //echo $this->getLastSql();
        /********************价格区间 计算筛选条件*************************/
        $goods_info = $this->field('MAX(shop_price) max_price,MIN(shop_price) min_price,COUNT(id) goods_count,GROUP_CONCAT(id) goods_ids')
            ->where(array(
                'cat_id' => array('in',$children),
            ))->find();
        //dump($goods_info);
        // 当商品数量超过30件时才为价格分段
        if($goods_info['goods_count'] > 1){
            // 最高价和最低价的差价
            $cha = $goods_info['max_price'] - $goods_info['min_price'];
            // 根据差价决定分几段
            if($cha < 100)
                $sectionCount = 1;
            elseif($cha <500)
                $sectionCount = 2;
            elseif($cha <1000)
                $sectionCount = 3;
            elseif($cha < 5000)
                $sectionCount = 4;
            elseif($cha < 10000)
                $sectionCount = 5;
            else
                $sectionCount = 6;
            // 计算每一段的增量
            $delta = ceil($cha/$sectionCount);
            // 保存分好的段
            $price = array();
            $firstPrice = $goods_info['min_price'];
            for ($i=0;$i<$sectionCount;$i++){
                $price[] = $firstPrice . '-' . ($firstPrice+$delta);
                $firstPrice += $delta;
            }
        }
        /************************取出这个分类下所有的商品属性,作为筛选条件************************************/
        // 条件需要属性Id,属性值,属性名
        $gaModel  = D('GoodsAttr');
        $gaData = $gaModel->alias('a')
            ->field('a.attr_id,a.attr_value,b.attr_name')
            ->join('LEFT JOIN vip_attribute b on a.attr_id=b.id')
            ->where(array(
                'a.goods_id' => array('in',$goods_info['goods_ids'])
            ))->select();
        // 把相同的属性值放到一起
        //dump($gaData);
        $_gaData = array();
        foreach ($gaData as $k => $v){
            if(!in_array($v['attr_value'],$_gaData[$v['attr_name']]))
                $_gaData[$v['attr_name'].'-'.$v['attr_id']][] = $v['attr_value'];
        }
        //$_gaData = array_unique($_gaData);过滤重复元素
        //dump($_gaData);
        return array(
            'data' => $data,
            'page'=> $pageString,
            'price' => $price,
            'gaData' => $_gaData,
        );
    }
}
