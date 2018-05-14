@extends('layouts.wapBody')
@section('hf')
<link rel="stylesheet" type="text/css" href="{{ asset('/css/aui/auicss/css/aui-slide.css') }}" />
@endsection
@section('content')
<header class="aui-bar aui-bar-nav">
    <div class="aui-title">Tengclub</div>
</header>
<div id="aui-slide">
    <div class="aui-slide-wrap" >
        <div class="aui-slide-node bg-dark">
            <img src="{{ asset('/css/aui/auicss/image/l1.png') }}" />
        </div>
        <div class="aui-slide-node bg-dark">
            <img src="{{ asset('/css/aui/auicss/image/l2.png') }}" />
        </div>
        <div class="aui-slide-node bg-dark">
            <img src="{{ asset('/css/aui/auicss/image/l3.png') }}" />
        </div>
    </div>
    <div class="aui-slide-page-wrap"><!--分页容器--></div>
</div>

<script type="text/javascript" src="{{ asset('/css/aui/auicss/script/aui-slide.js') }}"></script>
<script type="text/javascript">
    var slide = new auiSlide({
        container:document.getElementById("aui-slide"),
        // "width":300,
        "height":260,
        "speed":300,
        "pageShow":true,
        "pageStyle":'line',
        "loop":true,
        'dotPosition':'center'
    })

   
</script>

   
     <section class="aui-grid aui-margin-b-15 >
        <div class="aui-row">
        @foreach($menu as $m)
         <div class="aui-col-xs-4">
                <a href="{{ url($m->menu_path) }}" class="b-color-75">
                {!! $m->icon !!}
                <div class="aui-grid-label">{{$m->menu_name}}</div>
                </a>
            </div>
        @endforeach
        <!--
            <div class="aui-col-xs-4">
                <div class="aui-badge">88</div>
                <i class="aui-iconfont iconfont icon-kucun-xianxing"></i>
                <div class="aui-grid-label">库房</div>
            </div>
            <div class="aui-col-xs-4">
                <a href="{{ url('wap/order/out') }}" class="b-color-75">
                
                <i class="aui-iconfont aui-icon-back"></i>
                <div class="aui-grid-label">出库</div>
                </a>
            </div>
            <div class="aui-col-xs-4">
                <a href="{{ url('wap/order/in') }}" class="b-color-75">
                <i class="aui-iconfont aui-icon-forward"></i>
                <div class="aui-grid-label">入库</div>
                </a>
            </div>
            <div class="aui-col-xs-4">
                <a href="orderCheck.html" class="b-color-75">
                <i class="aui-iconfont aui-icon-calendar"></i>
                <div class="aui-grid-label">计划</div>
                </a>
            </div>
            
            <div class="aui-col-xs-4">
                <div class="aui-badge"></div>
                <i class="aui-iconfont aui-icon-date"></i>
                <div class="aui-grid-label">日期</div>
            </div>
            <div class="aui-col-xs-4">
                <div class="aui-dot"></div>
                 
                 <i class="aui-iconfont iconfont icon-danju-xianxing"></i>
                <div class="aui-grid-label">购物车</div>
                
            </div>
        -->
        </div>
    </section>
    <?php $_fmi=1; ?>
	@include('layouts._footer')

@endsection
