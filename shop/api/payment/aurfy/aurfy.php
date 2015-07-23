<?php
/**
 * Aurfy银联支付类
 * 
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
defined('InShopNC') or exit('Access Invalid!');
class aurfy{
	/**
	 * Aurfy在线支付网关
	 *
	 * @var string
	 */
	private $gateway   = 'https://pgw.aurfy.com/v2/api/purchase/ebank';
	/**
	 * 支付接口标识
	 *
	 * @var string
	 */
    private $code      = 'aurfy';
    /**
	 * 支付接口配置信息
	 *
	 * @var array
	 */
    private $payment;
     /**
	 * 订单信息
	 *
	 * @var array
	 */
    private $order;
    /**
	 * 发送至网银在线的参数
	 *
	 * @var array
	 */
    private $parameter;
    public function __construct($payment_info,$order_info){	
    	$this->aurfy($payment_info,$order_info);
    }
    public function aurfy($payment_info = array(),$order_info = array()){
    	if(!empty($payment_info) and !empty($order_info)){
    		$this->payment= $payment_info;
    	}
	$this->order	= $order_info;
    }
	/**
	 * 支付表单
	 *
	 */
	public function submit(){	
		$v_orderid = $this->order['pay_sn'];		//订单号
		$v_amount = $this->order['api_pay_amount'];   //支付金额                 
		$v_currency = "CNY";                                           //订单币种
		$v_merid =  $this->payment['payment_config']['aurfy_merchantid'];// 商户号
		$v_ordertime = date("YmdHis");//订单时间
		$v_orderdesc='';//订单描述
		$v_returnurl=SHOP_SITE_URL."/api/payment/aurfy/return_url.php";	//请填写返回url,地址应为绝对路径,带有http协议
		$v_callbackurl=SHOP_SITE_URL."/api/payment/aurfy/notify_url.php";	//请填写返回url,地址应为绝对路径,带有http协议
		$v_remark1='';
		$v_remark2='';
		$v_buyer='';
		$v_deliveryname='';
		$v_deliveryaddr='';
		$v_bankcode='';
		$aurfykey   = $this->payment['payment_config']['aurfy_md5key'];// 如果您还没有设置MD5密钥请登陆我们为您提供商户后台
		$planttext = $v_merid.$v_orderid.$v_currency.$v_amount.$v_ordertime.$v_orderdesc.$v_returnurl.$v_callbackurl.$v_remark1.$v_remark2.$v_buyer.$v_deliveryname.$v_deliveryaddr.$v_bankcode;       //md5加密拼凑串,注意顺序不能变
		$signature = strtoupper(md5($planttext.$aurfykey));        //md5函数加密并转化成大写字母
		$parameter = array(
			'merchantid'         => $v_merid,                    			// 商户号   
			'orderid'      => $v_orderid,                            	               // 订单号    
			'ordercurrency'   => $v_currency,                                 // 订单币种
			'orderamount'         => $v_amount,                  			// 订单金额
			'ordertime'         => $v_ordertime,                       	    	// 订单时间  yyyyMMddHHmmss
			'orderdescription'  => $v_orderdesc,        			// 订单描述
			'returnurl'     => $v_returnurl,                 			// 浏览器返回地址
			'callbackurl'    	  => $v_callbackurl,                       	// 服务器通知地址
			'txnremark1'    	  => $v_remark1,                          		// 备注字段1
			'txnremark2'    	  => $v_remark2,                          		// 备注字段2
			'txnbuyer'    	  => $v_buyer,                         		// 购买人信息
			'deliveryname'    	  => $v_deliveryname,                	// 收货人信息
			'deliveryaddress'    	  => $v_deliveryaddr,                	// 收货人地址
			'bankcode'    	  => $v_bankcode,                         	// 银行代码
			'signature'    	  => $signature                          		// 订单签名
		);	
		
		$html = '<html><head></head><body>';
		$html .= '<form method="post" name="E_FORM" action="'.$this->gateway.'">';
		foreach ($parameter as $key => $val){
			$html .= "<input type='hidden' name='$key' value='$val' />";
		}
		$html .= '</form><script type="text/javascript">document.E_FORM.submit();</script>';
		$html .= '</body></html>';
		echo $html;
		exit;
	}
	/**
	 * 返回地址验证
	 *
	 * @param 
	 * @return array
	 */
	public function return_verify(){		
		$key   =$this->payment['payment_config']['aurfy_md5key'];
			
		$v_mid     =trim($_GET['merchantid']);               //商户号
		$v_orderid   =trim($_GET['orderid']);               //订单号
		$v_currency =trim($_GET['ordercurrency']);   //币种
		$v_amount  =trim($_GET['orderamount']);          //金额
		$v_ordertime  =trim($_GET['ordertime']);        //商户上送订单时间
		$v_remark1   =trim($_GET['txnremark1']);        //备注信息1
		$v_remark2   =trim($_GET['txnremark2']);        //备注信息2
		$v_txnid  =trim($_GET['txnid']);                      //aurfy流水号
		$v_txntime  =trim($_GET['txntime']);                //aurfy返回订单时间
		$v_status  =trim($_GET['txnstatus']);              //订单状态 1表示成功 2 表示失败
		$v_respcode  =trim($_GET['respcode']);            //00 -交易成功，其他参照错误码定义
		$v_respmsg  =trim($_GET['respmsg']);                // 错误码表示的错误信息
		$v_signature  =trim($_GET['signature']);        //返回的签名信息
		/**
		 * 重新计算md5的值
		 */                   
		$md5string=strtoupper(md5($v_mid.$v_orderid.$v_currency.$v_amount.$v_ordertime.$v_remark1.$v_remark2.$v_txnid.$v_txntime.$v_status.$v_respcode.$v_respmsg.$key));
		
		/**
		 * 判断返回信息，如果支付成功，并且支付结果可信，则做进一步的处理
		 */
		if (strtoupper($v_signature)==$md5string){
			if($v_status=="1"&&$v_respcode=="00"){
				//支付成功，可进行逻辑处理！
				//商户系统的逻辑处理（例如判断金额，判断支付状态，更新订单状态等等）......
				return true;
			}else{
				return false;//echo "支付失败";
			}
		}else{
			return false;//echo "<br>校验失败,数据可疑";
		}
		
	}
		/**
	 * 返回地址验证
	 *
	 * @param 
	 * @return array
	 */
	public function notify_verify(){		
		$key   =$this->payment['payment_config']['aurfy_md5key'];
			
		$v_mid     =trim($_GET['merchantid']);               //商户号
		$v_orderid   =trim($_GET['orderid']);               //订单号
		$v_currency =trim($_GET['ordercurrency']);   //币种
		$v_amount  =trim($_GET['orderamount']);          //金额
		$v_ordertime  =trim($_GET['ordertime']);        //商户上送订单时间
		$v_remark1   =trim($_GET['txnremark1']);        //备注信息1
		$v_remark2   =trim($_GET['txnremark2']);        //备注信息2
		$v_txnid  =trim($_GET['txnid']);                      //aurfy流水号
		$v_txntime  =trim($_GET['txntime']);                //aurfy返回订单时间
		$v_status  =trim($_GET['txnstatus']);              //订单状态 1表示成功 2 表示失败
		$v_respcode  =trim($_GET['respcode']);            //00 -交易成功，其他参照错误码定义
		$v_respmsg  =trim($_GET['respmsg']);                // 错误码表示的错误信息
		$v_signature  =trim($_GET['signature']);        //返回的签名信息
		/**
		 * 重新计算md5的值
		 */                   
		$md5string=strtoupper(md5($v_mid.$v_orderid.$v_currency.$v_amount.$v_ordertime.$v_remark1.$v_remark2.$v_txnid.$v_txntime.$v_status.$v_respcode.$v_respmsg.$key));
		
		/**
		 * 判断返回信息，如果支付成功，并且支付结果可信，则做进一步的处理
		 */
		if (strtoupper($v_signature)==$md5string){
			if($v_status=="1"&&$v_respcode=="00"){
				//支付成功，可进行逻辑处理！
				//商户系统的逻辑处理（例如判断金额，判断支付状态，更新订单状态等等）......
				return true;
			}else{
				return false;//echo "支付失败";
			}
		}else{
			return false;//echo "<br>校验失败,数据可疑";
		}
		
	}
	/**
	 * 获取订单更新参数数组
	 *
	 * @param array $param
	 * @return array
	 */
	public function getUpdateParam($param){
		
		$return_array = array(
			'payment_time'=>time(),
			'order_state'=>20
		);		
		return $return_array;
	}
}
