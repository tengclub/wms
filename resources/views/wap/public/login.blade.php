@extends('layouts.wapBody')
@section('content')

<div class="aui-content aui-margin-b-15 b-login-main">
	<header class="aui-bar aui-bar-nav">
		<div class="aui-title">登录</div>
    </header>
    <form class="layui-form layui-form-pane" id="login-form" action="{{Request::getRequestUri()}}" method="post">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
        <ul class="aui-list aui-form-list">
            <li class="aui-list-item">
                <div class="aui-list-item-inner">
                    <div class="aui-list-item-label">
                        用户名
                    </div>
                    <div class="aui-list-item-input">
                        <input type="text" name="page[user]" value="{{ $model->user }}" placeholder="用户名" autocomplete="on" maxlength="20"/>
                        {{ $model->errors->first('user') }}
                    </div>
                </div>
            </li>
            <li class="aui-list-item">
                <div class="aui-list-item-inner">
                    <div class="aui-list-item-label">
                        密码
                    </div>
                    <div class="aui-list-item-input">
                        <input type="password" name="page[password]" value="{{ $model->password }}" placeholder="密码"maxlength="20"/>
                        {{ $model->errors->first('password') }}
                    </div>
                </div>
            </li>
           
            <li class="aui-list-item">
                <div class="aui-list-item-inner aui-list-item-center aui-list-item-btn">
                <input type="submit" value="登&nbsp;&nbsp;&nbsp;&nbsp;录" class="aui-btn aui-btn-info aui-margin-r-5">
                </div>
            </li>
        </ul>
    </div>
@endsection
