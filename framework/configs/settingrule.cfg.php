<?php
$GLOBALS['settingrule']['alipay']['ALIPAY_SELLER_EMAIL'] = array('name'=>'ALIPAY_SELLER_EMAIL','value'=>array('TEXT','/^[a-z0-9A-Z]{2,32}@[a-z0-9A-Z]{2,32}.[a-z]{2,32}$/',32));
$GLOBALS['settingrule']['alipay']['ALIPAY_KEY'] = array('name'=>'ALIPAY_KEY','value'=>array('TEXT','/^[a-z0-9A-Z_]{2,64}$/',32));
$GLOBALS['settingrule']['alipay']['ALIPAY_PARTNER'] = array('name'=>'ALIPAY_PARTNER','value'=>array('TEXT','/^2088[0-9]{12}$/',32));
$GLOBALS['settingrule']['alipay']['ALIPAY_MAINNAME'] = array('name'=>'ALIPAY_MAINNAME','value'=>array('TEXT','/^[a-z0-9A-Z_]{2,64}$/',32));
$GLOBALS['lang']['zh_CN']['ALIPAY_SELLER_EMAIL'] = '支付宝账号(seller_email)';
$GLOBALS['lang']['zh_CN']['ALIPAY_KEY'] = '支付宝安全码(key)';
$GLOBALS['lang']['zh_CN']['ALIPAY_PARTNER'] = '合作身份者ID';
$GLOBALS['lang']['zh_CN']['ALIPAY_MAINNAME'] = '收款方名称';
?>