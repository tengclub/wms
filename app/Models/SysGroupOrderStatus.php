<?php
namespace App\Models;

class SysGroupOrderStatus extends SysModel
{
	protected $table = 'sys_group_order_status';
	public static function getLabels()
	{
		return [
			'id'=>'主建自增',
			'group_id'=>'用户组id',
			'order_status_id'=>'权限',
			'next_order_status_id'=>'下一状态',
			'before_order_status_id'=>'前一状态',
		];
	}
}
