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
	


<!-- 搜索 -->
<div class="page-container">
	<form action="/index.php/Admin/Admin/lst" method="GET" name="search_form">
	<div class="text-c"> 管理员名称：
		<input type="text" class="input-text" style="width:250px"   name="username" value="<?php echo I('get.username'); ?>" />
		<button type="submit" class="btn btn-success"><i class="Hui-iconfont">&#xe665;</i> 搜用户</button>
	</div>
	</form>
	<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><a href="javascript:;"  class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
		<a href="<?php echo U('add');?>"  class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加管理员</a></span>
	</div>

	<!-- 列表 -->
	<table class="table table-border table-bordered table-bg">
		<thead>
		<tr>
			<th scope="col" colspan="9">员工列表</th>
		</tr>
		<tr class="text-c">

			<th>ID</th>
			<th>登录名</th>
			<th>密码</th>
			<th>操作</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($data as $k => $v): ?>
		<tr class="text-c">
			<td><?php echo $v['id'];?></td>
			<td><?php echo $v['username']; ?></td>
			<td><?php echo $v['password']; ?></td>
			<td class="td-manage"><a title="编辑" href="<?php echo U('edit?id='.$v['id']); ?>"  class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a title="删除" href="<?php echo U('delete?id='.$v['id']); ?>" onclick="return confirm('确定要删除吗？');" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
		</tr>
		<?php endforeach; ?>
		<?php if(preg_match('/\d/', $page)): ?>
		<tr><td align="right" nowrap="true" colspan="99" height="30"><?php echo $page; ?></td></tr>
		<?php endif; ?>
		</tbody>
	</table>
</div>

</div>
<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/Public/Admin/lib/jquery/1.9.1/jquery.min.js"></script>

<!--/_footer 作为公共模版分离出去-->
</body>
</html>