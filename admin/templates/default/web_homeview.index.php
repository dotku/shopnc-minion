<?php defined('InShopNC') or exit('Access Invalid!');?>
<link rel="stylesheet" type="text/css" href="<?php echo ADMIN_TEMPLATES_URL;?>/css/homeview.css"/>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_web_index'];?></h3>
      <?php require_once template('web_config_tab')?>
    </div>
  </div>
  <div class="fixed-empty"></div>

	<table class="tb-type1 noborder search table">
	<tr>
		<td>
					<table class="table">
						<tr id="sale_area_addRow">
										<form id="formAdd" method="post">
					<input type="hidden" name="act" value="web_homeview">
					<input type="hidden" name="op" value="homeview_index">
					<input type="hidden" name="rest" value="post">
							<td class="w200"><input type="text" class="txt" name="homeview_sort" size="4" placeholder="<?php echo $lang['nc_sort']; ?>"></td>
							<td class="w200"><input type="text" class="txt" name="homeview_name" placeholder="<?php echo $lang['web_homeview_name'];?>"></td>
							<td class="w108">
								
								<select name="sale_area_id">
									<option value="0">默认</option>
								<?php if (!empty($output['salearea_list']) && is_array($output['salearea_list'])) { ?>
								<?php foreach($output['salearea_list'] as $saleKey => $saleValue) { ?>
										<option value="<?php echo $saleValue['sale_area_id']; ?>"><?php echo $saleValue['sale_area_name'] ?></option>
								<?php } ?>
								<?php } ?>
								</select>
								
							</td>
							<td class="w150">
								
								<select name="homeview_template_id">
									<option value="0">默认</option>
									<?php if(!empty($output['homeview_template_list']) && is_array($output['homeview_template_list'])) { ?>
									<?php foreach ($output['homeview_template_list'] as $key => $val) { ?>
											<option value="<?php echo $val['homeview_template_id']; ?>"><?php echo $val['homeview_template_name']; ?></option>
									<?php } ?>
									<?php } ?>
								</select>
								
							</td>
							<td class="w84">
							<select name="homeview_show">
								<option value="0">禁止</option>
								<option value="1" selected="selected">启用</option>
							</select>
							</td>
							<td class="w48 align-center"><input type="submit" value="<?php echo $lang["nc_add"]; ?>"></td>
							</form>
							<td class="tr">
								<form method="get" name="formSearch" id="formSearch">
									<input type="hidden" name="act" value="web_homeview">
									<input type="hidden" name="op" value="homeview_index">
									<input name="keyword" class="txt" type="text" placeholder="搜索销售区域">
									<a href="javascript:void(0);" onclick="$('#formSearch').submit()" id="ncsubmit" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a>
								</form>
							</td>
						</tr>
					</table>
				
		</td>
	</tr>
  </table>
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
				<li>您可以通过下拉选择直接在本页面完成基本的信息修改操作</li>
				<li>您可以通过下方的添加表格来完成快捷添加创建新的首页的操作</li>
			</ul>
		</td>
      </tr>
    </tbody>
  </table>
	

    <table class="table tb-type2 nobdb" id="homeview_list">
      <thead>
	  	<tr class="space">
				<th colspan="15"><?php echo $lang['nc_list']; ?></th>
		</tr>
        <tr class="thead">
			<th><?php echo $lang['nc_sort'];?></th>
			<th><?php echo $lang['web_homeview_name'];?></th>
			<th class="w200"><?php echo $lang['web_homeview_sale_area'];?> <a href="index.php?act=web_homeview&op=homeview_salearea_index"><i class="icon-edit"></i></a></th>
			<th class="w270"><?php echo $lang['web_homeview_template_name'];?> <a href="index.php?act=web_homeview&op=homeview_template"><i class="icon-edit"></i></a></th>
			<th class="align-center"><?php echo $lang['web_config_update_time'];?></th>
			
			<th><?php echo $lang['nc_enabled'];?></th>
			<th class="align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['homeview_list']) && is_array($output['homeview_list'])){ ?>
        <?php foreach($output['homeview_list'] as $k => $v){ ?>
        <tr class="hover" data-id="<?php echo $v['homeview_id']?>">
			<td class="w120 sort">
				<span class="pointer input-homeviewSort" data-fieldName="homeview_sort"><?php echo $v['homeview_sort'];?></span>
				<span class="hint" style="width: 60px; display:inline-block"></span>
			</td>
			<td class="">
				<span class="w96 pointer input-homeviewName" data-fieldName="homeview_name" title="<?php echo $lang['nc_id'].'#'.$v['homeview_id'] ?>"><?php echo $v['homeview_name'];?></span>
				<span class="hint" style="width: 60px; display:inline-block"></span>
			</td>
			<td>
				<select class="sale_area_selector">
					<option value="0">默认</option>
					<?php if (!empty($output['salearea_list']) && is_array($output['salearea_list'])) { ?>
					<?php foreach($output['salearea_list'] as $saleKey => $saleValue) { ?>
						<option value="<?php echo $saleValue['sale_area_id']; ?>"
						<?php if ($saleValue['sale_area_id'] == $v['sale_area_id']) { echo 'selected="selected"';} ?>><?php echo $saleValue['sale_area_name'] ?></option>
					<?php } ?>
					<?php } ?>
				</select>
				<span class="hint" style="width: 60px; display:inline-block"></span>
			</td>
			<td>
				
				<select class="web_homeview_template_selector">
					<option value="0">默认</option>
					<?php if(!empty($output['homeview_template_list']) && is_array($output['homeview_template_list'])) { ?>
					<?php foreach ($output['homeview_template_list'] as $key => $val) { ?>
						<?php if ($val['homeview_template_id'] == $v['homeview_template_id']) { ?>
							<option selected="selected" value="<?php echo $v['homeview_template_id']; ?>"><?php echo $val['homeview_template_name']; ?></option>
						<?php } else { ?>
							<option value="<?php echo $val['homeview_template_id']; ?>"><?php echo $val['homeview_template_name']; ?></option>
						<?php } ?>
					<?php } ?>
					<?php } ?>
				</select>
				
				<a href="javascript:void(0)"><i class="icon-picture" style="font-size: 14px" title="模板预览" onclick="javascript:show_dialog('pic_preview', this)"></i></a>
				<span class="hint" style="width: 60px; display:inline-block"></span>
			</td>
			<td class="w150 align-center time"><?php echo date('Y-m-d H:i:s',$v['update_time']);?></td>
			
			<td class="w120">
				<?php if ($v['homeview_id'] == 0) { ?>
					<select class="homeview_show_selector" disabled="disabled" title="默认首页无法被禁用">
						<option>是</option>
					</select>
				<?php } else { ?>
					<select class="homeview_show_selector">
						<option <?php echo $v['homeview_show']==1 ? "selected=selected" : ''?> value="1"><?php echo $lang['nc_yes'] ?></option>
						<option <?php echo $v['homeview_show']==1 ? "" : 'selected=selected'?> value="0"><?php echo $lang['nc_no'] ?></option>
					</select>
				<?php } ?>
				
				<span class="hint" style="width: 60px; display:inline-block"></span>
			</td>
			
			<td class="w150 align-center">
				<a href="javascript:void(0)" onclick="itemTrash(<?php echo $v['homeview_id'];?>)"><?php echo $lang['nc_delete'];?></a> | 
				<a href="index.php?act=web_homeview&op=homeview_edit&homeview_id=<?php echo $v['homeview_id'];?>"><?php echo $lang['web_config_code_edit'];?></a>
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
			<td colspan="8">
				<div class="pagination"> <?php echo $output['page'];?></div>
			</td>
		</tr>
	  </tfoot>
    </table>
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
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui-timepicker-addon/jquery-ui-timepicker-addon.min.js"></script>

<script type="text/javascript">
/**
 * 监控区
 */

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

$("#homeview_list .sale_area_selector").change(function(){ selectUpdator('sale_area_id', this) });
$('#homeview_list .web_homeview_template_selector').change(function(){ selectUpdator('homeview_template_id', this) });
$('#homeview_list .homeview_show_selector').change(function(){ selectUpdator('homeview_show', this) });
$(".input-homeviewName").click(function(){
	sName = prompt("<?php echo $lang['nc_please_input_new'].$lang['web_homeview_name'];?>", $(this).text());
	if (!sName) {
		sName = $(this).text();
	} else {
		$(this).text(sName);
		spanUpdator(this);
	}
});
$('.input-homeviewIfTrash').click(function(){
	
})
$(".input-homeviewSort").click(function(){
	sName = prompt("<?php echo $lang['nc_please_input_new'].$lang['web_homeview_sort'];?>", $(this).text());
	if (!sName) {
		sName = $(this).text();
	} else {
		$(this).text(sName);
		spanUpdator(this);
	}
});

// 时间更新
function timeUpdator(obj, value){
	$(obj).parents("tr").find(".time").hide();
	$(obj).parents("tr").find(".time").fadeIn(500);
	$(obj).parents("tr").find(".time").text(value);
}

// span 更新
function spanUpdator(obj){
	var homeview_id = -1;
	var fieldName = '';
	var fieldValue = '';
	var updateStatus = "<?php echo $lang['update_processing'];?>";
	var objHint = $(obj).parent().find(".hint");
	
	homeview_id = $(obj).parents("tr").attr("data-id");
	fieldName = $(obj).attr("data-fieldName");
	fieldValue = $(obj).text();
	
	objHint.text(updateStatus);
	objHint.fadeIn(500);
	objHint.fadeOut(500);
	
	postURL = "&homeview_id=" + homeview_id + "&field=" + fieldName + "&value=" + fieldValue;
	finalURL = "index.php?act=web_api&op=homeview_indexUpdate" + postURL;
	$.get(finalURL, function(result){
		window.console ? console.log(result) : '';
		if(result.msg){
			alert("<?php echo $lang['nc_prompts']; ?>: " + result.msg);
		} else {
			objHint.text(result.update_status);
			timeUpdator(obj, result.format_time);
			objHint.fadeIn(500);
			objHint.fadeOut(500);
		}
	}, 'json');
}

// 选择器更新
function selectUpdator(field, obj){
	var homeview_id = $(obj).parents("tr").attr("data-id");
	var propertyName = field;
	var propertyValue = $(obj).val();
	var updateStatus = "<?php echo $lang['update_processing'];?>";
	var objHint = $(obj).parent().find(".hint");
	objHint.text(updateStatus);
	objHint.fadeIn(500);
	objHint.fadeOut(500);

	postURL = "&homeview_id=" + homeview_id + "&field=" + propertyName + "&value=" + propertyValue;
	finalURL = "index.php?act=web_api&op=homeview_indexUpdate" + postURL;
	$.get(finalURL, function(result){
		if(result.msg){
			alert("<?php echo $lang['nc_prompts']; ?>: " + result.msg);
		} else {
			objHint.text(result.update_status);
			timeUpdator(obj, result.format_time);
			objHint.fadeIn(500);
			objHint.fadeOut(500);
		}
	}, 'json');
}

// 对话框显示
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

function itemTrash(id) {
	url = "index.php?act=web_api&op=homeview_indexUpdate&homeview_id=" + id + "&field=ifTrash&value=1";
	$.get(url, function(result){
		window.console ? console.log (result) : '';
		if(result.msg){
			alert(result.msg);
		}
	}, 'json');
}
</script>