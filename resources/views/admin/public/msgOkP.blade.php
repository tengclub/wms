@extends('layouts.mainBody')
@section('bodyOption')
	class="body"
@endsection
@section('jq')
$("#btn-url").click(function () {
		parent.location.href="{{ $url }}";
	});

@endsection
@section('content')
<fieldset class="layui-elem-field layui-col-md3  layui-col-md-offset4">
	<legend style="color:#009688">提示</legend>
	<div class="layui-field-box">
			<div class="layui-form-item">
				<div class="layui-inline">
					{{$msg}}
				</div>
				
			</div>
			<div class="layui-col-md-offset10">
					<a class="layui-btn  layui-btn-small" href="###" id="btn-url">确定</a>
				</div>
	</div>
</fieldset>

@endsection

