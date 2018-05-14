<blockquote class="layui-elem-quote layui-text">
</blockquote>
<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
	<legend>货架</legend>
</fieldset>

<form class="layui-form" action="{{ Request::getRequestUri() }}"  method="POST" enctype="multipart/form-data">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="layui-form-item">
        <label class="layui-form-label" style="display: none">{{ $model->labels['warehouse_id'] }}</label>
        <div class="layui-input-inline" style="display: none">
        	{!! App\Lib\Ehtml::select(App\Models\Warehouse::getIdListByAll(),$model->warehouse_id,['name'=>'page[warehouse_id]','id'=>'warehouse_id','lay-filter'=>'warehouse_id','class'=>'form-control']) !!}
        	{{ str_replace('warehouse_id',$model->labels['warehouse_id'],$model->errors->first('warehouse_id') ) }}
        </div>
         <label class="layui-form-label">{{ $model->labels['wh_area_id'] }}</label>
        <div class="layui-input-inline">
            {!! App\Lib\Ehtml::select(App\Models\WhArea::getIdList(),$model->wh_area_id,['name'=>'page[wh_area_id]','id'=>'wh_area_id','lay-filter'=>'wh_area_id','class'=>'form-control']) !!}
        	{{ str_replace('wh_area_id',$model->labels['wh_area_id'],$model->errors->first('wh_area_id') ) }}
        </div>
    </div>
    
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['code'] }}</label>
        <div class="layui-input-inline">
           {!! App\Lib\Ehtml::select(App\Lib\SysKey::getWhCode1List(),$model->code,['name'=>'page[code]','class'=>'form-control']) !!}
        	{{ str_replace('code',$model->labels['code'],$model->errors->first('code') ) }}
        </div>
         <label class="layui-form-label">{{ $model->labels['status'] }}</label>
        <div class="layui-input-inline">
        	{!! App\Lib\Ehtml::select(App\Lib\SysKey::getStatusList(),$model->status,['name'=>'page[status]','id'=>'status','lay-filter'=>'status','class'=>'form-control']) !!}
        	{{ str_replace('status',$model->labels['status'],$model->errors->first('status') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['title'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->title }}" name="page[title]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['title'] }}" class="layui-input">
        	{{ str_replace('title',$model->labels['title'],$model->errors->first('title') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['volume'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->volume }}" name="page[volume]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['volume'] }}" class="layui-input">
        	{{ str_replace('volume',$model->labels['volume'],$model->errors->first('volume') ) }}
        </div>
    </div>
<!-- 	<div class="layui-form-item"> -->
<!--         <label class="layui-form-label">{{ $model->labels['type'] }}</label> -->
<!--         <div class="layui-input-block"> -->
<!--             <input type="text"  value="{{ $model->type }}" name="page[type]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['type'] }}" class="layui-input"> -->
<!--         	{{ str_replace('type',$model->labels['type'],$model->errors->first('type') ) }} -->
<!--         </div> -->
<!--     </div> -->
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['length'] }}</label>
        <div class="layui-input-inline">
            <input type="text"  value="{{ $model->length }}" name="page[length]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['length'] }}" class="layui-input">
        	{{ str_replace('length',$model->labels['length'],$model->errors->first('length') ) }}
        </div>
        <label class="layui-form-label">{{ $model->labels['width'] }}</label>
        <div class="layui-input-inline">
            <input type="text"  value="{{ $model->width }}" name="page[width]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['width'] }}" class="layui-input">
        	{{ str_replace('width',$model->labels['width'],$model->errors->first('width') ) }}
        </div>
        <label class="layui-form-label">{{ $model->labels['height'] }}</label>
        <div class="layui-input-inline">
            <input type="text"  value="{{ $model->height }}" name="page[height]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['height'] }}" class="layui-input">
        	{{ str_replace('height',$model->labels['height'],$model->errors->first('height') ) }}
        </div>
    </div>
    
	<div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            <a class="layui-btn  layui-btn-primary" id="btn-add" href="{{ URL('admin/whShelf/index') }}">返回</a>
        </div>
    </div>
</form>
@section('bodyEnd')
<script>
	layui.use(['form'], function(){
		var form = layui.form;
		form.on('select(warehouse_id)', function(data){
			loadDataArea();
		});
		function loadDataArea(){  
		 	$.ajax({ 
				type: 'GET',
				url: '{{URL('util/ajaxWhAreaSelect')}}/'+$("#warehouse_id").val(), 
				dataType: 'text',
				data:null,
				success: function(obj){
					$("#wh_area_id").html(obj);
					form.render('select');
		      	}
	      	});
			return false;
		 }

		@if(!$model->id)
			loadDataArea();	
		@endif
});
</script>
@endsection