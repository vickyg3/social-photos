<?php

require_once(dirname(dirname(__FILE__)) . '/social_network.php');
require_once(dirname(dirname(__FILE__)) . '/phpFlickr.php');
$api_key = Config::get("flickr_api_key");
$api_secret = Config::get("flickr_api_secret");
$flickr = new phpFlickr($api_key, $api_secret);

?>
