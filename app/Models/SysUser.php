<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SysUser extends SysModel
{
	
    //
	protected $table = 'sys_user';
	public static  function getLabels()
	{
		return array(
			'id' => 'ID',
			'user' => '用户名',
			'password' => '用户密码',
			'user_type' => '用户类型',
			'mail' => '邮箱',
			'phone' => '电话',
			'created_at' => '注册时间',
			'level' => '用户级别',
			'remarks' => '备注',
			'user_status' => '用户状态',
			'error_date' => '登录错误时间',
			'error_no' => '登录错误次数',
		);
	} 
}
