<?php defined('InShopNC') or exit('Access Invalid!');?>
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
				<li>不同的销售区域 (salearea) 可以采用不同的首页展示 (homeview) 方案</li>
				<li>同一个销售区域也可以销售跨区域的产品，比如中国区可以卖美国的产品</li>
			</ul>
		</td>
      </tr>
    </tbody>
  </table>
    <table class="table tb-type2 nobdb">
      <thead>
        <tr class="thead">
			<th><?php echo $lang['id'];?></th>
			<th><?php echo $lang['web_homeview_name'];?></th>
			<th><?php echo $lang['web_homeview_sale_area'];?></th>
			<th><?php echo $lang['web_homeview_template_name'];?></th>
			<th class="align-center"><?php echo $lang['web_config_update_time'];?></th>
			<th><?php echo $lang['nc_sort'];?></th>
			<th class="align-center"><?php echo $lang['nc_enabled'];?></th>
			<th class="align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['homeview_list']) && is_array($output['homeview_list'])){ ?>
        <?php foreach($output['homeview_list'] as $k => $v){ ?>
        <tr class="hover" data-id="<?php echo $v['homeview_id']?>">
			<td class="w48"><?php echo $v['homeview_id'] ?></td>
			<td><?php echo $v['homeview_name'];?></td>
			<td class="w150">
				<select class="sale_area_selector">
					<?php if (!empty($output['salearea_list']) && is_array($output['salearea_list'])) { ?>
						<?php foreach($output['salearea_list'] as $saleKey => $saleValue) { ?>
								<option value="<?php echo $saleKey; ?>"
								<?php if ($saleKey == $v['sale_area_id']) { echo 'selected="selected"';} ?>><?php echo $saleValue['sale_area_name'] ?></option>
						<?php } ?>
					<?php } ?>
				</select>
				<span class="sale_area_selector_hint" style="display: none">
					<?php echo $lang['status']; ?>
				</span>
			</td>
			<td>
				<select class="template_selector">
					<?php foreach ($output['homeview_template_list'] as $key => $val) { ?>
						<?php if ($key != $v['homeview_template_id']) { ?>
							<option value="<?php echo $val['homeview_template_id']; ?>"><?php echo $val['homeview_template_name']; ?></option>
						<?php } else { ?>
							<option selected="selected" value="<?php echo $v['homeview_template_id']; ?>"><?php echo $val['homeview_template_name']; ?></option>
						<?php } ?>
					<?php } ?>
				</select>
				<a href="javascript:void(0)"><i class="icon-picture" style="font-size: 14px" title="模板预览" onclick="javascript:show_dialog('pic_preview', this)"></i></a>
			</td>
			<td class="w150 align-center"><?php echo date('Y-m-d H:i:s',$v['update_time']);?></td>
			<td class="w48 sort"><?php echo $v['homeview_sort'];?></td>
			<td class="w48 align-center"><?php echo $v['homeview_show']==1 ? $lang['nc_yes'] : $lang['nc_no'];?></td>
			<td class="w150 align-center">
				<a href="index.php?act=web_config&op=homeview_basic&homeview_id=<?php echo $v['homeview_id'];?>"><?php echo $lang['web_config_web_edit'];?></a> | 
				<a href="index.php?act=web_config&op=homeview_edit&homeview_id=<?php echo $v['homeview_id'];?>"><?php echo $lang['web_config_code_edit'];?></a>
			</td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
	  <tfoot>
		<tr class="tfoot">
			<td>#</td>
			<td><input>
			<td><select><option>1<option>2</select></select></td>
			<td><select><option>1<option>2</select></select></td>
			<td class="w150 align-center"><?php echo date('Y-m-d H:i:s', time());?></td>
			<td><input size="5">
			<td><select><opiton><?php echo $lang["nc_yes"]; ?></option><option><?php echo $lang["nc_yes"]; ?></option></select></td>
			<td class="align-center"><a class="btn"><span><?php echo $lang["nc_add"]; ?></span></a></td>
		</tr>
	  </tfoot>
    </table>
	<form id="web_form" action="" method="post">
		<input type="hidden" name="homeview_id">
		<input type="hidden" name="propertyName">
		<input type="hidden" name="propertyValue">
	</form>
</div>
<div id="pic_preview_dialog" style="display:none;">
	<img class="preview_img" src="<?php echo ADMIN_TEMPLATES_URL; ?>/images/web_config/template_0.png" style="width:80%; padding:20px 10%;">
</div>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.ajaxContent.pack.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/dialog/dialog.js" id="dialog_js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/common_select.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.mousewheel.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/waypoints.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/web_config/web_index.js"></script>
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

$(".sale_area_selector").change(function(){
	var homeview_id = $(this).parents("tr").attr("data-id");
	var propertyName = "sale_area_id";
	var propertyValue = $(this).val();
	/*
	$("#web_form input[name=homeview_id]").val($(this).parents("tr").attr("data-id"));
	$("#web_form input[name=propertyName]").val("sale_area_id");
	$("#web_form input[name=propertyValue]").val($(this).val());
	$("#web_form").submit();
	*/
	postURL = "homveiw_id=" + homeview_id + "&propertyName=" + propertyName + "&propertyValue" + propertyValue;
	$.get("index.php?act=web_config&op=homeview_api" + postURL, function(result){
		if(window.console){console.log(result)}
	});
	$(this).next().text("<?php echo $lang['update_processing'];?>");
	$(this).next().fadeIn(300);
	$(this).next().fadeOut(300);
});

function show_dialog(id, obj) {
	template_id = $(obj).parent().prev().attr('value');
	imgURL = '<?php echo ADMIN_TEMPLATES_URL; ?>/images/web_config/template_' + template_id + '.png';
	$('#pic_preview_dialog .preview_img').attr('src', imgURL);
	
	if(DialogManager.show(id)) return;
	var d = DialogManager.create(id);
	var dialog_html = $("#"+id+"_dialog").html();
	$("#"+id+"_dialog").remove();
	d.setTitle(titles[id]);
	d.setContents('<div id="'+id+'_dialog" class="'+id+'_dialog">'+dialog_html+'</div>');
	d.setWidth(500);
	d.show('center',1);
}

</script>
