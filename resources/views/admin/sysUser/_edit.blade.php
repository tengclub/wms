<!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">首页</li>
                <li class="breadcrumb-item active">用户信息</li>
            </ol>
            <div class="container-fluid">
                <div class="animated fadeIn">
   
 				<form action="{{ Request::getRequestUri() }}"  method="POST" enctype="multipart/form-data">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">用户信息</div>
                                	<div class="card-block">
										<div class="form-group row">
                                            <label class="col-md-1 form-control-label" for="text-input">{{ $model->labels['user'] }}</label>
                                            <div class="col-md-9">
                                            <input type="text" value="{{ $model->user }}" name="page[user]"  class="form-control"  placeholder="{{ $model->labels['user'] }}" readonly="readonly">
                                            {{ $model->errors->first('user') }}
                                            </div>
										</div>
                                       	<div class="form-group row">
                                            <label class="col-md-1 form-control-label" for="text-input">{{ $model->labels['password'] }}</label>
                                            <div class="col-md-9">
                                            <input type="password" value="{{ $model->password }}" name="page[password]"  class="form-control"  placeholder="{{ $model->labels['password'] }}">
                                            {{ $model->errors->first('password') }}
                                            </div>
                                       	</div>
                                      	<div class="form-group row">
                                            <label class="col-md-1 form-control-label" for="text-input">{{ $model->labels['mail'] }}</label>
                                            <div class="col-md-9">
                                            <input type="text" value="{{ $model->mail }}" name="page[mail]"  class="form-control"  placeholder="{{ $model->labels['mail'] }}">
                                            {{ $model->errors->first('mail') }}
                                            </div>
                                      	</div>
                                       	<div class="form-group row">
                                            <label class="col-md-1 form-control-label" for="text-input">{{ $model->labels['phone'] }}</label>
                                            <div class="col-md-9">
                                            <input type="text" value="{{ $model->phone }}" name="page[phone]"  class="form-control"  placeholder="{{ $model->labels['phone'] }}">
                                            {{ $model->errors->first('phone') }}
                                            </div>
                                       	</div>
                                       	<div class="form-group row">
                                            <label class="col-md-1 form-control-label" for="text-input">{{ $model->labels['level'] }}</label>
                                            <div class="col-md-9">
												{!! App\Lib\Ehtml::select(App\Lib\SysKey::getUserLevelList(),$model->level,['name'=>'page[level]','class'=>'form-control']) !!}
                                            </div>
                                       	</div>
                                       	<div class="form-group row">
                                            <label class="col-md-1 form-control-label" for="text-input">{{ $model->labels['user_status'] }}</label>
                                            <div class="col-md-9">
											{!! App\Lib\Ehtml::select(App\Lib\SysKey::getStatusList(),$model->user_status,['name'=>'page[user_status]','class'=>'form-control']) !!}
                                            </div>
                                       	</div>
                                       	<div class="form-group row">
                                            <label class="col-md-1 form-control-label" for="text-input">{{ $model->labels['remarks'] }}</label>
                                            <div class="col-md-9">
                                            <input type="text" value="{{ $model->remarks }}" name="page[remarks]"  class="form-control"  placeholder="{{ $model->labels['remarks'] }}">
                                            {{ $model->errors->first('remarks') }}
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
   
    