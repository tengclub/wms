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
					<label class="layui-form-label">{{ $model->labels["id"] }}</label>
					<div class="layui-input-inline">
						<input type="text" id="id" name="id" value="{{$model->id}}"  autocomplete="off" class="layui-input">
					</div>
				</div>
<div class="layui-inline">
					<label class="layui-form-label">{{ $model->labels["type_id"] }}</label>
					<div class="layui-input-inline">
						<input type="text" id="type_id" name="type_id" value="{{$model->type_id}}"  autocomplete="off" class="layui-input">
					</div>
				</div>
<div class="layui-inline">
					<label class="layui-form-label">{{ $model->labels["type_id2"] }}</label>
					<div class="layui-input-inline">
						<input type="text" id="type_id2" name="type_id2" value="{{$model->type_id2}}"  autocomplete="off" class="layui-input">
					</div>
				</div>
<div class="layui-inline">
					<label class="layui-form-label">{{ $model->labels["flag"] }}</label>
					<div class="layui-input-inline">
						<input type="text" id="flag" name="flag" value="{{$model->flag}}"  autocomplete="off" class="layui-input">
					</div>
				</div>
<div class="layui-inline">
					<label class="layui-form-label">{{ $model->labels["channel_id"] }}</label>
					<div class="layui-input-inline">
						<input type="text" id="channel_id" name="channel_id" value="{{$model->channel_id}}"  autocomplete="off" class="layui-input">
					</div>
				</div>
<div class="layui-inline">
					<label class="layui-form-label">{{ $model->labels["status"] }}</label>
					<div class="layui-input-inline">
						<input type="text" id="status" name="status" value="{{$model->status}}"  autocomplete="off" class="layui-input">
					</div>
				</div>
<div class="layui-inline">
					<label class="layui-form-label">{{ $model->labels["click"] }}</label>
					<div class="layui-input-inline">
						<input type="text" id="click" name="click" value="{{$model->click}}"  autocomplete="off" class="layui-input">
					</div>
				</div>
<div class="layui-inline">
					<label class="layui-form-label">{{ $model->labels["money"] }}</label>
					<div class="layui-input-inline">
						<input type="text" id="money" name="money" value="{{$model->money}}"  autocomplete="off" class="layui-input">
					</div>
				</div>
<div class="layui-inline">
					<label class="layui-form-label">{{ $model->labels["title"] }}</label>
					<div class="layui-input-inline">
						<input type="text" id="title" name="title" value="{{$model->title}}"  autocomplete="off" class="layui-input">
					</div>
				</div>
<div class="layui-inline">
					<label class="layui-form-label">{{ $model->labels["short_title"] }}</label>
					<div class="layui-input-inline">
						<input type="text" id="short_title" name="short_title" value="{{$model->short_title}}"  autocomplete="off" class="layui-input">
					</div>
				</div>
<div class="layui-inline">
					<label class="layui-form-label">{{ $model->labels["color"] }}</label>
					<div class="layui-input-inline">
						<input type="text" id="color" name="color" value="{{$model->color}}"  autocomplete="off" class="layui-input">
					</div>
				</div>
<div class="layui-inline">
					<label class="layui-form-label">{{ $model->labels["writer"] }}</label>
					<div class="layui-input-inline">
						<input type="text" id="writer" name="writer" value="{{$model->writer}}"  autocomplete="off" class="layui-input">
					</div>
				</div>
<div class="layui-inline">
					<label class="layui-form-label">{{ $model->labels["source"] }}</label>
					<div class="layui-input-inline">
						<input type="text" id="source" name="source" value="{{$model->source}}"  autocomplete="off" class="layui-input">
					</div>
				</div>
<div class="layui-inline">
					<label class="layui-form-label">{{ $model->labels["lit_pic"] }}</label>
					<div class="layui-input-inline">
						<input type="text" id="lit_pic" name="lit_pic" value="{{$model->lit_pic}}"  autocomplete="off" class="layui-input">
					</div>
				</div>
<div class="layui-inline">
					<label class="layui-form-label">{{ $model->labels["pubdate"] }}</label>
					<div class="layui-input-inline">
						<input type="text" id="pubdate" name="pubdate" value="{{$model->pubdate}}"  autocomplete="off" class="layui-input">
					</div>
				</div>
<div class="layui-inline">
					<label class="layui-form-label">{{ $model->labels["member_user"] }}</label>
					<div class="layui-input-inline">
						<input type="text" id="member_user" name="member_user" value="{{$model->member_user}}"  autocomplete="off" class="layui-input">
					</div>
				</div>
<div class="layui-inline">
					<label class="layui-form-label">{{ $model->labels["keywords"] }}</label>
					<div class="layui-input-inline">
						<input type="text" id="keywords" name="keywords" value="{{$model->keywords}}"  autocomplete="off" class="layui-input">
					</div>
				</div>
<div class="layui-inline">
					<label class="layui-form-label">{{ $model->labels["scores"] }}</label>
					<div class="layui-input-inline">
						<input type="text" id="scores" name="scores" value="{{$model->scores}}"  autocomplete="off" class="layui-input">
					</div>
				</div>
<div class="layui-inline">
					<label class="layui-form-label">{{ $model->labels["good_post"] }}</label>
					<div class="layui-input-inline">
						<input type="text" id="good_post" name="good_post" value="{{$model->good_post}}"  autocomplete="off" class="layui-input">
					</div>
				</div>
<div class="layui-inline">
					<label class="layui-form-label">{{ $model->labels["bad_post"] }}</label>
					<div class="layui-input-inline">
						<input type="text" id="bad_post" name="bad_post" value="{{$model->bad_post}}"  autocomplete="off" class="layui-input">
					</div>
				</div>
<div class="layui-inline">
					<label class="layui-form-label">{{ $model->labels["vote_id"] }}</label>
					<div class="layui-input-inline">
						<input type="text" id="vote_id" name="vote_id" value="{{$model->vote_id}}"  autocomplete="off" class="layui-input">
					</div>
				</div>
<div class="layui-inline">
					<label class="layui-form-label">{{ $model->labels["is_not_post"] }}</label>
					<div class="layui-input-inline">
						<input type="text" id="is_not_post" name="is_not_post" value="{{$model->is_not_post}}"  autocomplete="off" class="layui-input">
					</div>
				</div>
<div class="layui-inline">
					<label class="layui-form-label">{{ $model->labels["description"] }}</label>
					<div class="layui-input-inline">
						<input type="text" id="description" name="description" value="{{$model->description}}"  autocomplete="off" class="layui-input">
					</div>
				</div>
<div class="layui-inline">
					<label class="layui-form-label">{{ $model->labels["file_name"] }}</label>
					<div class="layui-input-inline">
						<input type="text" id="file_name" name="file_name" value="{{$model->file_name}}"  autocomplete="off" class="layui-input">
					</div>
				</div>
<div class="layui-inline">
					<label class="layui-form-label">{{ $model->labels["tack_id"] }}</label>
					<div class="layui-input-inline">
						<input type="text" id="tack_id" name="tack_id" value="{{$model->tack_id}}"  autocomplete="off" class="layui-input">
					</div>
				</div>
<div class="layui-inline">
					<label class="layui-form-label">{{ $model->labels["weight"] }}</label>
					<div class="layui-input-inline">
						<input type="text" id="weight" name="weight" value="{{$model->weight}}"  autocomplete="off" class="layui-input">
					</div>
				</div>
<div class="layui-inline">
					<label class="layui-form-label">{{ $model->labels["lit_pic2"] }}</label>
					<div class="layui-input-inline">
						<input type="text" id="lit_pic2" name="lit_pic2" value="{{$model->lit_pic2}}"  autocomplete="off" class="layui-input">
					</div>
				</div>
<div class="layui-inline">
					<label class="layui-form-label">{{ $model->labels["content"] }}</label>
					<div class="layui-input-inline">
						<input type="text" id="content" name="content" value="{{$model->content}}"  autocomplete="off" class="layui-input">
					</div>
				</div>
<div class="layui-inline">
					<label class="layui-form-label">{{ $model->labels["create_time"] }}</label>
					<div class="layui-input-inline">
						<input type="text" id="create_time" name="create_time" value="{{$model->create_time}}"  autocomplete="off" class="layui-input">
					</div>
				</div>
<div class="layui-inline">
					<label class="layui-form-label">{{ $model->labels["create_user"] }}</label>
					<div class="layui-input-inline">
						<input type="text" id="create_user" name="create_user" value="{{$model->create_user}}"  autocomplete="off" class="layui-input">
					</div>
				</div>
<div class="layui-inline">
					<label class="layui-form-label">{{ $model->labels["update_time"] }}</label>
					<div class="layui-input-inline">
						<input type="text" id="update_time" name="update_time" value="{{$model->update_time}}"  autocomplete="off" class="layui-input">
					</div>
				</div>
<div class="layui-inline">
					<label class="layui-form-label">{{ $model->labels["update_user"] }}</label>
					<div class="layui-input-inline">
						<input type="text" id="update_user" name="update_user" value="{{$model->update_user}}"  autocomplete="off" class="layui-input">
					</div>
				</div>
<div class="layui-inline">
					<label class="layui-form-label">{{ $model->labels["templet_file"] }}</label>
					<div class="layui-input-inline">
						<input type="text" id="templet_file" name="templet_file" value="{{$model->templet_file}}"  autocomplete="off" class="layui-input">
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
		<a class="layui-btn btn-add btn-default layui-btn-small" id="btn-add" href="{{ URL('admin/news/create') }}">添加</a>
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
		,url: "{{ url("admin/sysGroup/ajaxData") }}?"+$("form").serialize()
		, cols: [[ 
			{field: "id", title: "ID", width: 80, sort: true ,checkbox: true, }
			, {field: "group_name", title: "名称", width: 120, sort: true}
			, {field: "group_status", title: "状态", width: 180}
			, {field: "remark", title: "备注", width: 180}
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
			layer.msg("编辑操作");
			window.location.href="{{ url("admin/sysGroup/edit/") }}/"+data.id;
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
    	