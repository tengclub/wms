<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SysGroup extends SysModel
{
	
    //
	protected $table = 'sys_group';
	public static  function getLabels()
	{
		return array(
			'id' => 'ID',
			'group_name' => '组名',
			'remarks' => '备注',
			'group_status' => '组状态',
		);
	} 
}
