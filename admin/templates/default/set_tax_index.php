<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>关税设置</h3>
      <ul class="tab-base">
          <li><a href="JavaScript:void(0);" nctype="category" class="current"><span>关税管理</span></a></li>
		  <li><a href="index.php?act=set_tax&op=set_tax&type=new" nctype="category" ><span>添加新税号</span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12" class="nobg"><div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td><ul>
        	<li>点击修改的内容，确保网络正常，否则更新不了。</li>
            
          </ul></td>
      </tr>
    </tbody>
  </table>
 
  <form method="post" name="form_category" action="index.php?act=set_tax&op=seo_category">
    <input type="hidden" name="form_submit" value="ok" />
    
  <table class="table tb-type2">
      <thead>
        <tr class="thead">
		<th>排序</th>
          <th>分类名称</th>
          <th>税号</th>
          <th>税率</th>
          <th>备注</th>
        </tr>
      </thead>
      <tbody>
       <?php if(!empty($output['show_goods_class']) && is_array($output['show_goods_class'])){?>
            <?php foreach($output['show_goods_class'] as $key=>$gc_list){?>
			<?php if ($gc_list['gc_parent_id'] != '0') break;?>
		  <tr class="hover edit">
		  <td class="w48 sort"><span title="<?php echo $lang['nc_editable'];?>" ajax_branch="goods_class_sort" datatype="number" fieldid="<?php echo $output['gc_list'][$child]['gc_id'];?>" fieldname="gc_sort" nc_type="inline_edit" class="editable tooltip"><?php echo $gc_list['gc_sort'];?></span></td>
          <td ><strong><?php echo $gc_list['gc_name'];?></strong> </td>
	
              <?php if (!empty($gc_list['class2'])) {?>
               <?php foreach ($gc_list['class2'] as $gc_list2) {?>
			   <tr class="hover edit">
		   <td class="w48 sort"><span title="<?php echo $lang['nc_editable'];?>" ajax_branch="goods_class_sort" datatype="number" fieldid="<?php echo $output['gc_list'][$child]['gc_id'];?>" fieldname="gc_sort" nc_type="inline_edit" class="editable tooltip"><?php echo $output['gc_list'][$child]['gc_sort'];?></span></td>
          <td class="w25pre">&nbsp;┝　<?php echo $gc_list2['gc_name'];?>
          </td>
        
        </tr>
			 <?php if (!empty($gc_list2['class3'])) {?>
			<?php foreach($gc_list2['class3'] as $key=>$gc_list3){?>
			<?php if( $gc_list3['tax_number'] != '' and $gc_list3['tax_rate'] != '0'){?>
          <tr class="hover edit">
		   <td class="w48 sort"><span title="<?php echo $lang['nc_editable'];?>" ajax_branch="goods_class_sort" datatype="number" fieldid="<?php echo $output['gc_list'][$child]['gc_id'];?>" fieldname="gc_sort" nc_type="inline_edit" class="editable tooltip"><?php echo $output['gc_list'][$child]['gc_sort'];?></span></td>
          <td class="w25pre">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;┝　<?php echo $gc_list3['gc_name'];?>
          </td>
        <td class="w25pre name">
          编号：<span title="<?php echo $lang['nc_editable'];?>" fieldid="<?php echo $gc_list3['gc_id'];?>" ajax_branch="goods_class_note" datatype="number" fieldname="tax_number" nc_type="inline_edit" class="editable tooltip"><?php echo $gc_list3['tax_number'];?></span>
          </td>
		 <td class="w25pre sort">
          税率：<span title="<?php echo $lang['nc_editable'];?>" fieldid="<?php echo $gc_list3['gc_id'];?>" ajax_branch="goods_class_sort" datatype="number"  fieldname="tax_rate" nc_type="inline_edit" class="editable tooltip"><?php echo $gc_list3['tax_rate']*100;?></span>%
          </td>
          <td class="w25pre name">
          备注：<span title="<?php echo $lang['nc_editable'];?>" fieldid="<?php echo $gc_list3['gc_id'];?>" ajax_branch="goods_class_note" fieldname="tax_note" nc_type="inline_edit" class="editable tooltip"><?php echo $gc_list3['tax_note'];?></span>
          </td>
        </tr>
		<?php }?>
			<?php }?>
              <?php }?>
              <?php }?>
        <?php }?>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="10"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
     
      <tfoot>
        <tr class="tfoot">
          <td></td>
          <td id="batchAction" colspan="15"><span class="all_checkbox">
            
            </td>
        </tr>
      </tfoot>
   
    </table>
  </form>

<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.edit.js" charset="utf-8"></script>
