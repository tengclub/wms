<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SysGroupMenu extends SysModel
{
	
    //
	protected $table = 'sys_group_menu';
	public static  function getLabels()
	{
		return array(
			'id' => 'ID',
			'group_id' => '用户组',
			'menu_id' => '菜单',
			'remarks' => '备注',
		);
	} 
}
