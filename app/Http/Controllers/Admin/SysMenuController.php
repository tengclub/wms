<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\SysMenu;
use App\Models\SysLog;
use App\Models\SysGroupMenu;
use Illuminate\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

use Input;
use App\Lib\Common;
use App\Lib\Ehtml;
use App\Lib\SysKey;
use App\Page;
use App\Models\SysUser;

class SysMenuController 
{
	public function show()
	{
	
	}

    public function index()
    {
    	$model = new SysMenu();
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
    	$data = SysMenu::whereRaw($condtion)->paginate(10);
    	$data->appends($page);
    	return view('admin.sysMenu.index', ['data' => $data,'model'=>$model]);
    }
    public function adminTree()
    {
    	$data = [];
    	$model = new SysMenu();
    	$objs = SysMenu::orderBy('order_id', 'asc')->get();
    	foreach ($objs as $obj)
    	{
    		$data[] = ['id'=>$obj->id,'pId'=>$obj->pid,'name'=>$obj->menu_name,
    			'menu_path'=>$obj->menu_path,'remarks'=>$obj->remarks,'menu_status'=>$obj->menu_status,
    				'order_id'=>$obj->order_id,'group'=>$obj->group
    		];
    	}
    	return view('admin.sysMenu.adminTree', ['data' => json_encode($data),'model'=>$model]);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function ajaxSave()
    {
    	$data = null;
    	$rs = ['code'=>'000','msg'=>'保存成功','data'=>$data];
    	$model = new SysMenu();
    	if(isset($_POST['page']))
    	{
    		$page = $_POST['page'];
    		$validator = Validator::make($page,
				[
    				'menu_name' => 'required',
//     				'menu_path' =>'required',
    			]
    		);
    		if($page['id'])
    		{
    			$model = SysMenu::findOrNew($page['id']);
    		}
    		foreach ($page as $key=>$value)
    		{
    			$model->$key = $value;
    		}
    		if(!$model->id)
    		{
    			$model->id = Common::getId();
    		}
    		if(!$model->pid)
    		{
    			$model->pid = 0;
    		}
    		if(!$model->order_id)
    		{
    			$model->order_id = 0;
    		}
    		if ($validator->passes())
    		{
    			$objs = SysMenu::orderBy('order_id', 'asc')->get();
		    	foreach ($objs as $obj)
		    	{
		    		$data[] = ['id'=>$obj->id,'pId'=>$obj->pid,'name'=>$obj->menu_name,
		    			'menu_path'=>$obj->menu_path,'remarks'=>$obj->remarks,'menu_status'=>$obj->menu_status,'order_id'=>$obj->order_id
		    		];
		    	}
    			$data['name'] = $model->menu_name;
    			if ($model->save()) {
    				$sysLog = new SysLog();
    				$sysLog->log_type = SysKey::$sysLogAddValue;
    				$sysLog->content = '菜单'.$model->menu_name.'信息';
    				$sysLog->esave();
    				$rs = ['code'=>'000','msg'=>'保存成功','data'=>$data];
    			} else {
    				$rs = ['code'=>'999','msg'=>'保存失败','data'=>$data];
    			}
    		}else {
    			$rs = ['code'=>'999','msg'=>'菜单名不能为空','data'=>$data];
    		}
    	}
    	echo json_encode($rs);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function ajaxDel($ids)
    {
    	$rs = ['code'=>'000','msg'=>'删除成功'];
    	$ids = explode(',', $ids);
    	foreach ($ids as $id)
    	{
    		$model = SysUser::findOrNew($id);
    		$sysLog = new SysLog();
    		$sysLog->log_type = SysKey::$sysLogDelValue;
    		$sysLog->content = '菜单'.$model->menu_name.'信息';
    		$sysLog->esave();
    		SysMenu::destroy($id);
    	}
    	echo json_encode($rs);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function move()
    {
    	$rs = ['code'=>'999','msg'=>'移动失败'];
    	$sid = $_POST['sid'];
    	$did = $_POST['did'];
    	$type = $_POST['type'];
    	$smenu = SysMenu::findOrNew($sid);
    	$dmenu = SysMenu::findOrNew($did);
		//移动到之前
    	if($type == 'prev')
    	{
    		$menus = SysMenu::all()->where('pid', $dmenu->pid);
    		$smenu->pid = $dmenu->pid;
    		$i = 1;
    		foreach ($menus as $obj)
    		{
    			if($obj->id!=$sid)
    			{
    				
    				if($obj->id==$did)
    				{
    					$smenu->order_id = $i;
    					if($smenu->save())
    					{
    						$rs = ['code'=>'000','msg'=>'移动成功'];
    					}
    					$i++;
    				}
    				$obj->order_id = $i;
    				$obj->save();
    			}
    			$i++;
    		}
    	}
    	//移动到之后
    	if($type == 'next')
    	{
    		$menus = SysMenu::all()->where('pid', $dmenu->pid);
    		$smenu->pid = $dmenu->pid;
    		$i = 1;
    		foreach ($menus as $obj)
    		{
    			if($obj->id!=$sid)
    			{
    				$obj->order_id = $i;
    				if($obj->id==$did)
    				{
    					$i++;
    					$smenu->order_id = $i;
    					if($smenu->save())
    					{
    						$rs = ['code'=>'000','msg'=>'移动成功'];
    					}
    				}
    				$obj->save();
    			}
    			$i++;
    		}
    	}
    	//移动到之后
    	if($type == 'inner')
    	{
    		$smenu->pid = $dmenu->id;
    		if($smenu->save())
			{
				$rs = ['code'=>'000','msg'=>'移动成功'];
			}
    	}
    	 echo json_encode($rs);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $model = new SysMenu();
    	if(isset($_POST['page']))
    	{
    		$page = $_POST['page'];
    		$validator = Validator::make($page,
    			[
    				'menu_name' => 'required',
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
	    			$sysLog = new SysLog();
	    			$sysLog->log_type = SysKey::$sysLogAddValue;
	    			$sysLog->content = '菜单'.$model->menu_name.'信息';
	    			$sysLog->esave();
	    			return view('admin.public.msgOk', ['msg'=>'保存成功','url'=>url('admin/sysMenu/index')]);
	    		} else {
	    			return Redirect::back()->withInput()->withErrors('保存失败！');
	    		}
	    	}else {
	    		$model->errors = $validator->messages();
	    	}
    	}
    	return view('admin.sysMenu.create', ['model'=>$model]);
    }

   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
    	$model = SysMenu::find($id);
    	
    	if(isset($_POST['page']))
    	{
    		$page = $_POST['page'];
    		$validator = Validator::make($page,
    			[
    				'menu_name' => 'required',
    			]
    		);
	    	if ($validator->passes())
	    	{
		    	foreach ($page as $key=>$value)
	    		{
	    			$model->$key = $value;
	    		}
	    		if ($model->save()) {
	    			$sysLog = new SysLog();
	    			$sysLog->log_type = SysKey::$sysLogUpdateValue;
	    			$sysLog->content = '菜单'.$model->menu_name.'信息';
	    			$sysLog->esave();
	    			return view('admin.public.msgOk', ['msg'=>'保存成功','url'=>url('admin/sysMenu/index')]);
	    		} else {
	    			return Redirect::back()->withInput()->withErrors('保存失败！');
	    		}
	    	}else {
	    		$model->errors = $validator->messages();
	    	}
    	}
    	return view('admin.sysMenu.edit', ['model'=>$model]);
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
        	$model = SysUser::findOrNew($id);
        	$sysLog = new SysLog();
        	$sysLog->log_type = SysKey::$sysLogDelValue;
        	$sysLog->content = '菜单'.$model->menu_name.'信息';
        	$sysLog->esave();
        	SysMenu::destroy($id);
        }
        return redirect('admin/sysMenu/index');
    }
    public function gridGroup()
    {
    	$model = new SysMenu();
    	$condtion = '1=1';
    	$gid = $_GET['gid'];
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
    	$array = SysGroupMenu::where('group_id',$gid)->lists('menu_id');
    	if(!$array)
    	{
    		$array = [];
    	}
    	$data = SysMenu::whereNotIn('id',$array)->whereRaw($condtion)->paginate(10);
    	return view('admin.sysMenu.gridGroup', ['data' => $data,'model'=>$model,'gid'=>$gid]);
    }
    /**
     * 
     * @return \Illuminate\View\View
     */
    public function gridGroupTree($gid,Request $request)
    {
    	$model = new SysMenu();
    	$condtion = '1=1';
//     	$gid = $request->get('gid');
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
    	$objs = SysMenu::whereRaw($condtion)->orderBy('order_id', 'asc')->get();
    	$data = [];
    	foreach ($objs as $obj)
    	{
    		$data[] = ['id'=>$obj->id,'pId'=>$obj->pid,'name'=>$obj->menu_name,
    				'menu_path'=>$obj->menu_path,'remarks'=>$obj->remarks,'menu_status'=>$obj->menu_status,
    				'order_id'=>$obj->order_id,'group'=>$obj->group
    		];
    	}
    	
    	return view('admin.sysMenu.gridGroupTree', ['data' => json_encode($data),'model'=>$model,'gid'=>$gid]);
    }
}
