<!--
 *
 * 店铺股份管理
 *
 *by joe
-->
<?php defined('InShopNC') or exit('Access Invalid!');?>

<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript">
$(function(){
    $('#query_start_time').datepicker({dateFormat: 'yy-mm-dd'});
    $('#query_end_time').datepicker({dateFormat: 'yy-mm-dd'});
    $('#ncsubmit').click(function(){
    	$('input[name="op"]').val('index');$('#formSearch').submit();
    });
});
</script>
<div class="tabmenu">
    <ul class="tab pngFix">
  <li class="active"><a  href="index.php?act=shares&op=index">我的股份</a></li></ul>
  <ul class="shares"><h5>现持有本站股份： <font size="2" color="red"><?php echo $output['ShopShares']?$output['ShopShares']:'0'; ?></font>股&nbsp;&nbsp;&nbsp;（累计销售股份： <font size="2" color="red"><?php echo $output['shares_sum']?$output['shares_sum']:'0'; ?></font>股）</h5></ul>
</div>
<form method="get">
  <input type="hidden" name="act" value="shares" />
  <input type="hidden" name="op" value="index" />
  <table class="search-form">
    <tr>
     
      <th>订单号</th>
      <td class="w160"><input type="text" class="text w150" name="order_id" value="<?php echo trim($_GET['order_id']); ?>" /></td>
      <th>时间</th>
      <td class="w240"><input class="txt date" type="text" value="<?php echo $_GET['query_start_time'];?>" id="query_start_time" name="query_start_time">
            <label for="query_start_time">~</label>
            <input class="txt date" type="text" value="<?php echo $_GET['query_end_time'];?>" id="query_end_time" name="query_end_time"/></td>     
      <td class="w70 tc"><label class="submit-border"><input type="submit" class="submit" value="<?php echo $lang['nc_search'];?>" /></label></td>
    </tr>
  </table>
</form>
<table class="ncsc-default-table">
  <thead>
    <tr>
      <th class="w130">ID</th>
      <th class="w300">订单号</th>
      <th class="w200">销售额</th>
      <th class="w200">股份</th>
      <th class="w130">时间</th>
    </tr>
  </thead>
  <tbody>
  <!--
	  <tr class="bd-line">
      <td height="30">7000000622023202 <?php echo $value['log_seller_name'];?></td>
      <td >1500<?php echo $value['log_content'];?></td>
      <td>300</td>
      <td><?php echo $value['log_seller_ip'];?></td>
      <td><?php echo date('Y-m-d H:s', $value['log_time']);?>20160333223</td>
    </tr>
	-->
    <?php if(!empty($output['shares_list']) && is_array($output['shares_list'])){?>
    <?php foreach($output['shares_list'] as $key => $value){?>
    <tr class="bd-line">
      <td><?php echo $value['shares_sn'];?></td>
      <td height="30"><?php echo $value['order_sn'];?></td>
      <td ><?php echo $value['order_amount'];?>（元）</td>
      <td><?php echo $value['shares_amount'];?>（股）</td>
      <td><?php echo date('Y-m-d H:s', $value['add_time']);?></td>
    </tr>
    <?php }?>
    <?php }else{?>
    <tr>
      <td colspan="20" class="norecord"><div class="warning-option"><i class="icon-warning-sign"></i><span><?php echo $lang['no_record'];?></span></div></td>
    </tr>
    <?php }?>
  </tbody>
  <tfoot>
    <tr>
      <td colspan="20"><div class="pagination"><?php echo $output['show_page']; ?></div></td>
    </tr>
  </tfoot>
</table>
