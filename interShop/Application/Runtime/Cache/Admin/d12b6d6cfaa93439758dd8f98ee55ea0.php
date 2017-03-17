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
<!--[if IE 6]>
<script type="text/javascript" src="/Public/Admin/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title><?php echo $title_name;?></title>
</head>
<body class="pos-r">
<div>

<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> <?php echo $nav_pre_name;?> <span class="c-gray en">&gt;</span> <?php echo $nav_next_name;?> 
    <?php  if($lst==1){ echo '<a class="btn btn-primary radius r" style="line-height:1.6em;margin-top:3px" href="/index.php/Admin/Goods/lst"><i class="Hui-iconfont">&#xe616;</i> 商品列表</a>'; }elseif($lst==2){ echo '<a class="btn btn-primary radius r" style="line-height:1.6em;margin-top:3px" href="/index.php/Admin/Category/lst"><i class="Hui-iconfont">&#xe616;</i> 分类列表</a>'; }elseif($lst == 3){ echo '<a class="btn btn-primary radius r" style="line-height:1.6em;margin-top:3px" href="/index.php/Admin/Admin/lst"><i class="Hui-iconfont">&#xe616;</i> 管理员列表</a>'; }elseif($lst == 4){ echo '<a class="btn btn-primary radius r" style="line-height:1.6em;margin-top:3px" href="/index.php/Admin/Privilege/lst"><i class="Hui-iconfont">&#xe616;</i> 权限列表</a>'; }elseif($lst == 5){ echo '<a class="btn btn-primary radius r" style="line-height:1.6em;margin-top:3px" href="/index.php/Admin/Role/lst"><i class="Hui-iconfont">&#xe616;</i> 角色列表</a>'; }elseif($lst == 6){ echo '<a class="btn btn-primary radius r" style="line-height:1.6em;margin-top:3px" href="/index.php/Admin/Type/lst"><i class="Hui-iconfont">&#xe616;</i> 类型列表</a>'; }else{ echo '<a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>'; } ?>
</nav>
	


<div class="page-container">
	<form method="get" action="/index.php/Admin/Attribute/lst/type_id/5.html">
		<div class="text-c">&ensp;
			属性名称：
			<input type="text" name="attr_name" style="width:250px" class="input-text" value="<?php echo I('get.attr_name'); ?>">
			类型:
			<?php $typeId = I('get.type_id');?>
			<span class="select-box" style="width: 15%;">
			<select name="type_id" class="select">
				<?php foreach($typeData as $k => $v){ if($v['id'] == $typeId) $select = 'selected="selected"'; else $select = ''; ?>
				<option <?php echo $select;?> value="<?php echo $v['id'];?>"><?php echo $v['type_name'];?></option>
				<?php } ?>
			</select>
			</span>
			属性的类型：
			<input type="radio" name='attr_type' value="-1" class='radio-box' <?php if(I('get.attr_type', -1) == -1) echo 'checked="checked"'; ?> />全部
			<input type="radio" name='attr_type' value="可选" class='radio-box' <?php if(I('get.attr_type', -1) == '可选') echo 'checked="checked"'; ?> />可选
			<input type="radio" name='attr_type' value="唯一" class='radio-box' <?php if(I('get.attr_type', -1) == '唯一') echo 'checked="checked"'; ?> />唯一
			<button class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜属性</button>
		</div>
	</form>
	<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><a class="btn btn-primary radius" href="<?php echo U('Attribute/add?type_id='.I('get.type_id'));?>"><i class="Hui-iconfont">&#xe600;</i> 属性添加</a></span> <span class="r">共有数据：<strong>54</strong> 条</span> </div>
	<form action="/index.php/Admin/Attribute/lst/type_id/5.html" method="post">
		<div class="mt-20">
			<table class="table table-border table-bordered table-bg table-hover table-sort">
				<thead>
				<tr class="text-c">
					<th>属性名</th>
					<th>属性的类型</th>
					<th>属性可选值,多个值用,隔开</th>
					<th>类型&ID</th>
					<th>操作</th>
				</tr>
				</thead>

				<tbody>
				<?php foreach ($data as $k => $v): ?>
				<tr class="text-c va-m">

					<td><?php echo $v['attr_name']; ?></td>
					<td><?php echo $v['attr_type']; ?></td>
					<td class="text-l"><?php echo $v['attr_option_value']; ?></td>
					<td><?php echo $v['type_id']; ?>--<?php foreach($typeData as $v){if($v['id'] == $typeId) echo $v['type_name'];}?></td>
					<td class="td-manage">
						<a style="text-decoration:none" class="ml-5" href="<?php echo U('edit?id='.$v['id'].'&type_id='.$typeId); ?>" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a>
						<a style="text-decoration:none" class="ml-5" onclick="return confirm('确定删除吗?')" href="<?php echo U('delete?id='.$v['id'].'&type_id='.$typeId); ?>" title="删除"><i class="Hui-iconfont">&#xe6e2;</i></a>
					</td>
				</tr>
				<?php endforeach; ?>
				</tbody>
				<tbody>
				<?php if(preg_match('/\d/', $page)): ?>
				<tr><td align="right" nowrap="true" colspan="99" height="30"><?php echo $page; ?></td></tr>
				<?php endif; ?>
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