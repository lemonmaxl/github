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

    <!--  主控区域 -->
<div id="main">
     <link type="text/css" rel="stylesheet" href="/Public/Home//css/product.css" />
        <div class="bg-base">
        <ol class="bread-crumb container">
            <li><a href="<?php echo U('/'); ?>">首页</a></li>
            <?php foreach($catData as $k => $v){ ?>
            <li><a href="<?php echo U('Search/cat_search?cat_id='.$v['id']); ?>"><?php echo $v['cat_name'];?></a></li>
            <?php } ?>
        </ol>
        </div>
    <div class="container">
    <div class="goods-detail mt10 clearfix" style="position: relative;">
    <div class="content">
        <!-- 筛选部分-->
        <div style="height: 25px;line-height: 25px;border: 1px solid #e4e4e4;border-bottom: none;padding-left: 38px;">
            当前筛选条件:
            <?php
 $filter_price = I('get.price'); if($filter_price){ ?>
            <?php echo $filter_price; ?> <a href="<?php echo filterUrl('price'); ?>">[X]</a>
            <?php } ?>
            <!-- 循环输出当前筛选的属性值-->
            <?php foreach(I('get.') as $k => $v): if(strpos($k,'attr_') ===0): $_attr = explode('-',$v); ?>
            <?php echo $_attr[1]; ?>&ensp;&ensp;<?php echo $_attr[0]; ?> <a href="<?php echo filterUrl($k); ?>">[X]</a>
            <?php endif;endforeach; ?>
        </div>
        <div id="selector">
            <div class="spec-attr box">
                <!-- 品牌-->
                <!-- 价格-->
                <?php if($price && !$filter_price){ ?>
                <dl class="attr clearfix">
                    <dt class="attr-key">价格：</dt>
                    <dd class="attr-value">
                        <?php foreach($price as $k => $v){ ?>
                        <a href="/index.php/Home/Search/cat_search/cat_id/1/price/<?php echo $v; ?>"><?php echo $v; ?><i></i></a>
                       <?php } ?>
                    </dd>
                </dl>
                <?php } ?>
                <!-- 价格-->
                <!--attribute-->
                <?php foreach($gaData as $k => $v){ $v= array_unique($v); $_k = explode('-',$k); $_name = 'attr_'. $_k[1]; if(isset($_GET[$_name])) continue; ?>
                <dl class="attr clearfix">
                    <dt class="attr-key"><?php echo $_k[0]; ?>：</dt>
                    <dd class="attr-value">
                        <?php foreach($v as $k1 => $v1){ ?>
                        <a href="/index.php/Home/Search/cat_search/cat_id/1/attr_<?php echo $_k[1]; ?>/<?php echo $v1;?>_<?php echo $_k[0]; ?>"><?php echo $v1; ?><i></i></a>
                        <?php } ?>
                    </dd>
                </dl>
                <?php } ?>
                <!-- attribute -->
            </div>
            <div id="select-more">
                <div class="attr-extra"><div></div></div>
            </div>
        </div>
        <!-- 筛选部分-->
        <!-- 商品部分-->
        <div class="mt10 product_show  product-list  clearfix">
            <div class="clearfix sortBarTop" style="">
                <div class="sort-bar">
                    <?php $odby = I('get.odby','xl-desc'); ?>
                    <span>排序：</span>
                    <a href="<?php echo filterUrl('odby'); ?>/odby/xl-desc" <?php if(strpos($odby,'xl')===0) echo 'class="current"';?>>销量</a>
                    <!--<a href="" >评论数</a>-->
                    <a  href="<?php echo filterUrl('odby');?>/odby/price-<?php echo $odby=='price-desc'?'asc':'desc'; ?>" <?php if(strpos($odby,'price')===0) echo 'class="current"';?>>
                    价格
                    <?php if(strpos($odby,'price')===0){ ?>
                        <?php if($odby == 'price-desc'){ ?>
                            ↓
                        <?php }else{ ?>
                            ↑
                        <?php } ?>
                    <?php } ?>
                    </a>
                    <a href="<?php echo filterUrl('odby'); ?>/odby/time-desc" <?php if(strpos($odby,'time')===0) echo 'class="current"'; ?>>最新</a>
                </div>
            </div>
            <dl>
                <dd>
                <ul class="clearfix">
                    <!-- goods-well-s -->
                    <?php foreach($data as $k => $v){ ?>
                    <li>
                        <dl class="product">
                            <dt class="img"><a href="<?php echo U('Index/goods?id='.$v['id']); ?>"><?php showImage($v['sm_logo'],210,210); ?></a></dt>
                            <dd class="title"><a href="<?php echo U('Index/goods?id='.$v['id']); ?>"><?php echo $v['goods_name']; ?></a></dd>
                            <dd><span class="price">￥<?php echo $v['shop_price']; ?></span></dd>
                            <dd class="product-ext">&nbsp;&nbsp;&nbsp;&nbsp;
                                <a href="<?php echo U('Index/goods?id='.$v['id']); ?>" class=" btn btn-main fr"><i class="Hui-iconfont">&#xe6b9;</i> 立即购买</a>
                            </dd>
                        </dl>
                    </li>
                    <?php } ?>
                    <!-- goods-well-e -->
                </ul>
            </dd>
        </dl>
        </div>
        <div class="page mt20">
            <?php echo $page; ?>
        </div>
        <!-- 商品部分-->
    </div>
</div>
</div>

<script>
    var attr_extra = '';
    $(".attr").each(function(i){
        var self = $(this);
        if(i>3){
            //self.css("display","none");
           // attr_extra += self.find(".attr-key:eq(0)").text()+"、";
        }
        if(self.find(".attr-value").get(0).scrollHeight>self.height()){
            var span = $("<div class='o-more'>更多<b></b></div>");
            self.append(span);
            if(self.find('.select').size()>0){
                span.html('收起<b></b>');
                span.parent().addClass("unflod");
            }
            span.on("click",function(){
                if($(this).text()=='更多'){
                    $(this).html('收起<b></b>');
                    $(this).parent().addClass("unflod");
                }
                else {
                    $(this).html('更多<b></b>');
                    $(this).parent().removeClass("unflod");
                }
            });
        }
    });

    attr_extra = $(".attr:gt(3) .attr-key").text();
    attr_extra = $.trim(attr_extra);
    attr_extra = attr_extra.replace(/：/gi,'、');
    attr_extra = attr_extra.replace(/、$/gi,'');
    if($(".attr:gt(3)").size()>0){

        if($(".attr:gt(3)").find(".select").size()>0){
            $(".attr:gt(3)").css("display","block");
            $(".attr-extra div:eq(0)").html('收起<b></b>');
            $(".attr-extra").addClass("unflod");
        }else{
            $(".attr:gt(3)").css("display","none");
            $(".attr-extra div:eq(0)").html('更多选项（'+attr_extra+'）<b></b>');
            $(".attr-extra").removeClass("unflod");
        }
    }else{
        $("#select-more").css("display","none");
    }
    $(".attr-extra:eq(0)").on("click",function(){
        if($(".attr:hidden").size()>0){
            $(".attr:gt(3)").css("display","block");
            $(".attr-extra div:eq(0)").html('收起<b></b>');
            $(".attr-extra").addClass("unflod");
        }else{
            $(".attr:gt(3)").css("display","none");
            $(".attr-extra div:eq(0)").html('更多选项（'+attr_extra+'）<b></b>');
            $(".attr-extra").removeClass("unflod");
        }

    })

</script>

</div>
    <!--  主控区域 -->

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