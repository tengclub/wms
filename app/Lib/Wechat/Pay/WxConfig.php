<?php
namespace App\Includes\Wechat\Pay;
use App\Includes\Wechat\Pay\Lib\WxPayConfig;
use App\Models\WxInfo;
class WxConfig
{
	public static  function getPayConfig()
	{
		$wxInfo = new WxInfo();
		$options['appid'] = $wxInfo->appid;
		$options['mchid'] = $wxInfo->mchid;
		$options['mchkey'] = $wxInfo->key;
		$options['secret'] = $wxInfo->appsecret;
		$options['notify_url'] = $wxInfo->web_url;
		$config = new WxPayConfig($options);
		return $config;
	}
}