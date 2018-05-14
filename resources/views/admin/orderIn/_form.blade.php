<blockquote class="layui-elem-quote layui-text">
</blockquote>
<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
	<legend>入库订单</legend>
</fieldset>

<form class="layui-form" action="{{ Request::getRequestUri() }}"  method="POST" enctype="multipart/form-data">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['wh_items_id'] }}</label>
        <div class="layui-input-block">
        	{!! App\Lib\Ehtml::select(App\Models\WhItems::getList(),$model->wh_items_id,['name'=>'page[wh_items_id]','id'=>'wh_items_id','lay-filter'=>'wh_items_id','class'=>'form-control']) !!}
        	{{ str_replace('wh_items_id',$model->labels['wh_items_id'],$model->errors->first('wh_items_id') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['wh_items_quantity'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->wh_items_quantity }}" name="page[wh_items_quantity]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['wh_items_quantity'] }}" class="layui-input">
        	{{ str_replace('wh_items_quantity',$model->labels['wh_items_quantity'],$model->errors->first('wh_items_quantity') ) }}
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
            <a class="layui-btn  layui-btn-primary" id="btn-add" href="{{ URL('admin/orderIn/index') }}">返回</a>
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