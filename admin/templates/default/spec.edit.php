<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_spec_manage'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=spec&op=spec"><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="index.php?act=spec&op=spec_add"><span><?php echo $lang['nc_new'];?></span></a></li>
        <li><a class="current" href="JavaScript:void(0);"><span><?php echo $lang['nc_edit'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="spec_form" method="post" enctype="multipart/form-data">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="s_id" value="<?php echo $output['sp_list']['sp_id']?>" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td class="required" colspan="2"><label class="validation" for="s_name"><?php echo $lang['spec_index_spec_name'].$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" class="txt" name="s_name" id="s_name" value="<?php echo $output['sp_list']['sp_name'];?>" /></td>
          <td class="vatop tips"><?php echo $lang['spec_index_spec_name_desc'];?></td>
        </tr>
        <tr>
          <td class="required" colspan="2"><label class="" for="s_sort"><?php echo $lang['spec_common_belong_class'].$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform" id="gcategory">
          <input type="hidden" value="<?php echo $output['sp_list']['class_id'];?>" class="mls_id" name="class_id" />
            <input type="hidden" value="<?php echo $output['sp_list']['class_name'];?>" class="mls_name" name="class_name" />
            <span class="mr10"><?php echo $output['sp_list']['class_name'];?></span>
            <?php if (!empty($output['sp_list']['class_id'])) {?>
            <input class="edit_gcategory" type="button" value="<?php echo $lang['nc_edit'];?>">
            <?php }?>
            <select <?php if (!empty($output['sp_list']['class_id'])) {?>style="display:none;"<?php }?> class="class-select">
              <option value="0"><?php echo $lang['nc_please_choose'];?>...</option>
              <?php if(!empty($output['gc_list'])){ ?>
              <?php foreach($output['gc_list'] as $k => $v){ ?>
              <?php if ($v['gc_parent_id'] == 0) {?>
              <option value="<?php echo $v['gc_id'];?>"><?php echo $v['gc_name'];?></option>
              <?php } ?>
              <?php } ?>
              <?php } ?>
            </select></td>
          <td class="vatop tips"><?php echo $lang['spec_common_belong_class_tips'];?>[[<?php echo $output['sp_list']['sp_value'];?></td>
        </tr>
 </tbody>
 </table>
 <table class="table tb-type2 " >
      <thead class="thead">
        <tr class="space">
          <th colspan="15"><?php echo $lang['spec_add_spec_add'];?></th>
        </tr>
        <tr class="noborder" >
          <th><?php echo $lang['nc_del'];?></th>
          <th><?php echo $lang['nc_sort'];?></th>
          <th><?php echo $lang['spec_index_spec_value'];?></th>
          <th></th>
          <th class="align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody id="tr_model">
        <tr></tr>
        <?php if(is_array($output['sp_value']) && !empty($output['sp_value'])) {?>
        <?php foreach($output['sp_value'] as $val) {?>
        <tr class="hover edit">
          <input type="hidden" nc_type="submit_value" name='s_value[<?php echo $val['sp_value_id'];?>][form_submit]' value='' />
          <input type="hidden" nc_type="ajax_spec_value_id" value="<?php echo $val['sp_value_id'];?>" />
          <td class="w48"><input type="checkbox" name="s_del[<?php echo $val['sp_value_id'];?>]" value="<?php echo $val['sp_value_id'];?>" /></td>
          <td class="w48 sort"><input type="text" nc_type="change_default_submit_value" name="s_value[<?php echo $val['sp_value_id'];?>][sort]" value="<?php echo $val['sp_value_sort'];?>" /></td>
          <td class="w270 name"><input type="text" nc_type="change_default_submit_value" name="s_value[<?php echo $val['sp_value_id'];?>][name]" value="<?php echo $val['sp_value_name'];?>" /></td>
          <td></td>
          <td class="w150 align-center"></td>
        </tr>
        <?php }?>
        <?php }else{?>
        <tr class="no_data">
          <td colspan="15"><?php echo $lang['spec_edit_spec_value_null'];?></td>
        </tr>
        <?php }?>
      </tbody>
      <tbody>
        <tr>
          <td colspan="15"><a class="btn-add marginleft" id="add_type" href="JavaScript:void(0);"> <span><?php echo $lang['spec_add_spec_add_one'];?></span> </a></td>
        </tr>
      </tbody>
    </table>
	<table>
      <tbody>
        <tr>
          <td class="required" colspan="2"><label class="validation" for="s_sort"><?php echo $lang['nc_sort'].$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php if ($output['sp_list']['sp_id'] != 1) {?><input type="text" class="txt" name="s_sort" id="s_sort" value="<?php echo $output['sp_list']['sp_sort'];?>" /><?php } else {echo $output['sp_list']['sp_sort'];}?></td>
          <td class="vatop tips"><?php echo $lang['spec_index_spec_sort_desc'];?></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="15"><a id="submitBtn" class="btn" href="JavaScript:void(0);"> <span><?php echo $lang['nc_submit'];?></span> </a></td>
        </tr>
      </tfoot>
  </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/common_select.js" charset="utf-8"></script> 
<script type="text/javascript">
$(function(){
	
    // 编辑分类时清除分类信息
    $('.edit_gcategory').click(function(){
        $('input[name="class_id"]').val('');
        $('input[name="class_name"]').val('');
    });
	//表单验证
    $('#spec_form').validate({
        errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },

        rules : {
        	s_name: {
        		required : true,
                maxlength: 10,
                minlength: 1
            },
            s_sort: {
				required : true,
				digits	 : true
            }
        },
        messages : {
        	s_name : {
            	required : '<?php echo $lang['spec_add_name_no_null'];?>',
                maxlength: '<?php echo $lang['spec_add_name_max'];?>',
                minlength: '<?php echo $lang['spec_add_name_max'];?>'
            },
            s_sort: {
				required : '<?php echo $lang['spec_add_sort_no_null'];?>',
				digits   : '<?php echo $lang['spec_add_sort_no_digits'];?>'
            }
        }
    });

   
	//按钮先执行验证再提交表单
    $("#submitBtn").click(function(){
        if($("#spec_form").valid() && confirm('<?php echo $lang['spec_edit_confirm_desc'];?>')){
        	$("#spec_form").submit();
    	}
    });
});
gcategoryInit('gcategory');
</script> 
<script type="text/javascript">
$(function(){
    var i=0;
	var tr_model = '<tr class="hover edit">'+
		'<td></td><td class="w48 sort"><input type="text" name="s_value[key][sort]" value="0" /></td>'+
		'<td class="w270 name"><input type="text" name="s_value[key][name]" value="" /></td>'+
		'<td></td><td class="w150 align-center"><a onclick="remove_tr($(this));" href="JavaScript:void(0);"><?php echo $lang['nc_del'];?></a></td>'+
	'</tr>';
	$("#add_type").click(function(){
		$('#tr_model > tr:last').after(tr_model.replace(/key/g,'s_'+i));
		if($('.image_display').is(":hidden")){
			$('.image_display').hide();
		}
		<?php if(empty($output['sp_value'])) {?>
		$('.no_data').hide();
		<?php }?>
		$.getScript("../resource/js/admincp.js");
		i++;
	});

    $("input[nc_type='change_default_submit_value']").change(function(){
    	$(this).parents('tr:first').find("input[nc_type='submit_value']").val('ok');
    });
	
});

function remove_tr(o){
	o.parents('tr:first').remove();
}
</script> 
<script type="text/javascript">
$(function(){
	$('input[nc_type="change_default_goods_image"]').live("change", function(){
		$(this).parent().find('input[class="type-file-text"]').val($(this).val());
	});
});
</script> 