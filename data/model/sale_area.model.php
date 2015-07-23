<?php
/**
 * ��������ģ��
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
	* ֻ��ʾ sale_area_id�� sale_area_name �����ֶ�
	* �� sale_area_id ��Ϊ���� index �����
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
	* �� sale_area_id ��Ϊ������� index �����������
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