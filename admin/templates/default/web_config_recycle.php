<?php defined('InShopNC') or exit('Access Invalid!');?>
<link rel="stylesheet" type="text/css" href="<?php echo ADMIN_TEMPLATES_URL;?>/css/homeview.css"/>

<div class="page" ng-app="">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_web_index'];?></h3>
      <?php require_once template('web_config_tab')?>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title"><h5><?php echo $lang['nc_prompts'];?></h5><span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td>
			<ul>
				<li>本回收站页面列出所有本模块 (web_config) 中删除内容</li>
				<li>{其他模块待加入}</li>
			</ul>
		</td>
      </tr>
    </tbody>
  </table>
    <table class="table tb-type2 nobdb">
      <thead>
	  	<tr class="space">
				<th colspan="15"><?php echo $lang['nc_list']; ?></th>
		</tr>
        <tr class="thead">
			<th><?php echo $lang['nc_choose']; ?></th>
			<th><?php echo $lang['web_homeview_name'];?></th>
			<th><?php echo $lang['nc_db_table'];?></th>
			<th class="align-center"><?php echo $lang['nc_recycle_time'];?></th>
			<th class="align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
		<tbody>
			<?php if(!empty($output['trash_list']) && is_array($output['trash_list'])){ ?>
			<?php foreach($output['trash_list'] as $k => $v){ ?>
			<tr class="hover" data-id="<?php echo $v['homeview_id']?>">
				<td class="w48"><input type="checkbox" class="checkitem"/></td>
				<td class="">
					<span class="w96 pointer input-homeviewName" data-fieldName="homeview_name"><?php echo $v['homeview_name'];?> (<?php echo $lang['nc_id'].'#'.$v['homeview_id'] ?>)</span>
					<span class="hint" style="width: 60px; display:inline-block"></span>
				</td>
				<td class="w150"><?php echo $output['db_table']?></td>
				<td class="w150 align-center time"><?php echo date('Y-m-d H:i:s',$v['update_time']);?></td>
				<td class="w150 align-center">
					<a href="index.php?act=web_api&op=recycle_restore&id=<?php echo $v['homeview_id'];?>"><?php echo $lang['nc_restore'];?></a> |
					<a href="javascript:void(0)" onclick="itemDelete(<?php echo $v['homeview_id']?>)"><?php echo $lang['nc_delete'];?></a> 
				</td>
			</tr>
			<?php } ?>
		</tbody>
		<tfoot>
			<tr class="tfoot">
				<td><input class="checkall" type="checkbox" title="<?php echo $lang['nc_select_all']; ?>"></td>
				<td colspan="8">
					<a class="btn"><span title="待完善功能"><?php echo $lang['nc_restore'] ?></span></a>
					<a class="btn"><span title="待完善功能"><?php echo $lang['nc_delete'] ?></span></a>
				</td>
			</tr>
		</tfoot>
        <?php }else { ?>
        <tr class="no_data">
          <td><?php echo $lang['nc_no_record'];?></td>
        </tr>
		</tbody>
        <?php } ?>
    </table>
	<form id="web_form" action="index.php?act=web_api&op=web_homeview" method="post">
		<input type="hidden" name="homeview_id">
		<input type="hidden" name="propertyName">
		<input type="hidden" name="propertyValue">
	</form>
</div>

<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.ajaxContent.pack.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/common_select.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.mousewheel.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/waypoints.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/angularjs/1.3.14/angular.min.js"></script>

<script type="text/javascript">
$(function(){
	// 更新 no_data 的 colspan
	$(".no_data td").attr("colspan", $(".thead th").size());
	
	// 销售区域更新
	
	$("#submitBtn").click(function(){
    if($("#web_form").valid()){
     $("#web_form").submit();
		}
	});
	$(".home-templates-board-style li").click(function(){
		$(".home-templates-board-style li").removeClass("selected");
		$("#style_name").val($(this).attr("class"));
		$(this).addClass("selected");
	});
});

function itemDelete(id){
	window.console ? console.log('item delete') : '' ;
	ifConfirm = confirm('彻底删除数据将无法还原，是否删除?(是/否)');
	window.console ? console.log(ifConfirm) : '' ;
	if (ifConfirm){
		url = "index.php?act=web_api&op=recycle_delete&id=" + id;
		$.get(url, function(result){
			window.console ? console.log(result) : console.log('fail');
		}, "json");
		location.reload();
	}
}

</script>
