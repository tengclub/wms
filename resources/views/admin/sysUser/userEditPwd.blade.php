@extends('admin.layouts.mainBody')
@section('content')
<!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">首页</li>
                <li class="breadcrumb-item active">用户修改密码</li>
            </ol>

            <div class="container-fluid">
                <div class="animated fadeIn">
   
 				<form action="{{ Request::getRequestUri() }}"  method="POST" enctype="multipart/form-data">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header"> 用户修改密码</div>
                               
                                <div class="card-block">
                                       <div class="form-group row">
                                            <label class="col-md-1 form-control-label" for="text-input">{{ $model->labels['password'] }}</label>
                                            <div class="col-md-9">
                                            <input type="password"  name="page[password]"  class="form-control"  placeholder="{{ $model->labels['password'] }}">
                                            {{ $model->errors->first('password') }}
                                            </div>
                                       </div>
                                       <div class="form-group row">
                                            <label class="col-md-1 form-control-label" for="text-input">新密码</label>
                                            <div class="col-md-9">
                                            <input type="password"  name="page[newPwd]"  class="form-control"  placeholder="新密码">
                                            </div>
                                       </div>
                                       <div class="form-group row">
                                            <label class="col-md-1 form-control-label" for="text-input">确认密码</label>
                                            <div class="col-md-9">
                                            <input type="password"  name="page[reNewPwd]"  class="form-control"  placeholder="确认密码">
                                            </div>
                                       </div>
                                   

                                </div>
                                <div class="card-footer">
                                    <button class="btn btn-sm btn-primary" type="submit">
                                    <i class="fa fa-dot-circle-o"></i> 保存
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
   
@endsection    

