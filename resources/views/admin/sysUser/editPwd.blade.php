@extends('admin.layouts.sysMainBody')
@section('content')
<!-- right_panel start-->
<div class="right_panel">
	<div class="con_box">
	<div class="con_head">
		<span class="top_toolcon">
			<a class="btn_gray btn_selectLeft" href="{{ URL('admin/sysUser/admin') }}">
				<span class="btn_back"></span><span class="btn_select_txt">返回</span>
			</a> 
		</span>
	</div>
	<form action="{{ Request::getRequestUri() }}"  method="POST">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div>
			<div style="_zoom:1;" class="con_body b_size">
				<div class="addr_line">用户信息</div>
				<div style="overflow:hidden; _zoom:1; padding-bottom:0;" class="formPanel">
					<div class="tr" >
						<label class="colum">{{ $model->labels['user'] }}：</label>
						{{ $model->user }}
					</div>
					<div class="tr" >
						<label class="colum">{{ $model->labels['password'] }}：</label>
						<input type="text" value="" class="txt" name="page[password]" >
						<span >{{ $model->errors->first('password') }}</span>
					</div>
				</div>
			</div>
		</div>
		<div style="padding:15px 0 0 130px;border-top:1px solid #ccc;margin-top:10px;">
			<input class="btn btnSubmit" type="submit" value="确定" style="position:static;vertical-align:middle;">
		</div>
	</form>
</div>




	
</div>
<!-- right_panel end-->
@endsection