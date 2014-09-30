<?php

require_once('../social_network.php');
if(isset($_REQUEST['action']) && $_REQUEST['action'] == "store") {
    $_SESSION["facebook_access_token"] = $_REQUEST['atoken'];
    header("Location: ../basic_info.php?network=1");
    die();
}

?>

<script>
    var atoken = window.location.href.split('#')[1].split('&')[0].split('=')[1];
    window.location = "facebook.php?action=store&atoken=" + atoken;
</script>
