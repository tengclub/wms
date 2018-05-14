<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Input;
use App\Page;
use App\Models\SysGroupOrderStatus;
use App\Models\SysLog;
use App\Models\SysGroup;
use App\Models\OrderStatus;
use App\Lib\Common;
use App\Lib\SysKey;

class SysGroupOrderStatusController 
{
	/**
	 * 全部列表
	 * @return \Illuminate\View\View
	 */
	public function index($gid,Request $request)
	{
		$model = new SysGroupOrderStatus();
		$group = SysGroup::findOrNew($gid);
		$condtion = '1=1 and group_id='.$gid;
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
    		$data = SysGroupOrderStatus::whereRaw($condtion)->orderBy($request->get('field','id'),$request->get('order','desc'))->paginate($request->get('limit'));
    		foreach ($data as $obj) {
    			foreach ($obj->getAttributes() as $k=>$v) {
    				$_tmp[$k] = $v;
    				if($k=='order_status_id')
    				{
    					$_tmp['order_status_id_text'] = OrderStatus::findOrNew($v)->title;
    				}
    			}
    			$_data[] = $_tmp;
    		}
    		echo json_encode(['data'=>$_data,'count'=>$data->total(),'code'=>0,'msg'=>'']);
    		return;
    	}
		return view('admin.sysGroupOrderStatus.index', ['model'=>$model,'group'=>$group]);
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$model = new SysGroupOrderStatus();
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
					return view('admin.public.msgOk', ['msg'=>'保存成功','url'=>url('admin/sysGroupOrderStatus/index')]);
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
		return view('admin.sysGroupOrderStatus.create', ['model'=>$model]);
	}
	/**
	 * Show the form for creating a new resource.
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$model = SysGroupOrderStatus::findOrNew($id);
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
					return view('admin.public.msgOk', ['msg'=>'保存成功','url'=>url('admin/sysGroupOrderStatus/index')]);
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
		return view('admin.sysGroupOrderStatus.create', ['model'=>$model]);
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
			$model = SysGroupOrderStatus::findOrNew($id);
			SysGroupOrderStatus::destroy($id);
		}
		return redirect('admin/sysGroupOrderStatus/index');
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
			$model = SysGroupOrderStatus::findOrNew($id);
			SysGroupOrderStatus::destroy($id);
		}
		echo json_encode($rs);
	}
	public function ajaxAdd(Request $request)
	{
		$rs = ['code'=>'000','msg'=>'添加成功请刷新'];
		$obj = $request->get('obj');
		$obj = explode(',', $obj);
		$gid = $request->get('gid');
		foreach ($obj as $orderStatusId)
		{
			$model = SysGroupOrderStatus::firstOrNew(['group_id'=>$gid,'order_status_id'=>$orderStatusId]);
			if(!$model->id)
			{
				$model->id = Common::getId();
				$model->order_status_id = $orderStatusId;
				$model->group_id = $gid;
				$model->next_order_status_id = OrderStatus::getNextById($orderStatusId)->id;
				$model->before_order_status_id = OrderStatus::getBeforeById($orderStatusId)->id;
				$model->save();
			}
		}
		echo json_encode($rs);
	}
}
