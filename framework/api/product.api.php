<?php

class ProductAPI extends API
{
	public function __construct()
	{
		load_lib('pub:product');
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
	}
	public function getProducts()
	{
			$products = array();
			$this->getVhostProducts($products);
			return $products;
	}
	/**
	 * 依据$product_type产生一个Product类
	 */
	public function newProduct($product_type)
	{
		$className = $product_type.'Product';
		$lib = 'pub:'.$className;
		load_lib($lib);
		$className[0] = strtoupper($className[0]);
		return new $className;
	}
}
?>