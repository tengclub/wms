<?php
namespace App\Models;

class WapMenu extends SysModel
{
	protected $table = 'wap_menu';
	public static function getLabels()
	{
		return [
			'id'=>'自增',
			'pid'=>'父菜单ID',
			'menu_name'=>'菜单名',
			'menu_type'=>'类型',
			'menu_site'=>'菜单位置',
			'menu_path'=>'菜单地址',
			'target'=>'打开框架名',
			'remarks'=>'备注',
			'menu_status'=>'状态',
			'order_id'=>'排序',
			'group'=>'分组',
			'icon'=>'Icon',
			'icon_img'=>'Icon',
		];
	}
}
