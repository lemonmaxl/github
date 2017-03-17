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
	


<script type="text/javascript" src="/Public/Admin/lib/ueditor/1.4.3/ueditor.config.js"></script>
<script type="text/javascript" src="/Public/Admin/lib/ueditor/1.4.3/ueditor.all.min.js"> </script>
<script type="text/javascript" src="/Public/Admin/lib/ueditor/1.4.3/lang/zh-cn/zh-cn.js"></script>

<div class="page-container">
    
    <form class="form form-horizontal" id="form-article-add" action="/index.php/Admin/Goods/add.html" method="post" enctype="multipart/form-data">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品名称：</label>
			<div class="formControls col-xs-8 col-sm-9">
                                <input type="text" name="goods_name"  class="input-text" style="width:50%"/>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>主分类：</label>
			<div class="formControls col-xs-6 col-sm-6">
                <span class="select-box">
				<select name="cat_id" class="select" >
					<option value="">请选择分类</option>
                    <?php foreach($catData as $k => $v){ ?>                 
                    <option  value="<?php echo $v['id'];?>"><?php echo str_repeat('-',$v['level']*6). $v['cat_name'];?></option>
					<?php } ?>
				</select>
                </span> 
			</div>
		</div>

		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">扩展分类：</label>
			<div class="formControls col-xs-6 col-sm-6">
			<input class="btn btn-success radius" type="button"  value="添加一个扩展分类" onclick="addNewExtCat(this)"/>
                <span class="select-box" style="width:30%;">
				<select name="ext_cat_id[]" class="select" >
					<option value="">请选择分类</option>
					<?php foreach($catData as $k => $v){ ?>
                    <option  value="<?php echo $v['id'];?>"><?php echo str_repeat('-',$v['level']*6). $v['cat_name'];?></option>
					<?php } ?>
				</select>
                </span>

			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>类型：</label>
			<div class="formControls col-xs-6 col-sm-6">
                <span class="select-box" style="width:50%;">
				<select name="type_id" class="select" >
					<option value="">请选择类型</option>
					<?php foreach($typeData as $k => $v){ ?>
                    <option  value="<?php echo $v['id'];?>"><?php echo $v['type_name'];?></option>
					<?php } ?>
				</select>
                </span>
				<ul id="attr_list"></ul>
			</div>
		</div>
                <div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品LOGO：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="file" name="logo"  />
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>本店价格：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" name="shop_price" class="input-text" style="width:20%"/>元
			</div>
		</div>
            <div class="row cl">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>市场价格：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" name="market_price" class="input-text" style="width:20%"/>元
				</div>
            </div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">促销价格：</label>
			<div class="formControls col-xs-8 col-sm-9">
				￥<input type="text" name="promote_price" value="" class="input-text" style="width:20%"/>元
				促销开始时间:<input type="text" name="promote_start_date" class="input-text" style="width:20%"/>
				促销结束时间:<input type="text" name="promote_end_date" class="input-text" style="width:20%"/>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">是否新品：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="radio" name="is_new" value="是" >是
				<input type="radio" name="is_new" value="否" checked>否
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">是否热卖：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="radio" name="is_hot" value="是" >是
				<input type="radio" name="is_hot" value="否" checked>否
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">是否推荐：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="radio" name="is_rec" value="是" >是
				<input type="radio" name="is_rec" value="否" checked>否
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">会员价格：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<div class="uploader-list-container" style="width: 70%;font-size: inherit">
					<div class="queueList">
						<?php foreach($mlData as $k => $v){?>
						<label class="form-label col-xs-4 col-sm-2"><?php echo $v['level_name'];?>：</label>
						<div>
							￥<input type="text" name="mp[]" value="" class="input-text" style="width:40%"/>元
							<input type="hidden" name="level_id[]" value="<?php echo $v['id'];?>" />
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">商品相册：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<div class="uploader-list-container">
					<div class="queueList">
						<div id="dndArea" class="placeholder">
							<table id="table_pics">
								<tr>
									<td><input id="btn_add_pic" type="button" value="添加一张图片" class="btn btn-warning radius"/></td>
								</tr>
								<tr>
									<td><input type="file" name="pic[]"/></td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
            <div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品描述：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<script id="goods_desc" type="text/plain" name="goods_desc" style="height:250px;"></script>
	
			</div>
		</div>
            <div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>是否上架：</label>
			<div class="formControls col-xs-8 col-sm-9">
                            
				<input type="radio" name="is_on_sale" value="1" >是
				<input type="radio" name="is_on_sale" value="0" >否
			</div>
		</div>
        <div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
				<button  class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存并提交</button>
				<button  class="btn btn-success radius" type="reset"><i class="Hui-iconfont">&#xe68f;</i> 重置</button>
			</div>
		</div>
	</form>
</div>
<script type="text/javascript" src="/Public/Admin/js/jquery-3.1.1.slim.min.js"></script>
<script type='text/javascript'>
// 编辑器 
var ue = UE.getEditor('goods_desc',{
    autoHeight: false
});
// 添加扩展分类的js
	function addNewExtCat(btn){
	    // 选择后面的下拉框并克隆一个
		var new_sel = $(btn).next('span').clone();
		// 把新的下拉框添加到
		$(btn).parent().append(new_sel);
	}

</script>
<script>
    // 为类型绑定change事件
    $("select[name=type_id]").change(function(){
        // 先取出选择的类型ID
        var type_id = $(this).val();
        $.ajax({
            type : "GET",
            url : "<?php echo U('ajaxGetAttr', '', FALSE); ?>/type_id/"+type_id,
            dataType : "json",
            success : function(data)
            {
                // 循环服务器返回的属性数据拼成一个HTML字符串
                var html = "";
                // 循环每个属性
                $(data).each(function(k,v){
                    html += "<li><input type='hidden' name='attr_id[]' value='"+v.id+"' />";
                    if(v.attr_type == '可选')
                        html += '<a href="javascript:void(0);" onclick="addRow(this);">[ + ]</a>';
                    html += v.attr_name+" : ";
                    if(v.attr_option_value != "")
                    {
                        var _arr = v.attr_option_value.split(",");
                        html += "<select name='goods_attr[]'><option value=''>请选择</option>";
                        for(var i=0; i<_arr.length; i++)
                        {
                            html += '<option value="'+_arr[i]+'">'+_arr[i]+'</option>';
                        }
                        html += "</select>";
                    }
                    else
                        html += "<input type='text' name='goods_attr[]' />";
                    html += "</li>";
                });
                // 把拼好的LI字符串放到页面中
                $("#attr_list").html(html);
            }
        });
    });
    // +号的事件
    function addRow(a)
    {
        // 先选中所在的LI标签
        var li = $(a).parent();
        if(li.find('a').html() == '[ + ]')
        {
            // 克隆一个新的LI
            var newLi = li.clone();
            // 变成-号
            newLi.find('a').html('[ - ]');
            // 新LI放到LI后面
            li.after(newLi);
        }
        else
            li.remove();
    }
    $("#btn_add_pic").click(function(){
        $("#table_pics").append('<tr><td><input type="file" name="pic[]"/></td>td></tr>')
	})
</script>
</div>
<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/Public/Admin/lib/jquery/1.9.1/jquery.min.js"></script>

<!--/_footer 作为公共模版分离出去-->
</body>
</html>