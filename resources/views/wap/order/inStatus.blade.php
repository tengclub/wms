@extends('layouts.wapBody')
@section('hf')
<script type="text/javascript" src="{{ asset('/css/aui/auicss/script/aui-toast.js') }}" ></script>
@endsection

@section('content')
	<header class="aui-bar aui-bar-nav">
		<a class="aui-pull-left" href="{{url('wap/order/in')}}">
        <span class="aui-iconfont aui-icon-left"></span>
	    </a>
	    <div class="aui-title">审核入库单</div>
	</header>
	<form action="{{ Request::getRequestUri() }}"  method="POST" enctype="multipart/form-data">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" id="_status" name="_status" value="1">
	<input type="hidden" name="page[status]" value="{{ $nextStatus->id }}">
	<input type="hidden" name="page[status_over]" value="{{ $nextStatus->status }}">
	<div class="aui-content aui-margin-b-15">
    <ul class="aui-list aui-form-list aui-content">
        <li class="aui-list-item">
            <div class="aui-list-item-inner">
                <div class="aui-list-item-label">
                  {{ $model->labels['wh_items_id'] }} : {{ App\Models\WhItems::findOrNew($model->wh_items_id)->title }}
                  
                </div>

            </div>
        </li>
        <li class="aui-list-item">
            <div class="aui-list-item-inner">
                <div class="aui-list-item-label">
                    {{ $model->labels['wh_items_quantity'] }} : {{ $model->wh_items_quantity }}
                </div>
            </div>
        </li>
        <li class="aui-list-item">
            <div class="aui-list-item-inner">
                <div class="aui-list-item-label">
                    {{ $model->labels['remark'] }} : 
                </div>
                <div class="aui-list-item-input">
                    {{ $model->remark }}
                </div>
            </div>
        </li>
    </ul>
   
    </div>
     @include('admin.orderStatus._wapStatus')
    </form>
    <?php $_fmi=3; ?>
	@include('layouts._footer')
@endsection
