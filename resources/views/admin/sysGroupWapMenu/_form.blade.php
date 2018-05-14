<blockquote class="layui-elem-quote layui-text">
</blockquote>
<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
	<legend>wap菜单</legend>
</fieldset>

<form class="layui-form" action="{{ Request::getRequestUri() }}"  method="POST" enctype="multipart/form-data">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['id'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->id }}" name="page[id]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['id'] }}" class="layui-input">
        	{{ str_replace('id',$model->labels['id'],$model->errors->first('id') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['group_id'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->group_id }}" name="page[group_id]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['group_id'] }}" class="layui-input">
        	{{ str_replace('group_id',$model->labels['group_id'],$model->errors->first('group_id') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['menu_id'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->menu_id }}" name="page[menu_id]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['menu_id'] }}" class="layui-input">
        	{{ str_replace('menu_id',$model->labels['menu_id'],$model->errors->first('menu_id') ) }}
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
            <a class="layui-btn  layui-btn-primary" id="btn-add" href="{{ URL('admin/sysGroupWapMenu/index') }}">返回</a>
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