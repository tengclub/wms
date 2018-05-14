@extends('layouts.wapBody')
@section('hf')
<script type="text/javascript" src="{{ asset('/css/aui/auicss/script/aui-toast.js') }}" ></script>
@endsection
@section('jq')
	$("#btn-submit").click(function () {
		var toast = new auiToast();
		toast.loading({
		    title:"提交中",
		    duration:30000
		});
		$("form").submit();
	});
@endsection
@section('content')
	<header class="aui-bar aui-bar-nav">
		<a class="aui-pull-left" href="{{url('wap/order/out')}}">
        <span class="aui-iconfont aui-icon-left"></span>
	    </a>
	    <div class="aui-title">创建入库单</div>
	</header>
	<div class="aui-content aui-margin-b-15">
	<form class="layui-form" action="{{ Request::getRequestUri() }}"  method="POST" enctype="multipart/form-data">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
    <ul class="aui-list aui-form-list">
        <li class="aui-list-item">
            <div class="aui-list-item-inner">
                <div class="aui-list-item-label">
                  {{ $model->labels['wh_items_id'] }}
                  
                </div>
                <div class="aui-list-item-input">
                 {!! App\Lib\Ehtml::select(App\Models\WhItems::getList(),$model->wh_items_id,['name'=>'page[wh_items_id]','id'=>'wh_items_id','lay-filter'=>'wh_items_id','class'=>'form-control']) !!}
                   
                </div>
            </div>
        </li>
        <li class="aui-list-item">
            <div class="aui-list-item-inner">
                <div class="aui-list-item-label">
                    {{ $model->labels['wh_items_quantity'] }}
                </div>
                <div class="aui-list-item-input">
                     <input type="number"  value="{{ $model->wh_items_quantity }}" name="page[wh_items_quantity]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['wh_items_quantity'] }}" class="layui-input">
        		{{ str_replace('wh_items_quantity',$model->labels['wh_items_quantity'],$model->errors->first('wh_items_quantity') ) }}
                </div>
            </div>
        </li>
        <li class="aui-list-item">
            <div class="aui-list-item-inner">
                <div class="aui-list-item-label">
                    {{ $model->labels['remark'] }}
                </div>
                <div class="aui-list-item-input">
                    <textarea placeholder="{{ $model->labels['remark'] }}" name="page[remark]" >{{ $model->remark }}</textarea>
        		{{ str_replace('remark',$model->labels['remark'],$model->errors->first('remark') ) }}
                </div>
            </div>
        </li>
        <li class="aui-list-item">
                <div class="aui-list-item-inner aui-list-item-center aui-list-item-btn">
                <input class="aui-btn aui-btn-info aui-margin-r-5" id="btn-submit" type="button" value="保&nbsp;&nbsp;&nbsp;&nbsp;存">
                </div>
            </li>

    </ul>
    </form>
    </div>
    <?php $_fmi=3; ?>
	@include('layouts._footer')
@endsection
