<?php
return array(
    //'配置项'=>'配置值'
    /**********图片相关配置***********/
    'IMAGE_PREFIX' => '/Public/Uploads/', // 显示图片时的前缀
    'IMAGE_SAVE_PATH' => './Public/Uploads/',
    'IMG_maxSize' => 2,
    'IMG_exts' => array('jpg','jpeg','png','gif','pjpeg'),
    /********************设置静态缓存规则******************************/
    'HTML_CACHE_ON'     =>    true, // 开启静态缓存
    'HTML_CACHE_TIME'   =>    60,   // 全局静态缓存有效期（秒）
    'HTML_FILE_SUFFIX'  =>    '.shtml', // 设置静态缓存文件后缀
    'HTML_CACHE_RULES'  =>     array(  // 定义静态缓存规则
         // 定义格式1 数组方式
         //'index:index'    =>     array('index', 3600),
          // 定义格式2 字符串方式
         '静态地址'    =>     '静态规则',
    )
);