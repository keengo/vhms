<?php
class ProductDAO extends DAO {
	public function open_db()
	{
		return $this->connect();
	}
}
?>