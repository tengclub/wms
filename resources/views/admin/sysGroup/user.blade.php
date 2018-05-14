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
			 window.location.href='{{ URL('admin/sysGroup/edit') }}/'+ck[0];
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
					var  data = {guid:ids,_token:'{{ csrf_token() }}' };
					$.ajax({ 
						type: 'POST',
						url: '{{URL('admin/sysGroup/ajaxDelUser')}}', 
						dataType: 'json',
						data:data,
						success: function(obj){
							$.alert({
							 	title: '信息',
							 	body: obj.msg,
								okHidden: function(e){
									if(obj.code=='000')
									{
										location.reload();
									}
								}
							});
				      	}
			      	});
				}
			})
		}
	});
	$("#btnSaveUser").click(function(){
		var chkValue =[];
		$('input[name="key_user"]:checked').each(function(){
			chkValue.push($(this).val());
		});
		var ids = chkValue.join(",")
		if(chkValue.length<1)
		{
			$.alert('请选择相应记录');
			return false;
		}else{
			var  data = {gid:{{ $gmodel->id }},uid:ids,_token:'{{ csrf_token() }}' };
			$.ajax({ 
				type: 'POST',
				url: '{{URL('admin/sysGroup/ajaxAddUser')}}', 
				dataType: 'json',
				data:data,
				success: function(obj){
					$.alert({
					 	title: '信息',
					 	body: obj.msg,
						okHidden: function(e){
							if(obj.code=='000')
							{
								location.reload();
							}
						}
					});
		      	}
	      	});
		}
	});
	
@endsection() 
@section('content')



<div id="J_addsuppliersDialog" tabindex="-1" role="dialog" class="sui-modal hide fade" data-addsupplierurl="http://" data-getsuppliersurl="http://xxx">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" data-dismiss="modal" aria-hidden="true" class="sui-close">×</button>
              <h4 id="myModalLabel" class="modal-title">系统用户</h4>
          </div>
          <div class="modal-body sui-form form-horizontal">
              <table class="sui-table table-bordered-simple">
				<thead>
				    <tr>
						<th width="50"></th>
						<th>用户</th>
				    </tr>
				</thead>
				<tbody>
					@foreach ($dataUser as $dr)
				    <tr>
				        <td><input type="checkbox" name="key_user" value="{{ $dr->user }}"></td>
						<td>{{ $dr->user }}</td>
				       
				    </tr>
				    @endforeach
				</tbody>
              </table>
          </div>
          <div class="modal-footer">
			<button class="btn btn-primary btn-large" type="button" id="btnSaveUser" >确定</button>
		  </div>
      </div>
  </div>
</div>
<script>
  $supDialog = $('#J_addsuppliersDialog')
  $supDialog.on('click', '.J_addOneSupplier', function(e) {
    $supDialog.modal('shadeIn');
    return false;
  });
  
  
</script>

<!-- Breadcrumb -->
<ol class="breadcrumb">
	<li class="breadcrumb-item">首页</li>
	<li class="breadcrumb-item active"> 管理</li>
</ol>
<div class="container-fluid">
	<div class="animated fadeIn">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header"> 信息</div>
					<div class="card-block">
						<div class="row">
							<div class="col-sm-10 col-lg-4">
								<div class="row">
									<div class="col-sm-5">
										<div class="callout callout-info">
											<small class="text-muted"> 总数</small>
											<br>
											<strong class="h4">{{ $data->total() }}</strong>
										</div>
									</div>
									<div class="col-sm-7">
										<a class="btn btn-success" href="#"  id="J_addsuppliers" data-toggle="modal" data-target="#J_addsuppliersDialog" data-width="large" data-backdrop="static"><i class="fa fa-plus"></i> 添加</a>
										<a class="btn btn-danger" id="btnDel" href="javascript::"><i class="fa fa-remove"></i> 删除</a>
										<a class="btn btn-outline-secondary" href="{{ url('admin/sysGroup/index') }}"><i class="fa mail-reply""></i> 返回</a>
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
									
									<th width="50" class="text-center"></th>
									<th class="text-center">用户</th>
									
								</tr>
							</thead>
							<tbody>
								@foreach ($data as $dr)
								<tr>
 									
									<td class="text-center"><input type="checkbox" name="key" value="{{ $dr->id }}"></td>
									<td class="text-center">{{ $dr->user }}</td>
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
  