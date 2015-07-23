<nav class="public-nav-layout">
  <div class="wrapper">
    <div class="all-category">
      <?php require template('layout/home_goods_class');?>
    </div>
    <ul class="site-menu">
      <li><a href="<?php echo SHOP_SITE_URL;?>" <?php if($output['index_sign'] == 'index' && $output['index_sign'] != '0') {echo 'class="current"';} ?>><?php echo $lang['nc_index'];?></a></li>
      <?php if (C('groupbuy_allow')){ ?>
      <li><a href="<?php echo urlShop('show_groupbuy', 'index');?>" <?php if($output['index_sign'] == 'groupbuy' && $output['index_sign'] != '0') {echo 'class="current"';} ?>> <?php echo $lang['nc_groupbuy'];?></a></li>
      <?php } ?>
      <li><a href="<?php echo urlShop('brand', 'index');?>" <?php if($output['index_sign'] == 'brand' && $output['index_sign'] != '0') {echo 'class="current"';} ?>> <?php echo $lang['nc_brand'];?></a></li>
      <?php if (C('points_isuse') && C('pointshop_isuse')){ ?>
      <li><a href="<?php echo urlShop('pointshop', 'index');?>" <?php if($output['index_sign'] == 'pointshop' && $output['index_sign'] != '0') {echo 'class="current"';} ?>> <?php echo $lang['nc_pointprod'];?></a></li>
      <?php } ?>
      <?php if (C('cms_isuse')){ ?>
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
</nav>