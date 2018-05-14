<?php 
class BaseInfo{
	/**
	 * 
	 * @param unknown $logo_url
	 * @param unknown $brand_name
	 * @param unknown $code_type
	 * @param unknown $title
	 * @param unknown $color
	 * @param unknown $notice
	 * @param unknown $service_phone
	 * @param unknown $description
	 * @param unknown $date_info
	 * @param unknown $sku
	 */
	public $logo_url;//卡券商家LOGO
	public $brand_name;//商家名字,上限为12个汉字
	public $code_type;//卡券的code类型
					/*"CODE_TYPE_TEXT"，文本；
					"CODE_TYPE_BARCODE"，一维码；
					"CODE_TYPE_QRCODE"，二维码；
					"CODE_TYPE_ONLY_QRCODE",二维码无code显示； 
					"CODE_TYPE_ONLY_BARCODE",一维码无code显示；
					"CODE_TYPE_NONE"无code类型*/
	public $title;//卡券名
	public $color;//券颜色，请参考
	public $notice;//使用提醒，上限为12个汉字（一句话描述，展示在首页，示例：请出示二维码核销卡券）
	public $service_phone;//
	public $description;//使用说明。长文本描述，可以分行，上限为1000个汉字
	public $date_info;//使用日期，有效期的信息，仅支持DATE_TYPE_FIX_TIME_RANGE
	public $sku;//商品信息
	
	
	public $sub_title;//卡券名的副标题
	public $use_limit;//
	public $get_limit;//每人可领券的数量限制
	public $use_custom_code;//是否自定义Code码。填写true或false，默认为false。
	public $bind_openid;//是否指定用户领取，填写true或false。默认为否。
	public $can_share;//默认为true
	public $location_id_list;//支持更新适用门店列表
	public $url_name_type;//
	public $custom_url;//商户自定义入口跳转外链的地址链接,跳转页面内容需与自定义cell名称保持匹配
// 	基本卡券数据，对于任何卡券类型base_info字段相同
	public function __construct($logo_url, $brand_name, $code_type, $title, $color, $notice, $service_phone,
			$description, $date_info, $sku)
	{
		if (! $date_info instanceof DateInfo )
			exit("date_info Error");
		if (! $sku instanceof Sku )
			exit("sku Error");
		if (! is_int($code_type) )
			exit("code_type must be integer");
		$this->logo_url = $logo_url;
		$this->brand_name = $brand_name;
		$this->code_type = $code_type;
		$this->title = $title;
		$this->color = $color;
		$this->notice = $notice;
		$this->service_phone = $service_phone;
		$this->description = $description;
		$this->date_info = $date_info;
		$this->sku = $sku;
	}
	function set_sub_title($sub_title){
		$this->sub_title = $sub_title;
	}
	function set_use_limit($use_limit){
		if (! is_int($use_limit) )
			exit("use_limit must be integer");
		$this->use_limit = $use_limit;
	}
	function set_get_limit($get_limit){
		if (! is_int($get_limit) )
			exit("get_limit must be integer");
		$this->get_limit = $get_limit;
	}
	function set_use_custom_code($use_custom_code){
		$this->use_custom_code = $use_custom_code;
	}
	function set_bind_openid($bind_openid){
		$this->bind_openid = $bind_openid;
	}
	function set_can_share($can_share){
		$this->can_share = $can_share;
	}
	function set_location_id_list($location_id_list){
		$this->location_id_list = $location_id_list;
	}
	function set_url_name_type($url_name_type){
		if (! is_int($url_name_type) )
			exit( "url_name_type must be int" );
		$this->url_name_type = $url_name_type;
	}
	function set_custom_url($custom_url){
		$this->custom_url = $custom_url;
	}
};
