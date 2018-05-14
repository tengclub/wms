<blockquote class="layui-elem-quote layui-text">
</blockquote>
<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
	<legend>仓库</legend>
</fieldset>

<form class="layui-form" action="{{ Request::getRequestUri() }}"  method="POST" enctype="multipart/form-data">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['title'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->title }}" name="page[title]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['title'] }}" class="layui-input">
        	{{ str_replace('title',$model->labels['title'],$model->errors->first('title') ) }}
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
        <label class="layui-form-label">{{ $model->labels['contacts'] }}</label>
        <div class="layui-input-inline">
            <input type="text"  value="{{ $model->contacts }}" name="page[contacts]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['contacts'] }}" class="layui-input">
        	{{ str_replace('contacts',$model->labels['contacts'],$model->errors->first('contacts') ) }}
        </div>
        <label class="layui-form-label">{{ $model->labels['tel'] }}</label>
        <div class="layui-input-inline">
            <input type="text"  value="{{ $model->tel }}" name="page[tel]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['tel'] }}" class="layui-input">
        	{{ str_replace('tel',$model->labels['tel'],$model->errors->first('tel') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['region_province_province_id'] }}</label>
        <div class="layui-input-inline">
        	{!! App\Lib\Ehtml::select(App\Models\RegionProvince::getListAll(),$model->region_province_province_id,['name'=>'page[region_province_province_id]','id'=>'region_province_province_id','lay-filter'=>'region_province_province_id','class'=>'form-control']) !!}
        	{{ str_replace('region_province_province_id',$model->labels['region_province_province_id'],$model->errors->first('region_province_province_id') ) }}
        </div>
         <label class="layui-form-label">{{ $model->labels['region_city_city_id'] }}</label>
        <div class="layui-input-inline">
        	{!! App\Lib\Ehtml::select(App\Models\RegionCity::getListByProvinceId(),$model->region_city_city_id,['name'=>'page[region_city_city_id]','id'=>'region_city_city_id','lay-filter'=>'region_city_city_id','class'=>'form-control']) !!}
        	{{ str_replace('region_city_city_id',$model->labels['region_city_city_id'],$model->errors->first('region_city_city_id') ) }}
        </div>
          <label class="layui-form-label">{{ $model->labels['region_area_area_id'] }}</label>
        <div class="layui-input-inline">
        	{!! App\Lib\Ehtml::select(App\Models\RegionArea::getListByCityId(),$model->region_area_area_id,['name'=>'page[region_area_area_id]','id'=>'region_area_area_id','lay-filter'=>'region_area_area_id','class'=>'form-control']) !!}
        	{{ str_replace('region_area_area_id',$model->labels['region_area_area_id'],$model->errors->first('region_area_area_id') ) }}
        </div> 
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['address'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->address }}" name="page[address]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['address'] }}" class="layui-input">
        	{{ str_replace('address',$model->labels['address'],$model->errors->first('address') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['lon'] }}</label>
        <div class="layui-input-inline">
            <input type="text"  value="{{ $model->lon }}" name="page[lon]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['lon'] }}" class="layui-input">
        	{{ str_replace('lon',$model->labels['lon'],$model->errors->first('lon') ) }}
        </div>
          <label class="layui-form-label">{{ $model->labels['lat'] }}</label>
        <div class="layui-input-inline">
            <input type="text"  value="{{ $model->lat }}" name="page[lat]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['lat'] }}" class="layui-input">
        	{{ str_replace('lat',$model->labels['lat'],$model->errors->first('lat') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['start_time'] }}</label>
        <div class="layui-input-inline">
            <input type="text"  value="{{ $model->start_time }}" name="page[start_time]" id="start_time" lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['start_time'] }}" class="layui-input">
        	{{ str_replace('start_time',$model->labels['start_time'],$model->errors->first('start_time') ) }}
        </div>
        <label class="layui-form-label">{{ $model->labels['end_time'] }}</label>
        <div class="layui-input-inline">
            <input type="text"  value="{{ $model->end_time }}" name="page[end_time]" id="end_time" lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['end_time'] }}" class="layui-input">
        	{{ str_replace('end_time',$model->labels['end_time'],$model->errors->first('end_time') ) }}
        </div>
    </div>
	
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['remark'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->remark }}" name="page[remark]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['remark'] }}" class="layui-input">
        	{{ str_replace('remark',$model->labels['remark'],$model->errors->first('remark') ) }}
        </div>
    </div>
    
	<div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            <a class="layui-btn  layui-btn-primary" id="btn-add" href="{{ URL('admin/warehouse/index') }}">返回</a>
        </div>
    </div>
</form>
@section('bodyEnd')
<script>
	layui.use(['form','laydate'], function(){
		var form = layui.form;
		form.on('select(region_province_province_id)', function(data){
			loadDataCity();
		});
		form.on('select(region_city_city_id)', function(data){
			loadDataArea();
		});
		function loadDataCity(){  
		 	$.ajax({ 
				type: 'GET',
				url: '{{URL('util/ajaxCitySelect')}}/'+$("#region_province_province_id").val(), 
				dataType: 'text',
				data:null,
				success: function(obj){
					$("#region_city_city_id").html(obj);
					form.render('select');
					//区县
					loadDataArea();
		      	}
	      	});
			return false;
		 }
		function loadDataArea(){  
			//区县
			$.ajax({ 
				type: 'GET',
				url: '{{URL('util/ajaxAreaSelect')}}/'+$("#region_city_city_id").val(), 
				dataType: 'text',
				data:null,
				success: function(obj){
					$("#region_area_area_id").html(obj);
					form.render('select');
		      	}
	      	});
			return false;
		 }
		@if(!$model->id)
			loadDataCity();	
		@endif
		  //时间选择器
	var laydate = layui.laydate;
	laydate.render({
		elem: '#start_time'
		,type: 'time'
	});
	laydate.render({
		elem: '#end_time'
		,type: 'time'
	});
});
</script>
@endsection