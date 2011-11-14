<?php
class NewsAPI extends API{
	
	public function getNewsList()
	{
		return daocall('news','getNewsList',array());
	}
	public function getNewsById($id)
	{
		return daocall('news','getNews',array($id));
	}
	
	
	
	
}