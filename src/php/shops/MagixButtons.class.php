<?php
if (!class_exists('Fetcher')) {
	require('../Fetcher.class.php');
}

class MagixButtons extends Fetcher {

	public $url = 'http://magixbuttons.com/shop?items_per_page=24&search_api_views_fulltext=';

	public function query($query) {
		$html = $this->fetch($this->url.urlencode($query));

		return $this->parseResults($html);
	}

	public function parseResults($html) {
		$dom = new DOMDocument;
		$dom->loadHTML($html);

		$xpath = new DOMXpath($dom);

		$elements = $xpath->query('//*[@id="nav-wrapper"]/div[2]/div/section/div/div/div[2]/div');

		$results = array();

		if (!is_null($elements)) {
			foreach ($elements as $element) {
				$str = preg_replace('/\s+/', ' ', trim($element->nodeValue));
				preg_match('/(.*)\s\|\s([a-zA-Z0-9 \-]+).*\s([0-9,]+).*/', $str, $matches);

				// Get product url
				$itemurl = $xpath->query('div/div/h4/a', $element);
				foreach($itemurl as $node) {
					$url = $node->getAttribute('href');
				}

				// Get image
				$imagenodes = $xpath->query('div/a/img', $element);
				foreach($imagenodes as $node) {
					$image = $node->getAttribute('src');
				}

				array_push($results, array(
					'title' => trim($matches[1]),
					'platform' => $matches[2],
					'price' => $matches[3],
					'url' => '//magixbuttons.com'.$url,
					'img' => $image
				));
			}
		}

		return $results;
	}
}

if (strpos(str_replace('\\', '/', __FILE__), $_SERVER['SCRIPT_NAME'])) {
	$class = new MagixButtons();
	return $class->query("kirby's adventure");
}