<?php

require_once(dirname(dirname(__FILE__)) . '/social_network.php');
require_once(dirname(dirname(__FILE__)) . '/utils/instagram_utils.php');

if($_GET['code']) {
    $instagram = get_instagram_api();
    $sn = sn(3);
    $data = $instagram->getOAuthToken($_GET['code']);
    $_SESSION[$sn->session_variable()] = $data->access_token;
    $_SESSION['instagram_name'] = $data->user->username;
    $_SESSION['instagram_link'] = "http://instagram.com/" . $data->user->username;
    // this is a dummy redirect in case of instagram, but there for consistency.
    header("Location: ../basic_info.php?network=3");
    die();
} else {
    header("Location: " . $instagram->getLoginUrl('basic'));
}

?>
