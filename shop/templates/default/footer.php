<div id="footer">
    	<div class="ribbon">
        	<div class="ribbon_art">
            	<span>100%正品担保</span>
                <span>跨境物流保证</span>
                <span>商家资质认证</span>
                <span>支付安全方便</span>
            </div>
        </div>

        <div class="help_wrap">
            <div class="help">
            <?php if(is_array($output['article_list']) && !empty($output['article_list'])){ ?>
    <?php foreach ($output['article_list'] as $k=> $article_class){ ?>
    <?php if(!empty($article_class)){ ?>
 <dl class="s<?php echo ''.$k+1;?>">
      <dt>
        <?php if(is_array($article_class['class'])) echo $article_class['class']['ac_name'];?>
      </dt>
      <?php if(is_array($article_class['list']) && !empty($article_class['list'])){ ?>
      <?php foreach ($article_class['list'] as $article){ ?>
      <dd><a href="<?php if($article['article_url'] != '')echo $article['article_url'];else echo urlShop('article', 'show',array('article_id'=> $article['article_id']));?>" title="<?php echo $article['article_title']; ?>"> <?php echo $article['article_title'];?> </a></dd>
      <?php }?>
      <?php }?>
    </dl>
    <?php }?>
    <?php }?>
    <?php }?>
                
            </div>
        </div>
        
        <div class="bot_nav_wrap">
            <div class="bot_nav">
                <a href="<?php echo SHOP_SITE_URL;?>"><?php echo $lang['nc_index'];?></a>
    <?php if(!empty($output['nav_list']) && is_array($output['nav_list'])){?>
    <?php foreach($output['nav_list'] as $nav){?>
    <?php if($nav['nav_location'] == '2'){?>
     <a  <?php if($nav['nav_new_open']){?>target="_blank" <?php }?>href="<?php switch($nav['nav_type']){
    	case '0':echo $nav['nav_url'];break;
    	case '1':echo urlShop('search', 'index', array('cate_id'=>$nav['item_id']));break;
    	case '2':echo urlShop('article', 'article',array('ac_id'=>$nav['item_id']));break;
    	case '3':echo urlShop('activity', 'index',array('activity_id'=>$nav['item_id']));break;
    }?>"><?php echo $nav['nav_title'];?></a>
    <?php }?>
    <?php }?>
    <?php }?>
            </div>
            <div class="cprt"> 
            Copyright © 2014-2015 易购达 All Right Reserved <br>
            USC Group 版权所有
            </div>
        </div>
    </div>