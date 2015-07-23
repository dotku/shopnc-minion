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
$_GET['act']	= 'payment';
$_GET['op']		= 'return';

$_GET['out_trade_no'] = $_GET['orderid'];

require_once('../../../index.php');
?>