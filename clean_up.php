<?php

require_once(dirname(__FILE__) . "/social_network.php");

$id = $_GET['id'];
$sn = sn(intval($id));
$sn->clean_up_after_album_creation();

?>