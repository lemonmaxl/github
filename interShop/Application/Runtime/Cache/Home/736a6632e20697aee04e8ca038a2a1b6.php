<?php if (!defined('THINK_PATH')) exit();?><!Doctype html>
<html lang="zh">
<head>
	<meta charset="UTF-8">
	<title>TinyShop商城</title>
	<link rel="stylesheet" type="text/css" href="/Public/Home/css/common.css">
</head>
<body>
<div class=" p10">
	<form id="address-form" class="simple" action="/index.php/Home/Order/address_up" method="post">
	<input type="hidden" name="id" value="">
	<table class="form">
		<tr>
			<td class="label">所在地区：</td>
			<td id="areas">
				<select id="province"  name="province" >
				<option value="0">==省份/直辖市==</option>
				</select>
				<select id="city" name="city">
					<option value="0">==市==</option>
				</select>
				<select id="county" name="county">
					<option value="0">==县/区==</option>
				</select>
				<input pattern="^\d+,\d+,\d+$" id="test" type="text" style="visibility:hidden;width:0;" value="410000,410100,410102" alt="请选择完整地区信息！"><label></label>
			</td>
		</tr>
		<tr>
			<td class="label">邮政编码：</td>
			<td>
				<input  type="text" name="zip" pattern="zip" value="475000" alt="邮政编码错误">
			</td>
		</tr>
		<tr>
			<td class="label">街道地址：</td>
			<td>
				<textarea name="addr" pattern="required" minlen="5" maxlen="120" alt="不需要重复填写省市区，必须大于5个字符，小于120个字符"></textarea> <label>&nbsp;</label>
			</td>
		</tr>
		<tr>
			<td class="label">收货人姓名：</td>
			<td>
				<input type="text" pattern="required" name="accept_name" maxlen="10" value="" alt="不为空，且长度不得超过10个字"> <label></label>
			</td>
		</tr>
		<tr>
			<td class="label">手机号码：</td>
			<td>
				<input type="text" pattern="mobi" name="mobile" value="15890149835" alt="手机号码格式错误"><label></label>
			</td>
		</tr>
		<tr>
			<td class="label">电话号码：</td>
			<td>
				<input type="text" name="phone"  value="" empty pattern="phone" alt="电话号码格式错误"><label></label>
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
				<input type="submit" class="btn">
			</td>
		</tr>
	</table>
</form>
</div>
<script type="text/javascript">
var form =  new Form('address-form');
form.setValue('is_default','1');
  $("#areas").Linkage({ url:"/index.php?con=ajax&act=area_data",selected:[410000,410100,410102],callback:function(data){
	var text = new Array();
	var value = new Array();
	for(i in data[0]){
	  if(data[0][i]!=0){
		text.push(data[1][i]);
		value.push(data[0][i]);
	  }
	}
	$("#test").val(value.join(','));
	FireEvent(document.getElementById("test"),"change");
	}});
</script>
</body>
</html>