<?php defined('InShopNC') or exit('Access Invalid!');?>
<link href="<?php echo ADMIN_TEMPLATES_URL;?>/css/font/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
<!--[if IE 7]>
  <link rel="stylesheet" href="<?php echo ADMIN_TEMPLATES_URL;?>/css/font/font-awesome/css/font-awesome-ie7.min.css">
<![endif]-->
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['web_config_index'];?></h3>
      <?php include_once template('web_homeview_tab'); ?>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="web_form" method="post" name="form1">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="homeview_id" value="<?php echo $output['homeview']['homeview_id']?>" />
    <table class="table tb-type2">
      <tbody>
      	<tr class="noborder">
          <td colspan="2" class="required"><label class="validation"><?php echo $lang['web_homeview_name'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="web_name" name="web_name" value="<?php echo $output['homeview']['homeview_name']?>" class="txt" type="text"></td>
          <td class="vatop tips"><?php echo $lang['web_config_web_name_tips'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation"><?php echo $lang['web_homeview_sort'];?>:</label>
            </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['homeview']['homeview_sort']?>" name="web_sort" id="web_sort" class="txt"></td>
          <td class="vatop tips"><?php echo $lang['web_config_sort_tips'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['nc_enabled'];?>:
            </td>
        </tr>
		<tr class="noborder">
			<td class="vatop rowform onoff">
				<label for="show1" class="cb-enable <?php if($output['homeview']['homeview_show'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_yes'];?>"><span><?php echo $lang['nc_yes'];?></span></label>
				<label for="show0" class="cb-disable <?php if($output['homeview']['homeview_show'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_no'];?>"><span><?php echo $lang['nc_no'];?></span></label>
				<input id="show1" name="homeview_show" <?php if($output['homeview']['homeview_show'] == '1'){ ?>checked="checked"<?php } ?>  value="1" type="radio">
				<input id="show0" name="homeview_show" <?php if($output['homeview']['homeview_show'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio">
			</td>
          <td class="vatop tips"></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="15" ><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script>
//按钮先执行验证再提交表单
$(function(){

	$("#submitBtn").click(function(){
    if($("#web_form").valid()){
     $("#web_form").submit();
		}
	});

	$("#web_form").validate({
		errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        rules : {
            web_name : {
                required : true
            },
            web_sort : {
                required : true,
                digits   : true
            }
        },
        messages : {
            web_name : {
                required : "<?php echo $lang['web_config_add_name_null'];?>"
            },
            web_sort  : {
                required : "<?php echo $lang['web_config_sort_int'];?>",
                digits   : "<?php echo $lang['web_config_sort_int'];?>"
            }
        }
	});
});

</script> 
