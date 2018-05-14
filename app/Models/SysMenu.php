<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SysMenu extends SysModel
{
	protected $table = 'sys_menu';
	/**
	 * 菜单labels
	 * @return array
	 */
	public static  function getLabels()
	{
		return array(
			'id' => 'ID',
			'pid' => '父菜单',
			'menu_name' => '菜单名',
// 			'menu_type' => '类型',
// 			'menu_site' => '菜单位置',
			'menu_path' => '菜单地址',
// 			'target' => '打开框架名',
			'remarks' => '备注',
			'menu_status' => '状态',
			'order_id' => '排序',
			'group' => '分组',
		);
	}
	/**
	 * 获取菜单名称
	 * @param sting $id
	 * @return string
	 */
	public static function getMenuNameById($id)
	{
		$rs = '';
		if($id=='0')
		{
			$rs = '根';
		}else {
			$model = SysMenu::find($id);
			if($model)
			{
				$rs = $model->menu_name;
			}
		}
		return $rs;
	}
	/**
	 * 获取父菜单
	 * @param string $pid
	 * @return string
	 */
	public static function getParentMenuList($pid = '0')
	{
		$rs = array('0'=>'请选择');
		$model = SysMenu::where('pid', $pid)->get();
		if($model)
		{
			foreach ($model as $obj)
			{
				$rs[$obj->id] = $obj->menu_name;
			}
		}
		return $rs;
	}
	/**
	 * 获取全部菜单
	 * @param string $pid
	 * @return string
	 */
	public static function getAllMenuList()
	{
		$rs = array('0'=>'请选择');
		$model = SysMenu::all();
		if($model)
		{
			foreach ($model as $obj)
			{
				$rs[$obj->id] = $obj->menu_name;
			}
		}
		return $rs;
	}
}
