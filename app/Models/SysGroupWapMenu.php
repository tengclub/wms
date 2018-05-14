<?php
namespace App\Models;

class SysGroupWapMenu extends SysModel
{
	protected $table = 'sys_group_wap_menu';
	public static function getLabels()
	{
		return [
			'id'=>'主建自增',
			'group_id'=>'用户组id',
			'menu_id'=>'菜单id',
			'remarks'=>'备注',
		];
	}
}
