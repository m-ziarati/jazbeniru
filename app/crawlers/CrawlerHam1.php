<?php

class CrawlerHam1 extends Crawler
{
	public $id = 6;

	public $url = 'http://www.rahnama.com/cat/index/id/36196';

	//public $startPage = 1;

	//public $endPage = 3;



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
		$url = $this->url;

		if (!$listContent = $this->loadUrlContent($url))
		{
			break;
		}

		phpQuery::newDocumentHTML($listContent);

		$catElems = pq('.hierarchylist-title2');

		foreach ($catElems as $i => $cat)
		{
			$e = pq($cat);

			if ($e->find('small')->html() == '(0)')
			{
				continue;
			}

			$links = $this->fetchInternalPageLinks($e->find('a')->attr('href'));

			foreach ($links as $i => $link)
			{
				if ($callback)
				{
					$result = $callback($this->fixPersianString($link['title']), $link['url'], $link['date'], $link['data']);

					if ($result === false)
					{
						return;
					}
				}
			}
		}
	}



	private function fetchInternalPageLinks($url)
	{
		$links = [];

		if (!$content = $this->loadUrlContent($url))
		{
			return $links;
		}

		$q = phpQuery::newDocumentHTML($content);

		foreach ($q->find('.listing-summary1') as $i => $elem)
		{
			$e = pq($elem);

			$links[] = 
			[
				'title' => $e->find('h3 a')->html(),
				'url'   => urldecode($e->find('h3 a')->attr('href')),
				'date'  => null,
				'data'  => null,
			];
		}

		return $links;
	}



	public function fetchContent($url)
	{
		$content = $this->get($url);

		$q = phpQuery::newDocumentHTML($content);

		return $q->find('.box')->html();
	}
}
