@extends('admin.layouts.mainBody')
@section('title') EWS @parent @stop
@section('hf') 
	<link rel="stylesheet"  type="text/css" href="{{ asset('/plug-in/jbox/jBox/Skins/Blue/jbox.css') }}" />
	<script type="text/javascript" src="{{ asset('/plug-in/jbox/jBox/jquery.jBox-2.3.min.js') }}"></script>
	<link rel="stylesheet" href="{{ asset('/plug-in/zTree_v3/css/zTreeStyle/zTreeStyle.css') }}" type="text/css">
	<script type="text/javascript" src="{{ asset('/plug-in/zTree_v3/js/jquery.ztree.core.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/plug-in/zTree_v3/js/jquery.ztree.excheck.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/plug-in/zTree_v3/js/jquery.ztree.exedit.js') }}"></script>
@endsection 

@section('js') 
		var setting = {
			data: {
				simpleData: {
					enable: true
				}
			},
			callback: {
				
			},
			check: {
				enable: true,
				chkboxType :{ "Y" : "s", "N" : "ps" }
			},
			edit: {
				enable: true,
				showRemoveBtn: false,
				showRenameBtn: false
			}
		};
		var zNodes ={!! $data !!};
		var zNodesAll ={!! $dataAll !!};

		$(document).ready(function(){
			$.fn.zTree.init($("#tree"), setting, zNodes);
			$.fn.zTree.init($("#treeAll"), setting, zNodesAll);
		});
@endsection() 


@section('jq') 
	
	function chkey(){
		var chkValue =[];
		$('input[name="key"]:checked').each(function(){
			chkValue.push($(this).val());
		});
		return chkValue
	} 
	$("#btnDel").click(function(){
		$.confirm({
			body: '您确认要删除所选记录吗'
			,okHide: function(){
				var treeObj = $.fn.zTree.getZTreeObj("tree");
				var nodes = treeObj.getChangeCheckedNodes();
				var mids = '0';
				$.each(nodes, function(i,node){
			     mids = mids+','+node.id;
			    }); 
			    var postData = {mids:mids,_token:'{{ csrf_token() }}',gid:{{ $model->id }}};
			     $.ajax({ 
					type: 'POST',
					url: '{{URL('admin/sysGroup/ajaxDelMenu')}}', 
					dataType: 'json',
					data:postData,
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
			
		
	    
	   
	});
	
	$("#btnSaveMenu").click(function(){
		var treeObj = $.fn.zTree.getZTreeObj("treeAll");
		var nodes = treeObj.getChangeCheckedNodes();
		var mids = '0';
		$.each(nodes, function(i,node){
	     mids = mids+','+node.id;
	    }); 
	    var postData = {mids:mids,_token:'{{ csrf_token() }}',gid:{{ $model->id }}};
	    
	    $.ajax({ 
			type: 'POST',
			url: '{{URL('admin/sysGroup/ajaxAddMenu')}}', 
			dataType: 'json',
			data:postData,
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

	});
	
@endsection() 
@section('content')

<div id="J_addsuppliersDialog" tabindex="-1" role="dialog" class="sui-modal hide fade" data-addsupplierurl="http://" data-getsuppliersurl="http://xxx">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" data-dismiss="modal" aria-hidden="true" class="sui-close">×</button>
              <h4 id="myModalLabel" class="modal-title">菜单用户</h4>
          </div>
          <div class="modal-body sui-form form-horizontal"  >
           <div class="ztree" id="treeAll" style="height:305px; float:left; overflow-y: auto;"></div>  
          </div>
          <div class="modal-footer">
			<button class="btn btn-primary btn-large" type="button" id="btnSaveMenu" >确定</button>
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
					<div class="card-header"> 组菜单信息</div>
					<div class="card-block">
						<div class="row">
							<!--/.col-->
							<div class="col-sm-6 col-lg-8">
								<div class="row">
									<div class="col-sm-7 mt-1">
										<a class="btn btn-success layui-btn-sm" href="#" id="J_addsuppliers" data-toggle="modal" data-target="#J_addsuppliersDialog" data-width="large" data-backdrop="static"><i class="fa fa-plus"></i>添加</a>
										<a class="btn btn-danger layui-btn-sm" id="btnDel" href="javascript::"><i class="fa fa-remove"></i> 删除</a>
										<a class="btn btn-outline-secondary layui-btn-sm" href="{{ url('admin/sysGroup/index') }}"><i class="fa fa-mail-reply"></i> 返回</a>
									</div>
								</div>
								<!--/.row-->
							</div>
							<!--/.col-->
						</div>
						<!--/.row-->
						<br>
						<div class="ztree" id="tree" style="width: 500px; height:405px; float:left; overflow-y: auto;"></div>  
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
 