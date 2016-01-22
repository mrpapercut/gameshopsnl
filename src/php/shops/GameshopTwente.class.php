<?php
if (!class_exists('Fetcher')) {
	require('../Fetcher.class.php');
}

class GameshopTwente extends Fetcher {

	private $url = 'https://www.gameshop-twente.nl/inhoudZoeken.php?blz=1&&tagNegeer=niets&&meegekregenTermen=';
	private $basehref = 'http://www.gameshop-twente.nl/';

	public function query($query) {
		$html = $this->fetch($this->url.urlencode(str_replace(' ', '_', $query)));

		return $html; // $this->parseResults($html);
	}

	public function parseResults($html) {
		$dom = new DOMDocument;
		$dom->loadHTML($html);

		$xpath = new DOMXpath($dom);

		$elements = $xpath->query('//*[@id="moreResults"]/div/div');

		$results = array();

		if (!is_null($elements)) {
			foreach ($elements as $element) {
				$available = true;

				// Item title & url
				foreach($xpath->query('table/tr/td/div/span/a', $element) as $link) {
					$url = $this->basehref.$link->getAttribute('href');
					$title = $link->nodeValue;
				}

				// Image
				foreach($xpath->query('div/a/img', $element) as $image) {
					$imageUrl = str_replace('klein', 'groot', $image->getAttribute('src'));
				}

				// Price & availability
				$price = null;

				foreach($xpath->query('div[@class="genoegVoorraad"]/span/a', $element) as $priceEl) {
					preg_match('/^.* ([0-9,]+$)/', $priceEl->nodeValue, $matches);

					if (is_null($price)) { // If price not yet set
						$price = $matches[1];
					} elseif($matches[1] < $price) { // If price lower than current found price
						$price = $matches[1];
					}
				}

				if (!is_null($price)) {
					$results[] = array(
						'title' => $title,
						'url' => $url,
						'img' => $imageUrl,
						'price' => $price
					);
				}
			}
		}

		return $results;
	}
}

if (str_replace('\\', '/', __FILE__) === $_SERVER['SCRIPT_FILENAME']) {
	$class = new GameshopTwente();
	return $class->query("kirby's adventure");
}