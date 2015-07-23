<!-- common_header begin -->
<link rel="stylesheet" type="text/css" href="<?php echo SHOP_TEMPLATES_URL;?>/css/common_header.css"/>
<div id="hd_main">
	<div class="logo"><a href="<?php echo SHOP_SITE_URL;?>"><img src="<?php echo UPLOAD_SITE_URL.DS.ATTACH_COMMON.DS.$output['setting_config']['site_logo']; ?>" /></a></div>
	<div class="area">
		<a class="ar" href="<?php echo SHOP_SITE_URL;?>/index.php?region_code=us" target="_blank"><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/us.gif" title="美国商城" alt="美国商城"/></a>
		<a class="ar" href="<?php echo SHOP_SITE_URL;?>/index.php?region_code=au" target="_blank"><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/au.gif" title="澳洲商城" alt="澳洲商城"/></a>
	</div>
	<div class="shop_car">
		<a class="car" href="index.php?act=cart" target="_blank"><span><?php echo $lang['nc_cart'];?>（<strong><?php echo $output['cart_goods_num'];?></strong>）件</span></a>
	</div>
	
	<div class="searchTool">
		<form action="<?php echo SHOP_SITE_URL;?>" method="get" class="search-form" id="top_search_form">
		<input name="act" id="search_act" value="search" type="hidden">
		<div class="selSearch">
			<div class="nowSearch" id="headSlected" onclick="if(document.getElementById('headSel').style.display=='none'){document.getElementById('headSel').style.display='block';}else {document.getElementById('headSel').style.display='none';};return false;" onmouseout="drop_mouseout('head');">商品</div>
			<div class="btnSel"><a href="#" onclick="if(document.getElementById('headSel').style.display=='none'){document.getElementById('headSel').style.display='block';}else {document.getElementById('headSel').style.display='none';};return false;" onmouseout="drop_mouseout('head');"></a></div>
			<div class="clear"></div>
			<ul class="selOption" id="headSel" style="display:none;">
				<li><a href="#" onclick="return search_show('head','store_list',this)" onmouseover="drop_mouseover('head');" onmouseout="drop_mouseout('head');">店铺</a></li>
				<li><a href="#" onclick="return search_show('head','search',this)" onmouseover="drop_mouseover('head');" onmouseout="drop_mouseout('head');">商品</a></li>
			</ul>
		</div>
		<input class="txtSearch" id="headq" name="keyword" type="text" value="<?php echo $_GET['keyword'];?>" autocomplete="off" placeholder="请输入您要搜索的商品关键字"/>
		<div class="btnSearch"><a href="#" onclick="javascript:document.getElementById('top_search_form').submit();"><span class="lbl">搜索</span></a></div>
		
		</form>
		<div class="clear"></div>
		<div class="rec">
			<span><?php echo $lang['hot_search'].$lang['nc_colon'];?></span>
			<?php if(is_array($output['hot_search']) && !empty($output['hot_search'])) { foreach($output['hot_search'] as $val) { ?>
			<a href="<?php echo urlShop('search', 'index', array('keyword' => $val));?>"><?php echo $val; ?></a>
			<?php } }?>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?php echo SHOP_TEMPLATES_URL;?>/js/index.js"></script>
<script type="text/javascript" src="<?php echo SHOP_TEMPLATES_URL;?>/js/common-header.js"></script>
<!-- common_header end -->