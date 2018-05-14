<?php
namespace App\Models;
use App\Lib\SysKey;

class OrderStatus extends SysModel
{
	protected $table = 'order_status';
	public static function getLabels()
	{
		return [
			'id'=>'表主键',
			'order_status_type_id'=>'分类',
			'title'=>'名称',
			'code'=>'编码',
			'status'=>'状态',
			'object_type'=>'分类',//(文本，日期，下拉，单选，多选,提示)
			'object_value'=>'附加项',//(1|是，2|否）
			'object_lable'=>'附加信息名称',
			'create_user'=>'创建人',
			'create_time'=>'创建时间',
			'update_user'=>'更新用户',
			'update_time'=>'更新时间',
			'sort'=>'排序',
		];
	}
	public static function getKeysOrNullByTypeId($typeId=null)
	{
		$rs = null;
		if($typeId)
		{
			$data = self::where('order_status_type_id',$typeId)->orderBy('sort')->get();
			foreach ($data as $obj)
			{
				$rs[] = $obj->id;
			}
		}
		return $rs;
	}
	public static function getKeysByTypeId($typeId=null)
	{
		$rs = null;
		if($typeId)
		{
			$data = self::where('order_status_type_id',$typeId)->orderBy('sort')->get();
		}else{
			$data = self::all();
		}
	
		foreach ($data as $obj)
		{
			$rs[] = $obj->id;
		}
		return $rs;
	}
	public static function getListByTypeId($typeId=null,$select = false)
	{
		$rs = null;
		if($select)
		{
			$rs[''] = '请选择';
		}
		if($typeId)
		{
			$data = self::where('order_status_type_id',$typeId)->orderBy('sort')->get();
		}else{
			$data = self::all();
		}
		
		foreach ($data as $obj)
		{
			$rs[$obj->id] = $obj->title;
		}
		return $rs;
	}
	public static function getListCodeByTypeId($typeId=null,$select = false)
	{
		$rs = null;
		if($select)
		{
			$rs[''] = '请选择';
		}
		if($typeId)
		{
			$data = self::where('order_status_type_id',$typeId)->orderBy('sort')->get();
		}else{
			$data = self::all();
		}
	
		foreach ($data as $obj)
		{
			$rs[$obj->code] = $obj->title;
		}
		return $rs;
	}
	public static function getModelsByTypeId($typeId=null)
	{
		$rs = null;
		if($typeId)
		{
			$data = self::where('order_status_type_id',$typeId)->orderBy('sort')->get();
		}else{
			$data = self::all();
		}
		return $data;
	}
	public static function getNextById($id)
	{
		
		$model = self::findOrNew($id);
		$nextStatus = new OrderStatus();
		if($model->status==SysKey::$orderStatusStatusIngValue)
		{
			$orderStatus = self::getModelsByTypeId($model->order_status_type_id);
			if(isset($orderStatus[0]))
			{
				$nextStatus = $orderStatus[0];
			}
			$_i = 0;
			foreach ($orderStatus as $obj)
			{
				if($_i==1)
				{
					$nextStatus = $obj;
					break;
				}
				if($obj->id==$id)
				{
					$_i = 1;
				}
			}
			if($_i==0)
			{
				$nextStatus = new OrderStatus();
			}
		}
		if($nextStatus->object_type==SysKey::$orderStatusTypeRadioValue||
		$nextStatus->object_type==SysKey::$orderStatusTypeCheckboxValue||
		$nextStatus->object_type==SysKey::$orderStatusTypeDropdownValue)
		{
			if($nextStatus->object_value)
			{
				$nextStatus->object_value = explode(',',$nextStatus->object_value);
				$_va = null;
				foreach ($nextStatus->object_value as $value)
				{
					$_tmp = explode('|',$value);
					if(isset($_tmp[1]))
					{
						$_va[] = $_tmp;
					}
					
				}
				$nextStatus->object_value = $_va;
			}else{
				$nextStatus->object_value = [];
			}
		}
		return $nextStatus;
	}
	public static function getBeforeById($id)
	{
	
		$model = self::findOrNew($id);
		$object = new OrderStatus();
		if($model->status==SysKey::$orderStatusStatusIngValue)
		{
			$orderStatus = self::getModelsByTypeId($model->order_status_type_id);
			$_i = 0;
			foreach ($orderStatus as $obj)
			{
				if($obj->id==$id)
				{
					break;
				}
				if($_i==0)
				{
					$object = $obj;
				}
			}
		}
		if($object->object_type==SysKey::$orderStatusTypeRadioValue||
				$object->object_type==SysKey::$orderStatusTypeCheckboxValue||
				$object->object_type==SysKey::$orderStatusTypeDropdownValue)
		{
			if($object->object_value)
			{
				$object->object_value = explode(',',$object->object_value);
				$_va = null;
				foreach ($object->object_value as $value)
				{
					$_tmp = explode('|',$value);
					if(isset($_tmp[1]))
					{
						$_va[] = $_tmp;
					}
						
				}
				$object->object_value = $_va;
			}else{
				$object->object_value = [];
			}
		}
		return $object;
	}
}
