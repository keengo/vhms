<?php
class ProductAPI extends API
{
		/**
	 * 构造函数
	 **/
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * 析构函数 **/
	public function __destruct()
	{
		parent::__destruct();
	}
	protected function getVhostProducts(&$products)
	{
		$products[]=array('name'=>'--虚拟主机产品--','type'=>'','id'=>0);
		$data = daocall('vhostproduct', 'getSellProducts', null);
		for($i=0;$i<count($data);$i++){
			$products[] = array('name'=>$data[$i]['name'],'type'=>'vhost','id'=>$data[$i]['id']);
		}		
		//print_r($products);
		
	}
	public function getProducts()
	{
			$products = array();
			$this->getVhostProducts($products);
			return $products;
	}	
}
?>