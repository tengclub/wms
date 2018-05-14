@extends('admin.layouts.sysMainBody')
@section('content')
	<!-- right_panel start-->
	<div class="right_panel">
		<div class="con_box">
			<div class="con_head">
				<span class="top_toolcon">
				</span>
			</div>
			<form action="{{ Request::getRequestUri() }}"  method="POST">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div>
					<div style="_zoom:1;" class="con_body b_size">
						<div class="addr_line">系统信息</div>
						<div style="overflow:hidden; _zoom:1; padding-bottom:0;" class="formPanel">
						@foreach($data as $dr)
							<div class="tr" >
								<label class="colum">{{ $dr['name'] }}：</label>
								@if ($dr['html_type'] == App\Includes\SysKey::$attributeInputValue)
									<input type="text" class="txt" name="page[{{ $dr['code'] }}]" value="{{ $dr['value'] }}">
								@elseif ($dr['html_type'] == App\Includes\SysKey::$attributeSelectValue)
									{!! App\Includes\Ehtml::select(['1'=>1,'2'=>'2'],$dr['value'],['name'=>'page['.$dr['code'].']','style'=>'width:233px;','class'=>'txt']) !!}
								@else
									<input type="text" class="txt" name="page[{{ $dr['code'] }}]" value="{{ $dr['value'] }}">
								@endif
							</div>
						@endforeach
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