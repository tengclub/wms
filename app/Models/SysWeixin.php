<?php
namespace App\Models;
use App\Lib\SysKey;

class SysWeixin extends SysModel
{
	protected $table = 'sys_weixin';
	public static function getLabels()
	{
		return [
			'id'=>'主键自增',
			'title'=>'名称',
			'wechat_user'=>'微信帐号',
			'token'=>'token',
			'encoding_aes_key'=>'EncodingAESKey',
			'appid'=>'appid',
			'appsecret'=>'appsecret',
			'mchid'=>'支付mchid',
			'key'=>'支付用KEY',
			'ip'=>'IP',
			'domainname'=>'域名',
			'create_time'=>'创建时间',
			'wechat_status'=>'状态',
			'create_user'=>'用户',
			'web_url'=>'地址',
		];
	}
	public static function getWeixin($appid=null)
	{
		if($appid)
		{
			$attributes = array('appid'=>$appid,'wechat_status'=>SysKey::$statusOkValue);
			$model = self::firstOrNew($attributes);
		}else {
			$attributes = array('wechat_status'=>SysKey::$statusOkValue);
			$model = self::firstOrNew($attributes);
		}
		return $model;
	}
}
