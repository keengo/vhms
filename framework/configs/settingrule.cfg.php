<?php
$GLOBALS['settingrule']['alipay']['ALIPAY_NAME'] = array('name'=>'ALIPAY_NAME','value'=>array('TEXT','/^[a-z0-9A-Z_]{2,32}$/'));
$GLOBALS['settingrule']['alipay']['ALIPAY_KEY'] = array('name'=>'ALIPAY_KEY','value'=>array('TEXT','/^[a-z0-9A-Z_]{2,64}$/',32));
$GLOBALS['settingrule']['alipay']['ALIPAY_PARTNER'] = array('name'=>'ALIPAY_PARTNER','value'=>array('TEXT','/^2088[0-9]{12}$/',32));
$GLOBALS['settingrule']['alipay']['ALIPAY_MAINNAME'] = array('name'=>'ALIPAY_MAINNAME','value'=>array('TEXT','/^[a-z0-9A-Z_]{2,64}$/',32));
$GLOBALS['lang']['zh_CN']['ALIPAY_NAME'] = '支付宝账号';
$GLOBALS['lang']['zh_CN']['ALIPAY_KEY'] = '支付宝安全码';
$GLOBALS['lang']['zh_CN']['ALIPAY_PARTNER'] = '合作身份者ID';
$GLOBALS['lang']['zh_CN']['ALIPAY_MAINNAME'] = '收款方名称';
?>