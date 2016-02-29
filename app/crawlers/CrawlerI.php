<?php

class CrawlerI extends Crawler
{
	public $id = 3;

	public $url = 'http://iranestekhdam.ir/category/agahi-estekhdam/';

	public $startPage = 1;

	public $endPage = 1;



	public function loadUrlContent($url)
	{
		try
		{
			return file_get_contents($url);
		}
		catch (Exception $e)
		{
			echo "Crawling Error [". $e->getMessage() ."]\n";

			return false;
		}
	}



	public function fetchPageLinks($callback = null)
	{
		for ($page = $this->startPage; $page <= $this->endPage; $page++)
		{
			$url = $page == 1 ? $this->url : $this->url .'page/'. $page;

			$data = [
			];

			$headers = [
				//'Host' =>'iranestekhdam.ir',
				//'Connection' =>'keep-alive',
				//'Pragma' =>'no-cache',
				//'Cache-Control' =>'no-cache',
				//'Accept' =>'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
				//'Upgrade-Insecure-Requests' =>'1',
				'User-Agent' =>'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.109 Safari/537.36',
				//'Accept-Encoding' =>'gzip, deflate, sdch',
				//'Accept-Language' =>'en-US,en;q=0.8',
				//'Cookie' =>'__utmt=1; __utma=69233992.647743299.1455292501.1455292501.1455292501.1; __utmb=69233992.12.10.1455292501; __utmc=69233992; __utmz=69233992.1455292501.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none)',
			];

			$result = $this->request('GET', $this->url, $data, $headers);

			if ($result === false)
			{
				continue;
			}

			phpQuery::newDocumentHTML($result);

			$ads = pq('section.pix-textADS');

			foreach ($ads as $i => $ad)
			{
				$e = pq($ad);

				$title = $e->find('header a')->html();
				$url   = urldecode($e->find('header a')->attr('href'));
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
		$content = $this->get($url);

		$q = phpQuery::newDocumentHTML($content);

		return $q->find('div.RightSingleSide > section:nth-child(1)')->html();
	}
}
