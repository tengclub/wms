<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Input;
use App\Page;
use App\Models\SysGroupWapMenu;
use App\Models\SysGroup;
use App\Models\WapMenu;
use App\Models\SysLog;
use App\Lib\Common;
use App\Lib\SysKey;

class SysGroupWapMenuController 
{
	/**
	 * 全部列表
	 * @return \Illuminate\View\View
	 */
	public function index(Request $request,$gid)
	{
		$model = new SysGroupWapMenu();
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
    		$data = SysGroupWapMenu::whereRaw($condtion)->orderBy($request->get('field','id'),$request->get('order','desc'))->paginate($request->get('limit'));
    		foreach ($data as $obj) {
    			foreach ($obj->getAttributes() as $k=>$v) {
    				$_tmp[$k] = $v;
    				if($k == 'menu_id')
    				{
    					$_tmp['menu_id_text'] = WapMenu::findOrNew($v)->menu_name;
    				}
    			}
    			$_data[] = $_tmp;
    		}
    		echo json_encode(['data'=>$_data,'count'=>$data->total(),'code'=>0,'msg'=>'']);
    		return;
    	}
		return view('admin.sysGroupWapMenu.index', ['model'=>$model,'group'=>$group]);
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$model = new SysGroupWapMenu();
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
					return view('admin.public.msgOk', ['msg'=>'保存成功','url'=>url('admin/sysGroupWapMenu/index')]);
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
		return view('admin.sysGroupWapMenu.create', ['model'=>$model]);
	}
	/**
	 * Show the form for creating a new resource.
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$model = SysGroupWapMenu::findOrNew($id);
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
					return view('admin.public.msgOk', ['msg'=>'保存成功','url'=>url('admin/sysGroupWapMenu/index')]);
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
		return view('admin.sysGroupWapMenu.create', ['model'=>$model]);
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
			$model = SysGroupWapMenu::findOrNew($id);
			SysGroupWapMenu::destroy($id);
		}
		return redirect('admin/sysGroupWapMenu/index');
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
			$model = SysGroupWapMenu::findOrNew($id);
			SysGroupWapMenu::destroy($id);
		}
		echo json_encode($rs);
	}
	public function ajaxAdd(Request $request)
	{
		$rs = ['code'=>'000','msg'=>'添加成功'];
		$menu = $request->get('menu');
		$menu = explode(',', $menu);
		$gid = $request->get('gid');
		foreach ($menu as $m)
		{
			$model = SysGroupWapMenu::firstOrNew(['group_id'=>$gid,'menu_id'=>$m]);
			if(!$model->id)
			{
				$model->id = Common::getId();
				$model->menu_id = $m;
				$model->group_id = $gid;
				$model->save();
			}
		}
		echo json_encode($rs);
	}
}
