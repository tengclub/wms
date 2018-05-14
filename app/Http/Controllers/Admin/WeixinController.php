<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Service\WxpayService;
use Illuminate\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Input;
use App\Lib\Common;
use Illuminate\Support\Facades\Session;
use App\Lib\Wechat\Auth;
use App\Lib\Wechat\Pay\JsApiPay;
use App\Lib\SysKey;
use App\Models\WxInfo;
use App\Http\Service\WeixinService;



class WeixinController extends Controller
{
	
   /**
    * demo扫码支付
    * @param unknown $orderId
    * @return Ambigous <\Illuminate\View\View, \Illuminate\Contracts\View\Factory>
    */
    public function payNative($orderId)
    {
//     	dd($orderId);
		$wxpayService = new WxpayService();
		$data = $wxpayService->native($orderId);
		if($data['code']=='000')
		{
       	
//        	$order = Order::findOrNew($orderId);
//        	$condition = ['order_id'=>$orderId];
//        	$orderItemData = OrderItem::where($condition)->get();
			return view('weixin.payNative', ['data'=>$data['data']]);
		}else{
			return view('public.msgNo', ['msg'=>$data['msg'],'url'=>url('/')]);
		}
        
    }
    /**
     * 生成二维码
     * @param Request $request
     */
    public function qrcode(Request $request)
    {
    	$data = $request->get('data');
    	$wxpayService = new WxpayService();
    	$wxpayService ->qrcode($data);
    }
    /**
     * 支付通知
     */
 	public function payNotify()
    {
    	$data = array();
		$postStr = file_get_contents("php://input");
		$data = (array)simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
    	$wxpayService = new WxpayService();
    	$wxpayService->notify($data);
    }
    /**
     * 订单查询
     * @param unknown $orderId
     */
    public function ajaxPayOrderQuery($orderId)
    {
    	$wxpayService = new WxpayService();
    	echo(json_encode($wxpayService ->orderQuery($orderId)));
    }
    
    /**
     * 获取微信用户
     * @param unknown $r
     * @return Ambigous <\Illuminate\Routing\Redirector, \Illuminate\Http\RedirectResponse>
     */
    public function login($r)
    {
    	$urlMap = ['1001'=>url('/'),'1002'=>'/'];
    	$reUrl = '/';
    	if(isset($urlMap[$r]))
    	{
    		$reUrl = $urlMap[$r];
    	}
    	$redirectUri = url()->full();
    	$wxInfo = new WxInfo();
    	$wcUrl = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$wxInfo->appid.'&redirect_uri='.$redirectUri.'&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect';
    	$rs = array('code'=>'999','msg'=>'登录失败');
    	if (isset($_GET['code'])){
    		$authPage = new Auth($wxInfo->appid, $wxInfo->appsecret);
    		$codeAccessToken = $authPage->getAccessToken('code',$_GET['code']);
    		if(isset($codeAccessToken['errcode']))
    		{
    			header("Location:".$wcUrl);
    			exit();
    		}
    		$codeAccessToken['expires_out'] = time()+7000;
    		Session::put('codeAccessToken',$codeAccessToken);
    		$authPage = $authPage->getUserInfo($codeAccessToken['openid']);
    		if(isset($authPage['errcode']))
    		{
    			header("Location:".$wcUrl);
    			exit();
    		}
    		$weixinService = new WeixinService();
    		$rs = $weixinService->login($authPage,$wxInfo->appid);
    		if($rs['code']=='999')
    		{
    			header("Location:".$wcUrl);
    			exit();
    		}
    	}else {
    		if(isset($_GET['state']))
    		{
    			redirect('/');
    		}else{
    			header("Location:".$wcUrl);
    		}
    		exit();
    	}
    	return redirect($reUrl);
    }
    
    /**
     * 支付：调用微信支付接口，记录支付操作日志
     * @param unknown $order_id
     * @return \Illuminate\View\View|\App\Includes\Wechat\Pay\json数据，可直接填入js函数作为参数
     */
    public function payUnifiedOrder($orderId){
    	
    	$wxpayService = new WxpayService();
    	$payParameters = $wxpayService->payUnifiedOrder($orderId);
    	return view('weixin.payUnifiedOrder', ['payParameters'=>$payParameters,'orderId'=>$orderId]);
    	 
    }
    
    public function payH5($orderId){
    	 
    	$wxpayService = new WxpayService();
    	$mwebUrl = $wxpayService->payH5UnifiedOrder($orderId);
    	if()
    	header("Location:".$mwebUrl);
//     	return view('weixin.payUnifiedOrder', ['payParameters'=>$payParameters,'orderId'=>$orderId]);
    
    }

   
    
}
