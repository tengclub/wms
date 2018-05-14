@extends('layouts.mainBody')
@section('content')
<!-- layout admin -->
<div class="layui-layout layui-layout-admin"> <!-- 添加skin-1类可手动修改主题为纯白，添加skin-2类可手动修改主题为蓝白 -->
    <!-- header -->
    <div class="layui-header my-header">
        <a href="index.html">
            <!--<img class="my-header-logo" src="" alt="logo">-->
            <div class="my-header-logo">后台模板 HTML</div>
        </a>
        <div class="my-header-btn">
            <button class="layui-btn layui-btn-small btn-nav"><i class="layui-icon">&#xe65f;</i></button>
        </div>

        <!-- 顶部左侧添加选项卡监听 -->
        <ul class="layui-nav" lay-filter="side-top-left">
            <li class="layui-nav-item"><a href="javascript:;" href-url="demo/btn.html"><i class="layui-icon">&#xe621;</i>按钮</a></li>
            <li class="layui-nav-item">
                <a href="javascript:;"><i class="layui-icon">&#xe621;</i>基础</a>
                <dl class="layui-nav-child">
                    <dd><a href="javascript:;" href-url="demo/btn.html"><i class="layui-icon">&#xe621;</i>按钮</a></dd>
                    <dd><a href="javascript:;" href-url="demo/form.html"><i class="layui-icon">&#xe621;</i>表单</a></dd>
                </dl>
            </li>
        </ul>

        <!-- 顶部右侧添加选项卡监听 -->
        <ul class="layui-nav my-header-user-nav" lay-filter="side-top-right">
<!--             <li class="layui-nav-item"><a href="javascript:;" class="pay" href-url="">支持作者</a></li> -->
            <li class="layui-nav-item">
                <a class="name" href="javascript:;"><i class="layui-icon">&#xe629;</i>主题</a>
                <dl class="layui-nav-child">
                    <dd data-skin="0"><a href="javascript:;">默认</a></dd>
                    <dd data-skin="1"><a href="javascript:;">纯白</a></dd>
                    <dd data-skin="2"><a href="javascript:;">蓝白</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item">
                <a class="name" href="javascript:;"><img src="{{ asset('/css/layui//frame/static/image/code.png')}}" alt="logo"> {{ $user->user  }} </a>
                <dl class="layui-nav-child">
                    <dd><a href="javascript:;" href-url="demo/login.html"><i class="layui-icon">&#xe621;</i>登录页</a></dd>
                    <dd><a href="javascript:;" href-url="demo/map.html"><i class="layui-icon">&#xe621;</i>图表</a></dd>
                    <dd><a href="/"><i class="layui-icon">&#x1006;</i>退出</a></dd>
                </dl>
            </li>
        </ul>

    </div>
    <!-- side -->
    <div class="layui-side my-side">
        <div class="layui-side-scroll">
            <!-- 左侧主菜单添加选项卡监听 -->
            <ul class="layui-nav layui-nav-tree" lay-filter="side-main">
            @foreach ($menu as $pm)
            <li class="layui-nav-item">
				<a href="javascript:;"><i class="layui-icon">&#xe620;</i>{{ $pm['i']->menu_name }}</a>
				@foreach ($pm['s'] as $sm)
				 <dl class="layui-nav-child">
				  <dd><a href="javascript:;" href-url="{{ url($sm->menu_path) }}"><i class="layui-icon">&#xe621;</i>{{ $sm->menu_name }}</a></dd>
				 </dl>
				@endforeach
            </li>
            @endforeach

        </div>
    </div>
    <!-- body -->
    <div class="layui-body my-body">
        <div class="layui-tab layui-tab-card my-tab" lay-filter="card" lay-allowClose="true">
            <ul class="layui-tab-title">
                <li class="layui-this" lay-id="1"><span><i class="layui-icon">&#xe638;</i>欢迎页</span></li>
            </ul>
            <div class="layui-tab-content">
                <div class="layui-tab-item layui-show">
                    <iframe id="iframe" src="{{ url('admin/home/welcome') }}" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    </div>
    <!-- footer -->
    <div class="layui-footer my-footer">
        <p><a href="###" target="_blank">TengClub</a>&nbsp;&nbsp;&&nbsp;&nbsp;<a href="###" target="_blank">管理系统</a></p>
        <p>{{ date('Y')}} © copyright</p>
    </div>
</div>

<!-- pay -->
<!-- <div class="my-pay-box none"> -->
<!--     <div><img src="./frame/static/image/zfb.png" alt="支付宝"><p>支付宝</p></div> -->
<!--     <div><img src="./frame/static/image/wx.png" alt="微信"><p>微信</p></div> -->
<!-- </div> -->

<!-- 右键菜单 -->
<div class="my-dblclick-box none">
    <table class="layui-tab dblclick-tab">
        <tr class="card-refresh">
            <td><i class="layui-icon">&#x1002;</i>刷新当前标签</td>
        </tr>
        <tr class="card-close">
            <td><i class="layui-icon">&#x1006;</i>关闭当前标签</td>
        </tr>
        <tr class="card-close-all">
            <td><i class="layui-icon">&#x1006;</i>关闭所有标签</td>
        </tr>
    </table>
</div>
@endsection

@section('bodyEnd')
<script type="text/javascript" src="{{ asset('/css/static/js/vip_comm.js')}}"></script>
<script type="text/javascript">
layui.use(['layer'], function () {

    // 操作对象
    var layer       = layui.layer;


});
</script>

@endsection

