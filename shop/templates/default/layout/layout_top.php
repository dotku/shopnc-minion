<!-- layout/top begin -->
<div id="append_parent"></div>
<div id="top">
    <div class="top_content">
        <div class="user-entry">
            <ul class="top_wel">
                <?php if($_SESSION['is_login'] == '1'){?>
                <li><span class="welcome"><?php echo $lang['nc_hello'];?></span></li>
                <li><span>
                  <a href="<?php echo urlShop('member','home');?>"><?php echo $_SESSION['member_name'];?></a>
                  <?php if ($output['member_info']['level_name']){ ?>
                  <div class="nc-grade-mini" style="cursor:pointer;" onclick="javascript:go('<?php echo urlShop('pointgrade','index');?>');"><?php echo $output['member_info']['level_name'];?></div>
                  <?php } ?>
                </span><?php echo $lang['nc_comma']?></li>
				<li><span class="welcome"><?php echo $lang['welcome_to_site']; ?> <a href="<?php echo SHOP_SITE_URL;?>" title="<?php echo $lang['homepage'];?>" alt="<?php echo $lang['homepage'];?>"><?php echo $output['setting_config']['site_name']; ?></a> </span></li>
                <?php } else { ?>
                
                <li><span class="welcome"><?php echo $lang['nc_hello'].$lang['nc_comma'].$lang['welcome_to_site']; ?> <a href="<?php echo SHOP_SITE_URL;?>" title="<?php echo $lang['homepage'];?>" alt="<?php echo $lang['homepage'];?>"><?php echo $output['setting_config']['site_name']; ?></a> </span></li>
                <li><span>[<a class="login" href="<?php echo urlShop('login');?>"><?php echo $lang['nc_login'];?></a>]</span></li>
                <li><span>[<a class="regist" href="<?php echo urlShop('login','register');?>"><?php echo $lang['nc_register'];?></a>]</span></li>
                <?php }?>
            </ul>
        </div>
        <ul class="top_user">
			<?php if ($_SESSION['is_login'] == '1') { ?>
			<li><a href="<?php echo urlShop('login','logout');?>" title="退出">[退出]</a></li>
			<?php } ?>
			<li><a href="index.php?act=seller_login&op=show_login" title="商家登录">商家登录</a></li>
            <?php if ($_SESSION['store_id']) { ?>
			<li><a href="shop/index.php?act=seller_center" title="商家中心">商家中心</a></li>
			<?php } else { ?>
				<li><a href="index.php?act=show_joinin&op=index" title="商家入驻">商家入驻</a></li>
			<?php } ?>
            <li><a href="<?php echo urlShop('member_order','index');?>">我的订单</a></li>
            <li><a href="<?php echo urlShop('member','home');?>">我的易购达</a></li>
        </ul>
    </div>
</div>
<!-- layout top end -->