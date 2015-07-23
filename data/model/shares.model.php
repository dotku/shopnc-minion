<?php
/**
 * 商品品牌模型
 *
 * 
 *
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc.
 */
defined('InShopNC') or exit('Access Invalid!');

class sharesModel extends Model {
    public function __construct() {
        parent::__construct('shares');
    }
    
    public function getSharesList($condition, $field = '*', $page = 0, $order = 'shares_id desc', $limit = '') {
        return $this->where($condition)->field($field)->order($order)->page($page)->limit($limit)->select();
    }
    public function getSharesSum($store_id){
		  return $this->where(array('store_id'=>$store_id))->sum('shares_amount');
	}
	public function addShares($data){
		  return $this->insert($data);
	}
	public function setShopShares($store_id,$shares){
		  return $this->table('store_extend')->where(array('store_id'=>$store_id))->setInc('shares',$shares);
	}
	public function getShopShares($store_id,$field = 'shares'){
		  return $this->table('store_extend')->where(array('store_id'=>$store_id))->find();
	}

}