<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php defined('InShopNC') or exit('Access Invalid!');?>
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/pinter.css" rel="stylesheet" type="text/css"/>
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
<div class="print-layout">
<?php if (!empty($output['order_info'])){?>
 <?php foreach ($output['goods_list'] as $item_k =>$item_v){?>
<table id="__01" width="800" height="926" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="320" height="60" align="left" valign="middle">
		  <img src="<?php echo UPLOAD_SITE_URL.DS.ATTACH_COMMON.DS.$output['setting_config']['site_logo']; ?>" height="60"></td>
		<td width="480" height="60" align="left" valign="baseline"><h1>www.ebuyuda.com</td>
		
		
        
	</tr>
 
	<tr>
		<td height="66" colspan="2" align="left">
		  <table width="100%" border="0">
		    <tr>
		      <td width="54%" height="50"><img src="../ID_image/ebuyda_order1D.php?text=<?php echo $output['order_info'] ['order_sn'];?>" alt="barcode" height="70"/></td>
		      <td width="46%" valign="bottom">System Number：<?php echo $output['order_info'] ['order_sn'];?></td>
	        </tr>
        </table></td>
  </tr>

	<tr>
	  <td height="90" colspan="5"><table width="100%" height="80" border="0"style="border:1px solid #000;  padding:10px 0;">
	   
		<tr>
		  <td width="35%" align="left">To：<?php echo $output['order_info']['extend_order_common']['reciver_name'];?></td>
	      <td width="35%" align="left">Celphoner:<?php echo @$output['order_info']['extend_order_common']['reciver_info']['phone'];?></td>
	      <td width="30%" align="left"><?php if (!empty($output['yundaexorder']['yundaex_order_systemnumber'])){;?>
              <span>Tracking Number：<?php echo $output['yundaexorder']['yundaex_order_systemnumber'];?></span>
              <?php }?></td>
        </tr>
	    <tr>
	      <td align="left">Order time：<?php echo @date('Y-m-d',$output['order_info']['add_time']);?></td>
	      <td align="left">Address：<?php echo @$output['order_info']['extend_order_common']['reciver_info']['address'];?></td>
	     
        </tr>
	   
      </table></td>
  </tr>
	<tr>
		<td height="305" colspan="5" valign="top" style="border-top:1px solid #000; border-bottom:1px solid #000; padding:10px 0;">
        	<table style="text-align:center; border:1px solid #000;" width="100%" height="332" border="0">
   <tr>
    <td height="380" colspan="3" valign="top">
   <table width="100%">
  <tr align="center">
    <td width="56" height="35"><strong>Serial Number</strong></td>
    <td height="35"><strong>Name</strong></td>
    <td width="105" height="35"><strong>Unit</strong></td>
    <td width="43" height="35"><strong>Quantity</strong></td>
    <td width="60" height="35"><strong>Unit Price</strong></td>
    <td width="91"><strong>Shipping</strong></td>
    <td width="91" height="35"><strong>Subtotal</strong></td>
	<?php if ($GLOBALS['setting_config']['tax_status']==5){?>
    <td width="91"><strong>Estimate Customs Duty</strong></td>
	<?php }?>
  </tr>
   <?php foreach ($item_v as $k=>$v){?>
 
  <tr align="center" >
    <td height="30"><?php echo $k;?></td>
    <td align="left"><?php echo $v['goods_name'];?></td>
    <td align="left"><?php echo $v['spec_info'];?></td>
    <td><?php echo $v['goods_num'];?></td>
    <td><?php echo $lang['currency'].$v['goods_price'];?></td>
    <td><?php echo $output['order_info']['shipping_fee'];?></td>
	
    <td><?php echo $lang['currency'].$v['goods_all_price'];?></td>
	<?php if ($GLOBALS['setting_config']['tax_status']==5){?>
    <td><?php echo $lang['currency'].(round($output['goodsinfo'][$k-1]['goods_price']*$output['good_class'][$k-1]['tax_rate']*$v['goods_num'],2));?></td>
	<?php }?>
  </tr>
  
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
    <td><?php echo $output['goods_all_num'];?></td>
    <td><?php echo $lang['currency'].$output['goods_total_price'];?></td>
    <td><?php echo $lang['currency'].$output['order_info']['shipping_fee'];?></td>
    <td><?php echo $lang['currency'].$output['order_info']['order_amount'];?></td>
	<?php if ($GLOBALS['setting_config']['tax_status']==5){?>
    <td><?php echo $lang['currency'].$output['tax'];?></td>
	 <?php }?>
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
		        <td width="32%" height="45" align="left" >Customer Service Number：&nbsp; <?php echo $output['store_info']['store_tel'];?></td>
		        <td width="100%" align="left" >Address：&nbsp;<?php echo $output['depot']['depot_address'];?></td>
		        </tr>
		      <tr>
		        <td></td>
		        <td height="141" colspan="2"><?php if (!empty($output['yundaexorder']['yundaex_order_systemnumber'])){;?><strong>Tracking Number</strong><br/><img src="../ID_image/ebuyda_order1D.php?text=<?php echo $output['yundaexorder']['yundaex_order_systemnumber'];?>" alt="barcode" height="60" /><?php }else{?>Tracking information not yet available<?php }?></td>
		        </tr>
	        </table></td>
		   <td width="1%" ></td>
		    <td width="29%" ><table width="100%" border="0" height="200" style="text-align:center; border:1px solid #000;">
			 <tr>
		              <td height="105"><table width="100%" border="0">
		                <tr>
		                  <td width="50%" align="right">Subtotal：</td>
		                  <td width="100%" align="left">&nbsp;<?php echo $lang['currency'].$output['goods_total_price'];?></td>
		                  </tr>
						 <?php if ($GLOBALS['setting_config']['tax_status']==5){?>
		                <tr>
		                  <td align="right">Prepaid Customs Duty：
：</td>
		                  <td align="left">&nbsp;<?php echo $lang['currency'].$output['order_info']['tax_fee'];?></td>
		                  </tr>
						  <?php }?>
		                <tr>
		                  <td align="right">Shipping：</td>
		                  <td align="left">&nbsp;<?php echo $lang['currency'].$output['order_info']['shipping_fee'];?></td>
		                  </tr>
						   <tr>
		                  <td align="right">Discount：</td>
		                   <td align="left">&nbsp;<?php echo $lang['currency'].$output['promotion_amount'];?></td>
		                  </tr>
		                </table></td>
	                </tr>
		            <tr>
		              <td height="56"><table style="text-align:left; border-top:1px solid #000;" width="100%" height="100%" border="0">
		                <tr>
		                  <td width="80" align="right"><h3>Total：</h3></td>
		                  <td align="left"><h3><?php echo $lang['currency'].$output['order_info']['order_amount'];?></h3>
						  </td>
		                  </tr>
		                </table></td>
	                </tr>
		     
	        </table></td>
	      </tr>
      </table></td>
		
  </tr>
            
 
	
	
	
		<tr>
		  <td height="80" colspan="3" align="center">2015 Goodsuper. All rights reserved.Refer to website for all terms and conditions.mall </td>
  </tr>
		  <td colspan="3" align="center" valign="top" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #666; padding:0px 0px 0px 30px;">●●●Thank you for shopping with us●●●
	      </td>
	</tr>
	
</table>
</div>
<?php } ?>
<?php } ?>
<!-- End ImageReady Slices -->
</body>
</html>