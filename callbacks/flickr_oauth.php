<?php

require_once(dirname(dirname(__FILE__)) . "/social_network.php");
require_once '../phpFlickr.php';
$api_key = Config::get("flickr_api_key");
$api_secret = Config::get("flickr_api_secret");
$flikr = new phpFlickr($api_key, $api_secret);
$flikr->auth("delete");

header("Location: ../index.php");

?>
