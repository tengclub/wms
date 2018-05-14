<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Input;
use DB;
use App\Page;
use App\Models\SysGroup;
use App\Models\SysGroupUser;
use App\Models\SysGroupMenu;
use App\Models\SysGroupOrderStatus;
use App\Models\SysUser;
use App\Models\SysMenu;
use App\Models\SysLog;
use App\Lib\Common;
use App\Lib\SysKey;

class SysGroupController 
{
	/**
	 * 全部列表
	 * @return \Illuminate\View\View
	 */
	public function index()
	{
		$model = new SysGroup();
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
		return view('admin.sysGroup.index',['model'=>$model]);
	}
	/**
	 * 全部列表
	 * @return \Illuminate\View\View
	 */
	public function ajaxData(Request $request)
	{
		$_data = null;
		$model = new SysGroup();
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
		$data = SysGroup::whereRaw($condtion)->orderBy($request->get('field','id'),$request->get('order','desc'))->paginate($request->get('limit'));
		foreach ($data as $boj) {
			foreach ($boj->getAttributes() as $k=>$v) {
				$_tmp[$k] = $v;
				if($k=='group_status')
				{
					$_tmp['group_status_text'] = SysKey::getStatusByValue($v);
				}
			}
			$_data[] = $_tmp;
		}
		echo json_encode(['data'=>$_data,'count'=>$data->total(),'code'=>0,'msg'=>'']);
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$model = new SysGroup();
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
					return view('public.msgOk', ['msg'=>'保存成功','url'=>url('admin/sysGroup/index')]);
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
		return view('admin.sysGroup.create', ['model'=>$model]);
	}
	/**
	 * Show the form for creating a new resource.
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$model = SysGroup::findOrNew($id);
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
					return view('admin.public.msgOk', ['msg'=>'保存成功','url'=>url('admin/sysGroup/index')]);
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
		return view('admin.sysGroup.create', ['model'=>$model]);
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
			$model = SysGroup::findOrNew($id);
			SysGroup::destroy($id);
		}
		return redirect('admin/sysGroup/index');
		
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
		if(SysGroup::destroy($ids))
		{
			SysGroupUser::whereIn('group_id',$ids)->delete();
			SysGroupMenu::whereIn('group_id',$ids)->delete();
			SysGroupOrderStatus::whereIn('group_id',$ids)->delete();
			$rs = ['code'=>'000','msg'=>'删除成功'];
		}else{
			$rs = ['code'=>'999','msg'=>'删除失败'];
		}
	
		echo json_encode($rs);
	
	}
	

	/**
	 * 组用户管理
	 * @param unknown $gid
	 */
	public function user($gid)
	{
		$dataUser = SysUser::paginate(10);
		$gmodel = SysGroup::findOrNew($gid);
		$data = SysGroupUser::where('group_id',$gid)->paginate(10);
		return view('admin.sysGroup.user', ['data' => $data,'dataUser'=>$dataUser,'gmodel'=>$gmodel]);
	}
	/**
	 * 组用户管理
	 * @param unknown $gid
	 */
	public function ajaxAddUser(Request $request)
	{
		$rs = ['code'=>'000','msg'=>'保存成功'];
		$msg = '保存失败';
		$gid = $request->get('gid');
		$uid = $request->get('uid');
		$users = explode(',', $uid);
		foreach ($users as $user)
		{
			$u = SysGroupUser::where(['group_id'=>$gid,'user'=>$user])->get();
			if(!count($u))
			{
				$model = new SysGroupUser();
				$model->id = Common::getId();
				$model->group_id = $gid;
				$model->user = $user;
				if (!$model->save()){
					$msg .= ','.$model->user;
					$rs = array('code'=>'999','msg'=>$msg);
				}
			}
		}
		echo json_encode($rs);
	}
	/**
	 * 组删除用户管理
	 * @param unknown $gid
	 */
	public function ajaxDelUser(Request $request)
	{
		$rs = ['code'=>'000','msg'=>'删除成功'];
		$msg = '删除失败';
		$guid = $request->get('guid');
		SysGroupUser::destroy(explode(',', $guid));
		echo json_encode($rs);
	}
	/**
	 * 组菜单管理
	 * @param unknown $gid
	 * @return \Illuminate\View\View
	 */
	public function menu($gid)
	{
		$model = SysGroup::findOrNew($gid);
		$data = SysGroupMenu::where('group_id',$gid)->paginate(10);
		return view('admin.sysGroup.menu', ['data' => $data,'model'=>$model]);
	}
	
	
	/**
	 * 组菜单管理
	 * @param unknown $gid
	 * @return \Illuminate\View\View
	 */
	public function menuTree($gid)
	{
// 		$gid = $request->get('gid');
		$condtion = '1=1';
		$objs = SysMenu::whereRaw($condtion)->orderBy('order_id', 'asc')->get();
		$dataAll = [];
		foreach ($objs as $obj)
		{
			$dataAll[] = ['id'=>$obj->id,'pId'=>$obj->pid,'name'=>$obj->menu_name,
					'menu_path'=>$obj->menu_path,'remarks'=>$obj->remarks,'menu_status'=>$obj->menu_status,
					'order_id'=>$obj->order_id,'group'=>$obj->group
			];
		}
		
		$model = SysGroup::findOrNew($gid);
		$data = [];
		$sysMenu = new SysMenu();
		$objs = SysMenu::whereRaw('id in(select menu_id from '.DB::getTablePrefix().'sys_group_menu where group_id=?)', [$gid])->get();
		foreach ($objs as $obj)
		{
			$data[] = ['id'=>$obj->id,'pId'=>$obj->pid,'name'=>$obj->menu_name,
					'menu_path'=>$obj->menu_path,'remarks'=>$obj->remarks,'menu_status'=>$obj->menu_status,'order_id'=>$obj->order_id
			];
		}
		return view('admin.sysGroup.menuTree', ['data' => json_encode($data),'model'=>$model,'dataAll' => json_encode($dataAll)]);
	}
	
	/**
	 * 组添加菜单管理
	 * @param unknown $gid
	 */
	public function ajaxAddMenu(Request $request)
	{
		
		
		$rs = array('code'=>'000','msg'=>'保存成功');
		$msg = '保存失败';
		$mids = $request->get('mids');
		$gid = $request->get('gid');
		$mids = explode(',', $mids);
		foreach ($mids as $mid)
		{
			$menu = SysMenu::find($mid);
			if(!$menu)
			{
				continue;
			}
			$u = SysGroupMenu::where(['group_id'=>$gid,'menu_id'=>$menu->pid])->get();
			if(!count($u))
			{
				$model = new SysGroupMenu();
				$model->id = Common::getId();
				$model->group_id = $gid;
				$model->menu_id = $menu->pid;
				$model->save();
			}
			$u = SysGroupMenu::where(['group_id'=>$gid,'menu_id'=>$mid])->get();
			if(!count($u))
			{
				$model = new SysGroupMenu();
				$model->id = Common::getId();
				$model->group_id = $gid;
				$model->menu_id = $mid;
				if (!$model->save()){
					$msg .= ','.$model->mid;
					$rs = array('code'=>'999','msg'=>$msg);
				}
			}
		}
		echo json_encode($rs);
		
	}
	/**
	 * 组删除菜单管理
	 * @param unknown $gid
	 */
	public function ajaxDelMenu(Request $request)
	{
		$rs = ['code'=>'000','msg'=>'删除成功'];
		$msg = '删除失败';
		
		$mids = $request->get('mids');
		$gid = $request->get('gid');
		$mids = explode(',', $mids);
		foreach ($mids as $mid)
		{
			$gm = SysGroupMenu::firstOrNew(['group_id'=>$gid,'menu_id'=>$mid]);
			SysGroupMenu::destroy($gm->id);
		}
		echo json_encode($rs);
	}
}
