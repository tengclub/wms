<?php
/**
* 2015-06-29 修复签名问题
**/
namespace App\Lib\Wechat\Pay\Lib;

use App\Lib\Wechat\Pay\Lib\WxPayException;
use App\Lib\Wechat\Pay\Lib\WxPayConfig;
use App\Lib\Wechat\Pay\Lib\WxPayDataBase;


/**
 * 
 * 接口调用结果类
 * @author widyhu
 *
 */
class WxPayResults extends WxPayDataBase
{
	/**
	 * 
	 * 检测签名
	 */
	public function CheckSign()
	{
		//fix异常
		if(!$this->IsSignSet()){
			throw new WxPayException("签名错误！");
		}
		
		$sign = $this->MakeSign();
		if($this->GetSign() == $sign){
			return true;
		}
		throw new WxPayException("签名错误！");
	}
	
	/**
	 * 
	 * 使用数组初始化
	 * @param array $array
	 */
	public function FromArray($array)
	{
		$this->values = $array;
	}
	
	/**
	 * 
	 * 使用数组初始化对象
	 * @param array $array
	 * @param 是否检测签名 $noCheckSign
	 */
	public function InitFromArray($array, $noCheckSign = false)
	{
		$obj = new self($this->wxpaycfg);
		$obj->FromArray($array);
		if($noCheckSign == false){
			$obj->CheckSign();
		}
        return $obj;
	}
	
	/**
	 * 
	 * 设置参数
	 * @param string $key
	 * @param string $value
	 */
	public function SetData($key, $value)
	{
		$this->values[$key] = $value;
	}
	
    /**
     * 将xml转为array
     * @param string $xml
     * @throws WxPayException
     */
	public function Init($xml,$isSign = true)
	{	
		$obj = new self($this->wxpaycfg);
		$obj->FromXml($xml);
		//fix bug 2015-06-29
		if($obj->values['return_code'] != 'SUCCESS'){
			 return $obj->GetValues();
		}
		if($isSign)//是否再次验证签名
		{
			$obj->CheckSign();
		}
        return $obj->GetValues();
	}
}

