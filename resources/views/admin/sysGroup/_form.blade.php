<blockquote class="layui-elem-quote layui-text">
</blockquote>
<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
	<legend>用户组</legend>
</fieldset>

<form class="layui-form" action="{{ Request::getRequestUri() }}"  method="POST" enctype="multipart/form-data">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['group_name'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->group_name }}" name="page[group_name]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['group_name'] }}" class="layui-input">
        	{{ str_replace('group_name',$model->labels['group_name'],$model->errors->first('group_name') ) }}
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['group_status'] }}</label>
        <div class="layui-input-inline">
        	{!! App\Lib\Ehtml::select(App\Lib\SysKey::getStatusList(),$model->group_status,['name'=>'page[group_status]','class'=>'form-control']) !!}
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
            <a class="layui-btn  layui-btn-primary" id="btn-add" href="{{ url('admin/sysGroup/index') }}">返回</a>
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
