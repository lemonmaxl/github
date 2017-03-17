<?php if (!defined('THINK_PATH')) exit();?><!Doctype HTML>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <meta name="HandheldFriendly" content="True">
    <meta name="keywords" content="<?php echo $_page_keywords;?>">
    <meta name="description" content="<?php echo $_page_desc;?>">
    <title><?php echo $_page_title;?></title>
    <link rel="shortcut icon" href=""/>
    <link rel="bookmark" href="" />
    <link rel="stylesheet" type="text/css" href="/Public/Home/css/common.css">

    <link rel="stylesheet" href="/Public/Home/css/nav/base.css" />
    <link rel="stylesheet" href="/Public/Home/css/nav/head.css" />
    <link rel="stylesheet" type="text/css" href="/Public/Home/css/HJ-icon/iconfont.css" />
    <script src="/Public/Home/js/navjs/global.js"></script>
    <script src="/Public/Home/js/common.js"></script>
    <script src="/Public/Home/js/sder.js"></script>
    <!-- 页面css样式 -->
    <link rel="stylesheet" href="/Public/Home/lunbo/css/tniu.css" />

    <!-- js文件 -->
    <!--<script src="/Public/Home/lunbo/js/jquery-1.11.0.min.js"></script>-->
    <script src="/Public/Home/lunbo/js/index.js"></script>

</head>
<body>
<!-- 头部区域 -->
<div id="header">
    <div class="topbar">
        <div class="layout-2 container">
            <div class="sub-1">
                欢迎来到好家唯品,用心即所得！
            </div>
            <div class="sub-2">
                <ul class="nav-x">
                    <li class="item down">
                        <a href="">会员中心 <i class="Hui-iconfont">&#xe6d5;</i></a>
                        <div class="dropdown user-box">
                            <ul class="user-center">
                                <li class="link"><a href="<?php echo U('My/order'); ?>">我的订单</a></li>
                                <li class="link"><a href="<?php echo U('My/order'); ?>">商品评价</a></li>
                                <li class="link"><a href="<?php echo U('My/order'); ?>">我的消息</a></li>
                                <li class="link"><a href="<?php echo U('My/order'); ?>">收货地址</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="item split"></li>
                    <li class="item down"><a href="">关注好家</a>
                        <div class="dropdown">
                            <img src="/Public/Home/static/images/vxcode.jpg" width="150px">
                        </div>
                    </li>
                    <li class="item split"></li>
                    <li class="item"><a href="<?php echo U('My/order'); ?>">我的订单</a></li>
                    <li class="item split"></li>
                    <li class="item" id="loginfo"></li>
                </ul>
                <a href="<?php echo U('/')?>" style="color: #F22E00;float: right;padding-right: 80px;">好家唯品首页</a>
                <script>
                    $.ajax({
                        type:"GET",
                        url:"<?php echo U('Member/chkLogin');?>",
                        dataType : "json",
                        success : function(data){
                            if(data.login == '1'){
                                $("#loginfo").html('Hi，'+data.username+' <a class="normal" href="<?php echo U('Member/loginOut');?>">退出</a>');
                            }else{
                                $("#loginfo").html('<a class="normal" href="<?php echo U('Member/login');?>">登录</a>/<a class="normal" href="<?php echo U('Member/regist');?>">注册</a>');
                            }
                        }
                    });
                </script>
            </div>
        </div>
    </div>
    <div class="container head-main">
        <div class="sub-1 logo" style="background-image: url(/Public/Home/static/images/logo.png);"></div>
        <div class="sub-2">
            <form id="search-form" class="search-form" action="" method="get">
                <input  class="search-keyword" id="search-keyword" class="txt-keyword" name="keyword" value="" type="text">
                <button class="btn-search " style="font-size: 16px">搜索</button>

                <!--<p id="tags-list"><a href="#"></a></p>-->
            </form>
        </div>
        <div class="sub-3">
            <div class="shopping" id="shopping-cart" style="font-size: 16px"><i class="Hui-iconfont">&#xe6b9;</i> 我的购物车
                <div class="dropdown">
                    <div class="cart-box " id="cart-list">

                        <div><img src="/Public/Home/static/loading2.gif" /></div>
                        <!--<div>购物车还没有商品,赶快挑选吧</div>-->
                    </div>
                    <div class="cart-count">
                        <a href="<?php echo U('Cart/lst');?>" class="btn btn-main">去购物车结算</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    //购物车
    $("#shopping-cart .Hui-iconfont").mouseover(function(){
        $(this).find(".dropdown").show();
        $(this).find(".dropdown").css("display","block");
    }).mouseout(function(){
        $(this).find(".dropdown").hide();
        $(this).find(".dropdown").css("display","none");
    });

    $("#shopping-cart").mouseover(function () {
        $.ajax({
            type: "GET",
            url: "<?php echo U('Cart/ajaxGetCartList'); ?>",
            dataType: "json",
            success: function (data) {
                if (data != "") {
                    var ul = "<table width='100%' callspacing='5' cellpadding='5' style='background:#FFF'>";
                    // 循环json数据
                    $(data).each(function (k, v) {
                        ul += '<tr>';
                        ul += '<td><a href="/index.php/Home/Index/goods/id/' + v.goods_id + '"><img width="50" src="/Public/Uploads/' + v.sm_logo + '" /></a></td>';
                        ul += '<td><a href="/index.php/Home/Index/goods/id/' + v.goods_id + '">' + v.goods_name + '</a></td>';
                        ul += "<td align='left' width='20px'>" + v.goods_number + "</td>";
                        ul += '<td>' + v.price + '</td>';
                        ul += '</tr>';
                    });
                    ul += '</table>';
                    $("#cart-list").html(ul);
                }else{
                    $("#cart-list").html("<div>购物车还没有商品,赶快挑选吧</div>");
                }
            }
        });
    });
</script>
    
<?php
$catModel = new Admin\Model\CategoryModel; $catdata = $catModel->getNavData(); ?>

<div class="headNav">

    <script src="/Public/Home/js/navjs/head.js"></script>
    <div class="navCon w1020">
        <div class="navCon-cate fl navCon_on">
            <div class="navCon-cate-title"> <a href="#"><i class="Hui-iconfont">&#xe681;</i>&ensp;&ensp;全部商品分类</a></div>
            <div class="cateMenu hide">
                <ul>
                    <?php foreach($catdata as $k => $v){ ?>
                    <li style="border-top: none;">
                        <div class="cate-tag"> <strong><a href="<?php echo U('Search/cat_search?cat_id='.$v['id'],'',false);?>"><?php echo $v["cat_name"];?></a></strong>
                            <div class="listModel">
                                <p>
                                    <?php foreach($v["children"] as $k1 => $v1){ ?>
                                <a href="<?php echo U('Search/cat_search?cat_id='.$v1['id'],'',false);?>"><?php echo $v1["cat_name"];?></a>
                                    <?php } ?>
                                </p>
                            </div>
                        </div>
                        <div class="list-item hide">
                            <ul class="itemleft">
                                <?php foreach($v["children"] as $k1 => $v1){?>
                                <dl>
                                    <dt><?php echo $v["cat_name"];?></dt>
                                    <dd>
                                        <?php foreach($v1["children"] as $k2 => $v2){?>
                                        <a href="<?php echo U('Search/cat_search?cat_id='.$v2['id'],'',false);?>"><?php echo $v2["cat_name"];?></a>
                                        <?php } ?>
                                    </dd>
                                </dl>
                                <div class="fn-clear"></div>
                                <?php } ?>
                            </ul>
                            <ul class="itemright">
                                <dl>
                                    <dt>促销信息</dt>
                                </dl>
                                <div class="news-list">
                                    <p> <span class="red">[杜康]</span> <a href="">酒体窖香幽雅、陈香舒适,只需156元，值得一试的好酒</a> </p>
                                    <p> <span class="red">[红星]</span> <a href="">经典红星153元热销千瓶，敢于全网誓比价！</a> </p>
                                    <p> <span class="red">[太白]</span> <a href="">中国第一诗酒，全场满200减50</a> </p>
                                </div>
                                <dl>
                                    <dt>促销活动</dt>
                                </dl>
                            </ul>
                        </div>
                    </li>
                    <?php } ?>
                    <li>
                        <div class="cate-tag"> <strong><a href="#">葡萄酒</a></strong>
                            <div class="listModel">
                                <p> <a href="">中国</a> <a href="">法国</a> <a href="">智利</a> <a href="">葡萄牙</a> </p>
                            </div>
                        </div>
                        <div class="list-item hide">
                            <ul class="itemleft">
                                <dl>
                                    <dt>产区</dt>
                                    <dd> <a href="">澳大利亚</a> </dd>
                                </dl>
                                <div class="fn-clear"></div>
                                <dl>
                                    <dt>类型</dt>
                                    <dd> <a href="">红葡萄酒</a> </dd>
                                </dl>
                                <div class="fn-clear"></div>
                                <dl>
                                    <dt>品种</dt>
                                    <dd> <a href="">芭贝拉</a> </dd>
                                </dl>
                                <div class="fn-clear"></div>
                            </ul>
                            <ul class="itemright">
                                <dl>
                                    <dt>促销信息</dt>
                                </dl>
                                <div class="news-list">
                                    <p> <span class="red">[加州乐事]</span> <a href="">美国爆款红酒，超市89元，68元特价售</a> </p>
                                    <p> <span class="red">[华尔兹]</span> <a href="">德国经典款，39元继续热卖中</a> </p>
                                    <p> <span class="red">[贵妇]</span> <a href="">法国进口红酒，购满6瓶每瓶仅需38元，超值专享价</a> </p>
                                </div>
                                <dl>
                                    <dt>促销活动</dt>
                                </dl>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <div class="float-list-dnav"> <a href="">新品</a> <a href="">清仓</a> <a href="">多买优惠</a> </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="navCon-menu fl">
            <ul>
                <li class="curMenu"><a  href="<?php echo U('Index/index'); ?>">首页</a></li>
                <li class="curMenu"><a href="">购酒团</a></li>
                <li class="curMenu"><a href="">我爱小酒版</a></li>
                <li class="curMenu"><a href="">名家鉴赏</a></li>
                <li class="curMenu"><a href="#">名庄酒窖</a></li>
                <li class="curMenu"><a href="#">VIP专场</a></li>
            </ul>
        </div>
    </div>
</div>

<div id="main">
    <!--  主区域 -->
        <link type="text/css" rel="stylesheet" href="/Public/Home//css/product.css" />
        <!--面包屑导航-->
    <div class="bread-crumb">
        <ol class="container">
            <li><a href="<?php echo U('Index/index');?>">首页 </a></li>
        <?php foreach($catData as $k => $v){?>
            <li><a href="<?php echo U('Search/cat_search?cat_id='.$v['id']);?>"><?php echo $v['cat_name'];?> </a></li>
        <?php } ?>
            <li><a href="<?php echo U('Index/goods?id='.$info['id']); ?>"><?php echo $info['goods_name'];?></a></li>
        </ol>
    </div>
    <div class="container">
    <!-- 产品展示-->
        <div id="product-intro">
        <div class="sub-1">
            <div id="gallery">
                <a class="turn-left ie6png"></a>
                <div class="show-list">
                    <div style="position: absolute;height:800px;">
                        <a class="small-img" href="javascript:;"><img src="<?php echo $imgpre.$info['sm_logo'];?>"  source="#" width="60"></a>
                        <?php foreach($gpData as $k => $v){?>
                        <a class="small-img" href="javascript:;"><img src="<?php echo $imgpre.$v['mid_pic'];?>"  source="#" width="60"></a>
                        <?php } ?>
                     </div>
                </div>
                <a class="turn-right ie6png"></a>
            </div>
        </div>
        <div class="sub-2">
            <div id="preview" >
                <div id="imgmini" style="width: 420px;height:420px;"><img class="big-pic" width="420"  src="<?php echo $imgpre.$info['logo'];?>" source="#"></div>
            </div>
        </div>
        <div class="sub-3">
            <ul class="product-info">
                <li class="product-title"><?php echo $info['goods_name'];?></li>
                <li class="product-no"><label>货号：</label><span id="pro-no">NS20140504123</span></li>
                <li class="red"></li>
                <li class="product-price">
                    <ul>
                        <li><span style="font-size: 13px;color: #666;">&nbsp;&nbsp;&nbsp;定价 : </span><span id="market_price" style="color:#333;"><s>￥<?php echo $info['market_price'];?></s></span></li>
                        <li><span style="font-size: 13px;color: #666;">本店价 : </span><span id="shop_price" style="color:#333;">￥<?php echo $info['shop_price'];?></span></li>
                        <li><span style="font-size: 13px;color: #666;">会员价 : </span><span id="member_price" style="font-weight:bold;"></span></li>
                    </ul>
                </li>
                <!--<li class="clearfix"><label></label><span>库存&nbsp;&nbsp;</span><span id="goods_nums">(191)</span></li>-->
            </ul>
            <script>
                $.ajax({
                    type: "GET",
                    url : "<?php echo U('Member/ajaxGetMemberPrice?id='.$info['id']);?>",
                    success:function(data){
                        $("#member_price").html("￥"+data);
                    }
                });
            </script>
            <fieldset class="line-title">
                <legend align="center" class="txt">商品规格</legend>
            </fieldset>
        <form action="<?php echo U('Cart/add');?>" method="post">
            <input type="hidden" name="goods_id" value="<?php echo $info['id'];?>" />
            <div class="spec-info">
                <div class="spec-close"></div>
                <?php foreach($raiArr as $k => $v){ ?>
                <dl class="spec-item clearfix">
                    <dt><?php echo $k;?></dt>
                    <dd>
                        <ul class="attrValuesList clearfix">
                            <?php foreach($v as $k1 => $v1){?>
                            <!--<li name="goods_attr_id_list[]" value="<?php echo $v1['id'];?>"><span><?php echo $v1['attr_value'];?></span><i></i></li>-->
                            <li <?php if($k1 == 0) echo 'class="selected"';?> ><span><input style="display: none;" type="radio" name="goods_attr_id_list[<?php echo $v1['attr_id']; ?>]" value="<?php echo $v1['id'];?>" <?php if($k1 == 0) echo 'checked="checked"';?> /><?php echo $v1['attr_value'];?></span></li>
                            <?php } ?>
                        </ul>
                    </dd>
                </dl>
                <?php }?>
                <dl class="spec-item clearfix">
                    <dt>购买量</dt>
                    <dd class="buy-num" id="getBuyNum"><a href="javascript:;"><i class="Hui-iconfont" style="color: #b7b3b3;">&#xe6a1;</i></a><input id="buy-num" name="goods_number" value="1"  maxlength=5><a href="javascript:;"><i class="Hui-iconfont" style="color: #b7b3b3;">&#xe600;</i></a>&nbsp;&nbsp;&nbsp;&nbsp;<span class="vm">库存：<b id="storeNums" class="red">191</b></span></dd>
                </dl>
                <dl id="spec-msg" class="spec-item clearfix" style="display: none;">
                    <dt></dt>
                    <dd ><p class="msg"><i class="icon icon-alert-16"></i><span >请选择您要购买的商品规格</span></p>
                    </dd>
                </dl>
                <dl class="spec-item clearfix">
                    <dd class="product-btns">
                        <a href="javascript:;" id="buy-now" class="btn btn-warning"><span><i class="Hui-iconfont">&#xe620;</i> 立即购买</span></a>&nbsp;&nbsp;&nbsp;&nbsp;
                        <button type="submit" id="add-cart" class="btn btn-main"><span><i class="Hui-iconfont">&#xe6b9;</i> 加入购物车</span></button>&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="javascript:;" id="attention" class="btn btn-info"><span><i class="Hui-iconfont">&#xe69e;</i> 收藏</span></a>
                    </dd>
                </dl>
            </div>
        </form>
        </div>
    </div>

    <!-- 商品详情-->
        <div class="clearfix" style="height: auto;">
        <div class="sub-left mt20">
            <fieldset class="line-title">
                <legend align="center" class="txt">看了又看</legend>
            </fieldset>
            <ul>
                <?php foreach($goodsHis as $k => $v){ ?>
                 <li class="product">
                    <dl>
                        <dt class="img tc"><a href="<?php echo U('goods?id='.$v['id']);?>"><img src="<?php echo $imgpre . $v['logo'];?>" width=200></a></dt>
                        <dd><a href="<?php echo U('goods?id='.$v['id']);?>"><?php echo $v['goods_name'];?></a></dd>
                        <dd><span class="price">售价：<b class="red">￥<?php echo $v['shop_price'];?></b></span></dd>
                    </dl>
                </li>
                <?php } ?>
             </ul>

            <fieldset class="line-title">
                <legend align="center" class="txt">最近浏览过的商品</legend>
            </fieldset>
            <ul id="history_list">
            <!--浏览历史-->
            </ul>
        </div>
        <script>
            $.ajax({
                type : "GET",
                url : "<?php echo U('ajaxDisplayHistory?id='.$info['id']);?>",
                dataType : "json",
                success : function (data){
                    var html = '' ;
                    $(data).each(function(k,v){
                        html += '<li class="product"><dl><dt class="img tc"><a href="/index.php/Home/Index/goods/id/'+v.id+'"><img src="/Public/Uploads/'+v.logo+'" width=200></a></dt> <dd><a href="/index.php/Home/Index/goods/id/'+v.id+'">'+v.goods_name+'</a></dd><dd><span class="price">售价：<b class="red">￥'+v.shop_price+'</b></span></dd></dl> </li>';
                    });
                 $("#history_list").html(html);
                }
            });
        </script>
        <div class="sub-right">
            <div class="goods-detail clearfix">
                <div class="content">
                    <!-- 捆绑销售 -->
                    <div class="tab ">
                        <ul class="tab-head">
                            <li>优惠套装1<i></i></li>
                        </ul>
                        <div class="tab-body" style="min-height: 180px;">
                            <ul class="bundling-list">

                                <li class="sub-1 group-item">
                                    <dl class="product goods-item">
                                        <dt class="img">
                                            <a href=""><img src="/Public/Home/data/uploads/2014/05/04/6a63f7365e4430b5d07791fd32c66500.jpg__100_100.jpg" width="100"></a>
                                        </dt>
                                        <dd class="title"><a href="">BRIOSO...</a></dd>
                                        <dd class="price"><b class="red price">49.00元</b></dd>
                                    </dl>
                                    <dl class="product goods-item">
                                        <s class="icon-add ie6png icon-plus-16"></s>
                                        <dt class="img">
                                            <a href=""><img src="/Public/Home/data/uploads/2014/05/04/b1dcd910f2d270c11d91668ecfbf7302.jpg__100_100.jpg" width="100"></a>
                                        </dt>
                                        <dd class="title"><a href="">职业女装纯棉...</a></dd>
                                        <dd class="price"><b class="red price">45.00元</b></dd>
                                    </dl>
                                    <dl class="product goods-item">
                                        <s class="icon-add ie6png icon-plus-16"></s>
                                        <dt class="img">
                                            <a href=""><img src="/Public/Home/data/uploads/2014/05/04/da175403c79047247a25e76ec8c4913a.jpg__100_100.jpg" width="100"></a>
                                        </dt>
                                        <dd class="title"><a href="">夏天职业衬衫...</a></dd>
                                        <dd class="price"><b class="red price">49.00元</b></dd>
                                    </dl>
                                    <dl class="product goods-item">
                                        <s class="icon-add ie6png icon-plus-16"></s>
                                        <dt class="img">
                                            <a href=""><img src="/Public/Home/data/uploads/2014/05/04/fb84a52b8da8869e478a236ed10172b8.jpg__100_100.jpg" width="100"></a>
                                        </dt>
                                        <dd class="title"><a href="">春夏装新款2...</a></dd>
                                        <dd class="price"><b class="red price">79.00元</b></dd>
                                    </dl>
                                    <dl class="product goods-item">
                                        <s class="icon-add ie6png icon-plus-16"></s>
                                        <dt class="img">
                                            <a href=""><img src="/Public/Home/data/uploads/2014/05/04/f81d28ad7c32504c0af3a8c44eec681e.jpg__100_100.jpg" width="100"></a>
                                        </dt>
                                        <dd class="title"><a href="">白衬衫女短袖...</a></dd>
                                        <dd class="price"><b class="red price">55.00元</b></dd>
                                    </dl>
                                    
                                </li>
                                <li class="sub-2 group-item">
                                    <div class="goods-item" >
                                        <s class="icon-add ie6png icon-equal-16"></s>
                                        <div>女式潮</div>
                                        <div>套&nbsp;&nbsp;装&nbsp;&nbsp;价： ￥240.00</div>
                                        <div>原　　价： <del>￥277</del></div>
                                        <div>立即节省： ￥37</div>
                                        <div class="mt10"><a href="" class="btn btn-main">购买套装</a></div>
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </div>
                                        <!-- 捆绑销售 -->
                    <div class="tab clearfix">
                        <ul class="tab-head">
                            <li>商品详情<i></i></li>
                            <li>商品评价<i></i></li>
                            <li>售后服务<i></i></li>
                        </ul>
                        <div class="tab-body" style="min-height: 200px;">
                            <!-- 商品详情-->
                            <div class=" clearfix">
                                <div class="">
                                    <ul class="attr-list">
                                        <!-- 商品唯一属性-->
                                        <?php foreach($uniArr as $k => $v){ ?>
                                        <li><?php echo $v['attr_name'];?>：<?php echo $v['attr_value'];?></li>

                                        <?php }?>
                                        <li>商品编号：NS20140504123_1</li>
                                        <li>商品重量：200g</li>
                                        <li>上架时间：2014-05-04 20:46:15</li>
                                        <li>袖长：长袖</li>
                                        <li>面料：棉</li>
                                    </ul>
                                </div>
                                <div class="description  clearfix" >
                                    <?php echo $info['goods_desc'];?>
                                </div>
                            </div>
                            <!-- 商品详情-->
                            <!-- 商品评价-->
                            <div class="comment-list">
                                <div class="comment-top clearfix">
                                    <ul>
                                        <li>
                                            <div class="tc comment-score"><em class="tc circle ">90<i style="font-size: 18px;">%</i></em>好评度</div>
                                        </li>
                                        <li class="comment-grade">
                                            <div>
                                                <h1>共有(0)人参考评价</h1>
                                                <dl class="comment-percent">
                                                    <dt>好评</dt>
                                                    <dd class="bar well"><i style="width:0%"></i></dd>
                                                    <dd class="percent"><i id="welldone"></i>%</dd>
                                                    <dt>中评</dt>
                                                    <dd class="bar can"><i style="width:0%"></i></dd>
                                                    <dd class="percent"><i id="candone"></i>%</dd>
                                                    <dt>差评</dt>
                                                    <dd class="bar bad"><i style="width:0%"></i></dd>
                                                    <dd class="percent"><i id="baddone"></i>%</dd>
                                                </dl>
                                            </div>
                                        </li>
                                        <li class="comment-action">
                                            <div class="buyer">
                                                <dl>
                                                    <dt>买家印象：</dt>
                                                </dl>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="comment tab" id="comment">
                                    <div class="tab-body">
                                        <div>
                                            <div class="page-content">
                                                <div class="comment-item">
                                                    <!-- 评论内容 -->
                                                    <!-- 评论内容-->
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- 分页信息 start -->
                                <div class="page mt20"></div>
                                <!-- 分页信息 end -->
                                <!--  评论表单 start-->
                                <div class="comment_form mt20" style="display: none;">
                                    <form action="">
                                        <input type="hidden" name="goods_id" value="<?php echo $info['id']; ?>">
                                        <ul>
                                            <li>
                                                <label for=""> 评分：</label>
                                                <input type="radio" name="star" value="5" checked="checked"/> <strong class="star star5"></strong>
                                                <input type="radio" name="star" value="4"/> <strong class="star star4"></strong>
                                                <input type="radio" name="star" value="3"/> <strong class="star star3"></strong>
                                                <input type="radio" name="star" value="2"/> <strong class="star star2"></strong>
                                                <input type="radio" name="star" value="1"/> <strong class="star star1"></strong>
                                            </li>

                                            <li>
                                                <label for="">评价内容：</label>
                                                <textarea name="content" id="" cols="" rows=""></textarea>
                                            </li>
                                            <li>
                                                <label for="">选择印象：</label>
                                                <div id="old_yx" style="height: 34px;"></div>
                                            </li>
                                            <li>
                                                <label for="">买家印象：</label>
                                                <input name="yx_name" id="" type="text" maxlength="80" style="width: 300px;">多个印象用","隔开,最多输入80个字
                                            </li>
                                            <li>
                                                <label for="">&nbsp;</label>
                                                <input type="button" value="提交评论"  class="comment_btn"/>
                                            </li>
                                        </ul>
                                    </form>
                                </div>
                                <script type="text/javascript">

                                </script>
                                <!--  评论表单 end-->
                            </div>
                            <!-- 商品评价-->
                            <!-- 售后保障-->
                            <div class="clearfix">
                            <div>
                                <div style="color:#666666;font-family:Arial;">
                                <strong>服务承诺：</strong><br />
                                    商城向您保证所售商品均为正品行货，自营商品开具机打发票或电子发票。凭质保证书及商城发票，
                                    可享受全国联保服务（奢侈品、钟表除外；奢侈品、钟表由联系保修，享受法定三包售后服务），与您亲临商场选购的商品享受相同的质量保证。
                                    商城还为您提供具有竞争力的商品价格和运费政策，请您放心购买！ <br />
                                    注：因厂家会在没有任何提前通知的情况下更改产品包装、产地或者一些附件，本司不能确保客户收到的货物与商城图片、产地、附件说明完全一致。只能确保为原厂正货！
                                    并且保证与当时市场上同样主流新品一致。若本商城没有及时更新，请大家谅解！
                                </div>
                                <div style="color:#666666;font-family:Arial;">
                                <strong>权利声明：</strong><br />
                                商城上的所有商品信息、客户评价、商品咨询、网友讨论等内容，是商城重要的经营资源，未经许可，禁止非法转载使用。
                                <p>
                                    <b>注：</b>本站商品信息均来自于厂商，其真实性、准确性和合法性由信息拥有者（厂商）负责。本站不提供任何保证，并不承担任何法律责任。
                                </p>
                                </div>
                            </div>
                        </div>
                            <!-- 售后保障-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
<script>

    // ajax 评论
    $(".comment_btn").click(function(){
        // 表单数据
        var formData = $(".comment_form form").serialize();
        $.ajax({
           type : "POST",
            url : "<?php echo U('Comment/add','',FALSE); ?>",
            data : formData,
            dataType : "json",
            success : function(data){
               if(data.status == 1){
                    alert('添加成功!')
               }else{
                   alert(data.info);
               }
            }
        });
    });

    // 点击翻页获取数据
    function getComment(page){
        $.ajax({
            type : "GET",
            url : "<?php echo U('Comment/lst?id='.$info['id'],'',false); ?>/p/"+page,
            dataType : "json",
            success : function(data){
                /************返回的数据放到页面中***********/
                var html = "";
                $(data.data).each(function(k,v){
                    html += '<div class="consult-q"><div class="head"><img src="#" width="80" height="80"><strong>'+v.username+'</strong><i class="arrow"><b></b></i></div>' +
                        '<div class="comment-content"><p class="top"><span class="star star'+v.star+'"></span><span class="fr">'+v.addtime+'</span></p><p>'+v.content+'</p><p class="btns">' +
                        '<a href="javascript:;" class="reply">回复(0)</a><a href="javascript:;" class="useful" onclick="ding(this,'+v.id+')">有用(<span>'+v.good_number+'</span>)</a></p></div></div>';
                });
                /*********输出内容***********/
                $(".comment-list .comment-item").html(html);
                /**********替换分页字符串****************/
                var pageString = "";
                for(var i=1;i<=data.pageNumber;i++){
                    if(page == i)
                        var cls = ' class="cur"';
                    else
                        var cls = '';
                    pageString += ' <a '+cls+' onclick="getComment('+i+');" href="javascript:void(0);">'+i+'</a>';
                }
                // 输出到页面中
                $(".page").html(pageString);
                // 判断是否显示表单
                if(data.member_id > 0){
                    $(".comment_form").show();
                }
                // 第一页就把好评率放到页面中
                if(page == 1){
                    $("#welldone").html(data.well);
                    $(".comment-score .circle").html(data.well+'<i style="font-size: 18px;">%</i>');
                    $(".well i").css("width",data.well+"%");
                    $("#candone").html(data.can);
                    $(".can i").css("width",data.can+"%");
                    $("#baddone").html(data.bad);
                    $(".bad i").css("width",data.bad+"%");
                    if($(".buyer dl").has("dd").length == 0) {
                        // 买家印象
                        var yx = "";
                        var chk = "";
                        $(data.impData).each(function (k, v) {
                            yx += '<dd><span>' + v.yx_name + '</span><em>(' + v.yx_count + ')</em></dd>';
                            chk += ' <input type="checkbox" name="old_yx_name[]" value="' + v.id + '"/>' + v.yx_name;
                        });
                        $(".buyer dl").append(yx);
                        $("#old_yx").html(chk);
                    }
                }
            }
        });
    }

    // 有用
    function ding(a,commentId){
        $.ajax({
            type:"GET",
            url :"<?php echo U('Comment/ding','',false); ?>/comment_id/"+commentId,
            dataType : "json",
            success : function(data){
                // 取出原来有用的数
                var num = parseInt($(a).find("span").text());
                num++;
                $(a).html("有用(<span>"+num+"</span>)");
            }
        });
    }
    getComment(1);
    $(".attrValuesList li ").each(function(){
        $(this).on("click",function(){
            var disabled = $(this).hasClass('disabled');
            if(disabled) return;
            var flage = $(this).hasClass('selected');

            $(this).parent().find("li").removeClass("selected");
            if(!flage){
                $(this).addClass("selected");
            }
            $(this).find("input").attr("checked","checked");
        })
    });

    $("#getBuyNum a:eq(0)").on("click",function(){
        var num = $("#getBuyNum input").val();
        if(num>1) num--;
        else num=1;
        $("#getBuyNum input").val(num);
        btnNumStatus(num);
    });
    $("#getBuyNum a:eq(1)").on("click",function(){
        var num = $("#getBuyNum input").val();
        var max = parseInt($("#storeNums").text());
        if(num<max) num++;
        else num=max;
        $("#getBuyNum input").val(num);
        btnNumStatus(num);
    });
    $("#getBuyNum input").on("change",function(){
        var value = $(this).val();
        var max = parseInt($("#storeNums").text());
        if((/^\d+$/i).test(value)){
            value = Math.abs(parseInt(value));
            if(value<1) value = 1;
            if(value>max) value = max;
        }else{
            value = 1;
        }
        $(this).val(value);
        btnNumStatus(value);
    });
    function btnNumStatus(value){
        var max = parseInt($("#storeNums").text());
        if(value <= 1){
            $("#getBuyNum a:eq(0)").addClass('disable');
        }else{
            $("#getBuyNum a:eq(0)").removeClass('disable');
        }
        if(value >= max){
            $("#getBuyNum a:eq(1)").addClass('disable');
        }else{
            $("#getBuyNum a:eq(1)").removeClass('disable');
        }
    }

</script>

<!--footer-->
<div id="footer">
    <div class="helps clearfix container">
        <dl >
            <dt class="clearfix"><a href="javascript:;">购物指南</a></dt>
            <dd><a href="javascript:;">账户注册</a></dd>
            <dd><a href="javascript:;">购物流程</a></dd>
            <dd><a href="javascript:;">积分制度</a></dd>
        </dl>
        <dl >
            <dt class="clearfix"><a href="javascript:;">支付方式</a></dt>
            <dd><a href="">银行卡支付</a></dd>
            <dd><a href="">支付宝支付</a></dd>
            <dd><a href="">微信支付</a></dd>
        </dl>
        <dl >
            <dt class="clearfix"><a href="javascript:;">售后保障</a></dt>
            <dd><a href="javascript:;">30天无理由退换货</a></dd>
            <dd><a href="javascript:;">如何申请退款</a></dd>
            <dd><a href="javascript:;">如何申请退款</a></dd>
            <dd><a href="javascript:;">第三方订单售后服务</a></dd>
        </dl>
        <dl >
            <dt class="clearfix"><a href="javascript:;">购物保障</a></dt>
            <dd><a href="javascript:;">正品保证</a></dd>
            <dd><a href="javascript:;">注册协议</a></dd>
            <dd><a href="javascript:;">隐私保护</a></dd>
            <dd><a href="javascript:;">免责声明</a></dd>
        </dl>
        <div class="col-contact">
            <img src="/Public/Home/static/images/vxcode.jpg" width="100px" />
        </div>
    </div>
            <div class="copyright">
                <div class="container bootom">
                    <div class="sub-2">
                        <span>Powered by <a href="http://www.haojiavip.com">好家唯品</a></span> © 2015-2017 <a href="http://www.haojiavip.com">haojiavip.com</a> . 保留所有权利 。
                    </div>
                    <div class="sub-3">
                        <a target="_blank" href="#"><img src="/Public/Home/static/images/f-logo-2.png" alt="诚信网站"></a>
                        <a target="_blank" href="#"><img src="/Public/Home/static/images/f-logo-1.png" alt="诚信网站"></a>
                        <a target="_blank" href="#"><img src="/Public/Home/static/images/f-logo-3.png" alt="网上交易保障中心"></a>
                    </div>
                </div>
            </div>
    </div>
</body>
</html>