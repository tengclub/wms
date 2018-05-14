<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\SysUser;
use Illuminate\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Input;
use App\Includes\Common;
use App\Page;
use Illuminate\Support\Facades\Session;
class PublicController extends Controller
{

   
    /**
     * login
     * @return Ambigous <\Illuminate\Routing\Redirector, \Illuminate\Http\RedirectResponse>
     */
    public function login()
    {
    	$reUrl = 'admin/home/index';
    	if(isset($_GET['reUrl']))
    	{
    		$reUrl = $_GET['reUrl'];
    	}
    	if(Session::has('admin'))
    	{
    		return redirect($reUrl);
    	}
    	$model = new SysUser();
    	if(isset($_POST['page']))
    	{
    		$page = $_POST['page'];
    		$validator = Validator::make($page,
    			[
    				'user' => 'required',
    				'password' => 'required',
    			]
    		);
    		foreach ($page as $key=>$value)
    		{
    			$model->$key = $value;
    		}
    		if ($validator->passes())
    		{
    			$user = SysUser::where('user', $page['user'])->first();
    			if($user)
    			{
    				if($user->password == md5($model->password))
    				{
    					Session::put('admin',$user);
    					return redirect($reUrl);
    				}else {
    					$validator->errors()->add('user', '密码错误');
    					$model->errors = $validator->messages();
    				}
    			}else {
    				$validator->errors()->add('user', '用户不存在');
    				$model->errors = $validator->messages();
    			}
    		}else {
    			$model->errors = $validator->messages();
    		}
    	}
    	return view('admin.public.login', ['model'=>$model]);
    }
    /**
     * logout
     */
    public function logout()
    {
    	Session::forget('admin');
    	return redirect('admin/pub/login');
    }
}
