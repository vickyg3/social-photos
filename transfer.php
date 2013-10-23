<?php

require_once(dirname(__FILE__) . "/social_network.php");
require_once(dirname(__FILE__) . "/utils/db_utils.php");

function li_element($pane, $photo) {
    $wstr = "";
    $wstr .= "<a id=\"{$pane}_a" . $photo['id'] . "\" href=\"javascript:void(0);\" title=\"" . $photo['caption'] . "\" onClick=\"previewImage('" . $photo['id'] . "');\">";
    $wstr .= "<img id=\"" . $photo['id'] . "\" src=\"" . $photo['thumbnail'] . "\" alt=\"" . $photo['caption'] . "\" />";
    $wstr .= "<input type=\"hidden\" id=\"h" . $photo['id'] . "\" value=\"" . $photo['url'] . "\">";
    $wstr .= "</a>";
    $wstr .= "</li>";
    return $wstr;
}

$src = $_GET['src'];
$dst = $_GET['dst'];
$photoid = $_GET['photoid']; // source photo id
$albumid = $_GET['albumid']; // destination album id
$pane = $_GET['pane']; // destination pane id

$src_sn = sn(intval($src));
$dst_sn = sn(intval($dst));

if (!$dst_sn->is_writable()) {
    exit;
}

// get the best available quality picture from source network
$start_time = time();
$source_photo = $src_sn->photo($photoid);
log_api_call($src, 'photo', time() - $start_time);

$source_photo_file = tempnam("temp", "temp_");
file_put_contents($source_photo_file, file_get_contents($source_photo['url']));

// post it in the destination network
$posted_photo = $dst_sn->post_photo($albumid, $source_photo, $source_photo_file);
echo json_encode(array(
                        "body" => li_element($pane, $posted_photo),
                        "show" => "<li id=\"l" . $posted_photo['id'] . "\">",
                        "noshow" => "<li id=\"l" . $posted_photo['id'] . "\" style=\"display:none\">"
                      ));

log_transfer($src, $dst, filesize($source_photo_file));

// delete the temporary file
unlink($source_photo_file);

?>
