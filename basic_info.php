<?php

require_once 'social_network.php';

if (isset($_GET['network'])) {
    $sn = sn(intval($_GET['network']));
    $sn->fetch_basic_info_from_network();
}

if ($_SESSION['taking_out']) {
    header("Location: takeout.php");
} else {
    header("Location: index.php");
}

?>
