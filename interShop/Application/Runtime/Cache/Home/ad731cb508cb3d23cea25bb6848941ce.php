<?php if (!defined('THINK_PATH')) exit();?><!Doctype html>
<html lang="zh-CN">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
	<meta charset="UTF-8">
	<meta name="HandheldFriendly" content="True">
	<link rel="shortcut icon" href="/favicon.ico"/>
	<link rel="bookmark" href="/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="/Public/Home/css/common.css">
	<link rel="stylesheet" type="text/css" href="/Public/Home/css/dlog.css">
	<script src="/Public/Home/js/navjs/global.js"></script>
	<script src="/Public/Home/js/cart/cart1.js"></script>
	<title><?php echo $_page_title;?></title>
	<link rel="stylesheet" type="text/css" href="/Public/Home/css/HJ-icon/iconfont.css" />
</head>
<body>
<!--  头部区域 -->
<div id="header">
	<div class="topbar">
		<div class="layout-2 container">
			<div class="sub-1">欢迎来到好家唯品,用心即所得！
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
					<a href="<?php echo U('/')?>" style="color: #F22E00;float: right;padding-right: 80px;">好家唯品首页</a>
				</ul>
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
		<a href="<?php echo U('/'); ?>" class="sub-1 logo" style="background-image: url(/Public/Home/static/images/logo.png);"></a>
		<div id='cart_navs'>
			<ul class="crumbs clearfix mt15 step-4">
				<li >4、订购完成<em></em><i></i></li>
				<li >3、选择支付<em></em><i></i></li>
				<li >2、确认订单信息<em></em><i></i></li>
				<li class="pass">1、购物车<em></em><i></i></li>
			</ul>
		</div>
	</div>
</div>
<!--  头部区域 -->

<!--  主控区域 -->
<div id="main" class="simple-main">

	<div class="mt20  container">
		<div style="height: 700px;">
		<table width="100%" class="simple">
			<tr>
				<th style="width:60px;">商品</th>
				<th style="width:200px;">名称</th>
				<th style="width:160px;">规格</th>
				<th style="width:100px;">单价</th>
				<th style="width:120px;">数量</th>
				<th style="width:100px;">优惠</th>
				<th style="width:80px;">小计</th>
				<th style="width:40px;">操作</th>
			</tr>
			<?php
 $totalPrice = 0; foreach($data as $k => $v){ ?>
			<tr class="even" goods_id="<?php echo $v['goods_id']; ?>" goods_attr_id_list="<?php echo $v['goods_attr_id_list']; ?>">
				<td>
					<a href="<?php echo U('Index/goods?id='.$v['goods_id']);?>" target="_blank"><?php showImage($v['sm_logo'],65);?></a>
				</td>
				<td>
					<a href="<?php echo U('Index/goods?id='.$v['goods_id']);?>" target="_blank"><?php echo $v['goods_name'];?></a>
				</td>
				<td>
					<?php foreach($v['gaData'] as $k1 => $v1){?>
					<p><?php echo $v1['attr_name'];?> ：<?php echo $v1['attr_value'];?></p>
					<?php } ?>
				</td>
				<td id="onepace">￥<span><?php echo $v['price'];?></span></td>
				<td>
					<div  class="buy-num-bar buy-num clearfix">
						<a class="btn-dec" href="javascript:;"><i class="Hui-iconfont" style="color: #b7b3b3;">&#xe6a1;</i></a>
						<input  name="buy_num" value="<?php echo $v['goods_number'];?>"  maxlength=5>
						<a class="btn-add" href="javascript:;"><i class="Hui-iconfont" style="color: #b7b3b3;">&#xe600;</i></a>
					</div>
				</td>
				<td class="prom">

				</td>
				<td class="amount red">￥<span>
					<?php
 $xj = $v['price'] * $v['goods_number']; $totalPrice += $xj; echo $xj; ?></span>
				</td>
				<td class="tc">
					<a onclick="delGoods(this);" href="javascript:void(0);">删除</a>
				</td>
			</tr>
			<?php } ?>
		</table>
		<div class="mb10 clearfix" style="padding:10px; background: #f0f0f0;">
			<span class="fr">商品总价(不含运费)：<span style="font-size: 24px;font-family: tahoma"><span class="currency-symbol">￥</span><b class="cart-total red" ><?php echo $totalPrice;?></b></span></span>
		</div>

		<div class="mt10 clearfix">
			<p class="fr">
				<a class="btn btn-gray" href="<?php echo U('Index/index');?>">继续购物</a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-main" href="<?php echo U('Order/add');?>">立即结算</a>
			</p>
		</div>
		</div>
	</div>


</div>
<!--  主控区域 -->

<div id="footer">
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
<script type="text/javascript">
    // ajax请求修改商品数量
    function updataCartGoodsNum(goodsId,goodsAttrId,goodsNum){
        $.ajax({
            type : "GET",
            url : "<?php echo U('ajaxUpdateCartData','',false); ?>/goods_id/"+goodsId+"/goods_attr_id_list/"+goodsAttrId+"/goods_number/"+goodsNum
        });
    }
    function delGoods(a){
        if(confirm('确定要删除吗?')){
			// 执行ajax
			// 找到tr标签
			var tr = $(a).parent().parent();
			var goodsId = tr.attr("goods_id");
			var goodsAttrId = tr.attr("goods_attr_id_list");
            updataCartGoodsNum(goodsId,goodsAttrId,0);
            tr .remove();
		}
	}
</script>