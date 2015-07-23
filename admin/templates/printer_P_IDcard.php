<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php defined('InShopNC') or exit('Access Invalid!');?>
<link href="../templates/default/css/pinter.css" rel="stylesheet" type="text/css"/>
<script src="../resource/js/img.js" type="text/javascript"></script>
<style>
body table {
	border:0px; margin:0 auto; text-align:center; font-size:12px;
}
td {
	font-family:"微软雅黑","宋体", Arial, Helvetica, sans-serif; color:#000;
}
</style>
<title>身份证打印--<?php echo $output['store_info']['store_name'];?><?php echo $lang['member_printorder_title'];?></title>
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<!-- ImageReady Slices (未标题-2.psd) -->
<?php
$r=explode("|",$output['order_id']);
		foreach ($r as $order_id){
		 if ($order_id <= 0){
			exit;
		     }
        $order_model = Model('order');
		$condition['order_id'] = $order_id;
		$order_info = $order_model->getOrderBysn($order_id);
		$model_store	= Model('store');
		$store_info		= $model_store->shopStore(array('store_id'=>$order_info['store_id']));
		if (!empty($store_info['store_label'])){
			if (file_exists(BasePath.DS.ATTACH_STORE.DS.$store_info['store_label'])){
				$store_info['store_label'] = SiteUrl.DS.ATTACH_STORE.DS.$store_info['store_label'];
			}else {
				$store_info['store_label'] = '';
			}
		}
		if (!empty($store_info['store_stamp'])){
			if (file_exists(BasePath.DS.ATTACH_STORE.DS.$store_info['store_stamp'])){
				$store_info['store_stamp'] = SiteUrl.DS.ATTACH_STORE.DS.$store_info['store_stamp'];
			}else {
				$store_info['store_stamp'] = '';
			}
		}
		$depot = $model_store->infodepot($store_info['depot_name']);
		$yundaexorder = $model_store->yundaexorder($order_info['order_id']);
		
		
?>
<?php if (!empty($order_info['order_id'])){?>
<div class="print-layout">
<table width="700" border="0" style="text-align:center; border:1px solid #000;">
  <tr align="left" >
    <td style="border-bottom:1px solid #000;">包裹跟踪号：<?php echo $yundaexorder['yundaex_order_systemnumber'];?></td>
  </tr>
  <tr align="left" >
    <td width="291" style="border-bottom:1px solid #000;"><table width="100%" border="0">
      <tr align="left">
        <td width="50%">收货人姓名：<?php echo $order_info['true_name'];?></td>
        <td width="50%">电话：<?php echo $order_info['mob_phone'];?></td>
      </tr>
    </table></td>
  </tr>
  <tr align="left">
    <td style=" border-bottom:1px solid #000;">身份证号码：<?php echo $order_info['id_number'];?></td>
  </tr>
  <tr align="left">
    <td style=" border-bottom:1px solid #000;">收件地址：<?php echo $order_info['address'];?></td>
  </tr>
  <tr>
    <td height="480" style=" border-bottom:1px solid #000;"><?php if (!empty($order_info['id_pic1'])){;?> <img src="../upload/auth/<?php echo $order_info['id_pic1'];?>" onload="AutoResizeImage(650,450,this)"> 
	<?php }else{?>还没上传身份证正面<?php } ?></td>
  </tr>
  <tr>
    <td height="480"><?php if (!empty($order_info['id_pic1'])){;?> <img src="../upload/auth/<?php echo $order_info['id_pic2'];?> "onload="AutoResizeImage(650,450,this)"> 
	<?php }else{?>还没上传身份证反面<?php } ?></td>
  </tr>
</table>
</div>
<?php }else{?>
<div class="print-layout">查不到订单号：<?php echo $order_id;?></div>
<?php } ?>
<?php } ?>

<!-- End ImageReady Slices -->
</body>
</html>