<?php

require_once('social_network.php');
if (isset($_GET['id']) && isset($_GET['pane'])) {
    $id = $_GET['id'];
    $pane = $_GET['pane'];
    session_register("pane{$pane}");
    $_SESSION["pane{$pane}"] = $id;
    $sn = sn($id);
    if (!session_is_registered($sn->session_variable())) {
        $oauth_url = $sn->oauth_url();
        $sign_in_button = $sn->sign_in_button();
        $name = $sn->name();
        $wstr = "";
        $wstr .= "<br/><br/>";
        $wstr .= "<a href=\"{$oauth_url}\">";
        $wstr .= "<img src=\"{$sign_in_button}\" alt=\"Sign in to {$name}\"/>";
        $wstr .= "</a>";
        $wstr .= "<br/><br/>";
        $wstr .= "We won't access/store your password. You will be redirected to {$name}'s website where you can authenticate Social Photos to give access to your data.";
        $wstr .= "<br/><br/><br/>";
        $config = array(
                        "networkId" => $id,
                        "networkName" => $sn->name(),
                        "paneId" => $pane,
                        "albumId" => "-1",
                        "isWritable" => $sn->is_writable() ? 1 : 0,
                        "hasAlbums" => $sn->has_albums() ? 1 : 0,
                        "loggedIn" => 0
                        );
        $retval = array("logged_in" => 0, "data" => $wstr, "config" => $config);
    } else {
        $config = array(
                        "networkId" => $id,
                        "networkName" => $sn->name(),
                        "paneId" => $pane,
                        "albumId" => "-1",
                        "isWritable" => $sn->is_writable() ? 1 : 0,
                        "hasAlbums" => $sn->has_albums() ? 1 : 0,
                        "loggedIn" => 1
                        );
        $retval = array("logged_in" => 1, "config" => $config);
    }
    echo json_encode($retval);
}

?>
