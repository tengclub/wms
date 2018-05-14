<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SysGroupUser extends SysModel
{
	
    //
	protected $table = 'sys_group_user';
	public static  function getLabels()
	{
		return array(
			'id' => 'ID',
			'group_id' => '用户组',
			'user' => '用户名',
		);
	} 
}
