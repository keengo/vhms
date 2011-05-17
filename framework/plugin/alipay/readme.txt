            ╭───────────────────────╮
  ╭────┤           支付宝代码示例结构说明             ├────╮
  │        ╰───────────────────────╯        │
　│                                                                  │
　│     接口名称：支付宝即时到帐接口（create_direct_pay_by_user）    │
　│　   代码版本：3.1                                                │
  │     开发语言：PHP                                                │
  │     版    权：支付宝（中国）网络技术有限公司                     │
　│     制 作 者：支付宝商户事业部技术支持组                         │
  │     联系方式：商户服务电话0571-88158090                          │
  │                                                                  │
  ╰─────────────────────────────────╯

───────
 代码文件结构
───────

js_php_utf8
  │
  ├class┈┈┈┈┈┈┈┈┈┈┈┈类文件夹
  │  │
  │  ├alipay_function.php┈┈┈公用函数类文件
  │  │
  │  ├alipay_notify.php┈┈┈┈支付宝通知处理类文件
  │  │
  │  └alipay_service.php ┈┈┈支付宝请求处理类文件
  │
  ├images ┈┈┈┈┈┈┈┈┈┈┈图片、CSS样式文件夹
  │
  ├log.txt┈┈┈┈┈┈┈┈┈┈┈日志文件
  │
  ├alipay_config.php┈┈┈┈┈┈基础信息配置文件
  │
  ├alipayto.php ┈┈┈┈┈┈┈┈支付宝接口入口文件
  │
  ├index.php┈┈┈┈┈┈┈┈┈┈快速付款入口模板文件
  │
  ├notify_url.php ┈┈┈┈┈┈┈服务器异步通知页面文件
  │
  ├return_url.php ┈┈┈┈┈┈┈页面跳转同步通知文件
  │
  └readme.txt ┈┈┈┈┈┈┈┈┈使用说明文本

※注意※
需要配置的文件是：alipay_config.php、alipayto.php

index.php仅是支付宝提供的付款入口模板文件，可选择使用。
如果商户网站根据业务需求不需要使用，请把alipayto.php作为与商户网站网站相衔接页面。
如果需要使用index.php，那么alipayto.php文件无需更改，只需配置好alipay_config.php文件
拿到index.php页面在商户网站中的HTTP路径放置在商户网站中需要的位置，就能直接使用支付宝接口。


─────────
 类文件函数结构
─────────

alipay_function.php

function build_mysign($sort_array,$key,$sign_type = "MD5")
功能：生成签名结果
输入：Array  $sort_array 要签名的数组
      String $key 安全校验码
      String $sign_type 签名类型 默认值 MD5
输出：String 签名结果字符串

function create_linkstring($array)
功能：把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
输入：Array  $array 需要拼接的数组
输出：String 拼接完成以后的字符串

function para_filter($parameter)
功能：除去数组中的空值和签名参数
输入：Array  $parameter 签名参数组
输出：Array  去掉空值与签名参数后的新签名参数组

function arg_sort($array)
功能：对数组排序
输入：Array  $array 排序前的数组
输出：Array  排序后的数组

function sign($prestr,$sign_type)
功能：签名字符串
输入：String $prestr 需要签名的字符串
      String $sign_type 签名类型
输出：String 签名结果

function log_result($word)
功能：写日志，方便测试（看网站需求，也可以改成存入数据库）
输入：String $word 要写入日志里的文本内容

function query_timestamp($partner) 
功能：用于防钓鱼，调用接口query_timestamp来获取时间戳的处理函数
输入：String $partner 合作身份者ID
输出：String 时间戳字符串

function charset_encode($input,$_output_charset ,$_input_charset)
功能：实现多种字符编码方式
输入：String $input 需要编码的字符串
      String $_output_charset 输出的编码格式
      String $_input_charset 输入的编码格式
输出：String 编码后的字符串

function charset_decode($input,$_input_charset ,$_output_charset) 
功能：实现多种字符解码方式
输入：String $input 需要解码的字符串
      String $_output_charset 输出的解码格式
      String $_input_charset 输入的解码格式
输出：String 解码后的字符串

┉┉┉┉┉┉┉┉┉┉┉┉┉┉┉┉┉┉┉┉┉┉┉┉┉┉┉┉┉┉┉

alipay_notify.php

function alipay_notify($partner,$key,$sign_type,$_input_charset = "GBK",$transport= "https") 
功能：构造函数
      从配置文件中初始化变量
输入：String $partner 合作身份者ID
      String $key 安全校验码
      String $sign_type 签名类型
      String $_input_charset 字符编码格式 默认值 GBK
      String $transport 访问模式 默认值 https

function notify_verify()
功能：对notify_url的认证
输出：Bool  验证结果：true/false

function return_verify()
功能：对return_url的认证
输出：Bool  验证结果：true/false

function get_verify($url,$time_out = "60")
功能：获取远程服务器ATN结果
输入：String $url 指定URL路径地址
      String $time_out 超时计时器 默认值60
输出：String 服务器ATN结果字符串

┉┉┉┉┉┉┉┉┉┉┉┉┉┉┉┉┉┉┉┉┉┉┉┉┉┉┉┉┉┉┉

alipay_service.php

function alipay_service($parameter,$key,$sign_type)
功能：构造函数
      从配置文件及入口文件中初始化变量
输入：Array  $parameter 需要签名的参数数组
      Array  $key 安全校验码
      Array  $sign_type 签名类型

function build_form()
功能：构造表单提交HTML
输出：String 表单提交HTML文本



──────────
 如何增加请求参数
──────────

在技术文档的请求参数列表中有诸多请求参数，如果因业务需求等原因要利用这些参数，那么可以按照下面的操作方法来扩充接口功能。

┉┉┉以参数it_b_pay为例┉┉┉
打开alipayto.php文件，在注释“以下参数是需要通过下单时的订单数据传入进来获得”与“/////////////////////////////////////////////////”代码段之间添加以下代码：

/////////////////////////////////////////////////
//扩展功能参数——自定义超时(若要使用，请按照注释要求的格式赋值)
//该功能默认不开通，
//申请开通方式：
//方式一：联系支付宝技术支持申请处理
//方式二：拨打0571-88158090申请
//方式三：提交集成申请（https://b.alipay.com/support/helperApply.htm?action=consultationApply）
$it_b_pay = "";
//超时时间，不填默认是15天。设置范围：1m~15d。,-分隔符，~-范围 ， m-分钟，h-小时，d-天，1c-当天（无论何时创建，交易都在0点关闭）
//如：$it_b_pay  = "1m~1h,2h,3h,1c";
/////////////////////////////////////////////////


在“构造要请求的参数数组，无需改动”注释下方的“数组参数$parameter”中增加数组元素【 "it_b_pay"	=> $it_b_pay】


/////////////////////////////////////////////////
$parameter = array(
        "service"		=> "create_direct_pay_by_user",	//接口名称，不需要修改
        "payment_type"		=> "1",               			//交易类型，不需要修改

        //获取配置文件(alipay_config.php)中的值
        "partner"		=> $partner,
        "seller_email"		=> $seller_email,
        "return_url"		=> $return_url,
        "notify_url"		=> $notify_url,
        "_input_charset"	=> $_input_charset,
        "show_url"		=> $show_url,

        //从订单数据中动态获取到的必填参数
        "out_trade_no"		=> $out_trade_no,
        "subject"		=> $subject,
        "body"			=> $body,
        "total_fee"		=> $total_fee,

        //扩展功能参数——网银提前
        "paymethod"		=> $paymethod,
        "defaultbank"		=> $defaultbank,

        //扩展功能参数——防钓鱼
        "anti_phishing_key"	=> $anti_phishing_key,
	"exter_invoke_ip"	=> $exter_invoke_ip,

	//扩展功能参数——自定义参数
	"buyer_email"		=> $buyer_email,
        "extra_common_param"=> $extra_common_param,
		
	//扩展功能参数——分润
        "royalty_type"		=> $royalty_type,
        "royalty_parameters"	=> $royalty_parameters,

        //扩展功能参数——自定义超时
        "it_b_pay"		=> $it_b_pay
);
/////////////////////////////////////////////////


──────────
 出现问题，求助方法
──────────

如果在集成支付宝接口时，有疑问或出现问题，可使用下面的链接，提交申请。
https://b.alipay.com/support/helperApply.htm?action=supportHome
我们会有专门的技术支持人员为您处理




