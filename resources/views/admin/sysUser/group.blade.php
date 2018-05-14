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
					<label class="layui-form-label">{{ $model->labels["user"] }}</label>
					<div class="layui-input-inline">
						<input type="text" id="user" name="user" value="{{$model->user}}"  autocomplete="off" class="layui-input">
					</div>
				</div>
				<div class="layui-inline">
					<button class="layui-btn  layui-btn-small" lay-submit="" ><i class="layui-icon">&#xe615;</i></button>
					<a class="layui-btn btn-add btn-default layui-btn-small" id="btn-add" href="###">添加</a>
				</div>
			</div>
		</form>
	</div>
</fieldset>

<table id="dataTable" lay-filter="dataTable"></table>
<script type="text/html" id="barOption">
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
			{field: "user", title: "ID", width: 80, sort: true ,checkbox: true, }
			, {field: "user", title: "{{ $model->labels['user'] }}", width: 120, sort: true}
			, {field: "level_text", title: "{{ $model->labels['level'] }}", width: 80}
			, {field: "user_status_text", title: "{{ $model->labels['user_status'] }}", width: 80}
// 			, {field: "remark", title: "备注", width: 180}
// 			, {fixed: "right", title: "操作", width: 150, align: "center", toolbar: "#barOption"} //这里的toolbar值是模板元素的选择器
		]]
		,size: "sm" 
		, id: "id"
		, method: "get"
		, page: true
		, limits: [5]
		, limit: 5 
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


	// 添加
	$("#btn-add").on("click", function () {
		var checkStatus = table.checkStatus("id");
		var chkValue =[];
		$.each(checkStatus.data, function(){
			chkValue.push(this.id);
		})
		var users = chkValue.join(",");
		var postData = {gid:'{{$gid}}',users:users,_token:'{{ csrf_token() }}'};
		$.ajax({ 
			type: "POST",
			url: "{{URL("admin/sysGroupUser/ajaxAddUser")}}", 
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

