<blockquote class="layui-elem-quote layui-text">
</blockquote>
<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
	<legend>订单状态日志</legend>
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
        <label class="layui-form-label">{{ $model->labels['order_id'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->order_id }}" name="page[order_id]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['order_id'] }}" class="layui-input">
        	{{ str_replace('order_id',$model->labels['order_id'],$model->errors->first('order_id') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['order_status_id'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->order_status_id }}" name="page[order_status_id]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['order_status_id'] }}" class="layui-input">
        	{{ str_replace('order_status_id',$model->labels['order_status_id'],$model->errors->first('order_status_id') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['order_status_title'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->order_status_title }}" name="page[order_status_title]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['order_status_title'] }}" class="layui-input">
        	{{ str_replace('order_status_title',$model->labels['order_status_title'],$model->errors->first('order_status_title') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['status_value'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->status_value }}" name="page[status_value]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['status_value'] }}" class="layui-input">
        	{{ str_replace('status_value',$model->labels['status_value'],$model->errors->first('status_value') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['object_type'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->object_type }}" name="page[object_type]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['object_type'] }}" class="layui-input">
        	{{ str_replace('object_type',$model->labels['object_type'],$model->errors->first('object_type') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['object_value'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->object_value }}" name="page[object_value]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['object_value'] }}" class="layui-input">
        	{{ str_replace('object_value',$model->labels['object_value'],$model->errors->first('object_value') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['object_lable'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->object_text }}" name="page[object_text]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['object_text'] }}" class="layui-input">
        	{{ str_replace('object_text',$model->labels['object_lable'],$model->errors->first('object_text') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['remark'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->remark }}" name="page[remark]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['remark'] }}" class="layui-input">
        	{{ str_replace('remark',$model->labels['remark'],$model->errors->first('remark') ) }}
        </div>
    </div>
    
	<div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            <a class="layui-btn  layui-btn-primary" id="btn-add" href="{{ URL('admin/orderStatusLog/index') }}">返回</a>
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