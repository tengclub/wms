@extends('layouts.mainBody')
@section('bodyOption')
	class="body"
@endsection
@section('content')


<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
	<legend>入库订单</legend>
</fieldset>

<form class="layui-form" action="{{ Request::getRequestUri() }}"  method="POST" enctype="multipart/form-data">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" name="orderId" value="{{ csrf_token() }}">
	<input type="hidden" name="whItemsId" value="{{ csrf_token() }}">
	<div class="layui-form-item">
        <div class="layui-input-block">
        	{{ $order->labels['wh_items_id'] }}&nbsp;&nbsp;:&nbsp;&nbsp;{{ $items->title }} [出库总数量:{{$order->wh_items_quantity-$order->out_quantity}}]
        </div>
    </div>
	<div class="layui-form-item">
        <div class="layui-input-block">
           {{ $unit->labels['title'] }} &nbsp;&nbsp;:&nbsp;&nbsp;{{$unit->title}}  [数量:{{$unit->wh_items_num}}]
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">出库数量</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $num }}" name="num"  lay-verify="title" autocomplete="off" placeholder="出库数量" class="layui-input">
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
@endsection