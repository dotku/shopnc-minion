<?php 
	$keyArray = explode("_", $_GET['op']);
	$keyCurrent = $keyArray[1];
	$ifCurrent[$keyCurrent] = 'current'; 
?>
<ul class="tab-base">
	<li><a href="index.php?act=web_homeview&op=homeview_index"><span><?php echo $lang['web_config_tab_area']; ?></span></a></li>
	<li><a href="index.php?act=web_homeview&op=homeview_basic&&homeview_id=<?php echo $output['homeview_id'] ?>" class="<?php echo $ifCurrent['basic'] ?>"><span><?php echo $lang['web_homeview_basic']; ?></span></a></li>
	<li><a href="index.php?act=web_homeview&op=homeview_edit&homeview_id=<?php echo $output['homeview_id'] ?>" class="<?php echo $ifCurrent['edit'] ?>"><span><?php echo $lang['web_homeview_edit']; ?></span></a></li>
	<li><a href="index.php?act=web_homeview&op=homeview_salearea" class="<?php echo $ifCurrent['salearea'] ?>"><span><?php echo $lang['web_homeview_saleedit']; ?></span></a></li>
	<li><a href="index.php?act=web_homeview&op=homeview_template" class="<?php echo $ifCurrent['template'] ?>"><span>模板编辑</span></a></li>
</ul>