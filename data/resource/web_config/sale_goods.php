<?php defined('InShopNC') or exit('Access Invalid!');?>
<?php 
    $arr_target = array_slice($output['code_sale_list']['code_info'], 0, 1);
    $arr_target = $arr_target[0];
    if (!empty($arr_target['goods_list']) && is_array($arr_target['goods_list'])) {
        $i_hot_max = 4;
        $i_hot = 0;
        foreach ($arr_target['goods_list'] as $k => $v) {
            if ($i_hot < $i_hot_max) {
?>
                <div class="brand_ad">
					<div class="productContainer">
					<a class="productLink" href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id'])); ?>" title="<?php echo $v['goods_name']; ?>" target="_blank"><img alt="<?php echo $v['goods_name']; ?>" class="productImg" src="<?php echo strpos($v['goods_pic'],'http')===0 ? $v['goods_pic']:UPLOAD_SITE_URL."/".$v['goods_pic'];?>"><div style="clear:both"></div></a>
					</div>
					<div class="productIntro">
					<a href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id'])); ?>" title="<?php echo $v['goods_name']; ?>" target="_blank"><?php echo $v['goods_name']; ?></a>
					</div>
				</div>
<?php
                $i_hot++;
            }
        } 
    } 
?>