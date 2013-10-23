<?php
    require_once('../social_network.php');
    require_once('../utils/http_utils.php');
    $response = json_decode(http_post( 'https://accounts.google.com/o/oauth2/token',
                                array(  'code' => $_REQUEST['code'],
                                        'client_id' => '', // key filled up in production deployment
                                        'client_secret' => '', // key filled up in production deployment
                                        'grant_type' => 'authorization_code',
                                        'redirect_uri' => Google::$callback_url)),
                    true);
    session_register("google_access_token");
    $_SESSION['google_access_token'] = $response['access_token'];
    header("Location: ../basic_info.php?network=0");
?>
