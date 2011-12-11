<?php
class MproductorderControl extends Control
{
	//非自动化业务
	public function left()
	{
		return dispatch('user', 'left');
	}
	public function renewMproductorderFrom()
	{
		$id = intval($_REQUEST['id']);
		$mproductorder = daocall('mproductorder','getMproductorder',array($id));

		$mproduct = daocall('mproduct','getMproductById',array($mproductorder['product_id']));
		$mproductorder['product_name'] = $mproduct['name'];

		$months = $this->getMonthsPrice($mproductorder['product_id']);
		
		$this->_tpl->assign('months',$months);
		$this->_tpl->assign('id',$id);
		$this->_tpl->assign('mproductorder',$mproductorder);
		return $this->_tpl->fetch('mproductorder/renew.html');
	}
	//获取产品的价格
	private function getMonthsPrice($product_id)
	{
		$mproduct = daocall('mproduct','getMproductById',array($product_id));
		$month_price = $mproduct['price']/12/100;
		$months ="";
		$months[1]=array('12','一年');
		$months[2]=array('24','二年');
		$months[3]=array('36','三年');
		if($mproduct['month_flag'] ==1) {
			$months[0]=array('1','一个月');
		}
		//数组内填入价格，用于在显示页面
		$months[1][2] = $month_price*$months[1][0];
		$months[2][2] = $month_price*$months[2][0];
		$months[3][2] = $month_price*$months[3][0];
		if($months[0]){
			$months[0][2] = $month_price*$months[0][0];
		}
		return $months;
	}
	/**
	 * 续费
	 * Enter description here ...
	 */
	public function renewMproductorder()
	{
		$user = getRole('user') or false;

		$mproductorder_id = intval($_REQUEST['id']);
		//获取订单信息。得到产品ID
		$mproductorder = daocall('mproductorder','getMproductorder',array($mproductorder_id));

		//用产品ID得到产品名称
		$mproduct = daocall('mproduct','getMproductById',array($mproductorder['product_id']));

		$arr=$_REQUEST;
		//传入产品名称，用于写消费记录
		$arr['name'] = $mproduct['name'];

		$product = apicall('product', 'newProduct',array('m'));

		if(!is_object($product)){
			trigger_error('没有该产品类型:m');
			return false;
		}

		if(!$product->renew($user,$arr['id'],intval($_REQUEST['month']))) {
			$this->_tpl->assign('msg',' 续费失败,请联系管理员');
		}else{
			$this->_tpl->assign('msg',' 续费成功');
		}
		return $this->_tpl->fetch('msg.html');
			
	}
	/**
	 * 显示单个订单信息
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

		$months = $this->getMonthsPrice($mproduct_id);
		
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
		$arr['group_id'] = $product_info['group_id'];
		print_r($arr);
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
		$page_count = 2;
		$count = 0;

		//排序字段
		$order = $_REQUEST['order'] or 'id';

		//查询条件，传入数组
		$where['username'] = getRole('user');

		if($_REQUEST['refer']) {
			$where['refer'] = intval($_REQUEST['refer']);
			$this->_tpl->assign('refer',$_REQUEST['refer']);
		}
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