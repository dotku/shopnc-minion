<?php 
/**
 * 商店服务模型模型
 * @author 炎藤(QQ44219991)
 * @URL /shop/index.php?act=shop_api&op=brand_index
 * @apth \shop\control\shop_api.php
 */
defined('InShopNC') or exit('Access Invalid!');
class shop_apiControl extends BaseHomeControl {
	public function brand_indexOp(){
		$model_brand = Model('brand');
		$model_goods_class = Model('goods_class');
		$goods_class = Model('goods_class')->getGoodsClassForCacheModel();
		
		$rgClassInfo = $this->_getTopClass($goods_class, 608);
		$rgChild = explode(',', $rgClassInfo['child']);
		$rgChildChild = explode(',', $rgClassInfo['childchild']);
		//var_dump($rgChild);
		echo "<h2>二级目录</h2>"."<br/>";
		foreach ($rgChild as $val) {
			echo $model_goods_class->find($val)['gc_name']."(id: ".$val.") ";
			foreach($model_brand->where(Array('class_id'=>$val))->select() as $v){
				echo $v['brand_name']." | ";
			}
			echo "<br/>";
		}
		echo "<h2>三级目录</h2>"."<br/>";
		foreach ($rgChildChild as $val) {
			echo $model_goods_class->find($val)['gc_name']."(id: ".$val.")";
			$sTempBrands = "";
			foreach($model_brand->where(Array('class_id'=>$val))->select() as $v){
				$sTempBrands += $v['brand_name']." | ";
			}
			echo $sTempBrands ? $sTempBrands : " - 无品牌";
			echo "<br/>";
		}
	}
	
	/**
	 * 获取顶级商品分类
	 * 递归调用
	 * @param array $goods_class
	 * @param int $gc_id
	 * @return array
	 */
	private function _getTopClass($goods_class, $gc_id) {
	    if (!isset($goods_class[$gc_id])) {
	        return null;
	    }
	    return $goods_class[$gc_id]['gc_parent_id'] == 0 ? $goods_class[$gc_id] : $this->_getTopClass($goods_class, $goods_class[$gc_id]['gc_parent_id']);
	}
}