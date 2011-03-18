<?php
//$GLOBALS['tplenv']['templete[:subtemplete]'] = array('name'=>'env name','distinct'=>'0|1','password'=>'1',value='value_regex');
$GLOBALS['tplenv']['php'][] = array('name'=>'TOMCAT_PASSWD','password'=>1,'count'=>1,'value'=>array('TEXT','/^[a-z0-9A-Z_]{2,16}$/'));
//$GLOBALS['tplenv']['php'][] = array('name'=>'ZEND','count'=>1,'value'=>array('RADIO',array(array('ON',''),array('OFF',';'))));
//$GLOBALS['tplenv']['php:php52'][] = array('name'=>'ZEND2','count'=>1,'value'=>array('CHECKBOX','',';'));
//$GLOBALS['tplenv']['php'] = array('name'=>'ZEND','count'=>1,'value'=>array('SELECT',array('0','1','2')));
?>
