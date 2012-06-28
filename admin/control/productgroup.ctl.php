<?php 
needRole('admin');
class ProductgroupControl extends control
{
	public function productgroupAdd()
	{
		$_REQUEST['group_name'] = trim($_REQUEST['group_name']);
		if ($_REQUEST['group_name'] == "") {
			die ("产品组名称不能为空");
		}
		if (daocall('productgroup','productgroupAdd',array($_REQUEST))) {
			header('Location:?c=productgroup&a=productgroupPageList');
			die();			
		}
		die("增加新产品组失败");
	}
	public function productgroupFrom()
	{
		if ($_REQUEST['group_id']) {
			$productgroup = daocall('productgroup','productgroupGet',array($_REQUEST['group_id']));
			if ($productgroup) {
				$this->_tpl->assign('productgroup',$productgroup);
			}
			$this->_tpl->assign('group_id',$_REQUEST['group_id']);
		}
		if ($_REQUEST['edit']) {
			$a = 'productgroupUpdate';
		} else {
			$a = 'productgroupAdd';
		}
		$this->_tpl->assign('a',$a);
		return $this->_tpl->fetch('productgroup/productgroupadd.html');
	}
	public function productgroupUpdate()
	{
		$arr['group_name'] = trim($_REQUEST['group_name']);
		if (daocall('productgroup','productgroupUpdate',array($_REQUEST['group_id'],$arr))) {
			header('Location:?c=productgroup&a=productgroupPageList');
			die();
		}
		die("更新产品分类失败");
	}
	public function productgroupDel()
	{
		if (daocall('productgroup','productgroupDel',array($_REQUEST['group_id']))) {
			header('Location:?c=productgroup&a=productgroupPageList');
			die();
		}
		die("删除失败");
	}	
	public function productgroupPageList()
	{
		$page = intval($_REQUEST['page']);
		if ($page 	<= 0) {
			$page 	= 1;
		}
		$page_count = 20;
		$count 		= 0;
		$list 		= daocall('productgroup','productgroupPageList',array($page,$page_count,&$count));
		$total_page = ceil($count/$page_count);
		if ($page 	>= $total_page) {
			$page 	= $total_page;
		}
		$this->_tpl->assign('count',$count);
		$this->_tpl->assign('total_page',$total_page);
		$this->_tpl->assign('page',$page);
		$this->_tpl->assign('page_count',$page_count);
		$this->_tpl->assign('list',$list);
		return $this->_tpl->display('productgroup/productgrouplist.html');
	}
}

