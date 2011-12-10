<?php
class MproductorderControl extends Control
{
	//非自动化业务
	public function left()
	{
		return dispatch('user', 'left');
	}
	/**
	 * 查看订单信息
	 * where id
	 */
	public function showMproductorder()
	{
		$id = intval($_REQUEST['id']);
		if (!$id){
			trigger_error('失败:没有这个订单');
			return false;
		}
		$mproductorder = daocall('mproductorder','getMproductorder',array($id));
			
		$mproduct = daocall('mproduct','getMproductById',array($mproductorder['product_id']));
		$mproductorder['product_name'] = $mproduct['name'];
		
		$this->_tpl->assign('mproductorder',$mproductorder);
		return $this->_tpl->fetch('mproductorder/showmproductorder.html');

	}

	/**
	 * 非自动化产品业务申请页面
	 */
	public function addMproductorderFrom()
	{
		
		//得到产品ID
		$mproduct_id = $_REQUEST['mproduct_id'];
		//获取产品信息,得到价格
		$mproduct = daocall('mproduct','getMproductById',array($mproduct_id));
		$month_price = $mproduct['price']/12/100;
		$months = array(
						array('1','一个月'),
						array('12','一年'),
						array('24','二年'),
						
		);
		$months[0][2] = $month_price*$months[0][0];
		$months[1][2] = $month_price*$months[1][0];
		$months[2][2] = $month_price*$months[2][0];
	
		$this->_tpl->assign('product_name',$mproduct['name']);
		$this->_tpl->assign('id',$mproduct_id);
		$this->_tpl->assign('months',$months);
		return $this->_tpl->fetch('mproductorder/addfrom.html');
	}
	/**
	 * 非自动化产品业务创建函数
	 */
	public function addMproductorder()
	{
	
		$arr = $_REQUEST;
		$arr['username'] = getRole('user');
		if($_REQUEST['product_id']) {
			$mproductorder = daocall('mproductorder','getMproductorder',array(intval($_REQUEST['product_id'])));
			if($mproductorder['status']!=0) {
				$this->_tpl->assign('msg',"订单已完成");
				return $this->_tpl->fetch('msg.html');
			}
		}
		//获取产品名称
		$product_info = daocall('mproduct','getMproductById',array($_REQUEST['product_id']));
		//
		$product = apicall('product', 'newProduct',array('m'));
		
		if(!is_object($product)){
			trigger_error('没有该产品类型:m');
			return false;
		}
		$user = getRole('user');
		//传产品名称，用于写消费记录的购买名称识别
		$arr['name'] = $product_info['name'];
		
		if(!$product->sell($user,intval($_REQUEST['product_id']),$arr)){
			return false;
		}
		$this->_tpl->assign('msg','购买成功,请注意看相订单详情里的管理员回复信息');
		return $this->_tpl->fetch('public/msg.html');
	}
	/**
	 * 非自动化产品业务列表
	 */
	public function pageListMyMproductorder()
	{
		$page = intval($_REQUEST['page']);
		if($page<=0){
			$page = 1;
		}
		$page_count = 20;
		$count = 0;

		//排序字段
		$order = $_REQUEST['order'] or 'id';

		//查询条件，传入数组
		$where['username'] = getRole('user');

		$mproducts = daocall('mproduct','getMproductById',array());

		$list = daocall('mproductorder','pageList',array($page,$page_count,&$count,$order,$where));
		if(is_array($mproducts)) {
			for($i=0;$i<count($list);$i++ ) {
				foreach($mproducts as $mproduct){
					if($list[$i]['product_id'] == $mproduct['id']){
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