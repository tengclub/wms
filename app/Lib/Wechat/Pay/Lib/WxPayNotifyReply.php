<?php
/**
* 2015-06-29 修复签名问题
**/
namespace App\Lib\Wechat\Pay\Lib;

use App\Lib\Wechat\Pay\Lib\WxPayException;
use App\Lib\Wechat\Pay\Lib\WxPayConfig;
use App\Lib\Wechat\Pay\Lib\WxPayDataBase;
use App\Lib\Wechat\Pay\Lib\WxPayApi;


/**
 * 
 * 回调基础类
 * @author widyhu
 *
 */
class WxPayNotifyReply extends  WxPayDataBase
{
    //微信支付配置参数，类初始化必填
    public $wxpaycfg;
    public $wxpayapi;

    //构造函数，初始化的时候最先执行
    public function __construct($wxpaycfg) {
        $this->wxpaycfg = $wxpaycfg;
        $this->wxpayapi = new WxPayApi($wxpaycfg);
    }
	/**
	 * 
	 * 设置错误码 FAIL 或者 SUCCESS
	 * @param string
	 */
	public function SetReturn_code($return_code)
	{
		$this->values['return_code'] = $return_code;
	}
	
	/**
	 * 
	 * 获取错误码 FAIL 或者 SUCCESS
	 * @return string $return_code
	 */
	public function GetReturn_code()
	{
		return $this->values['return_code'];
	}

	/**
	 * 
	 * 设置错误信息
	 * @param string $return_code
	 */
	public function SetReturn_msg($return_msg)
	{
		$this->values['return_msg'] = $return_msg;
	}
	
	/**
	 * 
	 * 获取错误信息
	 * @return string
	 */
	public function GetReturn_msg()
	{
		return $this->values['return_msg'];
	}
	
	/**
	 * 
	 * 设置返回参数
	 * @param string $key
	 * @param string $value
	 */
	public function SetData($key, $value)
	{
		$this->values[$key] = $value;
	}
}
