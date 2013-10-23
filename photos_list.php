<?php

require_once(dirname(__FILE__) . "/social_network.php");
require_once(dirname(__FILE__) . "/utils/db_utils.php");

$id = $_GET['id'];
$sn = sn(intval($id));
$pane = $_GET['pane'];
$albumid = $_GET['albumid'];

$start_time = time();
$photos = $sn->photos_list($albumid);
// TODO: remove this if once all networks supports album name listing
if (array_key_exists("list", $photos)) {
    $photos_list = $photos['list'];
} else {
    $photos_list = $photos;
}

log_api_call($id, 'photos_list', time() - $start_time);

if(isset($_GET['format']) && $_GET['format'] == 'json') {
    if ($photos_list == false) {
        echo "{}";
    } else {
        echo json_encode($photos_list);
    }
} else {
    if(!$photos_list && intval($id) == 4) {
        echo "Exceeded maximum quota usage for fetching Orkut data. This is a restriction on Orkut's side and we are unable to do anything about it! :-( <br/><br/>Please try again after a couple of hours!";
        echo "<br/><br/>";
        echo "Alternatively, you can export your Orkut photos to Google+ by visiting this link <a href=\"http://www.orkut.com/AlbumsExport\">http://www.orkut.com/AlbumsExport</a> and then use Social Photos to transfer those to other social networks.";
        die();
    }
    if ($sn->has_albums()) {
        if (array_key_exists("album_name", $photos)) {
            echo "In Album <a href=\"" . $photos['album_link'] . "\" target=\"_blank\">" . $photos['album_name'] . "</a> |";
        }
        echo "<button type=\"button\" class=\"btn btn-link\" onclick=\"loadAlbumList('$pane', '$id');\">[Back to List of Albums]</button>";
    }
    echo "<div id=\"pagination_pane{$pane}\"></div>";
    echo "<ul class=\"polaroids\" id=\"pane{$pane}_polaroids\">";
    foreach($photos_list as $photo) {
        echo "<li id=\"l" . $photo['photo_id'] . "\" style=\"display:none\">";
        echo "<div class=\".cornerpatch\">";
        echo "<a id=\"{$pane}_a" . $photo['photo_id'] . "\" href=\"javascript:void(0);\" title=\"" . $photo['photo_title'] . "\" onClick=\"previewImage('" . $photo['photo_id'] . "');\">";
        echo "<img id=\"" . $photo['photo_id'] . "\" src=\"" . $photo['photo_thumbnail'] . "\" alt=\"" . $photo['photo_title'] . "\" />";
        echo "<input type=\"hidden\" id=\"h" . $photo['photo_id'] . "\" value=\"" . $photo['photo_url'] . "\">";
        echo "</a>";
        echo "</div>";
        echo "</li>";
    }
    echo "</ul>";
}

?>
