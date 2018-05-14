@extends('layouts.mainBody')
@section('hf') 
	<link rel="stylesheet" href="{{ asset('/plug-in/zTree_v3/css/zTreeStyle/zTreeStyle.css') }}" type="text/css">
	<script type="text/javascript" src="{{ asset('/plug-in/zTree_v3/js/jquery.ztree.core.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/plug-in/zTree_v3/js/jquery.ztree.excheck.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/plug-in/zTree_v3/js/jquery.ztree.exedit.js') }}"></script>
@endsection 
@section('jq') 
	$("#btn-add").click(function(){
	var treeObj = $.fn.zTree.getZTreeObj("tree");
		var nodes = treeObj.getChangeCheckedNodes();
		var mids = '0';
		$.each(nodes, function(i,node){
			mids = mids+','+node.id;
	    }); 
		if(mids.length<1)
		{
			layer.msg('请选择相应记录');
			return false;
		}else{
			var postData = {gid:'{{$gid}}',mids:mids,_token:'{{ csrf_token() }}'};
			$.ajax({ 
				type: 'POST',
				url: '{{ URL('admin/sysGroupMenu/ajaxAddMenu') }}', 
				dataType: 'json',
				data:postData,
				success: function(obj){
					if(obj.code=='000')
					{
						layer.msg(obj.msg, {icon: 1});
						parent.location.reload();
					}else{
						layer.msg(obj.msg, {icon: 2});
					}
		      	}
	      	});
		}
		
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
				chkboxType :{ "Y" : "ps", "N" : "ps" }
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
	<legend>菜单</legend>
	<div class="layui-field-box">
		<div class="my-btn-box">
			<span class="fl">
				<a class="layui-btn btn-add btn-default layui-btn-sm" id="btn-add">添加</a>
			</span>
		</div>
		<div class="ztree" id="tree" style="width: 300px; height:250px; float:left; border-right:1px solid #ccc;overflow-y: auto;"></div>
	</div>
</fieldset>
@section('bodyEnd')
<script>
	layui.use(['form'], function(){
		var form = layui.form;
});
</script>
@endsection
<!-- 工具集 -->
@endsection
