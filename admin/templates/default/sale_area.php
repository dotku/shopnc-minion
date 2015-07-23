<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['store'];?></h3>
      <ul class="tab-base">
		<li><a href="JavaScript:void(0);" class="current" ><span>销售馆</span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="post" name="form1">
    <input type="hidden" name="form_submit" value="ok" />
   
    <table class="tb-type2" width="500">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="member_name">销售馆名称:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" id="sale_area_name" name="sale_area_name" class="txt"></td>
          <td ><a href="javascript:document.form1.submit();" class="btn"><span>添加</span></a></td>
        </tr>
        
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td  class="tips">&nbsp;&nbsp;(请输入要添加的销售馆名称)<br></td>
        </tr>
      </tfoot>
    </table>
  </form>
    <table class="tb-type2" width="500">
      <thead>
        <tr class="thead ">
          <th class="w24">ID编号</th>
         
          <th class="w270">销售馆名称</th>
          
          <th class="w72 align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['sale_area']) && is_array($output['sale_area'])){ ?>
        <?php foreach($output['sale_area'] as $k => $v){ ?>
        <tr class="hover edit">
          <td><?php echo $v['sale_area_id']?></td>
          
          <td class="name"> <span title="<?php echo $lang['nc_editable'];?>" required="1" fieldid="<?php echo $v['sale_area_id'];?>" ajax_branch="sale_area_name" fieldname="sale_area_name" nc_type="inline_edit" class="editable tooltip"><?php echo $v['sale_area_name'];?></span></td>
          
          <td class="align-center">&nbsp;<a href="javascript:void(0)" onclick="if(confirm('<?php echo $lang['nc_ensure_del'];?>')){location.href='index.php?act=setting&op=sale_area_del&del_area_id=<?php echo $v['sale_area_id'];?>';}else{return false;}"><?php echo $lang['nc_del'];?></a></td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="10"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <?php if(!empty($output['sale_area']) && is_array($output['sale_area'])){ ?>
        <tr colspan="15" class="tfoot">
          <td></td>
          <td colspan="16">
            </td>
        </tr>
        <?php } ?>
      </tfoot>
    </table>
  <div class="clear"></div>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.edit.js" charset="utf-8"></script> 
