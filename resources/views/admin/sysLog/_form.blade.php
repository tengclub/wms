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
								<label class="col-md-1 form-control-label" for="text-input">{{ $model->labels['id'] }}</label>
								<div class="col-md-9">
									<input type="text" value="{{ $model->id }}" name="page[id]" class="form-control"  placeholder="{{ $model->labels['id'] }}">
									{{ str_replace('id',$model->labels['id'],$model->errors->first('id') ) }}
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-1 form-control-label" for="text-input">{{ $model->labels['data_time'] }}</label>
								<div class="col-md-9">
									<input type="text" value="{{ $model->data_time }}" name="page[data_time]" class="form-control"  placeholder="{{ $model->labels['data_time'] }}">
									{{ str_replace('data_time',$model->labels['data_time'],$model->errors->first('data_time') ) }}
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-1 form-control-label" for="text-input">{{ $model->labels['user'] }}</label>
								<div class="col-md-9">
									<input type="text" value="{{ $model->user }}" name="page[user]" class="form-control"  placeholder="{{ $model->labels['user'] }}">
									{{ str_replace('user',$model->labels['user'],$model->errors->first('user') ) }}
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-1 form-control-label" for="text-input">{{ $model->labels['log_type'] }}</label>
								<div class="col-md-9">
									<input type="text" value="{{ $model->log_type }}" name="page[log_type]" class="form-control"  placeholder="{{ $model->labels['log_type'] }}">
									{{ str_replace('log_type',$model->labels['log_type'],$model->errors->first('log_type') ) }}
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-1 form-control-label" for="text-input">{{ $model->labels['content'] }}</label>
								<div class="col-md-9">
									<input type="text" value="{{ $model->content }}" name="page[content]" class="form-control"  placeholder="{{ $model->labels['content'] }}">
									{{ str_replace('content',$model->labels['content'],$model->errors->first('content') ) }}
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
    			