<?php
namespace App\Lib;
class Ehtml
{
	/**
	 * 
	 * @param array $data
	 * @param string $value
	 * @param array $option 如：['class'=>'txt','name'=>'name','id'=>'id']
	 */
	public static function  select($data,$value = null,$option = null)
	{
		$rs = '<select ';
		if(!isset($option['id']))
		{
			$option['id'] = 'select1';
		}
		foreach ($option as $k=>$v)
		{
			$rs .= $k.'="'.$v.'" ';
		}
		$rs .= '>';
		if(!empty($data))
		{
			foreach ($data as $k=>$v)
			{
				if($k == $value)
				{
					$rs .= '<option selected = "selected" value="'.$k.'">'.$v.'</option>';
				}else {
					$rs .= '<option value="'.$k.'">'.$v.'</option>';
				}
			}
		}
		$rs .= '</select>';
		return $rs;
	}
	
// 	/**
// 	 *
// 	 * @param array $data
// 	 * @param string $value:复选框的默认选中值，若有多个值，则用","隔开
// 	 * @param array $option 如：['name'=>'attr[13579]','id'=>'attr13579']
// 	 * @param int $eachLineNum 	如：每行所排复选框的个数
// 	 */
// 	public static function  checkbox($data, $value, $option = null, $eachLineNum = 5)
// 	{
// 		$rs = '';
// 		$rs = '<table>';
// 		if(!isset($option['id']))
// 		{
// 			$option['id'] = 'checkbox';
// 		}						
		
// 		$iCnt = 0;	//复选框计数
// 		$iEachLineNum = $eachLineNum;	//每行个数
// 		$iDataTotal = sizeof($data);	//总的个数
// 		$iLineNum = ($iDataTotal-1)/$iEachLineNum + 1; //总的行数
		
// 		$values = explode(',', $value);
		 
// 		foreach ($data as $k=>$v)	//$v:复选框旁边的文字,$k:复选框的值
// 		{
// 			$iCnt = $iCnt + 1;
				
// 			if($iCnt%$iEachLineNum == 1)
// 			{
// 				$rs .= '<tr>';
// 			}
// 			$rs .= '<td>';
			
// 			$isChecked = false;
// 			for($i=0; $i<sizeof($values); $i++){
// 				if($values[$i]==$k)
// 				{
// 					$isChecked = true;
// 					break;
// 				}
// 			}
			
			
// 			if($isChecked)
// 			{
// 				//$rs .= '<input type="checkbox" name="attr['.$pid.']['.$k.']" value="'. $k. '" checked';
// 				$rs .= '<input type="checkbox" value="'. $k. '" checked ';
// 			}else{
// 				//$rs .= '<input type="checkbox" name="attr['.$pid.']['.$k.']" value="'. $k. '"';
// 				$rs .= '<input type="checkbox" value="'. $k. '" ';
// 			}
			
// 			foreach ($option as $kOp=>$vOp)
// 			{
// 				if($kOp=='name'){
// 					$rs .= $kOp.'="'.$vOp.'['.$k.']"';
// 				}else if($kOp=='id'){
// 					$rs .= $kOp.'="'.$vOp.'_'.$k.'"';
// 				}else{
// 					$rs .= $kOp.'="'.$vOp.'" ';
// 				}
// 			}
			
// 			$rs .= '> '.$v.'&nbsp;&nbsp;';
// 			$rs .= '<td>';
			
// 			$iCnt = $iCnt + 1;
			
// 			if($iCnt%$iEachLineNum == 0)
// 			{
// 				$rs .= '</tr>';
// 			}
// 		}
		
// 		$rs .= '</table>';
// 		return $rs;
// 	}
	
	/**
	 *
	 * @param array $data
	 * @param string $value:复选框的默认选中值，若有多个值，则用","隔开
	 * @param array $option 如：['name'=>'attr[13579]','id'=>'attr13579']
	 * @param int $eachLineNum 	如：每行所排复选框的个数
	 */
	public static function  checkbox($data, $value, $option = null, $eachLineNum = 5)
	{
		$rs = '';
		$rs = '<div class="col-md-9">';
		if(!isset($option['id']))
		{
			$option['id'] = 'checkbox';
		}
	
		$iCnt = 0;	//复选框计数
		$iEachLineNum = $eachLineNum;	//每行个数
		$iDataTotal = sizeof($data);	//总的个数
		$iLineNum = ($iDataTotal-1)/$iEachLineNum + 1; //总的行数
	
		$values = explode(',', $value);
			
		foreach ($data as $k=>$v)	//$v:复选框旁边的文字,$k:复选框的值
		{
// 			$iCnt = $iCnt + 1;
	
// 			if($iCnt%$iEachLineNum == 1)
// 			{
// 				$rs .= '<tr>';
// 			}
			$rs .= '<label class="checkbox-inline" for="inline-checkbox1">';
				
			$isChecked = false;
			for($i=0; $i<sizeof($values); $i++){
				if($values[$i]==$k)
				{
					$isChecked = true;
					break;
				}
			}
				
				
			if($isChecked)
			{
				//$rs .= '<input type="checkbox" name="attr['.$pid.']['.$k.']" value="'. $k. '" checked';
				$rs .= '<input type="checkbox" value="'. $k. '" checked ';
			}else{
				//$rs .= '<input type="checkbox" name="attr['.$pid.']['.$k.']" value="'. $k. '"';
				$rs .= '<input type="checkbox" value="'. $k. '" ';
			}
				
			foreach ($option as $kOp=>$vOp)
			{
				if($kOp=='name'){
					$rs .= $kOp.'="'.$vOp.'['.$k.']"';
				}else if($kOp=='id'){
					$rs .= $kOp.'="'.$vOp.'_'.$k.'"';
				}else{
					$rs .= $kOp.'="'.$vOp.'" ';
				}
			}
				
			$rs .= '> '.$v.'&nbsp;&nbsp;';
			$rs .= '</label>';
				
			$iCnt = $iCnt + 1;
				
			if($iCnt%$iEachLineNum == 0)
			{
				$rs .= '</tr>';
			}
		}
	
		$rs .= '</div>';
		return $rs;
	}
}