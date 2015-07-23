<?php
/**
 * 销售区域模型
 *
 * 
 *
 *
 */
defined('InShopNC') or exit('Access Invalid!');

class sale_areaModel extends Model {
    public function __construct(){
        parent::__construct('sale_area');
    }
	
	/**
	* 只显示 sale_area_id、 sale_area_name 两个字段
	* 以 sale_area_id 作为数组 index 来输出
	*/ 
	public function getArray_idName(){
		$arrayTable = $this->field('sale_area_id, sale_area_name')->select();
		$arrayResult = Array();
		
		foreach ($arrayTable as $key => $value) {
			$arrayResult[$value['sale_area_id']] = $value['sale_area_name'];
		}
		
		return $arrayResult;
	}
	
	/**
	* 以 sale_area_id 作为输出数组 index 重置输出数组
	*/
	
	public function getArray_resetKeys() {
		$arrayTable = $this->order('sale_area_id')->select();
		$arrayResult = Array();
		
		foreach ($arrayTable as $key => $value) {
			$arrayResult[$value['sale_area_id']] = $value;
		}

		return $arrayResult;
	}
}