<?php
/**
 * 关税设置
 *
 *
 *
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
defined('InShopNC') or exit('Access Invalid!');
class set_taxControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('setting');
	}
	
public function set_taxOp(){
		$lang	= Language::getLangContent();
		$model_class = Model('goods_class');
        $goods_class = $model_class->get_all_category();
        Tpl::output('show_goods_class',$goods_class);//商品分类
		/*
         H('goods_class',true);
		$show_goods_class = ($g = F('goods_class')) ? $g : H('goods_class',true);
		Tpl::output('gc_list',$show_goods_class);
		*/

		if(trim($_GET['type']) == 'new'){
		Tpl::showpage('set_tax_new');
		}else{
		Tpl::showpage('set_tax_index');
		}
	}
	

/**
	 * ajax操作
	 */
	public function ajaxOp(){
		switch ($_GET['branch']){
			/**
			 * 更新分类
			 */
			case 'goods_class_note':
				$model_class = Model('goods_class');
			    $where = array('gc_id' => intval($_GET['id']));
				$update_array = array();
				$update_array[$_GET['column']] = $_GET['value'];
				$model_class->editGoodsClass($update_array, $where);
				echo 'true';exit;
				break;
			/**
			 * 分类 排序 显示 设置
			 */
			case 'goods_class_sort':
				$model_class = Model('goods_class');
			    $where = array('gc_id' => intval($_GET['id']));
				$update_array = array();
				$update_array[$_GET['column']] = trim($_GET['value']/100)>1?1:trim($_GET['value']/100);
				$model_class->editGoodsClass($update_array, $where);
				echo 'true';exit;
				break;
				
			/**
			 * 添加、修改操作中 检测类别名称是否有重复
			 */
			case 'check_class_name':
				$model_class = Model('goods_class');
				$condition['gc_name'] = trim($_GET['gc_name']);
				$condition['gc_parent_id'] = intval($_GET['gc_parent_id']);
				$condition['gc_id'] = array('neq', intval($_GET['gc_id']));
				$class_list = $model_class->getGoodsClassList($condition);
				if (empty($class_list)){
					echo 'true';exit;
				}else {
					echo 'false';exit;
				}
				break;
			
		}
	}

}