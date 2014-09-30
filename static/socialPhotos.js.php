<?php
require_once('../social_network.php');
?>

function fetchPaneData(data) {
    var index = data.selectedIndex;
    var origId = data.original[0].id + "";
    var destPane = origId.charAt(origId.length - 1);
    var destId = "#" + origId + "Contents";
    $(destId).html("<br/><br/><img src=\"static/images/loading.gif\"><br/><br/>");
    $.get("fetch_pane_data.php?id=" + index + "&pane=" + destPane, function(data, status) {
        retval = JSON.parse(data);
        paneConfig[parseInt(destPane) - 1] = retval.config;
        if (retval.logged_in) {
            loadUserInfo(destPane, index);
            // TODO: change this to loadPhotoList if config.hasAlbums is false
            if (retval.config.hasAlbums) {
                loadAlbumList(destPane, index);
            } else {
                loadAlbum(destPane, index, '-1');
            }
        } else {
            $(destId).html(retval.data);
        }
    });
}


<?php

$data = array();
for ($i = 0 ; $i < $num_social_networks; $i++) {
    $sn = sn($i);
    $data[] = array(
                    'text' => $sn->name(),
                    'value' => $i,
                    'selected' => false,
                    'description' => "Transfer photos " . ($sn->is_writable() ? "to/from" : "from") . " " . $sn->name(),
                    'imageSrc' => $sn->drop_down_icon()
                    );
}

?>
var socialNetworks = <?php echo json_encode($data); ?>;
<?php

$pane1 = "";
if (isset($_SESSION['pane1']))
    $pane1 = "defaultSelectedIndex: {$_SESSION['pane1']},";
$pane2 = "";
if (isset($_SESSION['pane2']))
    $pane2 = "defaultSelectedIndex: {$_SESSION['pane2']},";

?>

$('#socialNetworksPane1').ddslick({
    data: socialNetworks,
    width: "260px",
    <?php echo $pane1; ?>
    selectText: "Choose a Social Network",
    onSelected: fetchPaneData
});


$('#socialNetworksPane2').ddslick({
    data: socialNetworks,
    width: "260px",
    <?php echo $pane2; ?>
    selectText: "Choose a Social Network",
    onSelected: fetchPaneData
});
