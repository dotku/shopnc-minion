<?php
/**
 * 销售记录导入
 *
 *by joe
 */
class sale_importControl extends BaseSellerControl {
	public function __construct() {
        parent::__construct();
        Language::read('member_store_goods_index');
    }
	public function indexOp(){
	if ($_FILES){
        if (!isset($_FILES['file'])) {
            showMessage("文件上传出错");
        }
        if ($_FILES["file"]["error"] > 0) {
            showMessage($_FILES["file"]["error"]);
            //exit();
			showMessage("文件上传出错");
        }

        $tmpname=$_FILES["file"]["tmp_name"];
        $filename=$_FILES["file"]["name"];
        $uploaddir=BASE_DATA_PATH."/upload/";
        $filesize=$_FILES["file"]["size"];
        if($filesize>3145728){
            showMessage("文件大小超过限定值-3M");
            exit();
        }
        $file_arr = explode('.',$_FILES["file"]["name"]);
        $file_type = end($file_arr);
        if($file_type!='xls'){
            showMessage("文件格式错误,允许格式为97-2003格式excel文件");
            exit();
        }

        move_uploaded_file($tmpname,$uploaddir.'input.xls');
        $file=$uploaddir.'input.xls';
		
        if($this->dealExcel($file)){
            unlink($file);
            showMessage("批量添加成功");
        }else{
            unlink($file);
            showMessage("批量添加失败");
        }
	}
			Tpl::showpage('sale_import');
    }


    public function dealExcel($file){
        include BASE_DATA_PATH."/Excel/reader.php";
        $data = new Spreadsheet_Excel_Reader();
        $data->setOutputEncoding('GBK');
        $data->read($file);
        $xls_arr=array();
        for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
            for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
                $val= iconv("gb2312","utf-8//IGNORE",$data->sheets[0]['cells'][$i][$j]);
                $xls_arr[$i][$j]=$val;
            }
            echo "\n";

        }
        if(!empty($xls_arr)){
            return $this->insertExcelData($xls_arr);
        }else{
            return true;
        }

    }

    public function insertExcelData($data){
        $model_order = Model('order');
		$model_goods = Model('goods');
		$model_order_cn = Model('buy');
		$j=0;
        foreach($data as $key=>$val){
			//查询每个快递单号的所有商品信息by joe
			$r=explode(" ",$val[2]);
			$goods_serial = array();
			$goods_num = array();
			$goods_price = array();
			$goods_list = array();
			$goods_amount = array();
			$i = 0;
			foreach ($r as  $k=>$v){
				$goods=explode("*",$v);
				$goods_serial[$k] = $goods[0];
				$goods_num[$k] = $goods[1];
				//$goods_price[$k] = $goods[2];
				$goods_list[$k] = $model_goods -> getGoodsInfo(array('goods_serial'=>$goods[0]));
				if($goods_list[$k]){
				++$i;
				}
				$goods_amount[$k] += sprintf("%.2f",  $goods[1]*$goods_list[$k]['goods_price']);
			}
			if ($i>0){
				
			//如果找到对应商品就添加销售订单 by joe
			
			$order = array();
			$order_common = array();
            $order_goods = array();
			//生成订单号
			$order['order_sn'] = $model_order_cn->makeOrderSn($val[1]);
			$order['store_id'] = $_SESSION['store_id'];
			$order['store_name'] = $_SESSION['store_name'];
			$order['buyer_id'] = 676;
			$order['buyer_name'] = $val[4];
			$order['add_time'] = time();
			$order['goods_amount'] = $goods_amount[$k];
			$order['order_amount'] = $goods_amount[$k];
			$order['order_state'] = 30;
			$order['finnshed_time'] = time()+54200;
			$order['shipping_code'] = $val[1];
			$order_id = $model_order->addOrder($order);
			$order['order_id'] = $order_id;
            $order_common['order_id'] = $order_id;
            $order_common['store_id'] = $_SESSION['store_id'];
			$order_common['shipping_time'] =time()+54200;
			$order_common['reciver_name'] = $val[4];

			//选择物流公司 by joe 
			$order_common['shipping_express_id'] = 2;
			$order_id = $model_order->addOrderCommon($order_common);

			//生成订单商品信息 by joe
			foreach ($r as $k=>$v){
			$order_goods['order_id'] = $order_id;
			$order_goods['goods_id'] = $goods_list[$k]['goods_id'];
			$order_goods['goods_name'] = $goods_list[$k]['goods_name'];
			$order_goods['goods_image'] = $goods_list[$k]['goods_image'];
			$order_goods['goods_num'] = $goods_num[$k];
			$order_goods['goods_price'] = $goods_list[$k]['goods_price'];
			$order_goods['store_id'] = $_SESSION['store_id'];
			$order_goods['buyer_id'] = 676;
			$order_goods['goods_pay_price'] = $goods_list[$k]['goods_price'];
			$order_goods['gc_id'] = $goods_list[$k]['gc_id'];
			$insert = $model_order->addOrderSaleGoods($order_goods);
			}
			$j++;
			}
        }
        if($j>0){
            return true;
      }else{
            return false;
        }
    }
}