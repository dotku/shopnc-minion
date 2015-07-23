<div id="menu" class="public-nav-layout">
    	<div class="nav_wrap">
        	<div class="menu_cate">
                <a class="menu_title" href="<?php echo urlShop('category', 'index');?>"><?php echo $lang['nc_all_goods_class'];?></a>
                <div class="y_menu category">
                    <?php if (!empty($output['show_goods_class']) && is_array($output['show_goods_class'])) { ?>
						<?php // display only 8 categories ?>
						<?php $output['show_goods_class'] = array_slice($output['show_goods_class'], 0, 8); ?>
						<?php foreach ($output['show_goods_class'] as $key => $val) { ?>
							<div cat_id="<?php echo $val['gc_id'];?>" class="y_menu_1">
								<dl>
									<dt><a href="<?php echo urlShop('search','index',array('cate_id'=> $val['gc_id']));?>"><?php echo $val['gc_name'];?></a></dt>
									<dd>
										<?php if (!empty($val['class3']) && is_array($val['class3'])) { ?>
											<?php // display first 2 cates ?>
											<?php $val['class3'] = array_slice($val['class3'], 0, 2); ?>
											<?php foreach ($val['class3'] as $k => $v) { ?>
												<a href="<?php echo urlShop('search','index',array('cate_id'=> $v['gc_id']));?>" title="<?php echo $v['gc_name']; ?>"><?php echo $v['gc_name'];?></a>
											<?php } ?>
										<?php } ?>
									</dd> 
								</dl>
								<div class="sub_nav" cat_menu_id="<?php echo $val['gc_id'];?>">
									<?php if (!empty($val['class2']) && is_array($val['class2'])) { ?>
										<?php foreach ($val['class2'] as $k => $v) { ?>
											<h3><a href="<?php echo urlShop('search','index',array('cate_id'=> $v['gc_id']));?>"><?php echo $v['gc_name'];?></a></h3>
											<p><?php if (!empty($v['class3']) && is_array($v['class3'])) { ?>
											  <?php foreach ($v['class3'] as $k3 => $v3) { ?>
											  <a href="<?php echo urlShop('search','index',array('cate_id'=> $v3['gc_id']));?>"><?php echo $v3['gc_name'];?></a>
											  <?php } ?>
											  <?php } ?>
											</p>
										<?php } ?>
									<?php } ?>
								</div>
							</div>
						<?php } ?>
					<?php } ?>
                </div>
            </div>
			<!-- site menu -->
            <ul class="nav">
            	<li><a href="<?php echo SHOP_SITE_URL;?>" <?php if($output['index_sign'] == 'index' && $output['index_sign'] != '0') {echo 'class="current"';} ?>><?php echo $lang['nc_index'];?></a></li>
                <li><a href="<?php echo urlShop('brand', 'index');?>" <?php if($output['index_sign'] == 'brand' && $output['index_sign'] != '0') {echo 'class="current"';} ?>> <?php echo $lang['nc_brand'];?></a></li>
                <?php if (C('points_isuse') && C('pointshop_isuse')){ ?>
                <li><a href="<?php echo urlShop('pointshop', 'index');?>" <?php if($output['index_sign'] == 'pointshop' && $output['index_sign'] != '0') {echo 'class="current"';} ?>> <?php echo $lang['nc_pointprod'];?></a></li>
                <?php } ?>
                  <?php if(!empty($output['nav_list']) && is_array($output['nav_list'])){?>
                  <?php foreach($output['nav_list'] as $nav){?>
                  <?php if($nav['nav_location'] == '1'){?>
                  <li><a
                    <?php
                    if($nav['nav_new_open']) {
                        echo ' target="_blank"';
                    }
                    switch($nav['nav_type']) {
                        case '0':
                            echo ' href="' . $nav['nav_url'] . '"';
                            break;
                        case '1':
                            echo ' href="' . urlShop('search', 'index',array('cate_id'=>$nav['item_id'])) . '"';
                            if (isset($_GET['cate_id']) && $_GET['cate_id'] == $nav['item_id']) {
                                echo ' class="current"';
                            }
                            break;
                        case '2':
                            echo ' href="' . urlShop('article', 'article',array('ac_id'=>$nav['item_id'])) . '"';
                            if (isset($_GET['ac_id']) && $_GET['ac_id'] == $nav['item_id']) {
                                echo ' class="current"';
                            }
                            break;
                        case '3':
                            echo ' href="' . urlShop('activity', 'index', array('activity_id'=>$nav['item_id'])) . '"';
                            if (isset($_GET['activity_id']) && $_GET['activity_id'] == $nav['item_id']) {
                                echo ' class="current"';
                            }
                            break;
                    }
                    ?>><?php echo $nav['nav_title'];?></a></li>
                  <?php }?>
                  <?php }?>
                  <?php }?>
            </ul>
        </div>
    </div>