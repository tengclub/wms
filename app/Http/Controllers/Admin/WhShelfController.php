<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Input;
use App\Page;
use App\Models\WhShelf;
use App\Models\Warehouse;
use App\Models\WhArea;
use App\Models\SysLog;
use App\Lib\Common;
use App\Lib\SysKey;

class WhShelfController 
{
	/**
	 * 全部列表
	 * @return \Illuminate\View\View
	 */
	public function index(Request $request)
	{
		$model = new WhShelf();
		$condtion = '1=1';
		$page = null;
		if(Input::all())
		{
			$page = Input::all();
			foreach ($page as $key=>$value)
			{
				if(in_array($key,array_keys($model->labels)))
				{
					$model->$key = $value;
					$condtion .=' and '.$key.' like "%'.$value.'%"';
				}
			}
		}
		if($request->get('__data'))
		{
			$_data = null;
    		$data = WhShelf::whereRaw($condtion)->orderBy($request->get('field','id'),$request->get('order','desc'))->paginate($request->get('limit'));
    		foreach ($data as $boj) {
    			foreach ($boj->getAttributes() as $k=>$v) {
    				if($k!='length')
    				{
    					$_tmp[$k] = $v;
    				}
    				if($k=='status')
    				{
    					$_tmp['status_text'] = SysKey::getStatusByValue($v);
    				}
    				if($k=='warehouse_id')
    				{
    					$_tmp['warehouse_text'] = Warehouse::findOrNew($v)->title;
    				}
    				if($k=='wh_area_id')
    				{
    					$_tmp['wh_area_text'] = WhArea::findOrNew($v)->title;
    				}
    			}
    			$_data[] = $_tmp;
    		}
    		echo json_encode(['data'=>$_data,'count'=>$data->total(),'code'=>0,'msg'=>'']);
    		return;
    	}
		return view('admin.whShelf.index', ['model'=>$model]);
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$model = new WhShelf();
		if(isset($_POST['page']))
		{
			$page = $_POST['page'];
			$validator = Validator::make($page,
				[
					//'id' => 'required|unique:table_name',
				]
			);
			foreach ($page as $key=>$value)
			{
				$model->$key = $value;
			}
			$whShelf = WhShelf::firstOrNew(['warehouse_id'=>$model->warehouse_id,'wh_area_id'=>$model->wh_area_id,'code'=>$model->code]);
			if($whShelf->id)
			{
				$validator->errors()->add('code', '编码不能重复');
				$model->errors = $validator->messages();
			}else{
				if ($validator->passes())
				{
					$model->warehouse_code = Warehouse::findOrNew($model->warehouse_id)->code;
					$model->wh_area_code = WhArea::findOrNew($model->wh_area_id)->code;
					$model->id = Common::getId();
					$model->create_time = Common::getDateTime();
					$model->create_user = session('admin')->user;
					if ($model->save()) {
						return view('admin.public.msgOk', ['msg'=>'保存成功','url'=>url('admin/whShelf/index')]);
					} else {
						return Redirect::back()->withInput()->withErrors('保存失败！');
					}
				}else {
					$model->errors = $validator->messages();
				}
			}
		}else {
			$validator = Validator::make(array(),array());
			$model->errors = $validator->messages();
		}
		return view('admin.whShelf.create', ['model'=>$model]);
	}
	/**
	 * Show the form for creating a new resource.
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$model = WhShelf::findOrNew($id);
		if(isset($_POST['page']))
		{
			$page = $_POST['page'];
			$validator = Validator::make($page,
				[
					//'id' => 'required|unique:tale_name',
				]
			);
			foreach ($page as $key=>$value)
			{
				$model->$key = $value;
			}
			if ($validator->passes())
			{
				$model->warehouse_code = Warehouse::findOrNew($model->warehouse_id)->code;
				$model->wh_area_code = WhArea::findOrNew($model->wh_area_id)->code;
				$model->update_user = session('admin')->user;
				$model->update_time = Common::getDateTime();
				if ($model->save()) {
					$sysLog = new SysLog();
					$sysLog->log_type = SysKey::$sysLogUpdateValue;
					$sysLog->content = '用户信息';
					$sysLog->esave();
					return view('admin.public.msgOk', ['msg'=>'保存成功','url'=>url('admin/whShelf/index')]);
				} else {
					return Redirect::back()->withInput()->withErrors('保存失败！');
				}
			}else {
				$model->errors = $validator->messages();
			}
		}else {
			$validator = Validator::make(array(),array());
			$model->errors = $validator->messages();
		}
		return view('admin.whShelf.create', ['model'=>$model]);
	}
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
		$ids = explode(',', $id);
		foreach ($ids as $id)
		{
			$model = WhShelf::findOrNew($id);
			WhShelf::destroy($id);
		}
		return redirect('admin/whShelf/index');
	}
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function ajaxDestroy($id)
	{
		$rs = ['code'=>'000','msg'=>'删除成功'];
		$ids = explode(',', $id);
		foreach ($ids as $id)
		{
			$model = WhShelf::findOrNew($id);
			WhShelf::destroy($id);
		}
		echo json_encode($rs);
	}
}
