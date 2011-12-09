<?php 
needRole('admin');
class MproductorderControl extends Control
{
	public function addMproductorderFrom()
	{
		if($_REQUEST['id']) {
			$mproductorder = daocall('mproductorder','getMproductorder',array(intval($_REQUEST['id'])));
			$this->_tpl->assign('mproductorder',$mproductorder);
			$this->_tpl->assign('edit',1);
		}
		return $this->_tpl->fetch('mproductorder/addfrom.html');
	}
	public function addMproductorder()
	{
		$arr=$_REQUEST;
		if($arr['month'] < 0) {
			exit('失败，月份错误');
		}
		//传入状态1表示已开通。
		$arr['status'] = 1;
		$result = daocall('mproductorder','add',array($arr));
		if(!$result) {
			$this->_tpl->assign('msg','订单'.$arr['id'].'开通失败');
			return $this->_tpl->fetch('msg.html');
		}
		$this->_tpl->assign('msg','订单'.$arr['id'].'开通成功');
		return $this->_tpl->fetch('msg.html');
	}
	public function delMproductorder()
	{
		$result = daocall('mproductorder','del',array(intval($_REQUEST['id'])));
		if(!$result) {
			$this->_tpl->assign('msg','删除失败');
			return $this->_tpl->fetch('msg.html');
		}
		return $this->pageListMproductorder();
	}
	public function pageListMproductorder()
	{
		$page = intval($_REQUEST['page']);
		if($page<=0){
			$page = 1;
		}
		$page_count = 20;
		$count = 0;
		$order = $_REQUEST['order'] or 'id';//排序字段
		
		$list = daocall('mproductorder','pageList',array($page,$page_count,&$count,$order));
		//获取产品信息
		$mproducts = daocall('mproduct','getMproductById',array());
		//将product_id替换为product_name显示
		if(is_array($list) && is_array($mproducts)) {
			for($i=0;$i<count($list);$i++) {
				foreach($mproducts as $mproduct) {
					if($list[$i]['product_id'] == $mproduct['id']) {
						$list[$i]['product_name'] = $mproduct['name'];
					}
				}
			}
		}
		$total_page = ceil($count/$page_count);
		if($page>=$total_page){
			$page = $total_page;
		}
		$this->_tpl->assign('order',$order);
		$this->_tpl->assign('count',$count);
		$this->_tpl->assign('total_page',$total_page);
		$this->_tpl->assign('page',$page);
		$this->_tpl->assign('page_count',$page_count);
		$this->_tpl->assign('list',$list);
		return $this->_tpl->fetch('mproductorder/pagelistmproductorder.html');
		
		
	}
	
	
	
	
}



?>