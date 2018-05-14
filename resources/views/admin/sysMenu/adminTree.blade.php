@extends('layouts.mainBody')
@section('hf') 
	<link rel="stylesheet" href="{{ asset('/plug-in/zTree_v3/css/zTreeStyle/zTreeStyle.css') }}" type="text/css">
	<script type="text/javascript" src="{{ asset('/plug-in/zTree_v3/js/jquery.ztree.core.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/plug-in/zTree_v3/js/jquery.ztree.excheck.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/plug-in/zTree_v3/js/jquery.ztree.exedit.js') }}"></script>
@endsection 
@section('jq') 
	$("#btn-add").click(function(){
		$('#isAdd').val('1');
		$('#id').val('');
		$('#spanId').val('');
		$('#pid').val('');
		$('#spid').val('');
		var treeObj = $.fn.zTree.getZTreeObj("tree");
		var sNodes = treeObj.getSelectedNodes();
		if (sNodes.length > 0) {
			var node = sNodes[0];
			$('#pid').val(node.id);
			$('#spid').val(node.id);
		}
		$('#menu_path').val('');
		$('#remarks').val('');
		$('#order_id').val('');
		$('#menu_status').val('');
		$('#menu_name').val('');
		$('#group').val('');
		$('#editArea').show();
	});
	$("#btn-edit").click(function(){
	
		$('#isAdd').val('0');
		var treeObj = $.fn.zTree.getZTreeObj("tree");
		var sNodes = treeObj.getSelectedNodes();
		
		if (sNodes.length > 0) {
			var node = sNodes[0];
			if($('#isAdd').val()=='0')
			{
				$('#id').val(node.id);
				$('#spanId').html(node.id);
			}
			$('#pid').val(node.pId);
			$('#spid').val(node.pId);
			$('#menu_path').val(node.menu_path);
			$('#remarks').val(node.remarks);
			$('#order_id').val(node.order_id);
			$('#menu_status').val(node.menu_status);
			$('#menu_name').val(node.name);
			$('#group').val(node.group);
		}
		$('#editArea').show();
	});
	$("#btn-delete").click(function(){
		var treeObj = $.fn.zTree.getZTreeObj("tree");
		var nodes = treeObj.getChangeCheckedNodes();
		var ids = '0';
		$.each(nodes, function(i,node){
			ids = ids+','+node.id;
	    }); 
		//询问框
		layer.confirm('您确定要删除吗？', {
			btn: ['确定','取消'] //按钮
		}, function(){
		var index = layer.load(1,{time: 30*1000});
			$.ajax({ 
				type: 'GET',
				url: '{{URL('admin/sysMenu/ajaxDel')}}/'+ids, 
				dataType: 'json',
				success: function(obj){
					if(obj.code=='000')
					{
						var treeObj = $.fn.zTree.getZTreeObj("tree");
						var checkeNodes = treeObj.getChangeCheckedNodes();
						var l = checkeNodes.length;
						for (var i = 0; i < l; i++) {
							treeObj.removeNode(checkeNodes[i]);
						}
						layer.msg(obj.msg, {icon: 1});
					}else{
						layer.msg(obj.msg, {icon: 2});
					}
		      	}
	      	});
	      	layer.close(index); 
		}, function(){
	
		});

		
		return true; //close
	});
	$("#btnSave").click(function(){
		var postData = $("form").serialize();
		$.ajax({ 
			type: 'POST',
			url: '{{URL('admin/sysMenu/ajaxSave')}}', 
			dataType: 'json',
			data:postData,
			success: function(obj){
				if(obj.code=='000')
				{
					var treeObj = $.fn.zTree.getZTreeObj("tree");
					var selectNodes = treeObj.getSelectedNodes();
					if($('#isAdd').val()=='1')
					{
						var newNode = obj.data;
						newNode = treeObj.addNodes(selectNodes[0], newNode);
					}else{
						selectNodes[0].name = obj.data.name;
					 	treeObj.updateNode(selectNodes[0]);
					}
					layer.msg(obj.msg, {icon: 1});
				}else{
					layer.msg(obj.msg, {icon: 2});
				}
	      	}
      	});
		$('#editArea').hide();
		return false;
	});
	
	
@endsection() 
@section('js') 

		var setting = {
			data: {
				simpleData: {
					enable: true
				}
			},
			callback: {
				onClick: zTreeOnClick,
				beforeDrop: zTreeBeforeDrop
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

		$(document).ready(function(){
			$.fn.zTree.init($("#tree"), setting, zNodes);
		});
		function zTreeOnClick(event, treeId, treeNode) {
			if($('#isAdd').val()=='0')
			{
				$('#id').val(treeNode.id);
				$('#spanId').html(treeNode.id);
				$('#pid').val(treeNode.pId);
				$('#spid').val(treeNode.pId);
				$('#menu_path').val(treeNode.menu_path);
				$('#remarks').val(treeNode.remarks);
				$('#order_id').val(treeNode.order_id);
				$('#menu_status').val(treeNode.menu_status);
				$('#menu_name').val(treeNode.name);
				$('#group').val(treeNode.group);
			}else{
				$('#pid').val(treeNode.id);
				$('#spid').val(treeNode.id);
			}
		};
		//节结移动
		function zTreeBeforeDrop(treeId, treeNodes, targetNode, moveType) {
//		$('#divEditMenu').hide();	
			//禁止将节点拖拽成为根节点
			if(targetNode == null || (moveType != 'inner' && !targetNode.parentTId))
			{
				return false;
			}


			
			//询问框
			layer.confirm('确认将菜单移到此处吗？', {
				btn: ['确定','取消'] //按钮
			}, function(){
				var option =  {
						async : false,
						type: 'POST',
						url: '{{ URL("admin/sysMenu/move") }}',
						data : { 
							'sid' : treeNodes[0].id, 
							'did' : targetNode.id,
							'type':moveType,
							'_token':'{{ csrf_token() }}'
						},
						success : function (r) {
							var jsonObj = null;
							try{
								jsonObj = JSON.parse(r);
							}catch(e){
								//转换错误时，显示错误信息，并返回
								sysErrorInfo(e.message, r);
								 return false; //close
							}
							if(jsonObj.code=='000'){	
								layer.alert(jsonObj.msg, {icon: 1});
							}else{					
								layer.alert(jsonObj.msg, {icon: 2});
							}
							return false;
						}
					}
			    	$.ajax(option);
			}, function(){
		
			});
			
		};

@endsection() 
@section('bodyOption')
	class="body"
@endsection
@section('content')
<fieldset class="layui-elem-field">
	<legend>菜单</legend>
	<div class="layui-field-box">


<div class="my-btn-box">
	<span class="fl">
		
		<a class="layui-btn btn-add btn-default layui-btn-sm" id="btn-add">添加</a>
		<a class="layui-btn btn-add btn-default layui-btn-sm" id="btn-edit">编辑</a>
		<a class="layui-btn layui-btn-danger radius btn-delect layui-btn-sm" id="btn-delete">删除</a>
		<a class="layui-btn btn-add btn-default layui-btn-sm" id="btn-refresh"><i class="layui-icon">&#x1002;</i></a>
	</span>
</div>
<div class="ztree" id="tree" style="width: 300px; height:405px; float:left; border-right:1px solid #ccc;overflow-y: auto;"></div>

<form action="" class="layui-form" id="form1"　method="POST">
			<input type="hidden" id="isAdd" value="1">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div id="editArea" style="display: none;">
				<input type="hidden" value="{{ $model->id }}" class="txt" name="page[id]" id="id">
				<input type="hidden" value="{{ $model->pid }}" class="txt" name="page[pid]" id="pid">
				<div style="overflow:hidden; _zoom:1; padding-bottom:0;" class="formPanel">
					<div class="layui-form-item">
				        <label class="layui-form-label">{{ $model->labels['menu_name'] }}</label>
				        <div class="layui-input-block">
				            <input type="text" value="{{ $model->menu_name }}" class="layui-input" name="page[menu_name]" id="menu_name">
				        </div>
				    </div>
				    <div class="layui-form-item">
				        <label class="layui-form-label">{{ $model->labels['pid'] }}</label>
				        <div class="layui-input-block">
				            {!! App\Lib\Ehtml::select(App\Models\SysMenu::getAllMenuList(),$model->pid,['name'=>'spid','disabled'=>'disabled','id'=>'spid','style'=>'width:233px;']) !!}
				        </div>
				    </div>
				    <div class="layui-form-item">
				        <label class="layui-form-label">{{ $model->labels['menu_path'] }}</label>
				        <div class="layui-input-block">
				            <input type="text" value="{{ $model->menu_path }}" class="layui-input" name="page[menu_path]" id="menu_path">
				        </div>
				    </div>
				     <div class="layui-form-item">
				        <label class="layui-form-label">{{ $model->labels['remarks'] }}</label>
				        <div class="layui-input-block">
				            <input type="text" value="{{ $model->remarks }}" class="layui-input" name="page[remarks]" id="remarks">
				        </div>
				    </div>
				    <div class="layui-form-item">
				        <label class="layui-form-label">{{ $model->labels['order_id'] }}</label>
				        <div class="layui-input-block">
				            <input type="text" value="{{ $model->order_id }}" class="layui-input" name="page[order_id]" id="order_id">
				        </div>
				    </div>
				     <div class="layui-form-item">
				        <label class="layui-form-label">{{ $model->labels['menu_status'] }}</label>
				        <div class="layui-input-block">
				           {!! App\Lib\Ehtml::select(App\Lib\SysKey::getStatusList(),$model->menu_status,['name'=>'page[menu_status]','id'=>'menu_status']) !!}
				        </div>
				    </div>
				     <div class="layui-form-item">
				        <label class="layui-form-label">{{ $model->labels['group'] }}</label>
				        <div class="layui-input-block">
				           {!! App\Lib\Ehtml::select([0,1,2,3,4,5,6,7,8,9],$model->group,['name'=>'page[group]','id'=>'group']) !!}
				        </div>
				    </div>
				    <div class="layui-form-item">
				        <div class="layui-input-block">
				            <button id="btnSave" class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
				            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
				        </div>
				    </div>
				</div>
				
			</div>
		</div>
		</form>
	</div>
</fieldset>
<!-- 工具集 -->
@endsection
@section('bodyEnd')
<script>
	layui.use(['form'], function(){
		var form = layui.form;
});
</script>
@endsection
