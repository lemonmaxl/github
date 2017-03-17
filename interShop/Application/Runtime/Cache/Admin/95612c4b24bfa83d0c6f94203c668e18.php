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
	



<div class="page-container">
	<form action="/index.php/Admin/Category/add" method="post" class="form form-horizontal" id="form-user-add">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>上级分类：</label>
			<div class="formControls col-xs-6 col-sm-6">
				<span class="select-box">
					<select name="parent_id" class="select" >
						<option value="0">顶级分类</option>
						<?php foreach($data as $k => $v){?>
						<option value="<?php echo $v['id'];?>"><?php echo str_repeat('-',$v['level']*6).$v['cat_name'];?></option>
						<?php }?>
					</select>
				</span>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>分类名称：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="" name="cat_name" style='width:30%'>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">推荐为楼层：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="radio" name="is_rec" value="是" >是
				<input type="radio" name="is_rec" value="否" checked>否
			</div>
		</div>
		<div class="row cl">
			<div class="col-9 col-offset-2">
				<input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;" />
				<input type="reset" class="btn btn-success radius" value="&nbsp;&nbsp;重置&nbsp;&nbsp;" />
			</div>
		</div>
	</form>
</div>

</div>
<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/Public/Admin/lib/jquery/1.9.1/jquery.min.js"></script>

<!--/_footer 作为公共模版分离出去-->
</body>
</html>