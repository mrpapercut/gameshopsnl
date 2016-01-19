<?php

error_reporting(-1);

if (isset($_POST['query']) && isset($_POST['shop'])) {
	require('src/php/search.php');
	new Search($_POST['query'], $_POST['shop']);
} else {
	header('HTTP/1.0 404 Not Found');
}