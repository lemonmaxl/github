<?php
/**
 * 为一个订单生成支付宝按钮
 *
 * @param $orderId : 订单ID
 *
 */
function makeAlipayBtn($orderId){
    return require_once('./alipay/alipayapi.php');
}
/**
 * 去某个参数之后的当前地址
 * @param $params
 */
function filterUrl($params){
    // 获取当前地址的URL
    $re = "/\/$params\/[^\/]*/";
    return preg_replace($re,'',$_SERVER['PHP_SELF']);
}