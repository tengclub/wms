<?php
namespace App\Models;
use App\Lib\SysKey;

class WhShelf extends SysModel
{
	protected $table = 'wh_shelf';
	public static function getLabels()
	{
		return [
			'id'=>'表主键',
			'code'=>'编码',
			'title'=>'名称',
			'status'=>'状态',
			'volume'=>'容积',
			'type'=>'分类',
			'length'=>'长（mm）',
			'width'=>'宽（mm）',
			'height'=>'高（mm）',
			'wh_area_code'=>'区域编码',
			'wh_area_id'=>'区域',
			'create_time'=>'创建时间',
			'create_user'=>'创建人',
			'update_time'=>'更新时间',
			'update_user'=>'更新人',
			'warehouse_id'=>'仓库',
			'warehouse_code'=>'仓库编码'
		];
	}
	public static function getIdList($wh_area_id = null,$warehouse_id = null,$select = false)
	{
		$rs = null;
		if($select)
		{
			$rs[''] = '请选择';
		}
		if($warehouse_id&&$wh_area_id)
		{
			$data = self::where(['status'=>SysKey::$statusOkValue])->where(['warehouse_id'=>$warehouse_id,'wh_area_id'=>$wh_area_id])->get();
		}elseif($warehouse_id){
			$data = self::where(['status'=>SysKey::$statusOkValue])->where(['warehouse_id'=>$warehouse_id,])->get();
		}elseif($wh_area_id){
			$data = self::where(['status'=>SysKey::$statusOkValue])->where(['wh_area_id'=>$wh_area_id])->get();
		}else{
			$data = self::all();
		}
	
		foreach ($data as $obj)
		{
			$rs[$obj->id] = $obj->title;
		}
		return $rs;
	}
	public static function getCodeList($wh_area_id = null,$warehouse_id = null,$select = false)
	{
		$rs = null;
		if($select)
		{
			$rs[''] = '请选择';
		}
		if($warehouse_id&&$wh_area_id)
		{
			$data = self::where(['status'=>SysKey::$statusOkValue])->where(['warehouse_id'=>$warehouse_id,'wh_area_id'=>$wh_area_id])->get();
		}elseif($warehouse_id){
			$data = self::where(['status'=>SysKey::$statusOkValue])->where(['warehouse_id'=>$warehouse_id,])->get();
		}elseif($wh_area_id){
			$data = self::where(['status'=>SysKey::$statusOkValue])->where(['wh_area_id'=>$wh_area_id])->get();
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
