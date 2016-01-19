<?php
if (!class_exists('Fetcher')) {
	require('../Fetcher.class.php');
}

class GamelandGroningen extends Fetcher {

	private $url = 'http://www.gameland-groningen.nl/search/?menu=search&search=';

	public function query($query) {
		$html = $this->fetch($this->url.urlencode($query));

		return $this->parseResults($html);
	}

	public function parseResults($html) {
		$dom = new DOMDocument;
		$dom->loadHTML($html);

		$xpath = new DOMXpath($dom);

		$elements = $xpath->query('//*[@id="contentcolumn"]/div[1]/ul/li/div[2]/a');

		$results = array();

		if (!is_null($elements)) {
			foreach ($elements as $element) {
				$results[] = array(
					'title' => $element->nodeValue,
					'url' => $element->getAttribute('href')
				);
			}
		}

		return $this->getDetails($results);
	}

	public function getDetails($items) {
		if (count($items) > 0) {
			for($i = 0; $i < count($items); $i++) {
				$dom = new DOMDocument;
				$dom->loadHTML($this->fetch($items[$i]['url']));
				$xpath = new DOMXpath($dom);

				// Get product price
				$items[$i]['price'] = $this->getPrice($xpath);

				// Get product platform
				$items[$i]['platform'] = $this->getPlatform($xpath);

				// Get image
				$items[$i]['img'] = $this->getImage($xpath);
			}
		}

		return $items;
	}

	public function getPrice($xpath) {
		$elements = $xpath->query('//*[@id="productoptions"]/div[1]/div/span/span[@class="action" or @class="regular"]');

		if (!is_null($elements)) {
			foreach ($elements as $element) {
				preg_match('/([0-9,]+)/', $element->nodeValue, $matches);
				return $matches[0];
			}
		}
	}

	public function getPlatform($xpath) {
		$elements = $xpath->query('//*[@class="description rte_content"]/table[1]/tr[2]/td[2]');

		if (!is_null($elements)) {
			foreach ($elements as $element) {
				return $element->nodeValue;
			}
		}
	}

	public function getImage($xpath) {
		$elements = $xpath->query('//*[@id="afbeelding1"]/img');

		if (!is_null($elements)) {
			foreach ($elements as $element) {
				return $element->getAttribute('src');
			}
		}
	}
}

if (str_replace('\\', '/', __FILE__) === $_SERVER['SCRIPT_FILENAME']) {
	$class = new GamelandGroningen();
	return $class->query("kirby's adventure");
}