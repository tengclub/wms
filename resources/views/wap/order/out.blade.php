@extends('layouts.wapBody')
@section('hf')
<script type="text/javascript" src="{{ asset('/css/aui/auicss/script/aui-toast.js') }}" ></script>
@endsection
@section('jq')
	$("#more").click(function () {
		initData();
	});
	function initData(){
	 var toast = new auiToast();
		toast.loading({
		    title:"加载中",
		    duration:30000
		});
		page = $("#more").attr('data-page');
		$.ajax({ 
			type: "GET",
			url: "?__data=json&"+$("form").serialize()+"page="+page,
			dataType: "json",
			success: function(data){
				if(data.code=="000")
				{
					$("#more").attr('data-page',data.page);
					$("#demo").append(data.html);
					$("#more").html(data.more);
					toast.hide();
				}
			}
		});
	}
	initData();
@endsection
@section('content')
<header class="aui-bar aui-bar-nav">
		<a class="aui-pull-left" href="{{url('wap/home/index')}}">
        <span class="aui-iconfont aui-icon-left"></span>
	    </a>
	    <div class="aui-title">出库订单</div>
	    <a class="aui-pull-right aui-btn " href="{{url('wap/order/outCreate')}}">
        <i class="aui-iconfont aui-icon-plus"></i>
    	</a>
	</header>
	<section class="aui-refresh-content">
	    <div class="aui-content">
	        <div id="demo">
	           
	        </div>
	        <div class="aui-card-list-footer aui-text-center" id="more" style="margin-bottom: 50px;" data-page="1"> 查看更多</div>
	    </div>
	</section>
    <?php $_fmi=3; ?>
	@include('layouts._footer')
@endsection
