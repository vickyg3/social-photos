<?php

require_once(dirname(__FILE__) . "/social_network.php");

$id = $_GET['id'];
$sn = sn(intval($id));
$title = urldecode($_GET['albumtitle']);
$caption = urldecode($_GET['albumcaption']);

if (!$title) { $title = "Social Photos Album!"; }
if (!$caption) { $caption = "Album Created with Social Photos!"; }

$title = explode("(", $title);
$title = $title[0];

$data = $sn->create_album($title, $caption);
echo json_encode($data);

?>
