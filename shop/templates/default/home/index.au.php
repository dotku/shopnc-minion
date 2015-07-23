<?php defined('InShopNC') or exit('Access Invalid!');?>
<?php echo '<!-- RegionCode ' . $output['region_code'] . ' -->' . PHP_EOL; ?>
<script type="text/javascript" src="<?php echo SHOP_RESOURCE_SITE_URL;?>/js/home_index.js" charset="utf-8"></script>
<div id="ygd_bd">
	<!-- HomeFocusLayout Begin -->
	<?php echo $output['web_html']['index_pic']; ?>
	<!--HomeFocusLayout End-->
	<div style="clear:both"></div>
	<!-- 限时效果演示模块_Begin -->
<div class="sepcial">
        	<!--抢购左边大-->
       	  <div class="qg_item_l">
            	<a href="#" class="qg_good"><img src="images/qianggou.jpg"></a>
                <div class="qg_intro">
                	<h3 class="qg_title">
                    	<a href="#">
                        	<span class="title">【丝光棉短T】高档黑标短T</span>
                            <span class="by_img"><img src="images/baoyou.gif"></span>
                        </a>
                    </h3>
                    <div class="qg_intro_wrap">
                    	<span class="qg_intro_de">丝光棉短T高档黑标短T，精选柔滑冰爽丝光棉，搭配民族风蓝色暗提花，低调而不失优雅.</span>
                    </div>
                    <div class="price_title">
                    	<span class="pr">￥159<s>￥199</s></span>
                    	<span class="sale_out">已售(&nbsp;<b>100</b>&nbsp;)件</span>
                    </div>
                    <div class="lim_t">
                    	<span>剩余时间：120小时60分钟120秒</span>
                        <a href="#"><img src="images/qg_bt.gif"></a>
                    </div>
                </div>
            </div>
            
            
            <div class="qg_item_r">
            	<a href="#" class="qg_good"><img src="images/qianggou.jpg"></a>
                <div class="qg_intro">
                	<h3 class="qg_title">
                    	<a href="#">
                        	<span class="title">【丝光棉短T】高档黑标短T</span>
                            <span class="by_img"><img src="images/baoyou.gif"></span>
                        </a>
                    </h3>
                    <div class="qg_intro_wrap">
                    	<span class="qg_intro_de">丝光棉短T高档黑标短T，精选柔滑冰爽丝光棉，搭配民族风蓝色暗提花，低调而不失优雅.</span>
                    </div>
                    <div class="price_title">
                    	<span class="pr">￥159<s>￥199</s></span>
                    	<span class="sale_out">已售(&nbsp;<b>100</b>&nbsp;)件</span>
                    </div>
                    <div class="lim_t">
                    	<span>剩余时间：120小时60分钟120秒</span>
                        <a href="#"><img src="images/qg_bt.gif"></a>
                    </div>
                </div>
            </div>
            
            
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
			<div class="hot_cate_title"><a href="#"><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/hot_tag.jpg"></a></div>
			
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