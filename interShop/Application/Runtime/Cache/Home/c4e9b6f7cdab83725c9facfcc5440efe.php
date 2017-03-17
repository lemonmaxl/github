<?php if (!defined('THINK_PATH')) exit();?><!Doctype html>
<html lang="zh-CN">
<head>
	<meta charset="UTF-8">
	<title><?php echo $_page_title;?></title>
	<meta name="keywords" content="<?php echo $_page_keywords;?>">
	<meta name="content" content="<?php echo $_page_desc;?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <link type="text/css" rel="stylesheet" href="/Public/Home/css/userc/login.css">
</head>
<body class="login_bj" >
<div class="zhuce_body">
	<div class="logo"><a href="#"><img src="/Public/Home/css/userc/images/logo.png" width="114" height="54" border="0"></a></div>
    <div class="zhuce_kong login_kuang">
    	<div class="zc">
        	<div class="bj_bai">
            <h3>登录</h3>
       	  	  <form action="<?php echo U('Member/login');?>" method="post">
                <input name="username" type="text" class="kuang_txt" placeholder="用户名">
                <input name="password" type="password" class="kuang_txt" placeholder="密码">
                <input name="code" type="text" class="kuang_txt" placeholder="验证码">
                  <div>
                      <div class="hui_kuang"><img style="cursor: pointer;" onclick="this.src='<?php echo U('Member/chkcode')?>?cid='+Math.random()" src="<?php echo U('Member/chkcode');?>"></div>
                  </div>
                <div>
               		<a href="#">忘记密码？</a><input name="readme" type="checkbox" value="" checked><span>记住我</span>
                </div>
                <input type="submit" class="btn_zhuce" value="登录">
                
                </form>
            </div>
        	<div class="bj_right">
            	<p>使用以下账号直接登录</p>
                <a href="#" class="zhuce_qq">QQ注册</a>
                <a href="#" class="zhuce_wb">微博注册</a>
                <a href="#" class="zhuce_wx">微信注册</a>
                <p>没有账号？<a href="<?php echo U('Member/regist');?>">立即注册</a></p>
            
            </div>
        </div>
        <P>Diyhe.com&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;欢迎您定制盒子模型</P>
    </div>

</div>
    
</body>
</html>