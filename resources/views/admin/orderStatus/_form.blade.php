<blockquote class="layui-elem-quote layui-text">
</blockquote>
<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
	<legend>订单状态表</legend>
</fieldset>

<form class="layui-form" action="{{ Request::getRequestUri() }}"  method="POST" enctype="multipart/form-data">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['order_status_type_id'] }}</label>
        <div class="layui-input-block">
        	{!! App\Lib\Ehtml::select(App\Models\OrderStatusType::getList(),$model->status,['name'=>'page[order_status_type_id]','id'=>'order_status_type_id','lay-filter'=>'order_status_type_id','class'=>'form-control']) !!}
        	{{ str_replace('order_status_type_id',$model->labels['order_status_type_id'],$model->errors->first('order_status_type_id') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['title'] }}</label>
        <div class="layui-input-inline">
            <input type="text"  value="{{ $model->title }}" name="page[title]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['title'] }}" class="layui-input">
        	{{ str_replace('title',$model->labels['title'],$model->errors->first('title') ) }}
        </div>
         <label class="layui-form-label">{{ $model->labels['code'] }}</label>
        <div class="layui-input-inline">
            <input type="text"  value="{{ $model->code }}" name="page[code]"  lay-verify="code" autocomplete="off" placeholder="{{ $model->labels['code'] }}" class="layui-input">
        	{{ str_replace('code',$model->labels['code'],$model->errors->first('code') ) }}
        </div>
    </div>
	<div class="layui-form-item">
	 <label class="layui-form-label">{{ $model->labels['status'] }}</label>
        <div class="layui-input-inline">
        	{!! App\Lib\Ehtml::select(App\Lib\SysKey::getOrderStatusStatusList(),$model->status,['name'=>'page[status]','id'=>'status','lay-filter'=>'status','class'=>'form-control']) !!}
        	{{ str_replace('status',$model->labels['status'],$model->errors->first('status') ) }}
        </div>
        <label class="layui-form-label">{{ $model->labels['object_type'] }}</label>
        <div class="layui-input-inline">
        	{!! App\Lib\Ehtml::select(App\Lib\SysKey::getOrderStatusTypeList(),$model->object_type,['name'=>'page[object_type]','id'=>'object_type','lay-filter'=>'object_type','class'=>'form-control']) !!}
        	{{ str_replace('type',$model->labels['object_type'],$model->errors->first('object_type') ) }}
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
            <input type="text"  value="{{ $model->object_lable }}" name="page[object_lable]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['object_lable'] }}" class="layui-input">
        	{{ str_replace('object_lable',$model->labels['object_lable'],$model->errors->first('object_lable') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['sort'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->sort }}" name="page[sort]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['sort'] }}" class="layui-input">
        	{{ str_replace('sort',$model->labels['sort'],$model->errors->first('sort') ) }}
        </div>
    </div>
    
	<div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            <a class="layui-btn  layui-btn-primary" id="btn-add" href="{{ URL('admin/orderStatus/index') }}">返回</a>
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