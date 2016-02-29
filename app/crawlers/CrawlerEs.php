<?php

class CrawlerEs extends Crawler
{
	public $id = 4;

	public $url = 'http://www.1820co.com/cats/174/174/nav/100';

	public $startPage = 1;

	public $endPage = 3;


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
		// fetching
		for ($page = $this->startPage; $page <= $this->endPage; $page++)
		{
			$url = $this->url .'/'. ($page * 100);

			if (!$content = $this->loadUrlContent($url))
			{
				break;
			}

			phpQuery::newDocumentHTML($content);

			$elems = pq('td[align="right"]');

			foreach ($elems as $i => $elem)
			{
				$elem = pq($elem);

				$title = $elem->find('.txtdesc')->html();
				$url   = urldecode($elem->find('a')->attr('href'));
				$date  = $elem->find('.s73')->html();

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

		return $q->find('.hp_view_details')->html();
	}
}
