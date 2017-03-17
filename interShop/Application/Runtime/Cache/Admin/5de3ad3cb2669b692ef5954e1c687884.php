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
        <a class="btn btn-primary radius r" style="line-height:1.6em;margin-top:3px" href="<?php echo U('Attribute/lst?type_id='.I('get.type_id'));?>"><i class="Hui-iconfont">&#xe616;</i> 属性列表</a>
    </nav>
<div class="page-container">
    <form class="form form-horizontal" id="form-admin-add" method="POST" action="/index.php/Admin/Attribute/edit/id/1/type_id/3.html" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>属性名：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo $data['attr_name']; ?>"   name="attr_name" style="width: 30%;">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>属性的类型：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="radio" name='attr_type' value="可选" class='radio-box' <?php if($data['attr_type'] == '可选') echo 'checked="checked"'; ?>/>可选
                <input type="radio" name='attr_type' value="唯一" class='radio-box' <?php if($data['attr_type'] == '唯一') echo 'checked="checked"'; ?>/>唯一
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>属性可选值,多个值用,隔开：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo $data['attr_option_value']; ?>"   name="attr_option_value" style="width: 30%;">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>类型：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <?php $typeId = I('get.type_id');?>
                <span class="select-box" style="width: 15%;">
                    <select name="type_id" class="select">
                        <?php foreach($typeData as $k => $v){ if($v['id'] == $typeId) $select = 'selected="selected"'; else $select = ''; ?>
                        <option <?php echo $select; ?> value="<?php echo $v['id'];?>"><?php echo $v['type_name'];?></option>
                        <?php } ?>
                    </select>
                </span>
            </div>
        </div>

        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                <input class="btn btn-success radius" type="reset" value="&nbsp;&nbsp;重置&nbsp;&nbsp;">
            </div>
        </div>
    </form>
</div>
</div>
<script type="text/javascript" src="/Public/Admin/lib/jquery/1.9.1/jquery.min.js"></script>

</body>
</html>