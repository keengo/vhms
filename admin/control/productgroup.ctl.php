<?php 
needRole('admin');
class ProductgroupControl extends control
{
	public function productgroupAdd()
	{
		$_REQUEST['group_name'] = trim($_REQUEST['group_name']);
		if (daocall('productgroup','productgroupAdd',array($_REQUEST))) {
			die("成功");
		}
		die("增加新产品组失败");
	}	
	
}

