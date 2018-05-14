<blockquote class="layui-elem-quote layui-text">
</blockquote>
<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
	<legend>货物</legend>
</fieldset>

<form class="layui-form" action="{{ Request::getRequestUri() }}"  method="POST" enctype="multipart/form-data">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	  <div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['code'] }}</label>
        <div class="layui-input-inline">
            <input type="text"  value="{{ $model->code }}" name="page[code]" id="code"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['code'] }}" class="layui-input">
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
        <label class="layui-form-label">{{ $model->labels['img1'] }}</label>
        <div class="layui-input-block">
            <input type="file"  value="{{ $model->img1 }}" name="img1"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['img1'] }}" class="layui-input">
        	{{ str_replace('img1',$model->labels['img1'],$model->errors->first('img1') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['img2'] }}</label>
        <div class="layui-input-block">
            <input type="file"  value="{{ $model->img2 }}" name="img2"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['img2'] }}" class="layui-input">
        	{{ str_replace('img2',$model->labels['img2'],$model->errors->first('img2') ) }}
        </div>
    </div>
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
        <label class="layui-form-label">{{ $model->labels['border'] }}</label>
        <div class="layui-input-inline">
            <input type="text"  value="{{ $model->border }}" name="page[border]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['border'] }}" class="layui-input">
        	{{ str_replace('border',$model->labels['border'],$model->errors->first('border') ) }}
        </div>
         <label class="layui-form-label">{{ $model->labels['weight'] }}</label>
        <div class="layui-input-inline">
            <input type="text"  value="{{ $model->weight }}" name="page[weight]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['weight'] }}" class="layui-input">
        	{{ str_replace('weight',$model->labels['weight'],$model->errors->first('weight') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['out_code'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->out_code }}" name="page[out_code]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['out_code'] }}" class="layui-input">
        	{{ str_replace('out_code',$model->labels['out_code'],$model->errors->first('out_code') ) }}
        </div>
    </div>
    
	<div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            <a class="layui-btn  layui-btn-primary" id="btn-add" href="{{ URL('admin/whItems/index') }}">返回</a>
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