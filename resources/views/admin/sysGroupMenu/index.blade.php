@extends('layouts.mainBody')
@section('bodyOption')
	class="body"
@endsection
@section('content')
<fieldset class="layui-elem-field">
	<legend>检索</legend>
	<div class="layui-field-box">
		<form class="layui-form" action="{{ Request::getRequestUri() }}">
    			<input type="hide" name="__data" value="json">
			<div class="layui-form-item">
				
    			<div class="layui-inline">
					<label class="layui-form-label">{{ $model->labels["id"] }}</label>
					<div class="layui-input-inline">
						<input type="text" id="id" name="id" value="{{$model->id}}"  autocomplete="off" class="layui-input">
					</div>
				</div>

    			<div class="layui-inline">
					<label class="layui-form-label">{{ $model->labels["group_id"] }}</label>
					<div class="layui-input-inline">
						<input type="text" id="group_id" name="group_id" value="{{$model->group_id}}"  autocomplete="off" class="layui-input">
					</div>
				</div>

    			<div class="layui-inline">
					<label class="layui-form-label">{{ $model->labels["menu_id"] }}</label>
					<div class="layui-input-inline">
						<input type="text" id="menu_id" name="menu_id" value="{{$model->menu_id}}"  autocomplete="off" class="layui-input">
					</div>
				</div>

    			<div class="layui-inline">
					<label class="layui-form-label">{{ $model->labels["remarks"] }}</label>
					<div class="layui-input-inline">
						<input type="text" id="remarks" name="remarks" value="{{$model->remarks}}"  autocomplete="off" class="layui-input">
					</div>
				</div>

				<div class="layui-inline">
					<button class="layui-btn  layui-btn-small" lay-submit="" ><i class="layui-icon">&#xe615;</i></button>
				</div>
			</div>
		</form>
	</div>
</fieldset>
<!-- 工具集 -->
<div class="my-btn-box">
	<span class="fl">
		<a class="layui-btn layui-btn-danger radius btn-delect layui-btn-small" id="btn-delete-all">批量删除</a>
		<a class="layui-btn btn-add btn-default layui-btn-small" id="btn-add" href="{{ URL('admin/sysGroupMenu/create') }}">添加</a>
		<a class="layui-btn btn-add btn-default layui-btn-small" id="btn-refresh"><i class="layui-icon">&#x1002;</i></a>
	</span>
</div>
<table id="dataTable" lay-filter="dataTable"></table>
<script type="text/html" id="barOption">
	<a lay-event="edit" title="编辑">&nbsp;<i class="layui-icon">&#xe642;</i>&nbsp;&nbsp;</a>
	<a lay-event="del" title="删除"><i class="layui-icon">&#xe640;</i></a>
</script>
@endsection

@section('bodyEnd')
<script>
layui.use("table", function(){
	var table = layui.table;
	var tableIns = table.render({ //其它参数在此省略
		elem: "#dataTable"//指定原始表格元素选择器（推荐id选择器）
		,url: "?__data=json&"+$("form").serialize()
		, cols: [[ 
				{field: "id", title: "ID", width: 80, sort: true ,checkbox: true, }

,{field: "group_id", title: "{{ $model->labels["group_id"] }}",  sort: true}
,{field: "menu_id", title: "{{ $model->labels["menu_id"] }}",  sort: true}
,{field: "remarks", title: "{{ $model->labels["remarks"] }}",  sort: true}
			, {fixed: "right", title: "操作", width: 150, align: "center", toolbar: "#barOption"} //这里的toolbar值是模板元素的选择器
		]]
		,size: "sm" 
		, id: "id"
		, method: "get"
		, page: true
		, limits: [10, 20, 30, 40, 50,100,200]
		, limit: 10 
		, loading: true
		, done: function (res, curr, count) {
		}
	}); 
	table.on("sort(dataTable)", function(obj){ //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
	  //尽管我们的 table 自带排序功能，但并没有请求服务端。
	  //有些时候，你可能需要根据当前排序的字段，重新向服务端发送请求，如：
		tableIns.reload({
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
					url: "{{URL("admin/sysGroupMenu/ajaxDestroy")}}/"+data.id, 
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
			layer.msg("编辑操作");
			window.location.href="{{ url("admin/sysGroupMenu/edit/") }}/"+data.id;
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
			url: "{{URL("admin/sysGroupMenu/ajaxDestroy")}}/"+ids, 
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
    	