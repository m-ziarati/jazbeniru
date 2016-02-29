<?php

class CrawlerE extends Crawler
{
	public $id = 1;

	public $url = 'http://www.e-estekhdam.com/%D9%87%D9%85%D9%87-%DB%8C-%D8%A7%D8%B3%D8%AA%D8%AE%D8%AF%D8%A7%D9%85-%D9%87%D8%A7%DB%8C-%D8%A7%D9%85%D8%B1%D9%88%D8%B2/page/{$page}/';

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
			$url = str_replace('{$page}', $page, $this->url);

			if (!$content = $this->loadUrlContent($url))
			{
				break;
			}

			phpQuery::newDocumentHTML($content);

			$links = pq('div.posts-box:eq(1) .posts-box-list-entry .row');

			foreach ($links as $i => $link)
			{
				$e = pq($link);

				$title = $e->find('a')->html();
				$url = 'http://www.e-estekhdam.com'. urldecode($e->find('a')->attr('href'));
				$date = $e->find('time')->attr('datetime');

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

		$html = '<header>'. $q->find('article.post > header ')->html() .'</header>';
		$html .= '<div class="entry-content">'. $q->find('article.post > .entry-content')->html() .'</div>';

		return $html;
	}
}
