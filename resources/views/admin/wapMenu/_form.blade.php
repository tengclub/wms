@section('hf')
<link rel="stylesheet" type="text/css" href="{{ asset('/css/aui/alifont/iconfont.css') }}" />
@endsection
<blockquote class="layui-elem-quote layui-text">
</blockquote>
<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
	<legend>wap菜单</legend>
</fieldset>

<form class="layui-form" action="{{ Request::getRequestUri() }}"  method="POST" enctype="multipart/form-data">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['menu_name'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->menu_name }}" name="page[menu_name]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['menu_name'] }}" class="layui-input">
        	{{ str_replace('menu_name',$model->labels['menu_name'],$model->errors->first('menu_name') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['menu_path'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->menu_path }}" name="page[menu_path]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['menu_path'] }}" class="layui-input">
        	{{ str_replace('menu_path',$model->labels['menu_path'],$model->errors->first('menu_path') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['menu_status'] }}</label>
        <div class="layui-input-block">
        {!! App\Lib\Ehtml::select(App\Lib\SysKey::getStatusList(),$model->menu_status,['name'=>'page[menu_status]','class'=>'form-control']) !!}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['order_id'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->order_id }}" name="page[order_id]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['order_id'] }}" class="layui-input">
        	{{ str_replace('order_id',$model->labels['order_id'],$model->errors->first('order_id') ) }}
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['icon'] }}{!!$model->icon!!}</label>
        <div class="layui-input-block">
        
            <input type="text"  value="{{ $model->icon }}" name="page[icon]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['icon'] }}" class="layui-input">
        	
        	{{ str_replace('icon',$model->labels['icon'],$model->errors->first('icon') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            <a class="layui-btn  layui-btn-primary" id="btn-add" href="{{ URL('admin/wapMenu/index') }}">返回</a>
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