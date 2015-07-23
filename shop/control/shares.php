<?php
/**
 * 店铺股份管理
 *
 *by joe
 */
defined('InShopNC') or exit('Access Invalid!');
class sharesControl extends BaseSellerControl {
	public function indexOp(){
		$lang	= Language::getLangContent();
		$model_shares = Model('shares');
		$condition	= array();
		$condition['store_id'] = $_SESSION['store_id'];
		if (!empty($_GET['order_id'])){
			$condition['order_id'] = array('like',"%".$_GET['order_id']."%");
		}
		$if_start_time = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['query_start_time']);
        $if_end_time = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['query_end_time']);
        $start_unixtime = $if_start_time ? strtotime($_GET['query_start_time']) : null;
        $end_unixtime = $if_end_time ? strtotime($_GET['query_end_time']): null;
        if ($start_unixtime || $end_unixtime) {
            $condition['add_time'] = array('time',array($start_unixtime,$end_unixtime));
        }

		
		$shares_list = $model_shares->getSharesList($condition, "*", 50);
		$shares_sum = $model_shares->getSharesSum($_SESSION['store_id']);
		$ShopShares = $model_shares->getShopShares($_SESSION['store_id']);

		Tpl::output('ShopShares',$ShopShares['shares']);
		Tpl::output('show_page',$model_shares->showpage());
		Tpl::output('shares_list',$shares_list);
		Tpl::output('shares_sum',$shares_sum);
		Tpl::output('shares_id',trim($_GET['shares_id']));
		Tpl::output('shares_time',trim($_GET['shares_time']));
		
			Tpl::showpage('shares');
    }


}