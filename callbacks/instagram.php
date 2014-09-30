<?php

require_once(dirname(dirname(__FILE__)). '/social_network.php');
require_once(dirname(dirname(__FILE__)) . '/_SplClassLoader.php');

$loader = new SplClassLoader('Instagram', dirname(".."));
$loader->register();

$auth_config = array(
    'client_id'         => Config::get("instagram_api_key"),
    'client_secret'     => Config::get("instagram_api_secret"),
    'redirect_uri'      => Config::get("domain") . '/callbacks/instagram.php',
    'scope'             => array('basic')
);

$auth = new Instagram\Auth($auth_config);

if($_GET['code']) {
    $_SESSION['instagram_access_token'] = $auth->getAccessToken($_GET['code']);
    header("Location: ../basic_info.php?network=3");
    die();
} else {
    $auth->authorize();
}

?>
