@extends('layouts.sysMain')
@section('hf') 
	<link rel="stylesheet"  type="text/css" href="{{ asset('/plug-in/jbox/jBox/Skins/Blue/jbox.css') }}" />
	<script type="text/javascript" src="{{ asset('/plug-in/jbox/jBox/jquery.jBox-2.3.min.js') }}"></script>
@endsection 
@section('jq') 
	$('#btnAdd').click(function(){
		var ck = chkey();
		var mids = ck.join(',')
		if(mids.length<1)
		{
			$.jBox.alert('请选择相应记录', '信息');
			return false;
		}else{
			var postData = {gid:'{{$gid}}',mids:mids,_token:'{{ csrf_token() }}'};
			$.jBox.tip("...", 'loading');
			$.ajax({ 
				type: 'POST',
				url: '{{ URL('sysGroupMenu/ajaxAdd') }}', 
				dataType: 'json',
				data:postData,
				success: function(obj){
					if(obj.code=='000')
					{
						$.jBox.tip(obj.msg, 'success');
						 parent.location.reload();
					}else{
						$.jBox.tip(obj.msg, 'error');
					}
		      	}
	      	});
		}
	});
	function chkey(){
		var chkValue = [];
		$('input[name="key"]:checked').each(function(){
			chkValue.push($(this).val());
		});
		return chkValue
	} 
@endsection() 
@section('body')
<!--mainPanel start-->
<!-- right_panel start-->
<div style="padding: 10px;">
	<div class="con_box">
		<div class="con_body">
			<table  cellspacing="0" style="width:570px;table-layout:fixed;zoom:1;" class="listTable blockall with_move member_list_table">
				<tr><th>
					<div class="t_obj top_tools">
						<a style="" class="btn_gray btn_selectLeft" id="btnAdd" >
							<span class="icon_add"></span>
							<span class="btn_select_txt">新增</span>
						</a>
					</div>
					<div>
						<form id="search" method="get" action="{{ Request::getRequestUri() }}">
							<input  type="hidden" name="gid" value="{{ $gid }}">
							<div class="searchcon">
								<label>{{ $model->labels['menu_name'] }}</label>:    
								<input  class="txt bold t_search" width="100px" type="text" name="menu_name" value="{{ $model->menu_name }}">
								<input class="btnSearch" type="submit" value=" " >
							</div>
						</form>
					</div>
				</th></tr>
			</table>
			<table cellspacing="0" style="width:570px;table-layout:fixed;zoom:1;" class="listTable blockall with_move member_list_table">
				<tr>
					<td width="50"></td><td>{{ $model->labels['menu_name'] }}</td><td width="100">{{ $model->labels['pid'] }}</td><td width="100">{{ $model->labels['menu_status'] }}</td>
				</tr>
				@foreach ($data as $dr)
				<tr>
					<td><span><input type="checkbox" name="key" value="{{ $dr->id }}"></span></td>
					<td><span>{{ $dr->menu_name }}</span></td>
					<td><span title="">{{ @App\Models\SysMenu::getMenuNameById($dr->pid) }}</span></td>
					<td><span title="">{{ @App\Includes\SysKey::getStatusByValue($dr->menu_status) }}</span></td>
				</tr>
				@endforeach
			</table>     
			<div style="margin-top:10px;">{!! $data->appends(['gid'=>$gid])->render() !!}</div>   
		</div>
	</div>
</div>
<!-- right_panel end-->
<!--bottom end-->
@endsection