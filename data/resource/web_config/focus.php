<?php defined('InShopNC') or exit('Access Invalid!');?>

<div id="banner">
  <ul class="banner_img">
    <?php 
        $i_item = 1;
        if (is_array($output['code_screen_list']['code_info']) && !empty($output['code_screen_list']['code_info'])) { 
            foreach ($output['code_screen_list']['code_info'] as $key => $val) {  
    ?>
                <li class="item<?php echo $i_item?>" style="<?php if ($i_item == 1) { echo "display:list-item;";} else { echo "display:none;";}?> background: <?php echo $val['color'];?> url('<?php echo UPLOAD_SITE_URL.'/'.$val['pic_img'];?>') no-repeat center;">
                <a href="<?php echo $val['pic_url'];?>" target="_blank" title="<?php echo $val['pic_name'];?>"><div class="wrapper"> </div></a></li>
    <?php 
                $i_item++;
            } 
    ?>
    <?php 
        } 
    ?>
  </ul>
  <div class="banner_ctr">
    <div class="drag_ctr"> </div>
    <ul>
    <?php
        $i_item = 1;
        if (is_array($output['code_screen_list']['code_info']) && !empty($output['code_screen_list']['code_info'])) { 
            foreach ($output['code_screen_list']['code_info'] as $key => $val) {  
                if ($i_item == 1) {
    ?>
      <li style="width:0px;"></li>
      <li class="styclsa"> <a href="#" target="_blank" class="astysa"><?php echo $val['pic_name'];?></a></li>
    <?php
                } else {
    ?>
      <li style="width:1px;"></li>
      <li class="styclsa"> <a href="#" target="_blank" class="astysa"><?php echo $val['pic_name'];?></a></li>
    <?php
                }
                $i_item++;
            }
        }
    ?>
    </ul>
  </div>
</div>