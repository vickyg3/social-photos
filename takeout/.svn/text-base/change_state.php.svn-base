<?php

require_once(dirname(dirname(__FILE__)) . "/social_network.php");

if ($_GET['type'] == "tab") {
	session_register("takeout_tab");
	$_SESSION['takeout_tab'] = $_GET['tab'];
} else if ($_GET['type'] == "selection") {
	session_register("takeout_selection_{$_GET['id']}");
	$_SESSION["takeout_selection_{$_GET['id']}"] = $_GET['value'];
}

?>