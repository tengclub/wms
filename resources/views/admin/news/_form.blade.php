<blockquote class="layui-elem-quote layui-text">
</blockquote>
<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
	<legend>用户组</legend>
</fieldset>

<form class="layui-form" action="{{ Request::getRequestUri() }}"  method="POST" enctype="multipart/form-data">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['id'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->id }}" name="page[id]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['id'] }}" class="layui-input">
        	{{ str_replace('id',$model->labels['id'],$model->errors->first('id') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['type_id'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->type_id }}" name="page[type_id]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['type_id'] }}" class="layui-input">
        	{{ str_replace('type_id',$model->labels['type_id'],$model->errors->first('type_id') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['type_id2'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->type_id2 }}" name="page[type_id2]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['type_id2'] }}" class="layui-input">
        	{{ str_replace('type_id2',$model->labels['type_id2'],$model->errors->first('type_id2') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['flag'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->flag }}" name="page[flag]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['flag'] }}" class="layui-input">
        	{{ str_replace('flag',$model->labels['flag'],$model->errors->first('flag') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['channel_id'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->channel_id }}" name="page[channel_id]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['channel_id'] }}" class="layui-input">
        	{{ str_replace('channel_id',$model->labels['channel_id'],$model->errors->first('channel_id') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['status'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->status }}" name="page[status]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['status'] }}" class="layui-input">
        	{{ str_replace('status',$model->labels['status'],$model->errors->first('status') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['click'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->click }}" name="page[click]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['click'] }}" class="layui-input">
        	{{ str_replace('click',$model->labels['click'],$model->errors->first('click') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['money'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->money }}" name="page[money]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['money'] }}" class="layui-input">
        	{{ str_replace('money',$model->labels['money'],$model->errors->first('money') ) }}
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
        <label class="layui-form-label">{{ $model->labels['short_title'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->short_title }}" name="page[short_title]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['short_title'] }}" class="layui-input">
        	{{ str_replace('short_title',$model->labels['short_title'],$model->errors->first('short_title') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['color'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->color }}" name="page[color]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['color'] }}" class="layui-input">
        	{{ str_replace('color',$model->labels['color'],$model->errors->first('color') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['writer'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->writer }}" name="page[writer]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['writer'] }}" class="layui-input">
        	{{ str_replace('writer',$model->labels['writer'],$model->errors->first('writer') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['source'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->source }}" name="page[source]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['source'] }}" class="layui-input">
        	{{ str_replace('source',$model->labels['source'],$model->errors->first('source') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['lit_pic'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->lit_pic }}" name="page[lit_pic]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['lit_pic'] }}" class="layui-input">
        	{{ str_replace('lit_pic',$model->labels['lit_pic'],$model->errors->first('lit_pic') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['pubdate'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->pubdate }}" name="page[pubdate]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['pubdate'] }}" class="layui-input">
        	{{ str_replace('pubdate',$model->labels['pubdate'],$model->errors->first('pubdate') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['member_user'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->member_user }}" name="page[member_user]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['member_user'] }}" class="layui-input">
        	{{ str_replace('member_user',$model->labels['member_user'],$model->errors->first('member_user') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['keywords'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->keywords }}" name="page[keywords]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['keywords'] }}" class="layui-input">
        	{{ str_replace('keywords',$model->labels['keywords'],$model->errors->first('keywords') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['scores'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->scores }}" name="page[scores]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['scores'] }}" class="layui-input">
        	{{ str_replace('scores',$model->labels['scores'],$model->errors->first('scores') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['good_post'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->good_post }}" name="page[good_post]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['good_post'] }}" class="layui-input">
        	{{ str_replace('good_post',$model->labels['good_post'],$model->errors->first('good_post') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['bad_post'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->bad_post }}" name="page[bad_post]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['bad_post'] }}" class="layui-input">
        	{{ str_replace('bad_post',$model->labels['bad_post'],$model->errors->first('bad_post') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['vote_id'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->vote_id }}" name="page[vote_id]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['vote_id'] }}" class="layui-input">
        	{{ str_replace('vote_id',$model->labels['vote_id'],$model->errors->first('vote_id') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['is_not_post'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->is_not_post }}" name="page[is_not_post]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['is_not_post'] }}" class="layui-input">
        	{{ str_replace('is_not_post',$model->labels['is_not_post'],$model->errors->first('is_not_post') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['description'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->description }}" name="page[description]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['description'] }}" class="layui-input">
        	{{ str_replace('description',$model->labels['description'],$model->errors->first('description') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['file_name'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->file_name }}" name="page[file_name]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['file_name'] }}" class="layui-input">
        	{{ str_replace('file_name',$model->labels['file_name'],$model->errors->first('file_name') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['tack_id'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->tack_id }}" name="page[tack_id]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['tack_id'] }}" class="layui-input">
        	{{ str_replace('tack_id',$model->labels['tack_id'],$model->errors->first('tack_id') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['weight'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->weight }}" name="page[weight]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['weight'] }}" class="layui-input">
        	{{ str_replace('weight',$model->labels['weight'],$model->errors->first('weight') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['lit_pic2'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->lit_pic2 }}" name="page[lit_pic2]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['lit_pic2'] }}" class="layui-input">
        	{{ str_replace('lit_pic2',$model->labels['lit_pic2'],$model->errors->first('lit_pic2') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['content'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->content }}" name="page[content]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['content'] }}" class="layui-input">
        	{{ str_replace('content',$model->labels['content'],$model->errors->first('content') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['create_time'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->create_time }}" name="page[create_time]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['create_time'] }}" class="layui-input">
        	{{ str_replace('create_time',$model->labels['create_time'],$model->errors->first('create_time') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['create_user'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->create_user }}" name="page[create_user]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['create_user'] }}" class="layui-input">
        	{{ str_replace('create_user',$model->labels['create_user'],$model->errors->first('create_user') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['update_time'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->update_time }}" name="page[update_time]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['update_time'] }}" class="layui-input">
        	{{ str_replace('update_time',$model->labels['update_time'],$model->errors->first('update_time') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['update_user'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->update_user }}" name="page[update_user]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['update_user'] }}" class="layui-input">
        	{{ str_replace('update_user',$model->labels['update_user'],$model->errors->first('update_user') ) }}
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels['templet_file'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->templet_file }}" name="page[templet_file]"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels['templet_file'] }}" class="layui-input">
        	{{ str_replace('templet_file',$model->labels['templet_file'],$model->errors->first('templet_file') ) }}
        </div>
    </div>
    
	<div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            <a class="layui-btn  layui-btn-primary" id="btn-add" href="{{ URL('admin/news/index') }}">返回</a>
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