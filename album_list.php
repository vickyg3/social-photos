<?php

require_once(dirname(__FILE__) . "/social_network.php");
require_once(dirname(__FILE__) . "/utils/db_utils.php");

if(!isset($sn)) {
    $id = $_GET['id'];
    $sn = sn(intval($id));
    $pane = $_GET['pane'];
}

$start_time = time();
$album_list = $sn->album_list();
log_api_call($id, 'album_list', time() - $start_time);

if (!$album_list && intval($id) == 4) {
    echo "Exceeded maximum quota usage for fetching Orkut data. This is a restriction on Orkut's side and we are unable to do anything about it! :-( <br/><br/>Please try again after a couple of hours!";
    die();
}

echo "<div id=\"pagination_pane{$pane}\"></div>";
echo "<ul class=\"polaroids\" id=\"pane{$pane}_polaroids\">";
foreach($album_list as $album) {
    echo "<li style=\"display:none\">";
    echo "<a id=\"{$pane}_a" . $album['album_id'] . "\" href=\"javascript:void(0);\" onclick=\"loadAlbum('$pane', '$id', '" . $album['album_id'] . "')\" title=\"" . $album['album_title'] . " (" . $album['photos_count'] . ")\">";
    echo "<img id=\"" . $album['album_id'] . "\" src=\"" . $album['album_thumbnail'] . "\" alt=\"" . $album['album_description'] . "\" />";
    echo "</a>";
    echo "</li>";
}
echo "</ul>";

?>
