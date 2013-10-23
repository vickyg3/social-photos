<?php

require_once '../phpFlickr.php';
$api_key = ""; // key filled up in production deployment
$api_secret = ""; // key filled up in production deployment
$flikr = new phpFlickr($api_key, $api_secret);
$flikr->auth("delete");

header("Location: ../index.php");

?>
