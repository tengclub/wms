@extends('admin.layouts.mainBody')
@section('title') - @parent @stop
@section('jq') 
$("#btnEdit").click(function(){
		var ck = chkey();
		if(ck.length<1)
		{
			$.alert('您未选择,请选择记录');
			return false;
		}
		if(ck.length>1)
		{
			$.alert('编辑时不可以多选');
			return false;
		}else{
			 window.location.href='{{ URL('admin/sysMenu/edit') }}/'+ck[0];
		}
	});
	$("#btnEditPwd").click(function(){
		var ck = chkey();
		if(ck.length<1)
		{
			$.alert('您未选择,请选择记录');
			return false;
		}
		if(ck.length>1)
		{
			$.alert('修改时不可以多选');
			return false;
		}else{
			 window.location.href='{{ URL('admin/sysMenu/editPwd') }}/'+ck[0];
		}
	});
	function chkey(){
		var chkValue =[];
		$('input[name="key"]:checked').each(function(){
			chkValue.push($(this).val());
		});
		return chkValue
	} 
	$("#btnDel").click(function(){
		var ck = chkey();
		var ids = ck.join(",")
		if(ck.length<1)
		{
			$.alert('请选择相应记录');
			return false;
		}else{
			$.confirm({
				body: '您确认要删除所选记录吗'
				,okHide: function(){
				window.location.href='{{ URL('admin/sysMenu/destroy') }}/'+ids;
				}
			})
		}
	});
@endsection() 
@section('content')
<!-- Breadcrumb -->
<ol class="breadcrumb">
	<li class="breadcrumb-item">首页</li>
	<li class="breadcrumb-item active">菜单管理</li>
</ol>
<div class="container-fluid">
	<div class="animated fadeIn">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">菜单信息</div>
					<div class="card-block">
						<div class="row">
							<div class="col-sm-10 col-lg-4">
								<div class="row">
									<div class="col-sm-5">
										<div class="callout callout-info">
											<small class="text-muted">菜单总数</small>
											<br>
											<strong class="h4">{{ $data->total() }}</strong>
										</div>
									</div>
								</div>
								<!--/.row-->
							</div>
							<!--/.col-->
							<div class="col-sm-6 col-lg-8">
								<div class="row">
									<div class="col-sm-5">
										<div class="col-md-12 mt-1">
											<form id="search" method="get" action="{{ Request::getRequestUri() }}">
												<div class="input-group">
													<input  class="form-control"  placeholder="菜单" type="text" name="menu_name" value="{{$model->menu_name}}">
													<span class="input-group-btn">
														<button class="btn btn-primary" type="submit"><i class="fa fa-search"></i>检索</button>
													</span>
												</div>
											</form>
										</div>
									</div>
									<div class="col-sm-7 mt-1">
										<a class="btn btn-success" href="{{ url('admin/sysMenu/create') }}"><i class="fa fa-plus"></i> 添加</a>
										<a class="btn btn-success" id="btnEdit" href="javascript::"><i class="fa fa-pencil"></i> 编辑</a>
										<a class="btn btn-danger" id="btnDel" href="javascript::"><i class="fa fa-remove"></i> 删除</a>
									</div>
								</div>
								<!--/.row-->
							</div>
							<!--/.col-->
						</div>
						<!--/.row-->
						<br>
						<table class="table table-hover table-outline mb-1 hidden-sm-down">
							<thead class="thead-default">
								<tr>
									<th class="text-center"></th>
									<th >{{ $model->labels['menu_name'] }}</th>
									<th class="text-center">{{ $model->labels['pid'] }}</th>
									<th class="text-center">{{ $model->labels['menu_status'] }}</th>
									<th >{{ $model->labels['menu_path'] }}</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($data as $dr)
								<tr>
 									<td class="text-center"><input type="checkbox" name="key" value="{{ $dr->id }}"></td>
									<td >{{ $dr->menu_name }}</td>
									<td class="text-center">{{ @App\Models\SysMenu::getMenuNameById($dr->pid) }}</td>
									<td class="text-center">{{ @App\Lib\SysKey::getStatusByValue($dr->menu_status) }}</td>
									<td >{{ $dr->menu_path }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
						<nav>{!! $data->render() !!}</nav>
					</div>
				</div>
			</div>
			<!--/.col-->
		</div>
		<!--/.row-->
	</div>
</div>
<!-- /.conainer-fluid -->
<!-- right_panel end-->
@endsection
    	