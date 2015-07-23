<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="home-standard-layout wrapper style-<?php echo $output['style_name'];?> goods_wrap" 
    name="style-<?php echo $output['style_name'];?>" 
    id="style-<?php echo $output['style_name'];?>-<?php echo $output['code_tit']['web_id']?>" >
    <div class="broad">
        <div class="broad_title">
            <?php if ($output['code_tit']['code_info']['type'] == 'txt') { ?>
                <h2 title="<?php echo $output['code_tit']['code_info']['title'];?>"><?php echo $output['code_tit']['code_info']['title'];?></h2>
                <?php if(!empty($output['code_tit']['code_info']['floor'])) { ?><span><?php echo $output['code_tit']['code_info']['floor'];?></span><?php } ?>
                            
            <?php } else { ?>
                            <div class="pic-type"><img src="<?php echo UPLOAD_SITE_URL.'/'.$output['code_tit']['code_info']['pic'];?>"/></div>
            <?php } ?>
        </div>
        <div class="broad_list">
            <ul>
                <?php if (is_array($output['code_category_list']['code_info']['goods_class']) && !empty($output['code_category_list']['code_info']['goods_class'])) { ?>
				<?php $i_cate = 0; $max_cate = 7; ?>
                <?php foreach ($output['code_category_list']['code_info']['goods_class'] as $k => $v) { ?>
				<?php if ($i_cate < $max_cate) { $i_cate++; ?>
                            <li><a href="<?php echo urlShop('search','index',array('cate_id'=> $v['gc_id']));?>" title="<?php echo $v['gc_name'];?>" target="_blank"><?php echo mb_substr($v['gc_name'], 0, 4, 'UTF-8');?></a></li>
                <?php } ?>
				<?php } ?>
                <?php } ?>
          </ul>
        </div>
        <div class="broad_ad">
                <?php if(!empty($output['code_act']['code_info']['pic'])) { ?>
                        <a href="<?php echo $output['code_act']['code_info']['url'];?>" title="<?php echo $output['code_act']['code_info']['title'];?>" target="_blank">
                            <img src="<?php  echo UPLOAD_SITE_URL.'/'.$output['code_act']['code_info']['pic'];?>" alt="<?php echo $output['code_act']['code_info']['title']; ?>">
                        </a>
                <?php } ?>
        </div>
		<div style="clear:both"></div>
    </div>
    <div class="broad_info middle-layout">
        <?php 
            if (!empty($output['code_recommend_list']['code_info']) && is_array($output['code_recommend_list']['code_info'])) {
				foreach ($output['code_recommend_list']['code_info'] as $key => $val) {
                        if(!empty($val['goods_list']) && is_array($val['goods_list'])) { 
							$val['goods_list'] = array_slice($val['goods_list'], 0, 6);
                            foreach($val['goods_list'] as $k => $v){ 
        ?>
			<div class="goods">
                	<div class="goods_main">
                    	<a href="<?php echo urlShop('goods','index',array('goods_id'=> $v['goods_id'])); ?>" class="goods_img" target="_blank"><img src="<?php echo strpos($v['goods_pic'],'http')===0 ? $v['goods_pic']:UPLOAD_SITE_URL."/".$v['goods_pic'];?>" alt="<?php echo $v['goods_name']; ?>"></a>
                        <div class="goods_price">
                        	<div class="brand_logo"></div>
                            <span class="brand_name"><?php $brand_name = explode(" ", $v['goods_name']); echo $brand_name[0];?></span>
                            <span class="price"><em>¥</em><?php echo $v['goods_price'];?></span>
                        </div>
                    </div>
                    <div class="goods_intro"><a href="<?php echo urlShop('goods','index',array('goods_id'=> $v['goods_id'])); ?>" target="_blank"><?php echo $v['goods_name'];?></a></div>
                </div>
        <?php
                            } 
                        }
                    }  
             } 
        ?>
    </div>
	<!-- standard-layout ad -->
	<?php $output['code_adv']['code_info'] = array_slice($output['code_adv']['code_info'], 0, 1); ?>
	<?php if(!empty($output['code_adv']['code_info']) && is_array($output['code_adv']['code_info'])) { ?>
	<?php foreach ($output['code_adv']['code_info'] as $key => $val) { ?>
	<div class="img_ad">
		<a href="<?php echo $val['pic_url'];?>" title="<?php echo $val['pic_name'];?>" target="_blank"><img src="<?php  echo UPLOAD_SITE_URL.'/'.$val['pic_img'];?>" alt="<?php echo $val['pic_name']; ?>" style="width:1180px; height: 90px;"></a>
	 </div>
	<?php } ?>
	<?php } ?>
	<div style="clear:both"></div>
</div>