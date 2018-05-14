<!-- Breadcrumb -->
<ol class="breadcrumb">
	<li class="breadcrumb-item">首页</li>
	<li class="breadcrumb-item active">菜单信息</li>
</ol>
<div class="container-fluid">
	<div class="animated fadeIn">
		<form action="{{ Request::getRequestUri() }}"  method="POST" enctype="multipart/form-data">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header">菜单信息</div>
						<div class="card-block">
							<div class="form-group row">
								<div class="col-md-9">
									<input type="text" value="{{ $model->menu_name }}" name="page[menu_name]"  class="form-control"  placeholder="{{ $model->labels['menu_name'] }}">
									{{ $model->errors->first('menu_name') }}
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-9">
									{!! App\Lib\Ehtml::select(App\Models\SysMenu::getParentMenuList(),$model->pid,['name'=>'page[pid]','class'=>'form-control']) !!}
									{{ $model->errors->first('pid') }}
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-9">
									<input type="text" value="{{ $model->menu_path }}" name="page[menu_path]"  class="form-control"  placeholder="{{ $model->labels['menu_path'] }}">
									{{ $model->errors->first('menu_path') }}
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-9">
									<input type="text" value="{{ $model->remarks }}" name="page[remarks]"  class="form-control"  placeholder="{{ $model->labels['remarks'] }}">
									{{ $model->errors->first('remarks') }}
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-9">
									{!! App\Lib\Ehtml::select(App\Lib\SysKey::getStatusList(),$model->menu_status,['name'=>'page[menu_status]','class'=>'form-control']) !!}
									{{ $model->errors->first('menu_status') }}
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
 