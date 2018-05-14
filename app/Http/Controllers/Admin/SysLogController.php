<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Input;
use App\Page;
use App\Models\SysLog;
use App\Lib\Common;
use App\Lib\SysKey;

class SysLogController 
{
	
	/**
	 * 全部列表
	 * @return \Illuminate\View\View
	 */
	public function index()
	{
		$model = new SysLog();
		if(Input::all())
		{
			$page = Input::all();
			foreach ($page as $key=>$value)
			{
				if(in_array($key,array_keys($model->getLabels())))
				{
					if($key&&$value)
					{
						$model->$key = $value;
					}
				}
			}
		}
		return view('admin.sysLog.index',['model'=>$model]);
	}
	/**
	 * 全部列表
	 * @return \Illuminate\View\View
	 */
	public function ajaxData(Request $request)
	{
		$_data = null;
		$model = new SysLog();
		$condtion = '1=1';
		$page = null;
		if(Input::all())
		{
			$page = Input::all();
			foreach ($page as $key=>$value)
			{
				if(in_array($key,array_keys($model->getLabels())))
				{
					if($key&&$value)
					{
						$model->$key = $value;
						$condtion .=' and '.$key.' like "%'.$value.'%"';
					}
				}
			}
		}
		$data = SysLog::whereRaw($condtion)->orderBy($request->get('field','id'),$request->get('order','desc'))->paginate($request->get('limit'));
		foreach ($data as $boj) {
			foreach ($boj->getAttributes() as $k=>$v) {
				$_tmp[$k] = $v;
				if($k=='log_type')
				{
					$_tmp['log_type_text'] = SysKey::getSysLogTypeByValue($v);
				}
			}
			$_data[] = $_tmp;
		}
		echo json_encode(['data'=>$_data,'count'=>$data->total(),'code'=>0,'msg'=>'']);
	}
	
// 	/**
// 	 * 全部列表
// 	 * @return \Illuminate\View\View
// 	 */
// 	public function index()
// 	{
// 		$model = new SysLog();
// 		$condtion = '1=1';
// 		$page = null;
// 		if(Input::all())
// 		{
// 			$page = Input::all();
// 			foreach ($page as $key=>$value)
// 			{
// 				if(in_array($key,array_keys($model->labels)))
// 				{
// 					$model->$key = $value;
// 					$condtion .=' and '.$key.' like "%'.$value.'%"';
// 				}
// 			}
// 		}
// 		$data = SysLog::whereRaw($condtion)->paginate(10);
// 		$data->appends($page)->setPath('index');
// 		return view('admin.sysLog.index', ['data' => $data,'model'=>$model]);
// 	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$model = new SysLog();
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
			if ($validator->passes())
			{
				$model->id = Common::getId();
				if ($model->save()) {
					return view('admin.public.msgOk', ['msg'=>'保存成功','url'=>url('admin/sysLog/index')]);
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
		return view('admin.sysLog.create', ['model'=>$model]);
	}
	/**
	 * Show the form for creating a new resource.
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$model = SysLog::findOrNew($id);
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
				if ($model->save()) {
					$sysLog = new SysLog();
					$sysLog->log_type = SysKey::$sysLogUpdateValue;
					$sysLog->content = '用户信息';
					$sysLog->esave();
					return view('admin.public.msgOk', ['msg'=>'保存成功','url'=>url('admin/sysLog/index')]);
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
		return view('admin.sysLog.create', ['model'=>$model]);
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
			$model = SysLog::findOrNew($id);
			SysLog::destroy($id);
		}
		return redirect('admin/sysLog/index');
	}
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function ajaxDestroy($id)
	{
		//
		$ids = explode(',', $id);
		if(SysLog::destroy($ids))
		{
			$rs = ['code'=>'000','msg'=>'删除成功'];
		}else{
			$rs = ['code'=>'999','msg'=>'删除失败'];
		}
	
		echo json_encode($rs);
	
	}
}
