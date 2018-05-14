<?php
/**
 *    微信支付平台返回码类
 */
namespace App\Includes\Wechat;

class MapCode
{
	//支付银行代码对照
    public static $payBank=array(
		'ICBC'=>'工商银行',
		'ABC'=>'农业银行',
		'PSBC'=>'邮政储蓄',
		'CCB'=>'建设银行',
		'CMB'=>'招商银行',
		'COMM'=>'交通银行',
		'BOC'=>'中国银行',
		'SPDB'=>'浦发银行',
		'GDB'=>'广发银行',
		'CMBC'=>'民生银行',
		'PAB'=>'平安银行',
		'CEB'=>'光大银行',
		'CIB'=>'兴业银行',
		'CITIC'=>'中信银行',
		'SDB'=>'深发银行',
    	'BOSH'=>'上海银行',
    	'CRB'=>'华润银行',
    	'HZB'=>'杭州银行',
    	'BSB'=>'包商银行',
    	'CQB'=>'重庆银行',
    	'SDEB'=>'顺德农商行',
    	'SZRCB'=>'深圳农商银行',
    	'HRBB'=>'哈尔滨银行',
    	'BOCD'=>'成都银行',
    	'GDNYB'=>'南粤银行',
    	'GZCB'=>'广州银行',
    	'JSB'=>'江苏银行',
    	'NBCB'=>'宁波银行',
    	'NJCB'=>'南京银行',
    	'QDCCB'=>'青岛银行',
    	'ZJTLCB'=>'浙江泰隆银行',
    	'XAB'=>'西安银行',
    	'CSRCB'=>'常熟农商银行',
    	'QLB'=>'齐鲁银行',
    	'LJB'=>'龙江银行',
    	'HXB'=>'华夏银行',
    	'CS'=>'测试银行借记卡快捷支付',
    	'AE'=>'AE',
    	'JCB'=>'JCB',
    	'MASTERCARD'=>'MASTERCARD',
    	'VISA'=>'VISA',
    	'CFT'=>'财付通',
    );
    /**
     * 支付银行
     * @param unknown $code
     * @return multitype:string
     */
    public static function getPayBankText($code) {
    	if (isset(self::$payBank[$code])) {
    		return self::$payBank[$code];
    	}else {
    		return $code;
    	}
    }
    //货币类型
    public static $payFeeType=array(
    		'CNY'=>'人民币 ',
    );
    /**
     * 货币类型
     * @param unknown $code
     * @return multitype:string
     */
    public static function getFeeTypeText($code) {
    	if (isset(self::$payFeeType[$code])) {
    		return self::$payFeeType[$code];
    	}else {
    		return $code;
    	}
    }
    //交易状态
    public static $payTradeState=array(
    		'SUCCESS'=>'支付成功 ',
    		'REFUND'=>'转入退款',
    		'NOTPAY'=>'未支付',
    		'CLOSED'=>'已关闭',
    		'REVOKED'=>'已撤销 ',
    		'USERPAYING'=>'用户支付中',
    		'PAYERROR'=>'支付失败(其他原因)',
    );
    /**
     * 交易状态
     * @param unknown $code
     * @return multitype:string
    */
    public static function getTradeStateText($code) {
    	if (isset(self::$payTradeState[$code])) {
    		return self::$payTradeState[$code];
    	}else {
    		return $code;
    	}
    }
    //是否关注公众账号 
    public static $payIsSubscribe=array(
    		'Y'=>'关注',
    		'N'=>'未关注',
    );
    /**
     * 是否关注公众账号 
     * @param unknown $code
     * @return multitype:string
    */
    public static function getIsSubscribeText($code) {
    	if (isset(self::$payIsSubscribe[$code])) {
    		return self::$payIsSubscribe[$code];
    	}else {
    		return $code;
    	}
    }
}

?>