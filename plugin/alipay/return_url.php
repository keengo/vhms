<?php 
date_default_timezone_set('Asia/Shanghai');
header("Cache-Control: no-cache, must-revalidate");
header("Content-Type: text/html; charset=utf-8");
define('SYS_ROOT', dirname(dirname(dirname(__FILE__))).'/framework');
include(SYS_ROOT . '/runtime.php');
@load_conf('pub:setting');
if(!is_array($GLOBALS['setting_cfg']['ALIPAY_PARTNER'])){
	die("没有正确设置");
}
/*
	*功能：付完款后跳转的页面（页面跳转同步通知页面）
	*版本：3.1
	*日期：2010-10-29
	'说明：
	'以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
	'该代码仅供学习和研究支付宝接口使用，只是提供一个参考。
	
*/
///////////页面功能说明///////////////
//该页面可在本机电脑测试
//该页面称作“页面跳转同步通知页面”，是由支付宝服务器同步调用，可当作是支付完成后的提示信息页，如“您的某某某订单，多少金额已支付成功”。
//可放入HTML等美化页面的代码和订单交易完成后的数据库更新程序代码
//该页面可以使用PHP开发工具调试，也可以使用写文本函数log_result进行调试，该函数已被默认关闭，见alipay_notify.php中的函数return_verify
//TRADE_FINISHED(表示交易已经成功结束，为普通即时到帐的交易状态成功标识);
//TRADE_SUCCESS(表示交易已经成功结束，为高级即时到帐的交易状态成功标识);
///////////////////////////////////

require_once("class/alipay_notify.php");

//构造通知函数信息
$alipay = new alipay_notify(
				$GLOBALS['setting_cfg']['ALIPAY_PARTNER']['value'],
				$GLOBALS['setting_cfg']['ALIPAY_KEY']['value'],
				'MD5',
				'utf-8',
				strcasecmp($_SERVER['HTTPS'],"ON")==0?"https:":"http:");
//计算得出通知验证结果
$verify_result = $alipay->return_verify();

if($verify_result) {//验证成功
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//请在这里加上商户的业务逻辑程序代码
	//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
    //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表  
	apicall('money','payReturn',array($_GET['out_trade_no'],$_GET['total_fee']*100));
    echo "成功支付".$_GET['total_fee']."元"; 	
} else {
    //验证失败
    //如要调试，请看alipay_notify.php页面的return_verify函数，比对sign和mysign的值是否相等，或者检查$veryfy_result有没有返回true
    echo "fail";
}
?>