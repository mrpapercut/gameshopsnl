<?php

class Search {
	public $shops = array(
		'GamelandGroningen',
		'MagixButtons',
		'Nedgame',
		'RetroGameFreak',
		'GameshopTwente'
	);

    public function autoloader($class) {
        if (file_exists(__DIR__.'/'.$class.'.class.php')) {
			require_once(__DIR__.'/'.$class.'.class.php');
		} else if (file_exists(__DIR__.'/shops/'.$class.'.class.php')) {
			require_once(__DIR__.'/shops/'.$class.'.class.php');
		}
    }

    public function __construct($query, $shop) {
		echo __DIR__;
        spl_autoload_register('Search::autoloader');

		die(json_encode($this->search($query, $shop)));
    }

	private function search($query, $shop) {
		if (in_array($shop, $this->shops)) {
			$shopObj = new $shop();
			return $shopObj->query($query);
		}
	}
}