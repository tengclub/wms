<?php
namespace App\Lib;
class SysKey
{
	
	//请选择
	public static $selectValue = '';
	public static $selectText = '请选择';


	//系统用户级别
	public static $sysUserLevelSuperAdminValue = '99';
	public static $sysUserLevelSuperAdminText = '超级管理员';
	public static $sysUserLevelAdminValue = '10';
	public static $sysUserLevelAdminText = '主管';
	public static $sysUserLevelUserValue = '1';
	public static $sysUserLevelUserText = '用户';
// 	public static $sysUserLevelDevValue = '20';
// 	public static $sysUserLevelDevText = '开发';
	
	
	//状态
	public static $statusOkValue = '1';
	public static $statusOkText = '正常';
	public static $statusLockValue = '9';
	public static $statusLockText = '锁定';
	
	//审核状态
	public static $auditPassValue = '1';
	public static $sauditPassText = '正常';
	public static $auditOffValue = '9';
	public static $auditOffText = '锁定';
	
	
	
	
	
	//是否
	public static $yesValue = '1';
	public static $yesText = '是';
	public static $noValue = '9';
	public static $noText = '否';
	
	//true/false
	public static $trueValue = '1';
	public static $trueText = 'true';
	public static $falseValue = '9';
	public static $falseText = 'false';
	
	
	
	
	
	//log类型
	public static $sysLogLoginValue = '1';
	public static $sysLogLoginText = '登录';
	public static $sysLogLogoutValue = '2';
	public static $sysLogLogoutText = '退出';
	public static $sysLogAddValue = '3';
	public static $sysLogAddText = '添加';
	public static $sysLogUpdateValue = '4';
	public static $sysLogUpdateText = '更新';
	public static $sysLogDelValue = '5';
	public static $sysLogDelText = '册除';
	
	//前台用户级别
	public static $userLevelGeneralValue = '1';
	public static $userLevelGeneralText = '普通用户';
	public static $userLevelVipValue = '10';
	public static $userLevelVipText = 'VIP用户';
	

	/**
	 * 会员类型  listData
	 * Enter description here ...
	 */
	public static function getUserLevelList($isSelect=false)
	{
		$listData=array();
		if($isSelect)
		{
			$listData[self::$selectValue] = self::$selectText;
		}
		$listData[self::$userLevelGeneralValue] = self::$userLevelGeneralText;
		$listData[self::$userLevelVipValue] = self::$userLevelVipText;
		return $listData;
	}
	/**
	 * 获取会员类型Text
	 * Enter description here ...
	 * @param unknown_type $value
	 */
	public static function getUserLevelByValue($value)
	{
		$rs='';
		switch ($value)
		{
			case  self::$userLevelGeneralValue :
				$rs=self::$userLevelGeneralText;
				break;
			case self::$userLevelVipValue :
				$rs=self::$userLevelVipText;
				break;
		}
		return $rs;
	}
	
	
	//bug状态
	public static $bugStatusPendingValue = '0';
	public static $bugStatusPendingText = '待处理';
	public static $bugStatusHandledValue = '1';
	public static $bugStatusHandledText = '已处理';
	
	
	/**
	 * bug状态  listData
	 * Enter description here ...
	 */
	public static function getBugStatusList($isSelect=false)
	{
		$listData=array();
		if($isSelect)
		{
			$listData[self::$selectValue] = self::$selectText;
		}
		$listData[self::$bugStatusPendingValue] = self::$bugStatusPendingText;
		$listData[self::$bugStatusHandledValue] = self::$bugStatusHandledText;
		return $listData;
	}
	/**
	 * 获取bug状态Text
	 * Enter description here ...
	 * @param unknown_type $value
	 */
	public static function getBugStatusByValue($value)
	{
		$rs='';
		switch ($value)
		{
			case  self::$bugStatusPendingValue :
				$rs=self::$bugStatusPendingText;
				break;
			case self::$bugStatusHandledValue :
				$rs=self::$bugStatusHandledText;
				break;
		}
		return $rs;
	}
	
	
	/**
	 * 日志类型  listData
	 * Enter description here ...
	 */
	public static function getSysLogTypeList($isSelect=false)
	{
		$listData=array();
		if($isSelect)
		{
			$listData[self::$selectValue] = self::$selectText;
		}
		$listData[self::$sysLogLoginValue] = self::$sysLogLoginText;
		$listData[self::$sysLogLogoutValue] = self::$sysLogLogoutText;
		$listData[self::$sysLogAddValue] = self::$sysLogAddText;
		$listData[self::$sysLogUpdateValue] = self::$sysLogUpdateText;
		$listData[self::$sysLogDelValue] = self::$sysLogDelText;
		return $listData;
	}
	/**
	 * 获取日志类型Text
	 * Enter description here ...
	 * @param unknown_type $value
	 */
	public static function getSysLogTypeByValue($value)
	{
		$rs='';
		switch ($value)
		{
			case  self::$sysLogLoginValue :
				$rs=self::$sysLogLoginText;
				break;
			case self::$sysLogLogoutValue :
				$rs=self::$sysLogLogoutText;
				break;
			case self::$sysLogAddValue :
				$rs=self::$sysLogAddText;
				break;
			case self::$sysLogUpdateValue :
				$rs=self::$sysLogUpdateText;
				break;
			case self::$sysLogDelValue :
				$rs=self::$sysLogDelText;
				break;
		}
		return $rs;
	}
	
	
	/**
	 * 获取getTrueFalse listData
	 * Enter description here ...
	 */
	public static function getTrueFalseList($isSelect=false)
	{
		$listData=array();
		if($isSelect)
		{
			$listData[self::$selectValue] = self::$selectText;
		}
		$listData[self::$trueValue] = self::$trueText;
		$listData[self::$falseValue] = self::$falseText;
		return $listData;
	}
	/**
	 * 获取TrueFalseText
	 * Enter description here ...
	 * @param unknown_type $value
	 */
	public static function getTrueFalseByValue($value)
	{
		$rs='';
		switch ($value)
		{
			case  self::$trueValue :
				$rs=self::$trueText;
				break;
			case self::$falseValue :
				$rs=self::$falseText;
				break;
		}
		return $rs;
	}
	
	/**
	 * 获取用户级别
	 * Enter description here ...
	 */
	public static function getSysUserLevelList($isSelect=false)
	{
		$listData=array();
		if($isSelect)
		{
			$listData[self::$selectValue] = self::$selectText;
		}
		$listData[self::$sysUserLevelSuperAdminValue] = self::$sysUserLevelSuperAdminText;
		$listData[self::$sysUserLevelAdminValue] = self::$sysUserLevelAdminText;
// 		$listData[self::$sysUserLevelDevValue] = self::$sysUserLevelDevText;
		$listData[self::$sysUserLevelUserValue] = self::$sysUserLevelUserText;
		
		return $listData;
	}
	/**
	 * 获取用户级别Text
	 * Enter description here ...
	 * @param unknown_type $value
	 */
	public static function getSysUserLevelByValue($value)
	{
		$rs='';
		switch ($value)
		{
			case  self::$sysUserLevelSuperAdminValue :
				$rs=self::$sysUserLevelSuperAdminText;
				break;
			case  self::$sysUserLevelAdminValue :
				$rs=self::$sysUserLevelAdminText;
				break;
			case self::$sysUserLevelUserValue :
				$rs=self::$sysUserLevelUserText;
				break;
// 			case self::$sysUserLevelDevValue :
// 				$rs=self::$sysUserLevelDevText;
				break;
		}
		return $rs;
	}
	/**
	 * 获取状态 锁定正常
	 * Enter description here ...
	 * @param unknown_type $isSelect
	 */
	public static function getStatusList($isSelect=false)
	{
		$listData=array();
		if($isSelect)
		{
			$listData[self::$selectValue] = self::$selectText;
		}
		$listData[self::$statusOkValue] = self::$statusOkText;
		$listData[self::$statusLockValue] = self::$statusLockText;

		return $listData;
	}
	/**
	 * 获取状态标题by value
	 * Enter description here ...
	 * @param unknown_type $value
	 */
	public static function getStatusByValue($value)
	{
		$rs='';
		switch ($value)
		{
			case  self::$statusOkValue :
				$rs=self::$statusOkText;
				break;
			case  self::$statusLockValue :
				$rs=self::$statusLockText;
				break;
		}
		return $rs;
	}
	

	
	
	
	
	
	
	
	
	
	
	/**
	 * 获取是否list
	 * Enter description here ...
	 * @param unknown_type $isSelect
	 */
	public static function getYesOrNoList($isSelect = false)
	{
		$listData = array();
		if($isSelect)
		{
			$listData[self::$selectValue] = self::$selectText;
		}
		$listData[self::$yesValue] = self::$yesText;
		$listData[self::$noValue] = self::$noText;

		return $listData;
	}
	/**
	 * 是否by value
	 * Enter description here ...
	 * @param unknown_type $value
	 */
	public static function getYesOrNoByValue($value)
	{
		$rs='';
		switch ($value)
		{
			case  self::$yesValue :
				$rs=self::$yesText;
				break;
			case  self::$noValue :
				$rs=self::$noText;
				break;
		}
		return $rs;
	}
	
	/**
	 * 审核状态list
	 * @param unknown_type $isSelect
	 */
	public static function getAuditList($isSelect=false)
	{
		$listData=array();
		if($isSelect)
		{
			$listData[self::$selectValue] = self::$selectText;
		}
		$listData[self::$auditPassValue] = self::$sauditPassText;
		$listData[self::$auditOffValue] = self::$auditOffText;
	
		return $listData;
	}
	/**
	 * 是否by value
	 * Enter description here ...
	 * @param unknown_type $value
	 */
	public static function getAuditByValue($value)
	{
		$rs='';
		switch ($value)
		{
			case  self::$auditPassValue :
				$rs=self::$sauditPassText;
				break;
			case  self::$auditOffValue :
				$rs=self::$auditOffText;
				break;
		}
		return $rs;
	}
	
	public static function getProvinceList()
	{
		$data['bj'] = '北京市';
		$data['sh'] = '上海市';
		$data['tj'] = '天津市';
		$data['cq'] = '重庆市';
		$data['ah'] = '安徽省';
		$data['fj'] = '福建省';
		$data['gs'] = '甘肃省';
		$data['gd'] = '广东省';
		$data['gz'] = '贵州省';
		$data['hn'] = '海南省';
		$data['hb'] = '河北省';
		$data['hlj'] = '黑龙江省';
		$data['hn'] = '河南省';
		$data['hb'] = '湖北省';
		$data['hn'] = '湖南省';
		$data['js'] = '江苏省';
		$data['jx'] = '江西省';
		$data['jl'] = '吉林省';
		$data['ln'] = '辽宁省';
		$data['qh'] = '青海省';
		$data['sx'] = '陕西省';
		$data['sd'] = '山东省';
		$data['sx'] = '山西省';
		$data['sc'] = '四川省';
		$data['tw'] = '台湾省';
		$data['yn'] = '云南省';
		$data['zj'] = '浙江省';
		$data['am'] = '澳门特别行政区';
		$data['xg'] = '香港特别行政区';
		$data['gx'] = '广西壮族自治区';
		$data['xj'] = '新疆维吾尔族自治区';
		$data['nx'] = '宁夏回族自治区';
		$data['xz'] = '西藏自治区';
		$data['nmg'] = '内蒙古自治区';
		
		return $data;
	}
	public static function getProvinceByValue($value)
	{
		$rs = '';
		$data = self::getProvinceList();
		foreach ($data as $k=>$v)
		{
			if($k==$value)
			{
				$rs = $v;
			}
		}
		return $rs;
	}
	
	//文章Flag
	public static $newsFlagIndexValue = '101';
	public static $newsFlagIndexText = '首页';
	public static $newsFlagTopValue = '102';
	public static $newsFlagTopText = '头条';
	public static $newsFlagHotValue = '103';
	public static $newsFlagHotText = '热门';
	public static $newsFlagRecommendValue = '104';
	public static $newsFlagRecommendText = '推荐';
	
	
	/**
	 * 文章Flag  listData
	 * Enter description here ...
	 */
	public static function getNewsFlagList($isSelect=false)
	{
		$listData=array();
		if($isSelect)
		{
			$listData[self::$selectValue] = self::$selectText;
		}
		$listData[self::$newsFlagIndexValue] = self::$newsFlagIndexText;
		$listData[self::$newsFlagTopValue] = self::$newsFlagTopText;
		$listData[self::$newsFlagHotValue] = self::$newsFlagHotText;
		$listData[self::$newsFlagRecommendValue] = self::$newsFlagRecommendText;
		return $listData;
	}
	/**
	 * 获取文章FlagText
	 * Enter description here ...
	 * @param unknown_type $value
	 */
	public static function getNewsFlagByValue($value)
	{
		$rs='';
	    if($value)
	    {
	        $data = self::getNewsFlagList();
	        if(!is_array($value))
	        {
	            $value = explode(",",$value);
	        }
	        foreach ($value as $v){
	            $rs .= ','.$data[$v];
	        }
	        $rs = substr($rs, 1);
	    }
	    return $rs;
	}
	
	//会员用户type
	public static $userTypeGeneralValue = '1';
	public static $userTypeGeneralText = '普通用户';

	
	
	/**
	 * 会员用户type listData
	 * Enter description here ...
	 */
	public static function getUserTypeList($isSelect=false)
	{
		$listData=array();
		if($isSelect)
		{
			$listData[self::$selectValue] = self::$selectText;
		}
		$listData[self::$userTypeGeneralValue] = self::$userTypeGeneralText;
		return $listData;
	}
	/**
	 * 会员用户type Text
	 * Enter description here ...
	 * @param unknown_type $value
	 */
	public static function getUserTypeByValue($value)
	{
		$rs='';
		if($value)
		{
			$data = self::getUserTypeList();
			if(!is_array($value))
			{
				$value = explode(",",$value);
			}
			foreach ($value as $v){
				$rs .= ','.$data[$v];
			}
			$rs = substr($rs, 1);
		}
		return $rs;
	}
	/**
	 * 仓库1位编码
	 */
	public static function getWhCode1List()
	{
		$rs = ['A'=>'A','B'=>'B','C'=>'C','D'=>'D','E'=>'E','F'=>'F','G'=>'G','H'=>'H','I'=>'I','J'=>'J','K'=>'K','L'=>'L','M'=>'M','N'=>'N','O'=>'O','P'=>'P','Q'=>'Q','R'=>'R','S'=>'S','T'=>'T','U'=>'U','V'=>'V','W'=>'W','X'=>'X','Y'=>'Y','X'=>'X'];
		return $rs;
		
	}
	
	
	//订单状html态分类
	public static $orderStatusTypeNoneValue = '9';
	public static $orderStatusTypeNoneText = '无';
	public static $orderStatusTypeInputValue = '1';
	public static $orderStatusTypeInputText = '输入框';
	public static $orderStatusTypeRadioValue = '2';
	public static $orderStatusTypeRadioText = '单选';
	public static $orderStatusTypeCheckboxValue = '3';
	public static $orderStatusTypeCheckboxText = '多选';
	public static $orderStatusTypeDropdownValue = '4';
	public static $orderStatusTypeDropdownText = '下拉';
	public static $orderStatusTypeTextareaValue = '5';
	public static $orderStatusTypeTextareaText = 'Textarea';
	public static $orderStatusTypeInputDateValue = '6';
	public static $orderStatusTypeInputDateText = '日期框';
	public static $orderStatusTypeInputDateTimeValue = '7';
	public static $orderStatusTypeInputDateTimeText = '日期时间框';
	
	
	
	/**
	 * 订单状html态分类 listData
	 * Enter description here ...
	 */
	public static function getOrderStatusTypeList($isSelect=false)
	{
		$listData=array();
		if($isSelect)
		{
			$listData[self::$selectValue] = self::$selectText;
		}
		$listData[self::$orderStatusTypeNoneValue] = self::$orderStatusTypeNoneText;
		$listData[self::$orderStatusTypeInputValue] = self::$orderStatusTypeInputText;
		$listData[self::$orderStatusTypeRadioValue] = self::$orderStatusTypeRadioText;
		$listData[self::$orderStatusTypeCheckboxValue] = self::$orderStatusTypeCheckboxText;
		$listData[self::$orderStatusTypeDropdownValue] = self::$orderStatusTypeDropdownText;
		$listData[self::$orderStatusTypeTextareaValue] = self::$orderStatusTypeTextareaText;
		$listData[self::$orderStatusTypeInputDateValue] = self::$orderStatusTypeInputDateText;
		$listData[self::$orderStatusTypeInputDateTimeValue] = self::$orderStatusTypeInputDateTimeText;
		return $listData;
	}
	/**
	 * 订单状html态分类 Text
	 * Enter description here ...
	 * @param unknown_type $value
	 */
	public static function getOrderStatusTypeByValue($value)
	{
		$rs='';
		if($value)
		{
			$data = self::getOrderStatusTypeList();
			if(!is_array($value))
			{
				$value = explode(",",$value);
			}
			foreach ($value as $v){
				$rs .= ','.$data[$v];
			}
			$rs = substr($rs, 1);
		}
		return $rs;
	}

	
//状态 的状态
	public static $orderStatusStatusIngValue = '1';
	public static $orderStatusStatusIngText = '进行中';
	public static $orderStatusStatusOkValue = '2';
	public static $orderStatusStatusOkText = '完成';
	public static $orderStatusStatusOffValue = '3';
	public static $orderStatusStatusOffText = '关闭';
	public static $orderStatusStatusRefuseValue = '4';
	public static $orderStatusStatusRefuseText = '拒绝';
	
	/**
	 * 订状态 的状态 listData
	 * Enter description here ...
	 */
	public static function getOrderStatusStatusList($isSelect=false)
	{
		$listData=array();
		if($isSelect)
		{
			$listData[self::$selectValue] = self::$selectText;
		}
		$listData[self::$orderStatusStatusIngValue] = self::$orderStatusStatusIngText;
		$listData[self::$orderStatusStatusOkValue] = self::$orderStatusStatusOkText;
		$listData[self::$orderStatusStatusOffValue] = self::$orderStatusStatusOffText;
		$listData[self::$orderStatusStatusRefuseValue] = self::$orderStatusStatusRefuseText;
		return $listData;
	}
	/**
	 * 订单状态 的状态 Text
	 * Enter description here ...
	 * @param unknown_type $value
	 */
	public static function getOrderStatusStatusByValue($value)
	{
		$rs='';
		if($value)
		{
			$data = self::getOrderStatusStatusList();
			if(!is_array($value))
			{
				$value = explode(",",$value);
			}
			foreach ($value as $v){
				$rs .= ','.$data[$v];
			}
			$rs = substr($rs, 1);
		}
		return $rs;
	}
	//状态 的状态
	public static $orderTypeNoneValue = '0';
	public static $orderTypeNoneText = '= 无 =';
	
	/**
	 * 订状态 分类 listData
	 * Enter description here ...
	 */
	public static function getOrderTypeList($isSelect=false)
	{
		$listData=array();
		if($isSelect)
		{
			$listData[self::$selectValue] = self::$selectText;
		}
		$listData[self::$orderTypeNoneValue] = self::$orderTypeNoneText;
		return $listData;
	}
	/**
	 * 订单状态 的状态 Text
	 * Enter description here ...
	 * @param unknown_type $value
	 */
	public static function getOrderTypeByValue($value)
	{
		$rs='';
		if($value)
		{
			$data = self::getOrderTypeList();
			if(!is_array($value))
			{
				$value = explode(",",$value);
			}
			foreach ($value as $v){
				$rs .= ','.$data[$v];
			}
			$rs = substr($rs, 1);
		}
		return $rs;
	}
	
}
?>