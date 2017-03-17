<?php if (!defined('THINK_PATH')) exit();?><!Doctype html>
<html lang="zh">
<head>
	<meta charset="UTF-8">
	<title><?php echo $_page_title;?></title>
	<link rel="stylesheet" type="text/css" href="/Public/Home/css/common.css">
	<!--<script src="/Public/Home/js/navjs/global.js"></script>-->
	<script src="/Public/Home/js/region_select.js"></script>
</head>
<body>
<div class="p10">
	<form action="<?php echo U('Address/add');?>" method="post" novalidate="true">
		<input type="hidden" name="member_id" value="<?php echo $memberId; ?>" />
		<table class="form">
			<tr>
				<td class="label">所在地区：</td>
				<td>
					<select name="province" id="province" ></select>
					<select name="city" id="city"></select>
					<select name="area" id="area"></select>
				</td>
			</tr>
			<tr>
				<td class="label">邮政编码：</td>
				<td>
					<input  type="text" name="zip" value="">
				</td>
			</tr>
			<tr>
				<td class="label">街道地址：</td>
				<td>
					<textarea name="addr" ></textarea> <label>&nbsp;</label>
				</td>
			</tr>
			<tr>
				<td class="label">收货人姓名：</td>
				<td>
					<input type="text"  name="shr_name"  value=""> <label></label>
				</td>
			</tr>
			<tr>
				<td class="label">手机号码：</td>
				<td>
					<input type="text"  name="mobile" value=""><label></label>
				</td>
			</tr>
			<tr>
				<td class="label">电话号码：</td>
				<td>
					<input type="text" name="phone"  value="" ><label></label>
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

<script type="text/javascript">
	new PCAS('province', 'city', 'area', '北京市', '', '');
</script>