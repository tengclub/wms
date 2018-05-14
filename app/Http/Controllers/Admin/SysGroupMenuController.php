<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Input;
use App\Page;
use App\Models\SysGroupMenu;
use App\Models\SysLog;
use App\Models\SysMenu;
use App\Models\SysGroup;
use App\Lib\Common;
use App\Lib\SysKey;

class SysGroupMenuController 
{
	/**
	 * 全部列表
	 * @return \Illuminate\View\View
	 */
	public function index(Request $request)
	{
		$model = new SysGroupMenu();
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
    		$data = SysGroupMenu::whereRaw($condtion)->orderBy($request->get('field','id'),$request->get('order','desc'))->paginate($request->get('limit'));
    		foreach ($data as $boj) {
    			foreach ($boj->getAttributes() as $k=>$v) {
    				$_tmp[$k] = $v;
    			}
    			$_data[] = $_tmp;
    		}
    		echo json_encode(['data'=>$_data,'count'=>$data->total(),'code'=>0,'msg'=>'']);
    		return;
    	}
		return view('admin.sysGroupMenu.index', ['model'=>$model]);
	}
	public function adminTree($gid,Request $request)
	{
		$_pre = config('database')['connections']['mysql']['prefix'];
		$group = SysGroup::findOrNew($gid);
		$data = [];
		$model = new SysMenu();
		$condtion = 'id in (select menu_id from '.$_pre.'sys_group_menu where group_id='.$gid.')';
		$objs = SysMenu::whereRaw($condtion)->orderBy('order_id', 'asc')->get();
		foreach ($objs as $obj)
		{
			$data[] = ['id'=>$obj->id,'pId'=>$obj->pid,'name'=>$obj->menu_name,
					'menu_path'=>$obj->menu_path,'remarks'=>$obj->remarks,'menu_status'=>$obj->menu_status,
					'order_id'=>$obj->order_id,'group'=>$obj->group
			];
		}
		return view('admin.sysGroupMenu.adminTree', ['data' => json_encode($data),'group'=>$group]);
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$model = new SysGroupMenu();
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
					return view('admin.public.msgOk', ['msg'=>'保存成功','url'=>url('admin/sysGroupMenu/index')]);
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
		return view('admin.sysGroupMenu.create', ['model'=>$model]);
	}
	/**
	 * Show the form for creating a new resource.
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$model = SysGroupMenu::findOrNew($id);
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
					return view('admin.public.msgOk', ['msg'=>'保存成功','url'=>url('admin/sysGroupMenu/index')]);
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
		return view('admin.sysGroupMenu.create', ['model'=>$model]);
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
			$model = SysGroupMenu::findOrNew($id);
			SysGroupMenu::destroy($id);
		}
		return redirect('admin/sysGroupMenu/index');
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
			$model = SysGroupMenu::findOrNew($id);
			SysGroupMenu::destroy($id);
		}
		echo json_encode($rs);
	}
	public function ajaxAddMenu(Request $request)
	{
		$rs = ['code'=>'000','msg'=>'添加成功'];
		$mids = $request->get('mids');
		$mids = explode(',', $mids);
		$gid = $request->get('gid');
		foreach ($mids as $mid)
		{
			$model = SysGroupMenu::firstOrNew(['group_id'=>$gid,'menu_id'=>$mid]);
			if(!$model->id)
			{
				$model->id = Common::getId();
				$model->menu_id = $mid;
				$model->group_id = $gid;
				$model->save();
			}
		}
		echo json_encode($rs);
	}
}
