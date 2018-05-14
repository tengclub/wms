<ol class="breadcrumb">
	<li class="breadcrumb-item">首页</li>
	<li class="breadcrumb-item active"> 信息</li>
</ol>
<div class="container-fluid">
	<div class="animated fadeIn">
		<form action="{{ Request::getRequestUri() }}"  method="POST" enctype="multipart/form-data">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header">信息</div>
						<div class="card-block">
    					
							<div class="form-group row">
								<label class="col-md-1 form-control-label" for="text-input">{{ $model->labels['title'] }}</label>
								<div class="col-md-9">
									<input type="text" value="{{ $model->title }}" name="page[title]" class="form-control"  placeholder="{{ $model->labels['title'] }}">
									{{ str_replace('title',$model->labels['title'],$model->errors->first('title') ) }}
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-1 form-control-label" for="text-input">{{ $model->labels['wechat_user'] }}</label>
								<div class="col-md-9">
									<input type="text" value="{{ $model->wechat_user }}" name="page[wechat_user]" class="form-control"  placeholder="{{ $model->labels['wechat_user'] }}">
									{{ str_replace('wechat_user',$model->labels['wechat_user'],$model->errors->first('wechat_user') ) }}
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-1 form-control-label" for="text-input">{{ $model->labels['token'] }}</label>
								<div class="col-md-9">
									<input type="text" value="{{ $model->token }}" name="page[token]" class="form-control"  placeholder="{{ $model->labels['token'] }}">
									{{ str_replace('token',$model->labels['token'],$model->errors->first('token') ) }}
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-1 form-control-label" for="text-input">{{ $model->labels['encoding_aes_key'] }}</label>
								<div class="col-md-9">
									<input type="text" value="{{ $model->encoding_aes_key }}" name="page[encoding_aes_key]" class="form-control"  placeholder="{{ $model->labels['encoding_aes_key'] }}">
									{{ str_replace('encoding_aes_key',$model->labels['encoding_aes_key'],$model->errors->first('encoding_aes_key') ) }}
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-1 form-control-label" for="text-input">{{ $model->labels['appid'] }}</label>
								<div class="col-md-9">
									<input type="text" value="{{ $model->appid }}" name="page[appid]" class="form-control"  placeholder="{{ $model->labels['appid'] }}">
									{{ str_replace('appid',$model->labels['appid'],$model->errors->first('appid') ) }}
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-1 form-control-label" for="text-input">{{ $model->labels['appsecret'] }}</label>
								<div class="col-md-9">
									<input type="text" value="{{ $model->appsecret }}" name="page[appsecret]" class="form-control"  placeholder="{{ $model->labels['appsecret'] }}">
									{{ str_replace('appsecret',$model->labels['appsecret'],$model->errors->first('appsecret') ) }}
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-1 form-control-label" for="text-input">{{ $model->labels['mchid'] }}</label>
								<div class="col-md-9">
									<input type="text" value="{{ $model->mchid }}" name="page[mchid]" class="form-control"  placeholder="{{ $model->labels['mchid'] }}">
									{{ str_replace('mchid',$model->labels['mchid'],$model->errors->first('mchid') ) }}
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-1 form-control-label" for="text-input">{{ $model->labels['key'] }}</label>
								<div class="col-md-9">
									<input type="text" value="{{ $model->key }}" name="page[key]" class="form-control"  placeholder="{{ $model->labels['key'] }}">
									{{ str_replace('key',$model->labels['key'],$model->errors->first('key') ) }}
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-1 form-control-label" for="text-input">{{ $model->labels['ip'] }}</label>
								<div class="col-md-9">
									<input type="text" value="{{ $model->ip }}" name="page[ip]" class="form-control"  placeholder="{{ $model->labels['ip'] }}">
									{{ str_replace('ip',$model->labels['ip'],$model->errors->first('ip') ) }}
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-1 form-control-label" for="text-input">{{ $model->labels['domainname'] }}</label>
								<div class="col-md-9">
									<input type="text" value="{{ $model->domainname }}" name="page[domainname]" class="form-control"  placeholder="{{ $model->labels['domainname'] }}">
									{{ str_replace('domainname',$model->labels['domainname'],$model->errors->first('domainname') ) }}
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-1 form-control-label" for="text-input">{{ $model->labels['wechat_status'] }}</label>
								<div class="col-md-9">
									{!! App\Lib\Ehtml::select(App\Lib\SysKey::getStatusList(),$model->wechat_status,['name'=>'page[wechat_status]','class'=>'form-control']) !!}
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-1 form-control-label" for="text-input">{{ $model->labels['web_url'] }}</label>
								<div class="col-md-9">
									<input type="text" value="{{ $model->web_url }}" name="page[web_url]" class="form-control"  placeholder="{{ $model->labels['web_url'] }}">
									{{ str_replace('web_url',$model->labels['web_url'],$model->errors->first('web_url') ) }}
								</div>
							</div>
    					</div>
						<div class="card-footer">
							<button class="btn btn-sm btn-primary" type="submit">
								<i class="fa fa-dot-circle-o"></i> 保存
							</button>
							<button class="btn btn-sm btn-danger" type="reset">
								<i class="fa fa-ban"></i>重置
							</button>
						</div>
					</div>
				</div>
				<!--/.col-->
			</div>
			<!--/.row-->
		</form>
	</div>
</div>
    			