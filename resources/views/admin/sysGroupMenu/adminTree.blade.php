@extends('layouts.mainBody')
@section('hf') 
	<link rel="stylesheet" href="{{ asset('/plug-in/zTree_v3/css/zTreeStyle/zTreeStyle.css') }}" type="text/css">
	<script type="text/javascript" src="{{ asset('/plug-in/zTree_v3/js/jquery.ztree.core.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/plug-in/zTree_v3/js/jquery.ztree.excheck.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/plug-in/zTree_v3/js/jquery.ztree.exedit.js') }}"></script>
@endsection 
@section('jq') 
	$("#btn-add").click(function(){
	//iframe层-禁滚动条
		layer.open({
		  type: 2,
		  area: ['550px', '430px'],
		  skin: 'layui-layer-rim', //加上边框
		  content: ['{{ url("admin/sysMenu/gridGroupTree",['gid'=>$group->id]) }}']
		});
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
				url: '{{URL('admin/sysGroupMenu/ajaxDestroy')}}/'+ids, 
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
	
@endsection() 
@section('js') 

		var setting = {
			data: {
				simpleData: {
					enable: true
				}
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
	
@endsection() 
@section('bodyOption')
	class="body"
@endsection
@section('content')
<fieldset class="layui-elem-field">
	<legend>{{ $group->group_name }} - 菜单</legend>
	<div class="layui-field-box">
		<div class="my-btn-box">
			<span class="fl">
			<a class="layui-btn  layui-btn-primary layui-btn-sm" id="btn-return" href="{{ URL('admin/sysGroup/index') }}">返回</a>
				<a class="layui-btn btn-add btn-default layui-btn-sm" id="btn-add">添加</a>
				<a class="layui-btn layui-btn-danger radius btn-delect layui-btn-sm" id="btn-delete">删除</a>
				<a class="layui-btn btn-add btn-default layui-btn-sm" id="btn-refresh"><i class="layui-icon">&#x1002;</i></a>
			</span>
		</div>
		<div class="ztree" id="tree" style="width: 300px; height:405px; float:left; border-right:1px solid #ccc;overflow-y: auto;"></div>
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
