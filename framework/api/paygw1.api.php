<?php
class Paygw1API extends API
{
	public function pay($id,$user,$money)
	{
		$tpl = Control::$_tpl;
		$return_url = strcasecmp($_SERVER['HTTPS'],"ON")==0?"https://":"http://";
		$return_url.= $_SERVER['HTTP_HOST'];
		$return_url.= $_SERVER['PHP_SELF'];
		/*
		 *功能：设置商品有关信息（确认订单支付宝在线购买入口页）
		 *详细：该页面是接口入口页面，生成支付时的URL
		 *版本：3.1
		 *修改日期：2010-10-29
		 '说明：
		 '以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
		 '该代码仅供学习和研究支付宝接口使用，只是提供一个参考。

		 */

		////////////////////注意/////////////////////////
		//如果您在接口集成过程中遇到问题，
		//您可以到商户服务中心（https://b.alipay.com/support/helperApply.htm?action=consultationApply），提交申请集成协助，我们会有专业的技术工程师主动联系您协助解决，
		//您也可以到支付宝论坛（http://club.alipay.com/read-htm-tid-8681712.html）寻找相关解决方案
		//要传递的参数要么不允许为空，要么就不要出现在数组与隐藏控件或URL链接里。
		/////////////////////////////////////////////////

		//require_once("alipay_config.php");
		require_once(SYS_ROOT.'/plugin/alipay/class/alipay_service.php');

		/*以下参数是需要通过下单时的订单数据传入进来获得*/
		//必填参数
		$out_trade_no = $id;//date(Ymdhms);		//请与贵网站订单系统中的唯一订单号匹配
		
		$subject      = '充值';	//订单名称，显示在支付宝收银台里的“商品名称”里，显示在支付宝的交易管理的“商品名称”的列表里。
		$body         = '在线充值';	//订单描述、订单详细、订单备注，显示在支付宝收银台里的“商品描述”里
		$total_fee    = $money/100;	//订单总金额，显示在支付宝收银台里的“应付总额”里
		//扩展功能参数——默认支付方式
		$pay_mode	  = 'directPay';
		if ($pay_mode == "directPay") {
			$paymethod    = "directPay";	//默认支付方式，四个值可选：bankPay(网银); cartoon(卡通); directPay(余额); CASH(网点支付)
			$defaultbank  = "";
		}
		else {
			$paymethod    = "bankPay";		//默认支付方式，四个值可选：bankPay(网银); cartoon(卡通); directPay(余额); CASH(网点支付)
			$defaultbank  = $pay_mode;		//默认网银代号，代号列表见http://club.alipay.com/read.php?tid=8681379
		}


		//扩展功能参数——防钓鱼
		//请慎重选择是否开启防钓鱼功能
		//exter_invoke_ip、anti_phishing_key一旦被使用过，那么它们就会成为必填参数
		//开启防钓鱼功能后，服务器、本机电脑必须支持远程XML解析，请配置好该环境。
		//若要使用防钓鱼功能，请打开class文件夹中alipay_function.php文件，找到该文件最下方的query_timestamp函数，根据注释对该函数进行修改
		//建议使用POST方式请求数据
		$anti_phishing_key  = '';			//防钓鱼时间戳
		$exter_invoke_ip = '';				//获取客户端的IP地址，建议：编写获取客户端IP地址的程序
		//如：
		//$exter_invoke_ip = '202.1.1.1';
		//$anti_phishing_key = query_timestamp($partner);		//获取防钓鱼时间戳函数

		//扩展功能参数——其他
		$extra_common_param = '';			//自定义参数，可存放任何内容（除=、&等特殊字符外），不会显示在页面上
		$buyer_email		= '';			//默认买家支付宝账号

		//扩展功能参数——分润(若要使用，请按照注释要求的格式赋值)
		$royalty_type		= "";			//提成类型，该值为固定值：10，不需要修改
		$royalty_parameters	= "";
		//提成信息集，与需要结合商户网站自身情况动态获取每笔交易的各分润收款账号、各分润金额、各分润说明。最多只能设置10条
		//各分润金额的总和须小于等于total_fee
		//提成信息集格式为：收款方Email_1^金额1^备注1|收款方Email_2^金额2^备注2
		//如：
		//royalty_type = "10"
		//royalty_parameters	= "111@126.com^0.01^分润备注一|222@126.com^0.01^分润备注二"


		/////////////////////////////////////////////////
		load_conf('pub:setting');
		//构造要请求的参数数组，无需改动
		$parameter = array(
        "service"			=> "create_direct_pay_by_user",	//接口名称，不需要修改
        "payment_type"		=> "1",               			//交易类型，不需要修改

		//获取配置文件(alipay_config.php)中的值
        "partner"			=> $GLOBALS['setting_cfg']['ALIPAY_PARTNER'],
        "seller_email"		=> $GLOBALS['setting_cfg']['ALIPAY_SELLER_EMAIL'],
        "return_url"		=> $return_url,
        "notify_url"		=> $notify_url,
        "_input_charset"	=> 'utf-8',
        "show_url"			=> $show_url,

		//从订单数据中动态获取到的必填参数
        "out_trade_no"		=> $out_trade_no,
        "subject"			=> $subject,
        "body"				=> $body,
        "total_fee"			=> $total_fee,

		//扩展功能参数——网银提前
        "paymethod"			=> $paymethod,
        "defaultbank"		=> $defaultbank,

		//扩展功能参数——防钓鱼
        "anti_phishing_key"	=> $anti_phishing_key,
		"exter_invoke_ip"	=> $exter_invoke_ip,

		//扩展功能参数——自定义参数
		"buyer_email"		=> $buyer_email,
        "extra_common_param"=> $extra_common_param,

		//扩展功能参数——分润
        "royalty_type"		=> $royalty_type,
        "royalty_parameters"=> $royalty_parameters
		);

		//构造请求函数
		$alipay = new alipay_service($parameter,$GLOBALS['setting_cfg']['ALIPAY_KEY'],'MD5');
		$sHtmlText = $alipay->build_form();
		echo $sHtmlText;
	}
}
?>
