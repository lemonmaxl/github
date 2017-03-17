<?php
function clearXSS($string)
{
	require_once './htmlpurifier/HTMLPurifier.auto.php';
	// 生成配置对象
	$_clean_xss_config = HTMLPurifier_Config::createDefault();
	// 以下就是配置：
	$_clean_xss_config->set('Core.Encoding', 'UTF-8');
	// 设置允许使用的HTML标签
	$_clean_xss_config->set('HTML.Allowed','div,b,strong,i,em,a[href|title],ul,ol,li,p[style],br,span[style],img[width|height|alt|src]');
	// 设置允许出现的CSS样式属性
	$_clean_xss_config->set('CSS.AllowedProperties', 'font,font-size,font-weight,font-style,font-family,text-decoration,padding-left,color,background-color,text-align');
	// 设置a标签上是否允许使用target="_blank"
	$_clean_xss_config->set('HTML.TargetBlank', TRUE);
	// 使用配置生成过滤用的对象
	$_clean_xss_obj = new HTMLPurifier($_clean_xss_config);
	// 过滤字符串
	return $_clean_xss_obj->purify($string);
}
/**
 * 删除一个数组中所有的图片
 *
 * @param unknown_type $image
 */
function deleteImage($image = array())
{
	$savePath = C('IMAGE_SAVE_PATH');
	foreach ($image as $v)
	{
		unlink($savePath . $v);
	}
}
function hasImage($fileName)
{
    foreach ($_FILES[$fileName]['error'] as $k => $v)
    {
        if($v == 0)
            return TRUE;
    }
    return FALSE;
}
/**
 * 上传图片并生成缩略图
 * 用法：
 * $ret = uploadOne('logo', 'Goods', array(
array(600, 600),
array(300, 300),
array(100, 100),
));
返回值：
if($ret['ok'] == 1)
{
$ret['images'][0];   // 原图地址
$ret['images'][1];   // 第一个缩略图地址
$ret['images'][2];   // 第二个缩略图地址
$ret['images'][3];   // 第三个缩略图地址
}
else
{
$this->error = $ret['error'];
return FALSE;
}
 *
 */
function uploadOne($imgName, $dirName, $thumb = array())
{
    // 上传LOGO
    if(isset($_FILES[$imgName]) && $_FILES[$imgName]['error'] == 0)
    {
        $rootPath = C('IMAGE_SAVE_PATH');
        $upload = new \Think\Upload(array(
            'rootPath' => $rootPath,
        ));// 实例化上传类
        $upload->maxSize = (int)C('IMG_maxSize') * 1024 * 1024;// 设置附件上传大小
        $upload->exts = C('IMG_exts');// 设置附件上传类型
        /// $upload->rootPath = $rootPath; // 设置附件上传根目录
        $upload->savePath = $dirName . '/'; // 图片二级目录的名称
        // 上传文件
        // 上传时指定一个要上传的图片的名称，否则会把表单中所有的图片都处理，之后再想其他图片时就再找不到图片了
        $info   =   $upload->upload(array($imgName=>$_FILES[$imgName]));
        if(!$info)
        {
            return array(
                'ok' => 0,
                'error' => $upload->getError(),
            );
        }
        else
        {
            $ret['ok'] = 1;
            $ret['images'][0] = $logoName = $info[$imgName]['savepath'] . $info[$imgName]['savename'];
            // 判断是否生成缩略图
            if($thumb)
            {
                $image = new \Think\Image();
                // 循环生成缩略图
                foreach ($thumb as $k => $v)
                {
                    $ret['images'][$k+1] = $info[$imgName]['savepath'] . 'thumb_'.$k.'_' .$info[$imgName]['savename'];
                    // 打开要处理的图片
                    $image->open($rootPath.$logoName);
                    $image->thumb($v[0], $v[1])->save($rootPath.$ret['images'][$k+1]);
                }
            }
            return $ret;
        }
    }
}
// 显示图片的函数
function showImage($image, $width='', $height='', $isReturn = FALSE)
{
	// 无论showImage调用多少次，C函数只调用了一次
	static $prefix = null;
	if($prefix === null)
		$prefix = C('IMAGE_PREFIX');
	if($width)
		$width = " width='$width'";
	if($height)
		$height = " height='$height'";
		
	if(!$image)
	{
		$str =  "<img $width $height src='/Public/Home/images/default_goods.jpg' />";
		if($isReturn)
			return $str;
		else 
			echo $str;
		return ;
	}
	
	$str =  "<img $width $height src='{$prefix}{$image}' />";
	if($isReturn)
		return $str;
	else 
		echo $str;
}