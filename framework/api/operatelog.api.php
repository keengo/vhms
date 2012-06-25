<?php
class OperatelogAPI extends API
{
	public function operatelogAdd($arr)
	{
		return daocall('operatelog','operatelogAdd',array($arr));
	}
	
}