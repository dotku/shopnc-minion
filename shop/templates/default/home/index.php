<?php defined('InShopNC') or exit('Access Invalid!');?>
<?php echo '<!-- RegionCode ' . $output['region_code'] . ' -->' . PHP_EOL; ?>
<script type="text/javascript" src="<?php echo SHOP_RESOURCE_SITE_URL;?>/js/home_index.js" charset="utf-8"></script>
<div id="ygd_bd">
	<!-- HomeFocusLayout Begin-->
	<?php echo $output['web_html']['index_pic']; ?>
	<!--HomeFocusLayout End-->
	<div style="clear:both"></div>
	<!-- 限时效果演示模块_Begin -->
	<div class="sepcial">
						<div class="qg_item">
							<img class="imzhiyou" src="<?php echo SHOP_TEMPLATES_URL;?>/images/zhiyou.png" alt="Sale">
							<a href="http://www.ebuyda.com/shop/index.php?act=goods&op=index&goods_id=216" class="qg_good" title="KennethCole 男式手表KC1568" target="_blank"><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/AD/bag.jpg" style="max-height:200px;padding-top: 22px;"></a>
					<div class="qg_intro">
						<h3 class="qg_title">
							<a href="http://www.ebuyda.com/shop/index.php?act=goods&op=index&goods_id=216" target="_blank">
								<span class="title">COACH/蔻驰 浅棕迷你桶包</span>
								<span class="desc">曼哈顿工匠世代相传工艺</span>
							</a>
						</h3>
						<div class="qg_price_wrap">
							<span class="price_title">海外团</span>
							<span class="price_txt"><sup>￥</sup><b class="price_l">959</b>元</span>
						</div>
						<div class="qg_enter_wrap">
							<div class="qg_ft"><a class="qg_btm" href="http://www.ebuyda.com/shop/index.php?act=goods&op=index&goods_id=216" target="_blank">我要抢</a></div>
							<div class="qg_time">
								<span class="y_time time-remain" count_down="2890200">
									剩余时间:
									<em time_id="d">56</em> 天
									<em time_id="h">3</em> 小时
									<em time_id="m">16</em> 分
									<em time_id="s">40</em> 秒
								</span>
							</div>
						</div>
					</div>

							</div>

		<div id="saleDiscount" class="sale-discount">
									<div class="qg_r">
				<img class="imzhiyou" src="<?php echo SHOP_TEMPLATES_URL;?>/images/zhiyou.png" alt="Sale">
				<span class="goods-img-container">
				<a href="http://www.ebuyda.com/shop/index.php?act=goods&op=index&goods_id=929" title="Kirkland/柯克兰 Omega-3 1000mg深海鱼油400粒" target="_blank"><img class="goods-img" src="<?php echo SHOP_TEMPLATES_URL;?>/images/AD/qg_img3.jpg"></a>
				</span>
				<div class="tosee">
					<span class="tosee_price"><sup>￥</sup><b class="price_r">87</b></span>
					<div class="withtax">
						<span class="i_tax">包关税</span>
						<span class="i_pri"><s>￥170</s></span>
					</div>
					<a href="http://www.ebuyda.com/shop/index.php?act=goods&op=index&goods_id=929" class="tosee_btm" target="_blank">去看看</a>
				</div>
				<div class="gq_lim_time">
					<span class="y_time time-remain" count_down="1326200">
						剩余时间: <b time_id="d">36</b> 天
						<b time_id="h">17</b> 小时
						<b time_id="m">30</b> 分
						<b time_id="s">30</b> 秒
					</span>
				</div>
			</div>
						<div class="qg_r">
				<img class="imzhiyou" src="<?php echo SHOP_TEMPLATES_URL;?>/images/zhiyou.png" alt="Sale" original="<?php echo SHOP_TEMPLATES_URL;?>/images/zhiyou.png">
				<span class="goods-img-container">
				<a href="http://www.ebuyda.com/shop/index.php?act=goods&op=index&goods_id=787" title="Tommy 红白蓝格子短裤" target="_blank"><img class="goods-img" src="<?php echo SHOP_TEMPLATES_URL;?>/images/AD/qg_img4.jpg"></a>
				</span>
				<div class="tosee">
					<span class="tosee_price"><sup>￥</sup><b class="price_r">259</b></span>
					<div class="withtax">
						<span class="i_tax">包关税</span>
						<span class="i_pri"><s>￥312</s></span>
					</div>
					<a href="http://www.ebuyda.com/shop/index.php?act=goods&op=index&goods_id=787" class="tosee_btm" target="_blank">去看看</a>
				</div>
				<div class="gq_lim_time">
					<span class="y_time time-remain" count_down="13215">
						剩余时间:
						<b time_id="d">63</b> 天
						<b time_id="h">17</b> 小时
						<b time_id="m">30</b> 分
						<b time_id="s">30</b> 秒
					</span>
				</div>
			</div>
				   <div class="pagination"></div><div class="arrow pre" style="opacity: 0;"></div><div class="arrow next" style="opacity: 0;"></div></div>
	</div>
	<!-- 限时效果演示模块_End -->

	<?php // 必须同时开启 团购和限时功能才能显示以下列表 ?>
	<?php if(!empty($output['group_list']) && !empty($output['xianshi_item'])) {?>
		<!-- 临时隐藏该模块 -->
		<!--div class="sepcial" style="display: none">
			<?php if(!empty($output['group_list']) && is_array($output['group_list'])) {?>
			<div class="qg_item">
				<?php $output['group_list'] = array_slice($output['group_list'], 0, 1);?>
				<?php foreach($output['group_list'] as $val) {?>
					<img class="imzhiyou" src="<?php echo SHOP_TEMPLATES_URL;?>/images/zhiyou.png" alt="Sale">
					<a href="<?php echo urlShop('show_groupbuy','groupbuy_detail',array('group_id'=> $val['groupbuy_id']));?>" class="qg_good" title="<?php echo $val['goods_name'];?>" target="_blank"><img src="<?php echo gthumb($val['groupbuy_image1'], 'small');?>"></a>
					<div class="qg_intro">
						<h3 class="qg_title">
							<a href="<?php echo urlShop('show_groupbuy','groupbuy_detail',array('group_id'=> $val['groupbuy_id']));?>" target="_blank">
								<span class="title"><?php echo mb_substr($val['goods_name'], 0, 16, 'UTF-8');?></span>
								<span class="desc"><?php echo mb_substr($val['groupbuy_intro'], 0, 16, 'UTF-8');?></span>
							</a>
						</h3>
						<div class="qg_price_wrap">
							<span class="price_title">海外团</span>
							<span class="price_txt"><sup>￥</sup><b class="price_l"><?php echo intval($val['groupbuy_price']); ?></b>元</span>
						</div>
						<div class="qg_enter_wrap">
							<div class="qg_ft"><a class="qg_btm" href="#"><?php echo $val['button_text']; ?></a></div>
							<div class="qg_time">
								<span class="time-remain" count_down="<?php echo $val['end_time']-TIMESTAMP; ?>">
									<em time_id="d">0</em> <?php echo $lang['text_tian'];?>
									<em time_id="h">0</em> <?php echo $lang['text_hour'];?>
									<em time_id="m">0</em> <?php echo $lang['text_minute'];?>
									<em time_id="s">0</em> <?php echo $lang['text_second'];?>
								</span>
							</div>
						</div>
					</div>
				  </dl>
				<?php } ?>
			</div>
			<?php } ?>

		<div id="saleDiscount" class="sale-discount">
			<?php $output['xianshi_item'] = array_slice($output['xianshi_item'], 0, 2); ?>
			<?php foreach($output['xianshi_item'] as $val) { ?>
			<div class="qg_r">
				<img class="imzhiyou" src="<?php echo SHOP_TEMPLATES_URL;?>/images/zhiyou.png" alt="Sale">
				<span class="goods-img-container">
				<a href="<?php echo urlShop('goods','index',array('goods_id'=> $val['goods_id']));?>" title="<?php echo $val['goods_name']?>"><img class="goods-img" src="<?php echo UPLOAD_SITE_URL . DS . ATTACH_GOODS . DS . $val['goods_image']; ?>"></a>
				</span>
				<div class="tosee">
					<span class="tosee_price"><sup>￥</sup><b class="price_r"><?php echo intval($val['xianshi_price']);?></b></span>
					<div class="withtax">
						<span class="i_tax"><?php echo $lang['nc_include_tax']?></span>
						<span class="i_pri"><s>￥<?php echo intval($val['goods_price']); ?></s></span>
					</div>
					<a href="<?php echo urlShop('goods','index',array('goods_id'=> $val['goods_id']));?>" class="tosee_btm">去看看</a>
				</div>
				<div class="gq_lim_time">
					<span class="y_time time-remain" count_down="<?php echo $val['end_time']-TIMESTAMP;?>">
						<b time_id="d">0</b> <?php echo $lang['text_tian'];?>
						<b time_id="h">0</b> <?php echo $lang['text_hour'];?>
						<b time_id="m">0</b><?php echo $lang['text_minute'];?>
					</span>
				</div>
			</div>
			<?php } ?>
	   </div>
	</div-->
	<?php } ?>
	<div style="clear:both"></div>
	<!-- 热销产品 Begin -->
	<div class="hot">
		<div class="hot_cate">
			<div class="hot_cate_title"><a href="#"><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/temp/hot_tag.gif"></a></div>

			<?php if (!empty($output['brand_list']) && is_array($output['brand_list'])) { ?>
			<div class="hot_brand">
			<?php foreach($output['brand_list'] as $k => $v) { ?>
						<a href="shop/index.php?act=brand&op=list&brand=<?php echo $v['brand_id'] ?>" class="brand_list"><img style="max-width: 78px; max-height: 43px; border: solid #eee 1px" src="<?php echo C('base_site_url') . DS . DIR_UPLOAD . DS . ATTACH_BRAND . DS . $v['brand_pic'];?>"></a>
			<?php } ?>
			</div>
			<?php } ?>
		</div>

		<?php echo $output['web_html']['index_sale'];?>
		<!-- 热销产品 End -->
		<div style="clear:both"></div>
	</div>

	<!--StandardLayout Begin-->
	<div><?php echo $output['web_html']['index'];?></div>
	<!--StandardLayout End-->
</div>
<div style="clear:both"></div>