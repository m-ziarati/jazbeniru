<?php

class Crawler
{
	public function __construct()
	{
		libxml_use_internal_errors(true);
	}



	public function post($url, $data = [], $headers = [])
	{
		return $this->request('POST', $url, $data, $headers);
	}



	public function get($url, $data = [], $headers = [])
	{
		return $this->request('GET', $url, $data, $headers);
	}



	protected function request($method, $url, $data = [], $headers = [])
	{
		if ($method == 'POST')
		{
			$headers['Content-type'] = 'application/x-www-form-urlencoded; charset=UTF-8';
		}

		if (!isset($headers['User-Agent']))
		{
			$headers['User-Agent'] = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.109 Safari/537.36';
		}

		$headerString = '';

		foreach ($headers as $key => $value)
		{
			$headerString .= $key .': '. $value ."\r\n";
		}

		$options =
		[
			'http' =>
			[
				'header'  => $headerString,
				'method'  => $method,
				'content' => http_build_query($data),
			],
		];

		$context  = stream_context_create($options);

		$result = file_get_contents($url, false, $context);

		if ($result === false)
		{
			echo 'error';
			exit;
		}

		return $result;
	}



	public function fixPersianString($str)
	{
		$pattrens = [
			'ـ*' => '',
			'٠|۰' => '0',
			'١|۱' => '1',
			'٢|۲' => '2',
			'٣|۳' => '3',
			'٤|۴' => '4',
			'٥|۵' => '5',
			'٦|۶' => '6',
			'٧|۷' => '7',
			'٨|۸' => '8',
			'٩|۹' => '9',
		];

		foreach ($pattrens as $regex => $replacement)
		{
			$str = preg_replace('#'. $regex .'#u', $replacement, $str);
		}

		return $str;
	}
}
