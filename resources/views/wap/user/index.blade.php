@extends('layouts.wapBody')
@section('hf')
@endsection
@section('content')
<header class="aui-bar aui-bar-nav">
<a class="aui-pull-left" href="{{url('wap/home/index')}}">
        <span class="aui-iconfont aui-icon-left"></span>
	    </a>
    <div class="aui-title">Tengclub</div>
</header>
<section class="aui-content">
        <div class="aui-card-list">
            <div class="aui-card-list-header aui-card-list-user aui-border-b  b-item-user-head">
                 <div class="aui-card-list-user-avatar">
                <img src="{{ asset('/css/aui/auicss/image/demo4.png') }}" class="aui-img-round" />
                </div>
                <div class="aui-card-list-user-name">
                    <div>{{ $user->user }}</div>
                    <small></small>
                </div>
                <div class="aui-card-list-user-info">tengclub</div>
            </div>
        </div>
        <div class="aui-info aui-margin-t-10 aui-padded-l-10 aui-padded-r-10 b-bg-white">
            <div class="aui-info-item">
            <a class="aui-pull-left b-color-75" href="{{url('wap/pub/logout')}}">
            <i class="iconfont icon-danju-xianxing aui-font-size-14">退出</i>
            </a>
            </div>
            <div class="aui-info-item"></div>
        </div>
        <div class="aui-list-item-btn aui-margin-t-15 aui-padded-l-10 aui-padded-r-10 b-align-c" >
			<a style="width:50%;margin:10px auto;" class="aui-btn aui-btn-info aui-padded-l-15 aui-padded-r-15 b-align-c" href="{{url('wap/pub/logout')}}">退&nbsp;&nbsp;出</a>
        </div>

    </section>

   
   
    <?php $_fmi=7; ?>
	@include('layouts._footer')

@endsection
