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
	


<!-- 列表 -->
<div class="page-container">
    <form action="/index.php/Admin/Goods/goods_number/id/42.html" method="post" name="listForm">
        <div class="mt-20">
            <table class="table table-border table-bordered table-bg table-hover table-sort">
                <thead>
                <tr class="text-c">
                    <?php foreach($gaInfo as $k => $v){ ?>
                    <th><?php echo $v[0]['attr_name']?></th>
                    <?php } ?>
                    <th >库存量</th>
                    <th style="width: 120px;">操作</th>
                </tr>
                </thead>
                <tbody>
                <?php if($gnData){?>
                    <?php foreach($gnData as $k0 => $v0){ $_attr = explode(',',$v0['attr_list']); ?>
                <tr class="text-c va-m">
                    <?php foreach ($gaInfo as $k => $v): ?>
                    <td>
                    <select name="gaid[]">
                        <option value="">请选择</option>
                        <?php foreach($v as $k1 => $v1){ if(in_array($v1['id'],$_attr)) $select = 'selected="selected"'; else $select = ''; ?>
                        <option <?php echo $select;?> value="<?php echo $v1['id'];?>"><?php echo $v1['attr_value']?></option>
                        <?php } ?>
                    </select>
                    </td>
                    <?php endforeach; ?>
                    <td><input type="text" value="<?php echo $v0['goods_number'];?>" name="gn[]" class="input-text" style="width:30%;"/></td>
                    <td>
                        <input onclick="addTr(this)" type="button" value="<?php echo $k0==0?'添加':'移除';?>" class="btn btn-success radius"/>
                    </td>
                </tr>
                <?php } ?>
                <?php }else{ ?>
                <tr class="text-c va-m">
                    <?php foreach ($gaInfo as $k => $v): ?>
                    <td>
                        <select name="gaid[]">
                            <option value="">请选择</option>
                            <?php foreach($v as $k1 => $v1){?>
                            <option value="<?php echo $v1['id'];?>"><?php echo $v1['attr_value']?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <?php endforeach; ?>
                    <td><input type="text" value="" name="gn[]" class="input-text" style="width:30%;"/></td>
                    <td>
                        <input onclick="addTr(this)" type="button" value="添加" class="btn btn-success radius"/>
                    </td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="row cl mt-20">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                <button  class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 提交</button>
                <button  class="btn btn-default radius" type="reset"><i class="Hui-iconfont">&#xe68f;</i> 重置</button>
            </div>
        </div>
    </form>
</div>
<script>
    function addTr(btn){
        var tr = $(btn).parent().parent();
        if($(btn).val() == '添加'){
            var newTr = tr.clone();
            newTr.find(":button").val('移除');
            $("tbody").append(newTr);
        }else{
            tr.remove();
        }
    }
</script>
</div>
<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/Public/Admin/lib/jquery/1.9.1/jquery.min.js"></script>

<!--/_footer 作为公共模版分离出去-->
</body>
</html>