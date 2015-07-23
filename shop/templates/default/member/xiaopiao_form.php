<?php defined('InShopNC') or exit('Access Invalid!');?>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/img.js" type="text/javascript"></script>
<div class="eject_con">
  <div class="adds">
    <div id="warning"></div>
    <form method="post" action="index.php?act=member&op=xiaopiao" id="xiaopiao_form" enctype="multipart/form-data" target="_parent">
	  <input type="hidden" name="form_submit" value="ok" />
	  <input type="hidden" name="old_xiaopiao" value="<?php echo $output['goods_xiaopiao']['xiaopiao_image'];?>" />
	  <input type="hidden" name="goods_id" value="<?php echo $_GET['goods_id'];?>" />
      
<dd  style="height:500px;text-align:center;">
          <br/>
		  <?php if (!empty($output['goods_xiaopiao']['xiaopiao_image'])){;?> <img src="<?php echo UPLOAD_SITE_URL;?>/xiaopiao/<?php echo $output['goods_xiaopiao']['xiaopiao_image'];?>" onload="AutoResizeImage(600,450,this)"> 
	<?php }else{?>还没上传购物小票<?php } ?>
        </dd>

	  
   
    <dl>
      <dt>上传购物小票<?php echo $lang['nc_colon'];?></dt>
      <dd>
        <input name="xiaopiao" type="file" id="id_pic1"/>
      </dd>
	  <dd></dd>
    </dl>
   
      <dl class="bottom"><dt>&nbsp;</dt><dd>
        <input type="submit" class="submit" value="上传" />
      </dd></dl>
    </form>

  </div>
</div>
<script type="text/javascript">
// 模拟网站LOGO上传input type='file'样式
$(function(){
	$("#xiaopiao").change(function(){
		$("#textfield1").val($(this).val());
	});
	
// 上传图片类型
$('input[class="type-file-file"]').change(function(){
	var filepatd=$(this).val();
	var extStart=filepatd.lastIndexOf(".");
	var ext=filepatd.substring(extStart,filepatd.lengtd).toUpperCase();		
		if(ext!=".PNG"&&ext!=".GIF"&&ext!=".JPG"&&ext!=".JPEG"){
			alert("图片上传格式不正确");
				$(this).attr('value','');
			return false;
		}
	});
	
$('#time_zone').attr('value','<?php echo $output['list_setting']['time_zone'];?>');	
});
</script>

