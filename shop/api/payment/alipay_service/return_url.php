<?php

$_GET['act']	= 'payment';
$_GET['op']		= 'return';
$_GET['payment_code'] = 'alipay_service';
//$_GET['extra_common_param'] = $_POST['extra_common_param'];
$_GET['extra_common_param'] = 'real_order';
require_once(dirname(__FILE__).'/../../../index.php');

/*
echo $_GET['out_trade_no'];
echo "ok";
*/
?>