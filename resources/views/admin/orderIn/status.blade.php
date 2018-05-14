@extends('layouts.mainBody')
@section('bodyOption')
	class="body"
@endsection

@section('content')
<blockquote class="layui-elem-quote layui-text">
 <a class="layui-btn  layui-btn-primary layui-btn-sm" id="btn-add" href="{{ URL('admin/orderIn/index') }}">返回</a>
</blockquote>
<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
	<legend>入库订单</legend>
</fieldset>

<form class="layui-form" action="{{ Request::getRequestUri() }}"  method="POST" enctype="multipart/form-data">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" id="_status" name="_status" value="1">
	<input type="hidden" name="page[status]" value="{{ $nextStatus->id }}">
	<input type="hidden" name="page[status_over]" value="{{ $nextStatus->status }}">
	<div class="layui-form-item">
        <label class="layui-form-label"></label>
        <div class="layui-input-block">
       {{ $model->labels['wh_items_id'] }} : {{ App\Models\WhItems::findOrNew($model->wh_items_id)->title }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label"></label>
        <div class="layui-input-block">
         {{ $model->labels['wh_items_quantity'] }} : {{ $model->wh_items_quantity }}
        </div>
    </div>
    
    @include('admin.orderStatus._status')
</form>


@endsection
