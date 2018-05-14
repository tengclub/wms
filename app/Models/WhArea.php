<?php
namespace App\Models;
use App\Lib\SysKey;

class WhArea extends SysModel
{
	protected $table = 'wh_area';
	public static function getLabels()
	{
		return [
			'id'=>'表主键',
			'code'=>'编码',
			'warehouse_id'=>'仓库',
			'title'=>'名称',
			'volume'=>'容积',
			'status'=>'状态',
			'create_time'=>'创建时间',
			'create_user'=>'创建人',
			'update_time'=>'更新时间',
			'update_user'=>'更新人',
			'remark'=>'备注',
		];
	}
	public static function getIdList($warehouse_id = null,$select = false)
	{
		$rs = null;
		if($select)
		{
			$rs[''] = '请选择';
		}
		if($warehouse_id)
		{
			$data = self::where(['status'=>SysKey::$statusOkValue])->where(['warehouse_id'=>$warehouse_id])->get();
		}else{
			$data = self::where(['status'=>SysKey::$statusOkValue])->get();
		}
		
		foreach ($data as $obj)
		{
			$rs[$obj->id] = $obj->title;
		}
		return $rs;
	}
	public static function getCodeList($warehouse_id = null,$select = false)
	{
		$rs = null;
		if($select)
		{
			$rs[''] = '请选择';
		}
		if($warehouse_id)
		{
			$data = self::where(['status'=>SysKey::$statusOkValue])->where(['warehouse_id'=>$warehouse_id])->get();
		}else{
			$data = self::where(['status'=>SysKey::$statusOkValue])->get();
		}
		foreach ($data as $obj)
		{
			$rs[$obj->code] = $obj->title;
		}
		return $rs;
	}
}
