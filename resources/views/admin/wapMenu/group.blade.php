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
					<label class="layui-form-label">{{ $model->labels["menu_name"] }}</label>
					<div class="layui-input-inline">
						<input type="text" id="menu_name" name="menu_name" value="{{$model->menu_name}}"  autocomplete="off" class="layui-input">
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
		<a class="layui-btn btn-add btn-default layui-btn-sm" id="btn-add" href="###">添加</a>
		<a class="layui-btn btn-add btn-default layui-btn-sm" id="btn-refresh"><i class="layui-icon">&#x1002;</i></a>
	</span>
</div>
<table id="dataTable" lay-filter="dataTable"></table>
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

,{field: "menu_name", title: "{{ $model->labels["menu_name"] }}",  sort: true}
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
					url: "{{URL("admin/wapMenu/ajaxDestroy")}}/"+data.id, 
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
			window.location.href="{{ url("admin/wapMenu/edit/") }}/"+data.id;
		}
	});
	// 刷新
	$("#btn-refresh").on("click", function () {
		tableIns.reload();
	});
	// 添加
	$("#btn-add").on("click", function () {
		var checkStatus = table.checkStatus("id");
		var chkValue =[];
		$.each(checkStatus.data, function(){
			chkValue.push(this.id);
		})
		var menu = chkValue.join(",");
		var postData = {gid:'{{$gid}}',menu:menu,_token:'{{ csrf_token() }}'};
		$.ajax({ 
			type: "POST",
			url: "{{URL("admin/sysGroupWapMenu/ajaxAdd")}}", 
			dataType: "json",
			data:postData,
			success: function(data){
				layer.msg(data.msg, function(){
					parent.location.reload();
				});
			}
		});
    });

});
</script>
@endsection
    	