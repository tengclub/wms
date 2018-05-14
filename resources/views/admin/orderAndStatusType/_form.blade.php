<blockquote class="layui-elem-quote layui-text">
</blockquote>
<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
	<legend>订单与状态分类关联</legend>
</fieldset>

<form class="layui-form" action="{{ Request::getRequestUri() }}"  method="POST" enctype="multipart/form-data">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['order_table'] }}</label>
        <div class="layui-input-inline">
        	{!! App\Lib\Ehtml::select(App\Models\System::orderTable(),$model->order_table,['name'=>'page[order_table]','class'=>'form-control']) !!}
        	{{ str_replace('order_table',$model->labels['order_table'],$model->errors->first('order_table') ) }}
        </div>
         <label class="layui-form-label">{{ $model->labels['order_status_type_id'] }}</label>
        <div class="layui-input-inline">
        	{!! App\Lib\Ehtml::select(App\Models\OrderStatusType::getList(),$model->order_status_type_id,['name'=>'page[order_status_type_id]','class'=>'form-control']) !!}
        	{{ str_replace('order_status_type_id',$model->labels['order_status_type_id'],$model->errors->first('order_status_type_id') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['order_type'] }}</label>
        <div class="layui-input-block">
        	{!! App\Lib\Ehtml::select(App\Lib\SysKey::getOrderTypeList(),$model->order_type,['name'=>'page[order_type]','class'=>'form-control']) !!}
        	{{ str_replace('order_type',$model->labels['order_type'],$model->errors->first('order_type') ) }}
        </div>
    </div>
	
	<div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            <a class="layui-btn  layui-btn-primary" id="btn-add" href="{{ URL('admin/orderAndStatusType/index') }}">返回</a>
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