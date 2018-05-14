@extends('layouts.loginBody')

@section('content')
<div class="login-box">
    <form class="layui-form layui-form-pane" id="login-form" action="{{Request::getRequestUri()}}" method="post">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="layui-form-item">
            <h3>xx后台登录系统</h3>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">账号：</label>
            <div class="layui-input-inline">
                <input type="text" name="page[user]" value="{{ $model->user }}" class="layui-input" lay-verify="account" placeholder="账号"
                       autocomplete="on" maxlength="20"/>
                        {{ $model->errors->first('user') }}
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">密码：</label>
            <div class="layui-input-inline">
                <input type="password" name="page[password]" value="{{ $model->password }}" class="layui-input" lay-verify="password" placeholder="密码"
                       maxlength="20"/>{{ $model->errors->first('password') }}
            </div>
        </div>
<!--         <div class="layui-form-item"> -->
<!--             <label class="layui-form-label">验证码：</label> -->
<!--             <div class="layui-input-inline"> -->
<!--                 <input type="number" name="code" class="layui-input" lay-verify="code" placeholder="验证码" maxlength="4"/><img -->
<!--                     src="../frame/static/image/v.png" alt=""> -->
<!--             </div> -->
<!--         </div> -->
        <div class="layui-form-item">
            <button type="reset" class="layui-btn layui-btn-danger btn-reset">重置</button>
            <button type="submit" class="layui-btn btn-submit" lay-submit="" lay-filter="sub">立即登录</button>
        </div>
    </form>
</div>
@endsection
@section('bodyEnd')

<script type="text/javascript">
    layui.use(['form', 'layer'], function () {

        // 操作对象
        var form = layui.form
                , layer = layui.layer
                , $ = layui.jquery;

        // 验证
        form.verify({
            account: function (value) {
                if (value == "") {
                    return "请输入用户名";
                }
            },
            password: function (value) {
                if (value == "") {
                    return "请输入密码";
                }
            }
        });

    })

</script>

@endsection
