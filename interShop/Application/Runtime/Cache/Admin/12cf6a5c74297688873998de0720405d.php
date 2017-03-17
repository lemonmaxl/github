<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<!--[if lt IE 9]>
<script type="text/javascript" src="/Public/Admin/lib/html5shiv.js"></script>
<script type="text/javascript" src="/Public/Admin/lib/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="/Public/Admin/back/css/H-ui.min.css" />
<link rel="stylesheet" type="text/css" href="/Public/Admin/css/H-ui.admin.css" />
<link rel="stylesheet" type="text/css" href="/Public/Admin/lib/Hui-iconfont/1.0.8/iconfont.css" />
<link rel="stylesheet" type="text/css" href="/Public/Admin/skin/default/skin.css" id="skin" />
<link rel="stylesheet" type="text/css" href="/Public/Admin/css/style.css" />

<title><?php echo $title_name;?></title>
</head>
<body class="pos-r">
<div>

<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> <?php echo $nav_pre_name;?> <span class="c-gray en">&gt;</span> <?php echo $nav_next_name;?> 
    <?php  if($lst==1){ echo '<a class="btn btn-primary radius r" style="line-height:1.6em;margin-top:3px" href="/index.php/Admin/Goods/lst"><i class="Hui-iconfont">&#xe616;</i> 商品列表</a>'; }elseif($lst==2){ echo '<a class="btn btn-primary radius r" style="line-height:1.6em;margin-top:3px" href="/index.php/Admin/Category/lst"><i class="Hui-iconfont">&#xe616;</i> 分类列表</a>'; }elseif($lst == 3){ echo '<a class="btn btn-primary radius r" style="line-height:1.6em;margin-top:3px" href="/index.php/Admin/Admin/lst"><i class="Hui-iconfont">&#xe616;</i> 管理员列表</a>'; }elseif($lst == 4){ echo '<a class="btn btn-primary radius r" style="line-height:1.6em;margin-top:3px" href="/index.php/Admin/Privilege/lst"><i class="Hui-iconfont">&#xe616;</i> 权限列表</a>'; }elseif($lst == 5){ echo '<a class="btn btn-primary radius r" style="line-height:1.6em;margin-top:3px" href="/index.php/Admin/Role/lst"><i class="Hui-iconfont">&#xe616;</i> 角色列表</a>'; }elseif($lst == 6){ echo '<a class="btn btn-primary radius r" style="line-height:1.6em;margin-top:3px" href="/index.php/Admin/Type/lst"><i class="Hui-iconfont">&#xe616;</i> 类型列表</a>'; }elseif($lst == 7){ echo '<a class="btn btn-primary radius r" style="line-height:1.6em;margin-top:3px" href="/index.php/Admin/MemberLevel/lst"><i class="Hui-iconfont">&#xe616;</i> 会员级别列表</a>'; }else{ echo '<a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>'; } ?>
</nav>
	

﻿

<div class="page-container">
    <form method="get" action="/index.php/Admin/Goods/lst.html">
        <div class="text-c">
            <input type="radio" name='ob' value="id_desc" onchange="this.parentNode.parentNode.submit()" class='radio-box' <?php if(I('get.ob') == 'id_desc') echo 'checked="checked"';?> />id降序
        <input type="radio" name='ob' value="id_asc" onchange="this.parentNode.parentNode.submit()" class='radio-box' <?php if(I('get.ob') == 'id_asc') echo 'checked="checked"';?> />id升序
        <input type="radio" name='ob' value="price_desc" onchange="this.parentNode.parentNode.submit()" class='radio-box' <?php if(I('get.ob') == 'price_desc') echo 'checked="checked"';?> />价格降序
        <input type="radio" name='ob' value="price_asc" onchange="this.parentNode.parentNode.submit()" class='radio-box' <?php if(I('get.ob') == 'price_asc') echo 'checked="checked"';?> />价格升序&ensp;&ensp;

                商品分类：

                <span class="select-box" style="width: 15%;">
				<select name="cat_id" class="select" >
					<option value="">请选择分类</option>
                    <?php
 $cat_id = I('get.cat_id'); foreach($catData as $k => $v){ if($v['id'] == $cat_id){ $select = 'selected = "selected"'; }else{ $select = ''; } ?>
                    <option <?php echo $select; ?> value="<?php echo $v['id'];?>"><?php echo str_repeat('-',$v['level']*6). $v['cat_name'];?></option>
                    <?php } ?>
				</select>
                </span>


            商品名称：
            <input type="text" name="gn" style="width:250px" class="input-text" value="<?php echo I('get.gn');?>">
            价格：从
            <input type="text" name="minP"  class="input-text Wdate" style="width:120px;" value="<?php echo I('get.minP');?>">
                    到
            <input type="text" name="maxP" class="input-text Wdate" style="width:120px;" value="<?php echo I('get.maxP');?>">
            是否上架：
            <input type="radio" name='sale' value="" class='radio-box' <?php if(I('get.sale') == '') echo 'checked="checked"';?> />全部
            <input type="radio" name='sale' value="1" class='radio-box' <?php if(I('get.sale') == 1) echo 'checked="checked"';?> />是
            <input type="radio" name='sale' value="0" class='radio-box' <?php if(I('get.sale') == '0') echo 'checked="checked"';?> />否
            <button class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜产品</button>
        </div>
    </form>
        <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><a class="btn btn-primary radius" href="/index.php/Admin/Goods/add.html"><i class="Hui-iconfont">&#xe600;</i> 商品添加</a></span> <span class="r">共有数据：<strong>54</strong> 条</span> </div>
        <form action="/index.php/Admin/Goods/lst.html" method="post">   
        <div class="mt-20">
                    <table class="table table-border table-bordered table-bg table-hover table-sort">
                            <thead>
                                    <tr class="text-c">
                                            
                                            <th width="40">ID</th>
                                            <th width="60">缩略图</th>
                                            <th>产品名称</th>
                                            <th>描述</th>
                                            <th width="100">本店价</th>
                                            <th width="100">市场价</th>
                                            <th width="60">是否上架</th>
                                            <th width="100">操作</th>
                                    </tr>
                            </thead>
                            <?php foreach($gdata as $k => $v){ ?>
                            <tbody>
                                    <tr class="text-c va-m">
                                        
                                            <td><?php echo $v['id'];?></td>
                                            <td><img width="65" class="product-thumb" src="/Public/Uploads/<?php echo $v['sm_logo'];?>" /></td>
                                            <td class="text-l"><?php echo $v['goods_name'];?></td>
                                            <td class="text-l"><?php echo $v['goods_desc'];?></td>
                                            <td><span class="price"><?php echo $v['shop_price'];?></span> 元</td>
                                            <td><span class="price"><?php echo $v['market_price'];?></span> 元</td>
                                            <td class="td-status">
                                                <?php  if($v['is_on_sale'] == 1) echo '<span class="label label-success radius">是</span>'; elseif($v['is_on_sale'] == '0') echo '<span class="label radius">是</span>'; ?>
                                            </td>
                                            <td class="td-manage"><a style="text-decoration:none"  href="<?php echo U('Goods/goods_number?id='.$v['id']);?>" title="库存量"><i class="Hui-iconfont">&#xe6c6;</i></a>
                                                <a style="text-decoration:none" class="ml-5" href="<?php echo U('Goods/edit?id='.$v['id']);?>" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a>
                                                <a style="text-decoration:none" class="ml-5" onclick="return confirm('确定删除吗?')" href="<?php echo U('Goods/del?id='.$v['id']);?>" title="删除"><i class="Hui-iconfont">&#xe6e2;</i></a>
                                            </td>
                                    </tr>
                            </tbody>
                            <?php }?>                            
                            <tbody>
                                    <tr class="text-c va-m">                                       
                                        <td colspan="8"><?php echo $show;?></td>  
                                    </tr>
                            </tbody>
                    </table>
            
            </div>
        </form>
        
</div>


</div>
<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/Public/Admin/lib/jquery/1.9.1/jquery.min.js"></script>

<!--/_footer 作为公共模版分离出去-->
</body>
</html>