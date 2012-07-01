<?php
class ProductDAO extends DAO {
	/**
	 * product.lib.php renew
	 * Enter description here ...
	 */
	public function open_db()
	{
		return $this->connect();
	}
}
?>