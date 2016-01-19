<?php

class Fetcher {
	public function fetch($url, $post = false, $params = array()) {
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $url,
			CURLOPT_SSL_VERIFYPEER => false
		));

		if ($post === true) {
			curl_setopt_array($curl, array(
				CURLOPT_POST => 1,
				CURLOPT_POSTFIELDS => $params
			));
		}

		$res = curl_exec($curl);

		curl_close($curl);

		return $res;
	}
}