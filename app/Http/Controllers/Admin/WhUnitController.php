<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Input;
use App\Page;
use App\Models\WhUnit;
use App\Models\SysLog;
use App\Models\WhShelf;
use App\Models\Warehouse;
use App\Models\WhArea;
use App\Lib\Common;
use App\Lib\SysKey;
use App\Models\WhItems;

class WhUnitController 
{
	/**
	 * 全部列表
	 * @return \Illuminate\View\View
	 */
	public function index(Request $request)
	{
		$model = new WhUnit();
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
    		$data = WhUnit::whereRaw($condtion)->orderBy($request->get('field','id'),$request->get('order','desc'))->paginate($request->get('limit'));
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
    				if($k=='wh_shelf_id')
    				{
    					$_tmp['wh_shelf_text'] = WhShelf::findOrNew($v)->title;
    				}
    				if($k=='wh_items_id')
    				{
    					$_tmp['wh_items_text'] = WhItems::findOrNew($v)->title;
    				}
    			}
    			$_data[] = $_tmp;
    		}
    		echo json_encode(['data'=>$_data,'count'=>$data->total(),'code'=>0,'msg'=>'']);
    		return;
    	}
		return view('admin.whUnit.index', ['model'=>$model]);
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$model = new WhUnit();
		$model->code = '1'.Common::strLength(WhUnit::all()->count()+1);
		if(isset($_POST['page']))
		{
			$page = $_POST['page'];
			$validator = Validator::make($page,
				[
					'code' => 'required|unique:wh_unit',
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
				$model->wh_shelf_code = WhShelf::findOrNew($model->wh_shelf_id)->code;
				$model->id = Common::getId();
				$model->create_time = Common::getDateTime();
				$model->create_user = session('admin')->user;
				if ($model->save()) {
					return view('admin.public.msgOk', ['msg'=>'保存成功','url'=>url('admin/whUnit/index')]);
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
		return view('admin.whUnit.create', ['model'=>$model]);
	}
	/**
	 * Show the form for creating a new resource.
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$model = WhUnit::findOrNew($id);
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
				$model->wh_shelf_code = WhShelf::findOrNew($model->wh_shelf_id)->code;
				$model->update_user = session('admin')->user;
				$model->update_time = Common::getDateTime();
				if ($model->save()) {
					$sysLog = new SysLog();
					$sysLog->log_type = SysKey::$sysLogUpdateValue;
					$sysLog->content = '用户信息';
					$sysLog->esave();
					return view('admin.public.msgOk', ['msg'=>'保存成功','url'=>url('admin/whUnit/index')]);
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
		return view('admin.whUnit.create', ['model'=>$model]);
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
			$model = WhUnit::findOrNew($id);
			WhUnit::destroy($id);
		}
		return redirect('admin/whUnit/index');
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
			$model = WhUnit::findOrNew($id);
			WhUnit::destroy($id);
		}
		echo json_encode($rs);
	}
}
