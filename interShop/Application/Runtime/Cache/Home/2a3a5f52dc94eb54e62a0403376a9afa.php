<?php if (!defined('THINK_PATH')) exit();?><!Doctype html>
<html lang="zh">
<head>
	<meta charset="UTF-8">
	<title><?php echo $_page_title;?></title>
	<link rel="stylesheet" type="text/css" href="/Public/Home/css/common.css">
</head>
<body>
<div class="p10">
	<form action="/index.php/Home/Address/edit" method="post">
	<input type="hidden" name="id" value="">
	<table class="form">
		<tr>
			<td class="label">所在地区：</td>
			<td>
				<select name="province" >
				<option value="0">==省份/直辖市==</option>
				<option value="1">直辖市</option>
				<option value="2">直辖市</option>
				</select>
				<select name="city">
					<option value="0">==市==</option>
					<option value="1">范德萨</option>
					<option value="2">用户</option>
				</select>
				<select name="county">
					<option value="0">==县/区==</option>
					<option value="1">县区</option>
					<option value="2">县区</option>
				</select>
				<input  type="text" style="visibility:hidden;width:0;" value="" alt="请选择完整地区信息！"><label></label>
			</td>
		</tr>
		<tr>
			<td class="label">邮政编码：</td>
			<td>
				<input  type="text" name="zip" value="" alt="邮政编码错误">
			</td>
		</tr>
		<tr>
			<td class="label">街道地址：</td>
			<td>
				<textarea name="addr"  alt="不需要重复填写省市区，必须大于5个字符，小于120个字符"></textarea> <label>&nbsp;</label>
			</td>
		</tr>
		<tr>
			<td class="label">收货人姓名：</td>
			<td>
				<input type="text"  name="accept_name"  value="" alt="不为空，且长度不得超过10个字"> <label></label>
			</td>
		</tr>
		<tr>
			<td class="label">手机号码：</td>
			<td>
				<input type="text"  name="mobile" value="" alt="手机号码格式错误"><label></label>
			</td>
		</tr>
		<tr>
			<td class="label">电话号码：</td>
			<td>
				<input type="text" name="phone"  value="" alt="电话号码格式错误"><label></label>
			</td>
		</tr>
		<tr>
			<td class="label">设为默认地址：</td>
			<td>
				<input type="checkbox" name="is_default" value="1"><label>设置为默认收货地址</label>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="tc">
				<input type="submit" value="提交" class="btn">
			</td>
		</tr>
	</table>
</form>
</div>
</body>
</html>