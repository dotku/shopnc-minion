<?php
/**
 * 支付宝境外支付
 * by joe
 */
defined('InShopNC') or exit('Access Invalid!');

class alipay_service {

	private $gateway = "https://mapi.alipay.com/gateway.do?"; //this is the gateway of the alipay, don't change it 
	//var $parameter;       
	private $security_code;  	
	private $mysign;
	private $code = 'alipay_service';
    
    private $payment;
   
    private $order;
	private $order_type;
   
    private $parameter;
    
    public function __construct($payment_info=array(),$order_info=array()){
    	$this->alipay_service($payment_info,$order_info);
    }
    public function alipay_service($payment_info=array(),$order_info=array()){
    	if(!empty($payment_info) and !empty($order_info)){
    		$this->payment	= $payment_info;
    		$this->order	= $order_info;
    	}
    }
	public function get_payurl(){
		$this->parameter = array(
		'service' => 'create_forex_trade', //this is the service name
		'partner' =>$this->payment['payment_config']['alipay_service_partner'],                                               
		'return_url' =>SHOP_SITE_URL."/api/payment/alipay_service/return_url.php",  
		'notify_url' =>SHOP_SITE_URL."/api/payment/payment/alipay_service/notify_url.php", 
		'_input_charset' => 'utf-8',   
		'extra_common_param'=> $this->order['order_type'],
        'out_trade_no'	=> $this->order['pay_sn'],		//外部交易编号  
		'rmb_fee' => $this->order['api_pay_amount'], //the price of products
		'currency'=>'USD',
		);
		if ($this->order['order_type']  == 'real_order'){
			$this->parameter['subject'] = $this->order['order_sn'];//商品名称
			$this->parameter['body'] = $this->order['order_sn'];//商品名称
		}else{
			$this->parameter['subject'] = $this->order['pay_sn'];//商品名称
			$this->parameter['body'] = $this->order['pay_sn'];//商品名称
		}
		$this->security_code  = $this->payment['payment_config']['alipay_service_key'];
		$this->sign_type      = 'MD5';
		$this->mysign         = '';
		$this->transport      = 'http';
		if($parameter['_input_charset'] = "")
		$this->parameter['_input_charset']='utf-8';
		if($this->transport = "https") {
			$this->gateway = "https://mapi.alipay.com/gateway.do?";
		} else $this->gateway = "https://mapi.alipay.com/gateway.do?";
		$sort_array = array();
		$arg = "";
		$sort_array = $this->arg_sort($this->parameter);
		while (list ($key, $val) = each ($sort_array)) {
		$arg.=$key."=".$this->charset_encode($val,$this->parameter['_input_charset'])."&";
		}
		$prestr = substr($arg,0,count($arg)-2);  //去掉最后一个问号
		$this->mysign = $this->sign($prestr.$this->security_code);
			 return $this->create_url();
    }
	private function create_url() {
		$url = $this->gateway;
		$sort_array = array();
		$arg = "";
		$sort_array = $this->arg_sort($this->parameter);
		while (list ($key, $val) = each ($sort_array)) {
			$arg.=$key."=".urlencode($this->charset_encode($val,$this->parameter['_input_charset']))."&";
		}
		$url.= $arg."sign=" .$this->mysign ."&sign_type=".$this->sign_type;
		return $url;

	}

	public function notify_verify() {   //对notify_url的认证
		$this->partner       =   $this->payment['payment_config']['alipay_service_partner'];
		$this->security_code = $this->payment['payment_config']['alipay_service_key'];
		$this->sign_type      = 'MD5';
		$this->mysign         = '';
		$this->transport      = 'https';
		$this->_input_charset = 'utf-8';
		if($this->transport == "https") {
			$this->gateway = "https://mapi.alipay.com/gateway.do?";
		
		} else $this->gateway = "https://mapi.alipay.com/gateway.do?";
		
		if($this->transport == "https") {
			$veryfy_url = $this->gateway. "service=notify_verify" ."&partner=" .$this->partner. "&notify_id=".$_POST["notify_id"];
		} else {
			$veryfy_url = $this->gateway. "notify_id=".$_POST["notify_id"]."&partner=" .$this->partner;
		}
		$veryfy_result = $this->get_verify($veryfy_url);
		$post = $this->para_filter($_POST);
		$sort_post = $this->arg_sort($post);
		while (list ($key, $val) = each ($sort_post)) {
			$arg.=$key."=".$val."&";
		}
		$prestr = substr($arg,0,count($arg)-2);  //去掉最后一个&号
		$this->mysign = $this->sign($prestr.$this->security_code);

		if (eregi("true$",$veryfy_result) && $this->mysign == $_POST["sign"])  {
			return true;
		} else return false;
	}
	public function return_verify() {
		$pay_sn=$this->order['pay_sn'];
		$trade_status = $_GET['trade_status'];
		if ($pay_sn == $_GET['out_trade_no'] and $trade_status == "TRADE_FINISHED"){
			return true;
			} else return false;
			
	}
	/**
	 * 
	 * 取得订单支付状态，成功或失败
	 * @param array $param
	 * @return array
	 */
	
	public function getPayResult($param){
		return $param['trade_status'] == 'TRADE_FINISHED';
	}
	public function getUpdateParam($param){
		$input	= array();
		if(empty($param['trade_status']) and empty($param['refund_status'])){
			$input['error']	= true;
		}else{
			if(!empty($param['trade_status'])){
				$input['order_state']	= $this->getTradeState($param['trade_status']);
			}
			if(!empty($param['refund_status'])){
				$input['refund_state']	= $this->getRefundState($param['refund_status']);
			}
			if($this->order['order_state'] >= $input['order_state'] and $this->order['refund_state'] >= $input['refund_state']){
				$input	= array();
			}elseif($this->order['order_state'] < $input['order_state'] and $this->order['refund_state'] >= $input['refund_state']){
				$input	= $this->getTradeChange($input['order_state']);
				$input['out_payment_code']	= $param['trade_no'];
			}elseif($this->order['order_state'] >= $input['order_state'] and $this->order['refund_state'] < $input['refund_state']){
				$input	= $this->getRefundChange($input['refund_state']);
			}
		}
		return $input;
	}


	private function get_verify($url,$time_out = "60") {
		$urlarr = parse_url($url);
		$errno = "";
		$errstr = "";
		$transports = "";
		if($urlarr["scheme"] == "https") {
			$transports = "ssl://";
			$urlarr["port"] = "443";
		} else {
			$transports = "tcp://";
			$urlarr["port"] = "80";
		}
		$fp=@fsockopen($transports . $urlarr['host'],$urlarr['port'],$errno,$errstr,$time_out);
		if(!$fp) {
			die("ERROR: $errno - $errstr<br />\n");
		} else {
			fputs($fp, "POST ".$urlarr["path"]." HTTP/1.1\r\n");
			fputs($fp, "Host: ".$urlarr["host"]."\r\n");
			fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
			fputs($fp, "Content-length: ".strlen($urlarr["query"])."\r\n");
			fputs($fp, "Connection: close\r\n\r\n");
			fputs($fp, $urlarr["query"] . "\r\n\r\n");
			while(!feof($fp)) {
				$info[]=@fgets($fp, 1024);
			}

			fclose($fp);
			$info = implode(",",$info);
			while (list ($key, $val) = each ($_POST)) {
				$arg.=$key."=".$val."&";
			}
		}

	}

	private function arg_sort($array) {
		ksort($array);
		reset($array);
		return $array;

	}

	private function sign($prestr) {
		$mysign = "";
		if($this->sign_type == 'MD5') {
			$mysign = md5($prestr);
		}elseif($this->sign_type =='DSA') {
			//DSA 签名方法待后续开发
			die("DSA 签名方法待后续开发，请先使用MD5签名方式");
		}else {
			die("支付宝暂不支持".$this->sign_type."类型的签名方式");
		}
		return $mysign;

	}
	private function para_filter($parameter) { //除去数组中的空值和签名模式
		$para = array();
		while (list ($key, $val) = each ($parameter)) {
			if($key == "sign" || $key == "sign_type" || $val == "")continue;
			else	$para[$key] = $parameter[$key];

		}
		return $para;
	}
	//实现多种字符编码方式
	private function charset_encode($input,$_output_charset ,$_input_charset ="GBK" ) {
		$output = "";
		if(!isset($_output_charset) )$_output_charset  = $this->parameter['_input_charset '];
		if($_input_charset == $_output_charset || $input ==null) {
			$output = $input;
		} elseif (function_exists("mb_convert_encoding")){
			$output = mb_convert_encoding($input,$_output_charset,$_input_charset);
		} elseif(function_exists("iconv")) {
			$output = iconv($_input_charset,$_output_charset,$input);
		} else die("sorry, you have no libs support for charset change.");
		return $output;
	}
	
	
		/**
	 * 获取array格式的订单交易状态改变的参数数组
	 *
	 * @param string $code
	 * @param string $status
	 * @return int|bool
	 */
	private function getTradeState($status){
		$return	= false;
		switch($status){
			case 'WAIT_BUYER_PAY':
				$return	= 10;
				break;
			case 'WAIT_SELLER_SEND_GOODS':
				$return	= 20;
				break;
			case 'WAIT_BUYER_CONFIRM_GOODS':
				$return	= 30;
				break;
			case 'TRADE_FINISHED':
				$return	= 40;
				break;
			case 'TRADE_SUCCESS':
				$return	= 40;
				break;
			case 'TRADE_CLOSED':
				$return	= 99;
				break;
		}
		return $return;
	}
	/**
	 * 获取array格式的订单退款状态改变的参数数组
	 *
	 * @param string $code
	 * @param string $status
	 * @return int|bool
	 */
	private function getRefundState($status){
		$array_Status	= array();
		switch($status){
			case 'WAIT_SELLER_AGREE':
				$array_Status['refund_state']	= 10;
				break;
			case 'REFUND_CLOSED':
				$array_Status['refund_state']	= 20;
				break;
			case 'REFUND_SUCCESS':
				$array_Status['refund_state']	= 30;
				break;
		}
		return $array_Status;
	}
	/**
	 * 根据订单交易新状态获取其他订单属性的改变参数
	 *
	 * @param int $order_state
	 * @return array
	 */
	private function getTradeChange($order_state){
		$input	= array('order_state'=>$order_state);
		switch($order_state){
			case 10:
				break;
			case 20:
				$input['payment_time']	= time();
				break;
			case 30:
				$input['shipping_time']	= time();
				break;
			case 40:
				$input['finnshed_time']	= time();
				break;
		}
		return $input;
	}
	/**
	 * 根据订单退款新状态获取其他订单属性的改变参数
	 *
	 * @param int $order_state
	 * @return array
	 */
	private function getRefundChange($refund_state){
		$input	= array('refund_state'=>$refund_state);
		switch($refund_state){
			case 10:
				break;
			case 20:
				break;
			case 30:
				break;
		}
		return $input;
	}

}


?>