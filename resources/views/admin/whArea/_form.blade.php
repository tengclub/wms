<blockquote class="layui-elem-quote layui-text">
</blockquote>
<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
	<legend>仓库区域</legend>
</fieldset>

<form class="layui-form" action="{{ Request::getRequestUri() }}"  method="POST" enctype="multipart/form-data">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
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
	<div class="layui-form-item" style="display: none">
        <label class="layui-form-label">{{ $model->labels['warehouse_id'] }}</label>
        <div class="layui-input-block">
        	{!! App\Lib\Ehtml::select(App\Models\Warehouse::getIdListByAll(),$model->warehouse_id,['name'=>'page[warehouse_id]','id'=>'warehouse_idwarehouse_id','lay-filter'=>'warehouse_id','class'=>'form-control']) !!}
        	{{ str_replace('warehouse_id',$model->labels['warehouse_id'],$model->errors->first('warehouse_id') ) }}
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
	<div class="layui-form-item">
       
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
            <a class="layui-btn  layui-btn-primary" id="btn-add" href="{{ URL('admin/whArea/index') }}">返回</a>
        </div>
    </div>
</form>
@section('bodyEnd')
<script>
	layui.use(['form'], function(){
		var form = layui.form;
});
</script>
@endsection