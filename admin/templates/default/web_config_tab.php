<?php 
	$keyArray = explode("_", $_GET['op']);
	$keyCurrent = $keyArray[0];
	$ifCurrent[$keyCurrent] = 'current'; 
?>
<ul class="tab-base">
	<li><a href="index.php?act=web_config&op=web_config" class="<?php echo $ifCurrent['web']?>"><span><?php echo $lang['web_config_tab_board']; ?></span></a></li>
	<li><a href="index.php?act=web_config&op=focus_edit" class="<?php echo $ifCurrent['focus']?>"><span><?php echo $lang['web_config_tab_focus']; ?></span></a></li>
	<li><a href="JavaScript:window.parent.openItem('groupbuy_template_list,groupbuy,operation')"><span><?php echo $lang['web_config_tab_groupbuy']; ?></span></a></li>
	<li><a href="JavaScript:window.parent.openItem('xianshi_apply,promotion_xianshi,operation')"><span><?php echo $lang['web_config_tab_xianshi']; ?></span></a></li>
	<li><a href="index.php?act=web_config&op=hot_edit" class="<?php echo $ifCurrent['hot']?>"><span><?php echo $lang['web_config_tab_hot']; ?></span></a></li>
	<li><a href="index.php?act=web_homeview&op=homeview_index" class="<?php echo $ifCurrent['homeview']?>" title="<?php echo $lang['web_config_tab_area_title']?>"><span><?php echo $lang['web_config_tab_area']; ?></span></a></li>
	<li><a href="index.php?act=web_config&op=recycle_index" class="<?php echo $ifCurrent['recycle']?>"><span class="recycle"><?php echo $lang['nc_recycle']; ?></span></a></li>
</ul>