<?php

class Crawler7010 extends Crawler
{
	public $id = 4;

	public $url = 'http://www.7010.ir/list.php?P={$page}&Cat=4&Group=14&&&&&&&&&&&&&Ord=&D=ASC';

	public $startPage = 0;

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

			$elems = pq('.fullclick > li');

			foreach ($elems as $i => $elem)
			{
				$elem = pq($elem);

				$title = $elem->find('a')->html();
				$url   = 'http://www.7010.ir'. urldecode($elem->find('a')->attr('href'));
				$date  = $this->parseDateInListPage($elem->find('li')->html());
				$tags  = $this->parseTagsInListPage($elem->find('li')->html());

				if ($callback)
				{
					$result = $callback($title, $url, $date, $tags);

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

		$content = iconv('UTF-8', 'UTF-8//IGNORE', $content);

		$q = phpQuery::newDocument($content);

		$html = '<div id="tab1">'. $q->find('#tab1')->html() .'</div>';
		$html .= '<div class="content-info">'. $q->find('#sidebar > div.content-info')->html() .'</div>';

		return $html;
	}



	private function parseDateInListPage($str)
	{
		// $str = "1394/11/26 | خراسان رضوی، مشهد، گرجی"

		$data = explode(' | ', $str);

		return str_replace('/', '-', $data[0]);
	}



	private function parseTagsInListPage($str)
	{
		// $str = "1394/11/26 | خراسان رضوی، مشهد، گرجی"

		$data = explode(' | ', $str);

		$tags = explode('، ', $data[1]);
		
		return $tags;
	}
}
