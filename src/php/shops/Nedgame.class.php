<?php
if (!class_exists('Fetcher')) {
	require('../Fetcher.class.php');
}

class Nedgame extends Fetcher {

	public $url = 'http://www.nedgame.nl/zoek/*/*/*/*/*/*/*/*/*/';

	public function query($query) {
		$html = $this->fetch($this->url.htmlentities($query, ENT_QUOTES));

		return $this->parseResults($html);
	}

	private function parseResults($html) {
		$dom = new DOMDocument;
		$dom->loadHTML($html);

		$xpath = new DOMXpath($dom);

		$elements = $xpath->query('//*[@id="middenkolom"]/div/table/tbody/tr');

		$results = array();

		if (!is_null($elements)) {
			foreach ($elements as $element) {

				// Get image
				foreach ($xpath->query('td[1]/a/img', $element) as $image) {
					$imageUrl = 'http://www.nedgame.nl'.$image->getAttribute('src');
				}

				// Get link & title
				foreach ($xpath->query('td[2]/a', $element) as $link) {
					$url = $link->getAttribute('href');
					$title = $link->nodeValue;
				}

				// Get price
				foreach ($xpath->query('td[3]/div/div[4]', $element) as $prices) {
					preg_match('/([0-9,\-]+)/', $prices->nodeValue, $matches);
					$price = $matches[0];
				}

				// Get platform
				foreach ($xpath->query('td[2]/span', $element) as $details) {
					preg_match('/Platform: (.*)Type:/', $details->nodeValue, $matches);
					$platform = $matches[1];
				}

				$results[] = array(
					'title' => $title,
					'url' => $url,
					'img' => $imageUrl,
					'platform' => $platform,
					'price' => $price
				);
			}

			return $results;
		}
	}
}

if (str_replace('\\', '/', __FILE__) === $_SERVER['SCRIPT_FILENAME']) {
	$class = new Nedgame();
	return $class->query("kirby's adventure");
}