@extends('layouts.main')
@section('body')


@section('js')
	window.onload = function(){
		payOrder();			
	};
	
	function payOrder(){
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
		        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
		    }
		}else{
		    jsApiCall();
		}
	}
	
	//调用微信JS api 支付
	function jsApiCall()
	{
		WeixinJSBridge.invoke(
			'getBrandWCPayRequest',
			<?php echo $payParameters; ?>,
			function(res){
				WeixinJSBridge.log(res.err_msg);
				if( res.err_msg=='get_brand_wcpay_request:ok' )
				{
					$.ajax({ 
						type: 'GET',
						url: '{{URL('weixin/ajaxPayOrderQuery',['orderId'=>$orderId])}}', 
						dataType: 'json',
						success: function(obj){
							if(obj.code=='000')
							{
								alert(obj.msg);
							}else{
								alert(obj.msg);
							}
				      	}
			      	});
					
				}else{
					alert("支付失败");
				}
			}
		);
	}
	
@endsection() 

@section('content')
	<div id="cart-done">
	支付DMEO
	</div><!-- /cart-done -->
	<div class="fixed cart-done" id="div_pay">
		<a href="javascript:payOrder()" class="ok">付款(微信支付)</a>
	</div>
@endsection
