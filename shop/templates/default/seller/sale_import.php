
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />




<div class="alert mt15 mb5"><strong>操作提示：</strong>
  <ul>
    <li>1、请严格按照样板格式导入，导入文件后缀为slx。<br>
2、快递跟踪号、商品信息（商品货号*销售数量 商品货号*销售数量 商品货号*销售数量...）、收件人等位置必须与样本对号入座且不能错乱。</li>
  </ul>
</div>
<form method="post" action="index.php?act=sale_import&op=index" enctype="multipart/form-data" id="goods_form">
  <div class="ncsc-form-goods" >
    <dl>
      <dt><i class="required">*</i>上传xls文件：</dt>
      <dd>
        <div class="handle">
        <div class="ncsc-upload-btn"> <a href="javascript:void(0);"><span>
          <input type="file" hidefocus="true" size="15"  name="file" id="xls">
          </span></a></div>
      </dd>
    </dl>
    
    
    <!--transport info begin-->
   
    <dl>
      <dt><a href="../data/upload/sample.xls" > 上传样本</a>&nbsp;</dt>
      <dd>
        <input type="submit" class="submit" value="<?php echo $lang['store_goods_import_submit'];?>" />
      </dd>
    </dl>
    </ul>
  </div>


</form>
