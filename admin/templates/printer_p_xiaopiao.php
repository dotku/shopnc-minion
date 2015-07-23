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
<title>导出购物小票--<?php echo $output['store_info']['store_name'];?><?php echo $lang['member_printorder_title'];?></title>
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
		$yundaexorder = $model_store->yundaexorder($order_id);
		
		$ordergoods_model = Model('order_goods');
		$goods_model = Model('goods');
		//订单商品
		if (!empty($order_info['order_id'])){
		$ordergoods_list= $ordergoods_model->getOrderGoodsList(array('order_id'=>$order_info['order_id']));
		$ordergoods_listnew = array();
		$goods_allnum = 0;
		$goods_totleprice = 0;
		if (!empty($ordergoods_list)){
			$goods_count = count($ordergoods_list);
			$i = 1;
			$goods_xiaopiao=array();
			foreach ($ordergoods_list as $k=>$v){
				$v['goods_name'] = str_cut($v['goods_name'],100);
				$v['spec_info'] = str_cut($v['spec_info'],40);
				$goods_allnum += $v['goods_num'];				
				$v['goods_allprice'] = ncPriceFormat($v['goods_num']*$v['goods_price']);
				$goods_totleprice += $v['goods_allprice'];
				$ordergoods_listnew[ceil($i/4)][$i] = $v;
				$i++;
				$goods_xiaopiao[$k]= $goods_model->getOne($v['goods_id']);
			}
		}
		}
?>
<div class="print-layout">
<br/><br/><br/><br/><br/><br/>
<table width="700" border="0" style="text-align:center; border:1px solid #000;">
  <tr align="left" >
    <td colspan="2" style="border-bottom:1px solid #000;">快递单号：<?php echo $yundaexorder['yundaex_order_systemnumber'];?></td>
  </tr>
  <tr align="left" >
    <td colspan="2" style="border-bottom:1px solid #000;"><table width="100%" border="0">
      <tr  align="left">
        <td width="50%">收货人姓名：<?php echo $order_info['true_name'];?></td>
        <td width="50%">电话：<?php echo $order_info['mob_phone'];?></td>
      </tr>
    </table></td>
  </tr>
  <tr align="left">
    <td colspan="2" style=" border-bottom:1px solid #000;">收件地址：<?php echo $order_info['address'];?></td>
  </tr>
  <tr align="left">
    <td width="464" style=" border-bottom:1px solid #000;">订单号码：<?php echo $order_info ['order_sn'];?></td>
    <td width="224" style=" border-bottom:1px solid #000;">数量：<?php echo $goods_allnum;?></td>
  </tr>
  
  <tr>
    <td height="600" colspan="2">
	<?php if (!empty($order_info['order_id'])){?>
	<?php foreach ($goods_xiaopiao as $v){?>
	<?php if (!empty($v['xiaopiao'])){;?> <img src="../upload/xiaopiao/<?php echo $v['xiaopiao'];?> "onload="AutoResizeImage(650,450,this)"><br/> 
	<?php }else{?>还没上传购物小票<?php } ?>
	<?php } ?>
	<?php }else{?>查不到订单号：<?php echo $order_id;}?>
	</td>
  </tr>
</table>
</div>
<?php } ?>

<!-- End ImageReady Slices -->
</body>
</html>