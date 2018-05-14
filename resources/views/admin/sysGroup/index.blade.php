@extends('layouts.mainBody')
@section('bodyOption')
	class="body"
@endsection
@section('content')
<fieldset class="layui-elem-field">
	<legend>检索</legend>
	<div class="layui-field-box">
		<form class="layui-form" action="{{ Request::getRequestUri() }}">
			<div class="layui-form-item">
				<div class="layui-inline">
					<label class="layui-form-label">{{ $model->labels["group_name"] }}</label>
					<div class="layui-input-inline">
						<input type="text" id="group_name" name="group_name" value="{{$model->group_name}}"  autocomplete="off" class="layui-input layui-btn-sm">
					</div>
					<button class="layui-btn " lay-submit="" ><i class="layui-icon">&#xe615;</i></button>
				</div>
			</div>
		</form>
	</div>
</fieldset>
<!-- 工具集 -->
<div class="my-btn-box">
	<span class="fl">
		<a class="layui-btn layui-btn-danger radius btn-delect  layui-btn-sm" id="btn-delete-all">批量删除</a>
		<a class="layui-btn btn-add btn-default layui-btn-sm" id="btn-add" href="{{ url('admin/sysGroup/create') }}">添加</a>
		<a class="layui-btn btn-add btn-default layui-btn-sm" id="btn-refresh"><i class="layui-icon">&#x1002;</i></a>
	</span>
</div>
<table id="dataTable" lay-filter="dataTable"></table>
<script type="text/html" id="barOption">
	<a lay-event="edit" title="编辑">&nbsp;<i class="layui-icon">&#xe642;</i>&nbsp;&nbsp;</a>
	<a lay-event="del" title="删除"><i class="layui-icon">&#xe640;</i></a>
</script>
<script type="text/html" id="barShowUser">
	<a lay-event="user" title="查看用户">查看</a>
</script>
<script type="text/html" id="barShowMenu">
	<a lay-event="menu" title="查看菜单">查看</a>
</script>
<script type="text/html" id="barOrderStatus">
	<a lay-event="order-status" title="查看权限">查看</a>
</script>
<script type="text/html" id="barWapMenu">
	<a lay-event="wap-menu" title="wap菜单">查看</a>
</script>
@endsection

@section('bodyEnd')
<script>
layui.use("table", function(){
	var table = layui.table;
	var tableIns = table.render({ //其它参数在此省略
		elem: "#dataTable"//指定原始表格元素选择器（推荐id选择器）
		,url: "{{ url("admin/sysGroup/ajaxData") }}?"+$("form").serialize()
		, cols: [[ 
			{field: "id", title: "ID", width: 80, sort: true ,checkbox: true, }
			, {field: "group_name", title: "名称", width: 120, sort: true}
			, {field: "group_status_text", title: "状态", width: 180}
			, {field: "remark", title: "备注", width: 180}
			, {field: "right", title: "菜单", width: 80, align: "center", toolbar: "#barShowMenu"}
			, {field: "right", title: "用户", width: 80, align: "center", toolbar: "#barShowUser"}
			, {field: "right", title: "订单审核权", width: 120, align: "center", toolbar: "#barOrderStatus"}
			, {field: "right", title: "wap菜单", width: 120, align: "center", toolbar: "#barWapMenu"}
			, {fixed: "right", title: "操作", width: 150, align: "center", toolbar: "#barOption"} //这里的toolbar值是模板元素的选择器
		]]
		,size: "sm" 
		, id: "id"
		, method: "get"
		, page: true
		, limits: [10, 60, 90, 150, 300]
		, limit: 10 
		, loading: true
		, done: function (res, curr, count) {
		}
	}); 
	table.on("sort(dataTable)", function(obj){ //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
	  //尽管我们的 table 自带排序功能，但并没有请求服务端。
	  //有些时候，你可能需要根据当前排序的字段，重新向服务端发送请求，如：
		table.reload("dataTable", {
			initSort: obj //记录初始排序，如果不设的话，将无法标记表头的排序状态。 layui 2.1.1 新增参数
			,where: { //请求参数
				field: obj.field //排序字段
				,order: obj.type //排序方式
			}
		});
	});
	//监听工具条
	table.on("tool(dataTable)", function(obj){ //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
		var data = obj.data //获得当前行数据
		,layEvent = obj.event; //获得 lay-event 对应的值
		if(layEvent === "del"){
			layer.confirm("真的删除吗？", function(index){
	        	//向服务端发送删除指令
				$.ajax({ 
					type: "GET",
					url: "{{URL("admin/sysGroup/ajaxDestroy")}}/"+data.id, 
					dataType: "json",
					success: function(data){
						if(data.code=="000")
						{
							obj.del(); //删除对应行（tr）的DOM结构
							layer.close(index);
						}
						 layer.msg(data.msg);
			      	}
				});
			});
		} else if(layEvent === "edit"){
// 			layer.msg("编辑操作");
			window.location.href="{{ url("admin/sysGroup/edit/") }}/"+data.id;
		} else if(layEvent === "user"){
			window.location.href="{{ url("admin/sysGroupUser/index") }}/"+data.id;
		} else if(layEvent === "order-status"){
			window.location.href="{{ url("admin/sysGroupOrderStatus/index") }}/"+data.id;
		} else if(layEvent === "wap-menu"){
			window.location.href="{{ url("admin/sysGroupWapMenu/index") }}/"+data.id;
		} else if(layEvent === "menu"){
			window.location.href="{{ url("admin/sysGroupMenu/adminTree") }}/"+data.id;
				
// 			//iframe层-禁滚动条
// 			layer.open({
// 			  type: 2,
// 			  area: ['360px', '500px'],
// 			  skin: 'layui-layer-rim', //加上边框
// 			  content: ['http://www.baidu.com', 'no']
// 			});
		}
	});
	// 刷新
	$("#btn-refresh").on("click", function () {
		tableIns.reload();
	});
	// 批量删除
	$("#btn-delete-all").on("click", function () {
		var checkStatus = table.checkStatus("id");
		var chkValue =[];
		$.each(checkStatus.data, function(){
			chkValue.push(this.id);
		})
		var ids = chkValue.join(",");
		$.ajax({ 
			type: "GET",
			url: "{{URL("admin/sysGroup/ajaxDestroy")}}/"+ids, 
			dataType: "json",
			success: function(data){
				if(data.code=="000")
				{
					 tableIns.reload();
				}
				layer.msg(data.msg);
			}
		});
    });
});
</script>
@endsection
