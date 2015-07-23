<?php
/**
 * aurfy银联在线支付浏览器返回地址
 *
 * 
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */

parse_str($_SERVER['QUERY_STRING'],$myArray);

$_GET['act']	= 'payment';
$_GET['op']		= 'notify';

$_POST['out_trade_no'] = $myArray['orderid'];
require_once('../../../index.php');
?>