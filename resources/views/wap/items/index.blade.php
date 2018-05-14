@extends('layouts.wapBody')
@section('hf')
<link rel="stylesheet" type="text/css" href="{{ asset('/css/aui/auicss/css/aui-pull-refresh.css') }}" />
<script type="text/javascript" src="{{ asset('/css/aui/auicss/script/aui-toast.js') }}" ></script>
<script type="text/javascript" src="{{ asset('/css/aui/auicss/script/api.js') }}" ></script>
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
			url: "?__data=json&searchKey="+$("#search-input").val()+"&page="+page,
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
	$(".aui-icon-search").click(function () {
		window.location.href='?searchKey='+$("#search-input").val();
	});
@endsection
@section('content')

<header class="aui-bar aui-bar-nav">
		<a class="aui-pull-left" href="{{url('wap/home/index')}}">
        <span class="aui-iconfont aui-icon-left"></span>
	    </a>
	    <div class="aui-title">货物</div>
	    <a class="aui-pull-right aui-btn " href="{{url('wap/items/create')}}">
        <i class="aui-iconfont aui-icon-plus"></i>
    	</a>
	</header>
	<div class="aui-searchbar" id="search">
        <div class="aui-searchbar-input aui-border-radius" tapmode >
            <i class="aui-iconfont aui-icon-search"></i>
            <input type="search"  placeholder="请输入搜索名称或编号" id="search-input" value="{{$searchKey}}">
        </div>
        <div class="aui-searchbar-cancel" tapmod>取消</div>
    </div>
<script type="text/javascript">
    apiready = function(){
        api.parseTapmode();
    }
    var searchBar = document.querySelector(".aui-searchbar-input");
    if(searchBar){
        searchBar.onclick = function(){
            document.querySelector(".aui-searchbar-cancel").style.marginRight = 0;
        }
    }
    document.querySelector(".aui-searchbar-cancel").onclick = function(){
        this.style.marginRight = "-"+this.offsetWidth+"px";
        document.getElementById("search-input").value = '';
        document.getElementById("search-input").blur();
    }

</script>
	<div class="aui-content aui-margin-b-15">
    <ul class="aui-list aui-media-list" id="demo">
    </ul>
     <div class="aui-card-list-footer aui-text-center" id="more" style="margin-bottom: 50px;" data-page="1"> 查看更多</div>
</div>
    <?php $_fmi=5; ?>
	@include('layouts._footer')
@endsection
