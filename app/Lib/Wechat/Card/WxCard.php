<?php
namespace App\Includes\Wechat\WxCard;

/*
 * CARD_TYPE 为
 团购券：GROUPON; 折扣券：DISCOUNT; 礼品券：GIFT; 
代金券：CASH; 通用券：GENERAL_COUPON; 
会员卡：MEMBER_CARD; 景点门票：SCENIC_TICKET；
电影票：MOVIE_TICKET； 飞机票：BOARDING_PASS； 
会议门票：MEETING_TICKET； 汽车票：BUS_TICKET;
 *
 */
class WxCard {
	
    public $parameters  = array();
    private $appId;
    private $appSecret;
    private $mchid;
    private $privatekey;
    
    public function __construct($appId, $appSecret) {
    	$this->appId = $appId;
    	$this->appSecret = $appSecret;
    }
    
    /****************************************************
     *    微信提交API方法，返回微信指定JSON
     ****************************************************/

    public function wxHttpsRequest($url,$data = null){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

    /****************************************************
     *  微信带证书提交数据 - 微信红包使用
     ****************************************************/

    public function wxHttpsRequestPem($url, $vars, $second=30,$aHeader=array()){
        $ch = curl_init();
        //超时时间
        curl_setopt($ch,CURLOPT_TIMEOUT,$second);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
        //这里设置代理，如果有的话
        //curl_setopt($ch,CURLOPT_PROXY, '10.206.30.98');
        //curl_setopt($ch,CURLOPT_PROXYPORT, 8080);
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);

        //以下两种方式需选择一种

        //第一种方法，cert 与 key 分别属于两个.pem文件
        //默认格式为PEM，可以注释
        curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
        curl_setopt($ch,CURLOPT_SSLCERT,getcwd().'/apiclient_cert.pem');
        //默认格式为PEM，可以注释
        curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
        curl_setopt($ch,CURLOPT_SSLKEY,getcwd().'/apiclient_key.pem');

        curl_setopt($ch,CURLOPT_CAINFO,'PEM');
        curl_setopt($ch,CURLOPT_CAINFO,getcwd().'/rootca.pem');

        //第二种方式，两个文件合成一个.pem文件
        //curl_setopt($ch,CURLOPT_SSLCERT,getcwd().'/all.pem');

        if( count($aHeader) >= 1 ){
            curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeader);
        }

        curl_setopt($ch,CURLOPT_POST, 1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$vars);
        $data = curl_exec($ch);
        if($data){
            curl_close($ch);
            return $data;
        }
        else { 
            $error = curl_errno($ch);
            echo "call faild, errorCode:$error\n"; 
            curl_close($ch);
            return false;
        }
    }

    /****************************************************
     *    微信获取AccessToken 返回指定微信公众号的at信息
     ****************************************************/

    public function wxAccessToken(){
    	$data['expire_time'] = 0;
    	if(is_file(app_path('epfiles/wechat/access_token.json')))
    	{
    		$data = json_decode(file_get_contents(app_path('epfiles/wechat/access_token.json')),true);
    	}
    	if(!$data)
    	{
    		$data['expire_time'] = 0;
    	}
    	if ($data['expire_time'] < time()) {
    		// 如果是企业号用以下URL获取access_token
    		// $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->appId&corpsecret=$this->appSecret";
    		$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
    		$res = json_decode($this->httpGet($url),true);
    		$access_token = $res['access_token'];
    		if ($access_token) {
    			$data['expire_time'] = time() + 7000;
    			$data['access_token'] = $access_token;
    			$fp = fopen(app_path('epfiles/wechat/access_token.json'), "w");
    			fwrite($fp, json_encode($data));
    			fclose($fp);
    		}
    	} else {
    		$access_token = $data['access_token'];
    	}
    	return $access_token;
    }

    /****************************************************
     *    微信获取AccessToken 返回指定微信公众号的at信息
     ****************************************************/

    public function wxJsApiTicket(){
    	// jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
    	$data['expire_time'] = 0;
    	if(is_file(app_path('epfiles/wechat/wx_card_ticket.json')))
    	{
    		$data = json_decode(file_get_contents(app_path('epfiles/wechat/wx_card_ticket.json')),true);
    	}
    	if(!$data)
    	{
    		$data['expire_time'] = 0;
    	}
    	if ($data['expire_time'] < time()) {
    		$accessToken = $this->wxAccessToken();
    		// 如果是企业号用以下 URL 获取 ticket
    		// $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
    		$url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=wx_card&access_token=$accessToken";
    		$res = json_decode($this->httpGet($url),true);
    		 
    		$ticket = $res['ticket'];
    		if ($ticket) {
    			$data['expire_time'] = time() + 7000;
    			$data['jsapi_ticket'] = $ticket;
    			$fp = fopen(app_path('epfiles/wechat/wx_card_ticket.json'), "w");
    			fwrite($fp, json_encode($data));
    			fclose($fp);
    		}
    	} else {
    		$ticket = $data['jsapi_ticket'];
    	}
    	return $ticket;
    }
    
   
    /*******************************************************
     *      将数组解析XML - 微信红包接口
     *******************************************************/
    public function wxArrayToXml($parameters = NULL){
        if(is_null($parameters)){
        $parameters = $this->parameters;
        }
        
        if(!is_array($parameters) || empty($parameters)){
        die("参数不为数组无法解析");
        }
        
        $xml = "<xml>";
        foreach ($arr as $key=>$val)
        {
        if (is_numeric($val))
        {
            $xml.="<".$key.">".$val."</".$key.">"; 
        }
        else
            $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";  
        }
        $xml.="</xml>";
        return $xml; 
    }
    
    /*******************************************************
     *      微信卡券：上传LOGO - 需要改写动态功能
     *******************************************************/
    /**
     * 
     * @param strin $logoImg 如'@D:\\workspace\\htdocs\\yky_test\\logo.jpg';
     * @return mixed
     */
    public function wxCardUpdateImg($logoImg) {
        $wxAccessToken = $this->wxAccessToken();
        //$data['access_token'] =  $wxAccessToken;
        $data['buffer'] = $logoImg;
        $url = "https://api.weixin.qq.com/cgi-bin/media/uploadimg?access_token=".$wxAccessToken;
        $result = $this->wxHttpsRequest($url,$data);
        $jsoninfo = json_decode($result, true);
        return $jsoninfo;
    }
    
    /*******************************************************
     *      微信卡券：获取颜色
     *******************************************************/
    public function wxCardColor(){
        $wxAccessToken = $this->wxAccessToken();
        $url = "https://api.weixin.qq.com/card/getcolors?access_token=".$wxAccessToken;
        $result = $this->wxHttpsRequest($url);
        $jsoninfo = json_decode($result, true);
        return $jsoninfo;
    }
    
    /*******************************************************
     *      微信卡券：创建卡券
     *******************************************************/
    public function wxCardCreated($jsonData) {
        $wxAccessToken = $this->wxAccessToken();
        $url = "https://api.weixin.qq.com/card/create?access_token=" . $wxAccessToken;
        $result = $this->wxHttpsRequest($url,$jsonData);
        $jsoninfo = json_decode($result, true);
        return $jsoninfo;
    }
    
    /*******************************************************
     *      微信卡券：查询卡券详情
     *******************************************************/
    public function wxCardGetInfo($jsonData) {
        $wxAccessToken = $this->wxAccessToken();
        $url = "https://api.weixin.qq.com/card/get?access_token=" . $wxAccessToken;
        $result = $this->wxHttpsRequest($url,$jsonData);
        $jsoninfo = json_decode($result, true);
        return $jsoninfo;
    }

    /*******************************************************
     *      微信卡券：设置白名单
     *******************************************************/
    public function wxCardWhiteList($jsonData){
        $wxAccessToken = $this->wxAccessToken();
        $url = "https://api.weixin.qq.com/card/testwhitelist/set?access_token=" . $wxAccessToken;
        $result = $this->wxHttpsRequest($url,$jsonData);
        $jsoninfo  = json_decode($result, true);
        return $jsoninfo;
    }
    
    /*******************************************************
     *      微信卡券：JSAPI 卡券Package - 基础参数没有附带任何值 - 再生产环境中需要根据实际情况进行修改
     *******************************************************/        
    public function wxCardPackage($cardId , $openid = ''){
        $timestamp = time();
        $api_ticket = $this->wxJsApiTicket();
        $cardId = $cardId;
        $arrays = array($api_ticket,$timestamp,$cardId);
        sort($arrays);
        $string = sha1(implode("",$arrays));

        $resultArray['card_id'] = $cardId;
        $resultArray['card_ext'] = array();
        $resultArray['card_ext']['openid'] = $openid;
        $resultArray['card_ext']['timestamp'] = $timestamp;
        $resultArray['card_ext']['signature'] = $string;

        return $resultArray;
    }

    /*******************************************************
     *      微信卡券：消耗卡券
     *******************************************************/
    public function wxCardConsume($jsonData){
        $wxAccessToken = $this->wxAccessToken();
        $url = "https://api.weixin.qq.com/card/code/consume?access_token=" . $wxAccessToken;
        $result = $this->wxHttpsRequest($url,$jsonData);
        $jsoninfo = json_decode($result, true);
        return $jsoninfo;        
    }

    /*******************************************************
     *      微信卡券：删除卡券
     *******************************************************/
    public function wxCardDelete($jsonData){
        $wxAccessToken = $this->wxAccessToken();
        $url  = "https://api.weixin.qq.com/card/delete?access_token=" . $wxAccessToken;
        $result = $this->wxHttpsRequest($url,$jsonData);
        $jsoninfo = json_decode($result, true);
        return $jsoninfo;        
    }    
    
    /*******************************************************
     *      微信卡券：JSAPI 卡券全部卡券 Package
     *******************************************************/
    public function wxCardAllPackage($cardIdArray = array(),$openid = ''){
        $reArrays = array();
        if(!empty($cardIdArray) && (is_array($cardIdArray) || is_object($cardIdArray))){
        //print_r($cardIdArray);
        foreach($cardIdArray as  $value){
            //print_r($this->wxCardPackage($value,$openid));
            $reArrays[] = $this->wxCardPackage($value,$openid);
        }
        //print_r($reArrays);
        }
        else{
        $reArrays[] = $this->wxCardPackage($cardIdArray,$openid);
        }
        return json_encode($reArrays);
    }
        
}
