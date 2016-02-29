<?php

class CrawlerS extends Crawler
{
	public $id = 2;

	public $url = 'http://www.shahrvand811.com/Home/InfinateScroll';

	public $startPage = 0;

	public $endPage = 2;



	public function fetchPageLinks($callback = null)
	{
		for ($page = $this->startPage; $page <= $this->endPage; $page++)
		{

			$data = [
				'MainCatgoryId' => '2',
				'SubCategoryID' => '',
				'Text'          => '',
				'IsToday'       => '',
				'CompanyID'     => '',
				'PageIndex'     => $page,
			];

			$headers = [
				'Cookie'           => 'cityName=Tehran',
				'Referer'          => 'http://www.shahrvand811.com/Home/ADV?MainCatID=2',
				'User-Agent'       => 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.109 Safari/537.36',
				'X-Requested-With' => 'XMLHttpRequest',
			];

			$result = $this->request('POST', $this->url, $data);


			if ($result === false)
			{
				continue;
			}

			$jsonObject = json_decode($result);
			$content = $jsonObject->HTMLString;

			phpQuery::newDocumentHTML($content);

			$spans = pq('.panel-body span');

			foreach ($spans as $i => $span)
			{
				$e = pq($span);

				$title = preg_replace("/<a\b[^>]*>(.*?)<\/a>/i", "", $e->html());
				$url   = 'http://www.shahrvand811.com/Home/GetTXT?AdId='. $e->attr('id');
				$date  = date('Y-m-d');

				if ($callback)
				{
					$result = $callback($title, $url, $date);

					if ($result === false)
					{
						return;
					}
				}
			}
		}
	}



	public function fetchContent($url)
	{
		$id  = preg_replace('#^.*(\?AdId\=)#', '', $url);
		$url = preg_replace('#\?.*#', '', $url);

		$data = [
			'AdId' => $id,
		];

		$result = $this->post($url, $data);

		$jsonObject = json_decode($result);

		$content = $jsonObject->HTMLString;

		return $content;
	}
}
