<?php
namespace App\Lib;
use App\Includes\Net\Curl;
class ExpressApi
{
	/**
	 * 快递100接口
	 * @param sting $com //快递公司名称
	 * @param string $num　//快递单号
	 * @return string
	 */
	public static function kuaidi100($com,$num)
	{
		
// 		$appKey = config('epconfig')['kuaidi100_app_key'];//请将XXXXXX替换成您在http://kuaidi100.com/app/reg.html申请到的KEY
// 		$url ='http://api.kuaidi100.com/api?id='.$appKey.'&com='.$com.'&nu='.$num.'&show=2&muti=1&order=asc';
// 		$url ='http://www.kuaidi100.com/applyurl?key='.$appKey.'&com='.$com.'&nu='.$num;
		
		//请勿删除变量$powered 的信息，否者本站将不再为你提供快递接口服务。
// 		$powered = '查询数据由：<a href="http://kuaidi100.com" target="_blank">KuaiDi100.Com （快递100）</a> 网站提供 ';
		
		
		//优先使用curl模式发送数据
// 		if (function_exists('curl_init') == 1){
// 			$curl = curl_init();
// 			curl_setopt ($curl, CURLOPT_URL, $url);
// 			curl_setopt ($curl, CURLOPT_HEADER,0);
// 			curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
// 			curl_setopt ($curl, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
// 			curl_setopt ($curl, CURLOPT_TIMEOUT,5);
// 			$get_content = curl_exec($curl);
// 			curl_close ($curl);
// 		}else{
// 			$snoopy = new Snoopy();
// 			$snoopy->referer = 'http://www.google.com/';//伪装来源
// 			$snoopy->fetch($url);
// 			$get_content = $snoopy->results;
// 		}
		$curl = new Curl();
		$expressData = $curl->callWebServer('http://www.kuaidi100.com/query?type='.$com.'&postid='.$num.'&id=19&valicode=&temp=0.'.mt_rand(1000000000,9999999999));
		return $expressData;
	}
}