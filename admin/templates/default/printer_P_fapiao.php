<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php defined('InShopNC') or exit('Access Invalid!');?>
<link href="../templates/default/css/pinter.css" rel="stylesheet" type="text/css"/>
<style>
body table {
	border:0px; margin:0 auto; text-align:center; font-size:12px;
}
td {
	font-family:"微软雅黑","宋体", Arial, Helvetica, sans-serif; color:#000;
}
</style>
<title>发票打印--<?php echo $output['store_info']['store_name'];?><?php echo $lang['member_printorder_title'];?></title>
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
		$model = Model();
		$price=0;
		$tax=0;
		$total=0;
		$ship = 0;
		
		//订单商品
		if (!empty($order_info['order_id'])){
		$ordergoods_list= $ordergoods_model->getOrderGoodsList(array('order_id'=>$order_info['order_id']));
		$ordergoods_listnew = array();
		$goods_allnum = 0;
		$goods_totleprice = 0;
		if (!empty($ordergoods_list)){
			$goods_count = count($ordergoods_list);
			$i = 1;
			foreach ($ordergoods_list as $k=>$v){
				$v['goods_name'] = str_cut($v['goods_name'],100);
				$v['spec_info'] = str_cut($v['spec_info'],40);
				$goods_allnum += $v['goods_num'];				
				$v['goods_allprice'] = ncPriceFormat($v['goods_num']*$v['goods_price']);
				$goods_totleprice += $v['goods_allprice'];
				$ordergoods_listnew[ceil($i/4)][$i] = $v;
				$goodsinfo[$k] = $model->table('goods')->where(array('goods_id'=>array('in',$v['goods_id'])))->find();
				$good_class[$k] = $model->table('goods_class')->where(array('gc_id'=>array('in',$goodsinfo[$k]['gc_id'])))->find();
				$price += $goodsinfo[$k]['goods_price']*$v['goods_num'];
				$tax += round($goodsinfo[$k]['goods_price']*$good_class[$k]['tax_rate']*$v['goods_num'],2);
				$ship += round(($v['goods_allprice']-$goodsinfo[$k]['goods_price']*$v['goods_num']),2);
				$total = $v['goods_allprice']+$total;
				$i++;
			}
		}
		//优惠金额
		$goods_primeprice = $model_store->goods_primeprice($v['goods_id']);
		$order_info['discount'] = ncPriceFormat($order_info['voucher_price']+($v['goods_allprice']+$order_info['tax_fee']-$order_info['order_amount']));
		//运费
		$shipping_fee =$order_info['order_amount']-$goods_primeprice['goods_price']*$goods_allnum;
		}
?>
 <?php if (!empty($order_info['order_id'])){?>
<div class="print-layout">
<table id="__01" width="800" height="926" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="320" height="60" align="left" valign="middle">
		  <img src="../upload/printer.gif" height="60"></td>
		<td width="480" height="60" align="left" valign="baseline"><h1>www.<?php echo $GLOBALS['setting_config']['subdomain_suffix']; ?></td>
		
		
        
	</tr>
 
	<tr>
		<td height="66" colspan="2" align="left">
		  <table width="100%" border="0">
		    <tr>
		      <td width="54%" height="50">
			  <?php if (!empty($order_info['order_sn'])){?>
			  <img src="../ID_image/ebuyda_order1D.php?text=<?php echo $order_info ['order_sn'];?>" alt="barcode" height="70"/>
			  <?php }?>
			  </td>
		      <td width="46%" valign="bottom">System Number：<?php echo $order_info ['order_sn'];?></td>
	        </tr>
        </table></td>
  </tr>

	<tr>
	  <td height="133" colspan="5"><table width="100%" height="116" border="0"style="border:1px solid #000;  padding:10px 0;">
	   
		<tr>
		  <td width="35%" align="left">To：<?php echo $order_info['true_name'];?></td>
	      <td width="35%" align="left">Celphoner:<?php echo $order_info['mob_phone'];?></td>
	      <td width="30%" align="left"><?php if (!empty($yundaexorder['yundaex_order_systemnumber'])){;?>
              <span>Tracking Number：<?php echo $yundaexorder['yundaex_order_systemnumber'];?></span>
              <?php }?></td>
        </tr>
	    <tr>
	      <td align="left">Zip Code：<?php echo $order_info['zip_code'];?></td>
	      <td align="left">Home Phone：<?php echo $order_info['tel_phone'];?></td>
	      <td align="left">Order PlacedAddress：<?php echo @date('Y-m-d',$order_info['add_time']);?></td>
        </tr>
	    <tr>
	      <td align="left">City/State：<?php echo $order_info['area_info'];?></td>
	      <td colspan="2" align="left">Address：<?php echo $order_info['address'];?></td>
        </tr>
      </table></td>
  </tr>
	<tr>
		<td height="305" colspan="5" valign="top" style="border-top:1px solid #000; border-bottom:1px solid #000; padding:10px 0;">
        	<table style="text-align:center; border:1px solid #000;" width="100%" height="332" border="0">
   <tr>
    <td height="380" colspan="3" valign="top">
   <table >
 <tr align="center">
    <td width="56" height="35"><strong>Serial Number</strong></td>
    <td height="35"><strong>Name</strong></td>
    <td width="105" height="35"><strong>Unit</strong></td>
    <td width="43" height="35"><strong>Quantity</strong></td>
    <td width="60" height="35"><strong>Unit Price</strong></td>
    <td width="91"><strong>Shipping</strong></td>
    <td width="91" height="35"><strong>Subtotal</strong></td>
	<?php if ($GLOBALS['setting_config']['tax_status']==1){?>
    <td width="91"><strong>Estimate Customs Duty</strong></td>
	<?php }?>
  </tr>
   <?php if (!empty($order_info['order_id'])){?>
  <?php foreach ($ordergoods_listnew as $item_k =>$item_v){?>
  <?php foreach ($item_v as $k=>$v){?>
 
  <tr align="center" >
    <td height="30"><?php echo $k;?></td>
    <td align="left"><?php echo $v['goods_name'];?></td>
    <td align="left"><?php echo $v['spec_info'];?></td>
    <td><?php echo $v['goods_num'];?></td>
    <td><?php echo $lang['currency'].$goodsinfo[$k-1]['goods_price'];?></td>
    <td><?php echo $lang['currency'].round(($v['goods_allprice']-$goodsinfo[$k-1]['goods_price']*$v['goods_num']),2);?></td>
	
    <td><?php echo $lang['currency'].$v['goods_allprice'];?></td>
	<?php if ($GLOBALS['setting_config']['tax_status']==1){?>
    <td><?php echo $lang['currency'].(round($goodsinfo[$k-1]['goods_price']*$good_class[$k-1]['tax_rate']*$v['goods_num'],2));?></td>
	<?php }?>
  </tr>
  
   <?php }?>
    <?php }?>
	 <tr align="center">
    <td height="50">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
     <tr align="center">
    <td height="30"></td>
    <td align="right"></td>
    <td >Total Quantity:</td>
    <td><?php echo $goods_allnum;?></td>
    <td><?php echo $lang['currency'].$price;?></td>
    <td><?php echo $lang['currency'].$ship;?></td>
    <td><?php echo $lang['currency'].$total;?></td>
	<?php if ($GLOBALS['setting_config']['tax_status']==1){?>
    <td><?php echo $lang['currency'].$tax;?></td>
	 <?php }?> <?php }?>
  </tr>
  </table >
 
    </td>
    </tr>
    
    
</table>
	  </td>
  </tr>
    
	<tr>
		<td height="122" colspan="5" rowspan="1" style="padding-top:10px;"><table width="100%" height="100%" border="0">
		  <tr>
		    <td width="70%" ><table width="100%" height="186" border="0" style="text-align:center; border:1px solid #000;">
		      <tr>
		        <td width="3%" >&nbsp;</td>
		        <td width="32%" height="45" align="left" >Customer Service Number：&nbsp; <?php echo $store_info['store_tel'];?></td>
		        <td width="100%" align="left" >Address：&nbsp;<?php echo $depot['depot_address'];?></td>
		        </tr>
		      <tr>
		        <td></td>
		        <td height="141" colspan="2"><?php if (!empty($yundaexorder['yundaex_order_systemnumber'])){;?><strong>Tracking Number</strong><br/><img src="../ID_image/ebuyda_order1D.php?text=<?php echo $yundaexorder['yundaex_order_systemnumber'];?>" alt="barcode" height="60" /><?php }else{?>Tracking information not yet available<?php }?></td>
		        </tr>
	        </table></td>
		   <td width="1%" ></td>
		    <td width="29%" ><table width="100%" border="0" height="200" style="text-align:center; border:1px solid #000;">
			 <tr>
		              <td height="105"><table width="100%" border="0">
		                <tr>
		                  <td width="30%" align="right">Subtotal：</td>
		                  <td width="100%" align="left">&nbsp;<?php echo $lang['currency'].$price;?></td>
		                  </tr>
						 <?php if ($GLOBALS['setting_config']['tax_status']==1){?>
		                <tr>
		                  <td align="right">Prepaid Customs Duty：</td>
		                  <td align="left">&nbsp;<?php echo $lang['currency'].$order_info['tax_fee'];?></td>
		                  </tr>
						  <?php }?>
		                <tr>
		                  <td align="right">Shipping：</td>
		                  <td align="left">&nbsp;<?php echo $lang['currency'].$ship;?></td>
		                  </tr>
						   <tr>
		                  <td align="right">Discount：</td>
		                  <td align="left">&nbsp;<?php if ($GLOBALS['setting_config']['tax_status']==1){ $s = $order_info['tax_fee'];}else{$s=0;} $T= $order_info['order_amount']-($goods_totleprice + $s); echo $lang['currency'].$T;?></td>
		                  </tr>
		                </table></td>
	                </tr>
		            <tr>
		              <td height="56"><table style="text-align:left; border-top:1px solid #000;" width="100%" height="100%" border="0">
		                <tr>
		                  <td width="80" align="right"><h3>Total：</h3></td>
		                  <td align="left"><h3><?php echo $lang['currency'].$order_info['order_amount'];?></h3>
						  </td>
		                  </tr>
		                </table></td>
	                </tr>
		     
	        </table></td>
	      </tr>
      </table></td>
		
  </tr>
            
 
	
	
	
		<tr>
		  <td height="80" colspan="3" align="center">2014 Goodsuper. All rights reserved.Refer to website for all terms and conditions.UDAmall </td>
  </tr>
		  <td colspan="3" align="center" valign="top" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #666; padding:0px 0px 0px 30px;">●●●Thank you for shopping with us●●●
	      </td>
	</tr>
	
</table>
</div>
<?php }else {?>
<div class="print-layout">
输入错误或找不到此订单: <?php echo $order_id ;?>
</div>
 <?php }?>
 <?php }?>
<!-- End ImageReady Slices -->
</body>
</html>