<?php
/**
* 2015-06-29 修复签名问题
**/
namespace App\Lib\Wechat\Pay\Lib;

use App\Lib\Wechat\Pay\Lib\WxPayException;
use App\Lib\Wechat\Pay\Lib\WxPayConfig;
use App\Lib\Wechat\Pay\Lib\WxPayDataBase;


/**
 *
 * 提交企业付款对象
 * @author widyhu
 *
 */
class WxPayMchPay extends WxPayDataBase
{
	
    /**
     * 设置微信分配的公众账号ID
     * @param string $value
     **/
    public function SetMch_appid($value)
    {
        $this->values['mch_appid'] = $value;
    }
    /**
     * 获取微信分配的公众账号ID的值
     * @return 值
     **/
    public function GetMch_appid()
    {
        return $this->values['mch_appid'];
    }
    /**
     * 判断微信分配的公众账号ID是否存在
     * @return true 或 false
     **/
    public function IsMch_appidSet()
    {
        return array_key_exists('mch_appid', $this->values);
    }


    /**
     * 设置微信支付分配的商户号
     * @param string $value
     **/
    public function SetMchid($value)
    {
        $this->values['mchid'] = $value;
    }
    /**
     * 获取微信支付分配的商户号的值
     * @return 值
     **/
    public function GetMchid()
    {
        return $this->values['mchid'];
    }
    /**
     * 判断微信支付分配的商户号是否存在
     * @return true 或 false
     **/
    public function IsMchidSet()
    {
        return array_key_exists('mchid', $this->values);
    }


    /**
     * 设置微信支付分配的终端设备号，与下单一致
     * @param string $value
     **/
    public function SetDevice_info($value)
    {
        $this->values['device_info'] = $value;
    }
    /**
     * 获取微信支付分配的终端设备号，与下单一致的值
     * @return 值
     **/
    public function GetDevice_info()
    {
        return $this->values['device_info'];
    }
    /**
     * 判断微信支付分配的终端设备号，与下单一致是否存在
     * @return true 或 false
     **/
    public function IsDevice_infoSet()
    {
        return array_key_exists('device_info', $this->values);
    }


    /**
     * 设置随机字符串，不长于32位。推荐随机数生成算法
     * @param string $value
     **/
    public function SetNonce_str($value)
    {
        $this->values['nonce_str'] = $value;
    }
    /**
     * 获取随机字符串，不长于32位。推荐随机数生成算法的值
     * @return 值
     **/
    public function GetNonce_str()
    {
        return $this->values['nonce_str'];
    }
    /**
     * 判断随机字符串，不长于32位。推荐随机数生成算法是否存在
     * @return true 或 false
     **/
    public function IsNonce_strSet()
    {
        return array_key_exists('nonce_str', $this->values);
    }

    /**
     * 设置商户订单号
     * @param string $value
     **/
    public function SetPartner_trade_no($value)
    {
        $this->values['partner_trade_no'] = $value;
    }
    /**
     * 获取商户订单号
     * @return 值
     **/
    public function GetPartner_trade_no()
    {
        return $this->values['partner_trade_no'];
    }
    /**
     * 判断微商户订单号是否存在
     * @return true 或 false
     **/
    public function IsPartner_trade_noSet()
    {
        return array_key_exists('partner_trade_no', $this->values);
    }


    /**
     * 商户appid下，某用户的openid
     * @param string $value
     **/
    public function SetOpenid($value)
    {
        $this->values['openid'] = $value;
    }
    /**
     * 商户appid下，某用户的openid
     * @return 值
     **/
    public function GetOpenid()
    {
        return $this->values['openid'];
    }
    /**
     * 商户appid下，某用户的openid
     * @return true 或 false
     **/
    public function IsOpenidSet()
    {
        return array_key_exists('openid', $this->values);
    }

    /**
     * 校验用户姓名选项
     * 设置NO_CHECK：不校验真实姓名
	   FORCE_CHECK：强校验真实姓名（未实名认证的用户会校验失败，无法转账）
	   OPTION_CHECK：针对已实名认证的用户才校验真实姓名（未实名认证用户不校验，可以转账成功）
     * @param string $value
     **/
    public function SetCheck_name($value)
    {
        $this->values['check_name'] = $value;
    }
    /**
     * 获取校验用户姓名选项值
     * @return 值
     **/
    public function GetCheck_name()
    {
        return $this->values['check_name'];
    }
    /**
     * 判断校验用户姓名选项是否存在
     * @return true 或 false
     **/
    public function IsCheck_nameSet()
    {
        return array_key_exists('check_name', $this->values);
    }


    /**
     * 收款用户姓名
     * @param string $value
     **/
    public function SetRe_user_name($value)
    {
        $this->values['re_user_name'] = $value;
    }
    /**
     * 收款用户姓名
     * @return 值
     **/
    public function GetRe_user_name()
    {
        return $this->values['re_user_name'];
    }
    /**
     * 收款用户姓名
     * @return true 或 false
     **/
    public function IsRe_user_nameSet()
    {
        return array_key_exists('re_user_name', $this->values);
    }


    /**
     * 金额 企业付款金额，单位为分
     * @param string $value
     **/
    public function SetAmount($value)
    {
        $this->values['amount'] = $value;
    }
    /**
     * 金额
     * @return 值
     **/
    public function GetAmount()
    {
        return $this->values['amount'];
    }
    /**
     * 金额
     * @return true 或 false
     **/
    public function IsAmountSet()
    {
        return array_key_exists('amount', $this->values);
    }


    /**
     * 企业付款描述信息 企业付款操作说明信息。必填。
     * @param string $value
     **/
    public function SetDesc($value)
    {
        $this->values['desc'] = $value;
    }
    /**
     * 企业付款描述信息
     * @return 值
     **/
    public function GetDesc()
    {
        return $this->values['desc'];
    }
    /**
     * 企业付款描述信息
     * @return true 或 false
     **/
    public function IsDescSet()
    {
        return array_key_exists('desc', $this->values);
    }
    /**
     * Ip地址　调用接口的机器Ip地址
     * @param string $value
     **/
    public function SetSpbill_create_ip($value)
    {
    	$this->values['spbill_create_ip'] = $value;
    }
    /**
     * Ip地址
     * @return 值
     **/
    public function GetSpbill_create_ip()
    {
    	return $this->values['spbill_create_ip'];
    }
    /**
     * Ip地址
     * @return true 或 false
     **/
    public function IsSpbill_create_ipSet()
    {
    	return array_key_exists('spbill_create_ip', $this->values);
    }
}
