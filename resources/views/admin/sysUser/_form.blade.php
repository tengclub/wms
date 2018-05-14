<blockquote class="layui-elem-quote layui-text">
</blockquote>
<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
	<legend>系统用户</legend>
</fieldset>

<form class="layui-form" action="{{ Request::getRequestUri() }}"  method="POST" enctype="multipart/form-data">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['user'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->user }}" name="page[user]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['user'] }}" class="layui-input">
        	{{ str_replace('user',$model->labels['user'],$model->errors->first('user') ) }}
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['password'] }}</label>
        <div class="layui-input-block">
            <input type="password"  value="{{ $model->password }}" name="page[password]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['password'] }}" class="layui-input">
        	{{ str_replace('password',$model->labels['password'],$model->errors->first('password') ) }}
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['mail'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->mail}}" name="page[mail]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['mail'] }}" class="layui-input">
        	{{ str_replace('mail',$model->labels['mail'],$model->errors->first('mail') ) }}
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['phone'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->phone }}" name="page[phone]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['phone'] }}" class="layui-input">
        	{{ str_replace('phone',$model->labels['phone'],$model->errors->first('phone') ) }}
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['level'] }}</label>
        <div class="layui-input-inline">
        	{!! App\Lib\Ehtml::select(App\Lib\SysKey::getSysUserLevelList(),$model->level,['name'=>'page[level]','class'=>'form-control']) !!}
        </div>
    </div>
     <div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['user_status'] }}</label>
        <div class="layui-input-inline">
        	{!! App\Lib\Ehtml::select(App\Lib\SysKey::getStatusList(),$model->user_status,['name'=>'page[user_status]','class'=>'form-control']) !!}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['remarks'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->remarks }}" name="page[remarks]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['remarks'] }}" class="layui-input">
        	{{ str_replace('remarks',$model->labels['remarks'],$model->errors->first('remarks') ) }}
        </div>
	</div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            <a class="layui-btn  layui-btn-primary" id="btn-add" href="{{ url('admin/sysUser/index') }}">返回</a>
        </div>
    </div>
</form>
@section('bodyEnd')
<script>
	layui.use(['form'], function(){
		var form = layui.form;
});
</script>
@endsection

    