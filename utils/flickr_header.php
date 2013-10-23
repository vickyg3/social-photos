<?php

require_once(dirname(dirname(__FILE__)) . '/phpFlickr.php');
$api_key = ""; // key filled up in production deployment
$api_secret = ""; // key filled up in production deployment
$flickr = new phpFlickr($api_key, $api_secret);

?>
