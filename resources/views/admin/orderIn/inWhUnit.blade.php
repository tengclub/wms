@extends('layouts.mainBody')
@section('bodyOption')
	class="body"
@endsection
@section('content')
<fieldset class="layui-elem-field">
	<legend>入库订单</legend>
	<div class="layui-field-box">
			<div class="layui-form-item">
			 <div class="layui-col-md4">{{ $order->labels["order_no"] }}:{{ $order->order_no }}</div>
			 <div class="layui-col-md4">{{ $items->labels["title"] }}:{{ $items->title }}</div>
			 <div class="layui-col-md4">{{ $order->labels["wh_items_quantity"] }}:{{ $order->wh_items_quantity }}</div>
			</div>
	</div>
</fieldset>
<fieldset class="layui-elem-field">
	<legend>检索</legend>
	<div class="layui-field-box">
		<form class="layui-form" action="{{ Request::getRequestUri() }}">
    		<input type="hidden" name="orderId" value="{{ $orderId }}">
			<div class="layui-form-item">
		        <label class="layui-form-label"  style="display: none">{{ $model->labels['warehouse_id'] }}</label>
		        <div class="layui-input-inline" style="display: none">
		        	{!! App\Lib\Ehtml::select(App\Models\Warehouse::getIdListByAll(),$model->warehouse_id,['name'=>'warehouse_id','id'=>'warehouse_id','lay-filter'=>'warehouse_id','class'=>'form-control']) !!}
		        	{{ str_replace('warehouse_id',$model->labels['warehouse_id'],$model->errors->first('warehouse_id') ) }}
		        </div>
		        <label class="layui-form-label">{{ $model->labels['wh_area_id'] }}</label>
		        <div class="layui-input-inline">
		            {!! App\Lib\Ehtml::select(App\Models\WhArea::getIdList(),$model->wh_area_id,['name'=>'wh_area_id','id'=>'wh_area_id','lay-filter'=>'wh_area_id','class'=>'form-control']) !!}
		        	{{ str_replace('wh_area_id',$model->labels['wh_area_id'],$model->errors->first('wh_area_id') ) }}
		        </div>
		         <label class="layui-form-label">{{ $model->labels['wh_shelf_id'] }}</label>
		        <div class="layui-input-inline">
		        	 {!! App\Lib\Ehtml::select(App\Models\WhShelf::getIdList(),$model->wh_shelf_id,['name'=>'wh_shelf_id','id'=>'wh_shelf_id','lay-filter'=>'wh_shelf_id','class'=>'form-control']) !!}
		        	{{ str_replace('wh_shelf_id',$model->labels['wh_shelf_id'],$model->errors->first('wh_shelf_id') ) }}
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
		<a class="layui-btn layui-btn-primary layui-btn-sm" href="{{ url('admin/orderIn/index') }}"><i class="fa fa-mail-reply"></i> 返回</a>
		<a class="layui-btn layui-btn-danger radius btn-delect layui-btn-sm" id="btn-delete-all">批量删除</a>
		<a class="layui-btn btn-add btn-default layui-btn-sm" id="btn-add" href="{{ URL('admin/whUnit/create') }}">添加</a>
		<a class="layui-btn btn-add btn-default layui-btn-sm" id="btn-refresh"><i class="layui-icon">&#x1002;</i></a>
		
	</span>
</div>
<table id="dataTable" lay-filter="dataTable"></table>
<script type="text/html" id="barOption">
	<a lay-event="edit" title="编辑">&nbsp;<i class="layui-icon">&#xe642;</i>&nbsp;&nbsp;</a>
	<a lay-event="del" title="删除"><i class="layui-icon">&#xe640;</i></a>
</script>
<script type="text/html" id="setIn">
 [{{'{'.'{'.'d.wh_items_num'.'}'.'}'}}] &nbsp;&nbsp;<span class="layui-badge">点击入库</span>
</script>
@endsection

@section('bodyEnd')
<script>
layui.use("table", function(){
	var table = layui.table;
	var tableIns = table.render({ //其它参数在此省略
		elem: "#dataTable"//指定原始表格元素选择器（推荐id选择器）
		,url: "?orderId={{ $orderId }}&__data=json&"+$("form").serialize()
		, cols: [[ 
{field: "warehouse_text", title: "{{ $model->labels["warehouse_id"] }}",  sort: true}
,{field: "wh_area_text", title: "{{ $model->labels["wh_area_id"] }}",  sort: true}
,{field: "wh_shelf_text", title: "{{ $model->labels["wh_shelf_id"] }}",  sort: true}
,{field: "code", title: "仓位编码",  sort: true}
,{field: "title", title: "{{ $model->labels["title"] }}",  sort: true}
,{field: "status_text", title: "{{ $model->labels["status"] }}",  sort: true}
,{field: "volume", title: "{{ $model->labels["volume"] }}",  sort: true}
,{field: "wh_items_text", title: "{{ $model->labels["wh_items_id"] }}",event: 'setIn', sort: true}
,{field: "wh_items_num", title: "{{ $model->labels["wh_items_num"] }}", event: 'setIn', templet: '#setIn',   sort: true}
// 			, {fixed: "right", title: "操作", width: 150, align: "center", toolbar: "#barOption"} //这里的toolbar值是模板元素的选择器
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
		if(layEvent === "setIn"){
			layer.open({
				  type: 2,
				  area: ['550px', '430px'],
				  skin: 'layui-layer-rim', //加上边框
				  content: ['{{ url("admin/orderIn/setInUnit") }}?orderId={{$orderId}}&unitId='+data.id, 'no']
				});
// 		} else if(layEvent === "edit"){
// 			layer.msg("编辑操作");
// 			window.location.href="{{ url("admin/whUnit/edit/") }}/"+data.id;
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
			url: "{{URL("admin/whUnit/ajaxDestroy")}}/"+ids, 
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
    	