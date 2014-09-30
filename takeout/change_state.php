<?php

require_once(dirname(dirname(__FILE__)) . "/social_network.php");

if ($_GET['type'] == "tab") {
	$_SESSION['takeout_tab'] = $_GET['tab'];
} else if ($_GET['type'] == "selection") {
	$_SESSION["takeout_selection_{$_GET['id']}"] = $_GET['value'];
}

?>