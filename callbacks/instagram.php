<?php

require_once(dirname(dirname(__FILE__)). '/social_network.php');
require_once(dirname(dirname(__FILE__)) . '/_SplClassLoader.php');

$loader = new SplClassLoader('Instagram', dirname(".."));
$loader->register();

$auth_config = array(
    'client_id'         => '', // key filled up in production deployment
    'client_secret'     => '', // key filled up in production deployment
    'redirect_uri'      => 'http://socialphotos.net/callbacks/instagram.php',
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
