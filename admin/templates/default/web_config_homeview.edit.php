<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
		<h3><?php echo $lang['nc_web_index'];?></h3>
		<?php include_once template('web_homeview_tab'); ?>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <table class="tb-type1 noborder">
    <tbody>

    </tbody>
  </table>
  
  <table class="table tb-type2">
	<thead>
      <tr>
		<td>
			<table class="tb-type1 noborder">
				<th><?php echo $lang['web_homeview_name']; ?>:</th>
				<td><?php echo $output['homeview_name'];?></td>
				<th><?php echo $lang['web_homeview_template_name']; ?>:</th>
				<td>
					<select id="template-selector">
					<?php foreach($output['homeview_template_list'] as $key => $value) { ?>
						<option <?php if ($output['homeview_template_id'] == $value['homeview_template_id']) {echo 'selected="selected"';}?>
							value="<?php echo $value['homeview_template_id']; ?>"><?php echo $value['homeview_template_name']; ?></option>
					<?php } ?>
					</select>
				</td>
			</table>
		</td>
      </tr>
	</thead>
	<tbody>
		<tr>
			<td>
				<?php $template_code = $output['homeview_template_code'];?>
				<?php include_once template('web_homeview' . DS . $template_code . DS . 'homeview_focus.edit'); ?>
			</td>
		<tr>
	</tbody>
	<tfoot >
		<tr class="tfoot">
			<td style="text-align:center"><a class="btn"><span>保存并更新</span></a></td>
		</tr>
	</tfoot>
  </table>
</div>


<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.ajaxContent.pack.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/colorpicker/evol.colorpicker.min.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/dialog/dialog.js" id="dialog_js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/common_select.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.mousewheel.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/waypoints.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/web_config/web_index.js"></script>
<script type="text/javascript" src="<?php echo ADMIN_TEMPLATES_URL;?>/js/homeview.js" charset="utf-8"></script>