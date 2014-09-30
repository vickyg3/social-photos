<?php

// saves state of the page and redirects to oauth url

require_once(dirname(dirname(__FILE__)) . "/social_network.php");

$_SESSION['taking_out'] = true;
for ($i = 0; $i < 4; $i++) {
	$_SESSION["takeout_selection_${i}"] = $_GET["n{$i}"];
}

$sn = sn(intval($_GET['id']));
header("Location: " . $sn->oauth_url());

?>