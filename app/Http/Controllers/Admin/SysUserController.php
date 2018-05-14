<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\SysUser;
use App\Models\SysLog;
use App\Models\SysGroupUser;
use Illuminate\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

use Input;
use App\Lib\Common;
use App\Lib\SysKey;
use App\Page;

class SysUserController 
{
	/**
	 * 全部列表
	 * @return \Illuminate\View\View
	 */
	public function index()
	{
		$model = new SysUser();
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
		return view('admin.sysUser.index',['model'=>$model]);
	}
	/**
	 * 全部列表
	 * @return \Illuminate\View\View
	 */
	public function ajaxData(Request $request)
	{
		$_data = null;
		$model = new SysUser();
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
		$data = SysUser::whereRaw($condtion)->orderBy($request->get('field','id'),$request->get('order','desc'))->paginate($request->get('limit'));
		foreach ($data as $boj) {
			foreach ($boj->getAttributes() as $k=>$v) {
				$_tmp[$k] = $v;
				if($k=='user_status')
				{
					$_tmp['user_status_text'] = SysKey::getStatusByValue($v);
				}
				if($k=='level')
				{
					$_tmp['level_text'] = SysKey::getSysUserLevelByValue($v);
				}
			}
			$_data[] = $_tmp;
		}
		echo json_encode(['data'=>$_data,'count'=>$data->total(),'code'=>0,'msg'=>'']);
	}
	

//     /**
//      * Display a listing of the resource.
//      *
//      * @return Response
//      */
//     public function index()
//     {
//     	$model = new SysUser();
//     	$condtion = '1=1';
//     	$page = null;
//     	if(Input::all())
//     	{
//     		$page = Input::all();
//     		foreach ($page as $key=>$value)
//     		{
//     			if(in_array($key,array_keys($model->labels)))
//     			{
//     				$model->$key = $value;
//     				$condtion .=' and '.$key.' like "%'.$value.'%"';
//     			}
//     		}
//     	}
//     	$data = SysUser::whereRaw($condtion)->paginate(10);
//     	$data->appends($page);
//     	return view('admin.sysUser.index', ['data' => $data,'model'=>$model]);
//     }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $model = new SysUser();
    	if(isset($_POST['page']))
    	{
    		$page = $_POST['page'];
    		$validator = Validator::make($page,
    			[
    				'user' => 'required|unique:sys_user',
     				'password' => 'required',
//     					'password' => 'required|min:8',
    					//'mail' => 'required|email',
    					//'phone' => 'required|numeric',
    			]
    		);
    		foreach ($page as $key=>$value)
    		{
    			$model->$key = $value;
    		}
	    	if ($validator->passes())
	    	{
	    		$model->id = Common::getId();
	    		$model->password = md5($model->password);
	    		$model->create_date = Common::formatTimeStamp2DateTime();
	    		if ($model->save()) {
	    			$sysLog = new SysLog();
	    			$sysLog->log_type = SysKey::$sysLogAddValue;
	    			$sysLog->content = '添加用户'.$model->user.'';
	    			$sysLog->esave();
	    			return view('admin.public.msgOk', ['msg'=>'添加成功','url'=>url('admin/sysUser/index')]);
	    		} else {
	    			return Redirect::back()->withInput()->withErrors('添加失败');
	    		}
	    	}else {
	    		$model->errors = $validator->messages();
	    	}
    	}else {
    		$validator = Validator::make(array(),array());
    		$model->errors = $validator->messages();
    	}
    	return view('admin.sysUser.create', ['model'=>$model]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
    	$model = SysUser::find($id);
    	
    	if(isset($_POST['page']))
    	{
    		$page = $_POST['page'];
    		$validator = Validator::make($page,
    			[
//      			 	'user' => 'required',
//     				'password' => 'required',
    				//'mail' => 'required|email',
    					//'phone' => 'required|numeric',
    			]
    		);
    		foreach ($page as $key=>$value)
    		{
    			if($key == 'password')
				{
					if($value)
					{
						$model->password = md5($value);
					}
				}else{
					$model->$key = $value;
				}
    		}
	    	if ($validator->passes())
	    	{
	    		if ($model->save()) {
	    			$sysLog = new SysLog();
	    			$sysLog->log_type = SysKey::$sysLogUpdateValue;
	    			$sysLog->content = '修改密码'.$model->user.'';
	    			$sysLog->esave();
	    			return view('admin.public.msgOk', ['msg'=>'修改成功','url'=>url('admin/sysUser/index')]);
	    		} else {
	    			return Redirect::back()->withInput()->withErrors('修改失败');
	    		}
	    	}else {
	    		$model->errors = $validator->messages();
	    	}
    	}else {
    		$validator = Validator::make(array(),array());
    		$model->errors = $validator->messages();
    	}
    	$model->password = '';
    	return view('admin.sysUser.edit', ['model'=>$model]);
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
        	$sysLog->content = '删除了用户'.$model->user.'';
        	$sysLog->esave();
        	SysUser::destroy($id);
        }
        return redirect('admin/sysUser/index');
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
    	if(SysUser::destroy($ids))
    	{
    		$rs = ['code'=>'000','msg'=>'删除成功'];
    	}else{
    		$rs = ['code'=>'999','msg'=>'删除失败'];
    	}
    
    	echo json_encode($rs);
    
    }
    /**
     * 缁勬坊鍔犵敤鎴峰垪琛�
     * @return \Illuminate\View\View
     */
    public function group($gid,Request $request)
    {
    	$model = new SysUser();
//     	$gid = $request->get('gid');
    	$condtion = '1=1';
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
    	
//     	$data = SysUser::whereNotIn('user',$array)->whereRaw($condtion)->paginate(10);
    	
    	if($request->get('__data'))
    	{
    		$array = SysGroupUser::where('group_id',$gid)->pluck('user');
    		if(!$array)
    		{
    			$array = [];
    		}
    		
    		$_data = null;
    		$data = SysUser::whereNotIn('user',$array)->whereRaw($condtion)->orderBy($request->get('field','id'),$request->get('order','desc'))->paginate($request->get('limit'));
    		foreach ($data as $boj) {
    			foreach ($boj->getAttributes() as $k=>$v) {
    				$_tmp[$k] = $v;
    				if($k=='user_status')
    				{
    					$_tmp['user_status_text'] = SysKey::getStatusByValue($v);
    				}
    				if($k=='level')
    				{
    					$_tmp['level_text'] = SysKey::getSysUserLevelByValue($v);
    				}
    			}
    			$_data[] = $_tmp;
    		}
    		echo json_encode(['data'=>$_data,'count'=>$data->total(),'code'=>0,'msg'=>'']);
    		return;
    	}
    	
    	return view('admin.sysUser.group', ['model'=>$model,'gid'=>$gid]);
    }
    
    public function editMyPwd()
    {
    	$model = session('admin');
    	if(isset($_POST['page']))
    	{
    		$page = $_POST['page'];
    
    		if (md5($page['password'])==$model->password)
    		{
    			if($page['newPwd']==$page['reNewPwd'])
    			{
    				$model->password = md5($page['newPwd']);
    				if ($model->save()) {
    					return view('admin.public.msgOk', ['msg'=>'修改成功','url'=>url('admin/sysUser/editMyPwd')]);
    				} else {
    					return view('admin.public.msgNo', ['msg'=>'修改失败','url'=>url('admin/sysUser/editMyPwd')]);
    				}
    			}else{
    				return view('admin.public.msgNo', ['msg'=>'两次密码不一致','url'=>url('admin/sysUser/editMyPwd')]);
    			}
    		}else {
    			return view('admin.public.msgNo', ['msg'=>'当前登录用户密码不正确','url'=>url('admin/sysUser/editMyPwd')]);
    		}
    	}
    	return view('admin.sysUser.editMyPwd', ['model'=>$model]);
    }
    
}
