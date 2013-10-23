<?php

function flickr_get_userinfo() {
    include(dirname(__FILE__) . "/flickr_header.php");
    $flickr_userid = $flickr->test_login();
    $flickr_userid = $flickr_userid['id'];
    return $flickr->people_getInfo($flickr_userid);
}

function flickr_get_thumbnail($albumid) {
    include(dirname(__FILE__) . "/flickr_header.php");
    $data = $flickr->photosets_getPhotos($albumid, "url_t", NULL, 1, 1, NULL);
    return $data['photoset']['photo'][0]['url_t'];
}

function flickr_get_album_list() {
    include(dirname(__FILE__) . "/flickr_header.php");
    $albums = $flickr->photosets_getList();
    $album_list = array();
    foreach($albums['photoset'] as $album) {
        $album_list[] = array(
                                "album_id" => $album['id'],
                                "album_title" => $album['title'],
                                "album_description" => $album['description'],
                                "album_thumbnail" => flickr_get_thumbnail($album['id']),
                                "photos_count" => $album['photos']
                             );
    }
    return $album_list;
}

function flickr_get_photos_list($albumid) {
    include(dirname(__FILE__) . "/flickr_header.php");
    $album = $flickr->photosets_getInfo($albumid);
    $data = $flickr->photosets_getPhotos($albumid, "url_t,url_o", NULL, 500, 1, NULL);
    $photo_list = array();
    foreach($data['photoset']['photo'] as $photo) {
        $photo_list[] = array(
                                'photo_id' => $photo['id'],
                                'photo_title' => $photo['title'],
                                'photo_thumbnail' => $photo['url_t'],
                                'photo_url' => $photo['url_o']
                             );
    }
    return array(
                'album_name' => $album['title'],
                'album_link' => "http://www.flickr.com/photos/{$album['username']}/sets/{$albumid}",
                'list' => $photo_list
                );
}

function flickr_get_photo($photoid) {
    include(dirname(__FILE__) . "/flickr_header.php");
    $info = $flickr->photos_getInfo($photoid);
    $sizes = $flickr->photos_getSizes($photoid);
    $url = "";
    $thumbnail = "";
    foreach($sizes as $size) {
        if ($size['label'] == "Original") {
            $url = $size['source'];
        }
        if ($size['label'] == "Thumbnail") {
            $thumbnail = $size['source'];
        }
    }
    $photo = array(
                    'id' => $photoid,
                    'url' => $url,
                    'caption' => $info['photo']['title'],
                    'thumbnail' => $thumbnail
                  );
    return $photo;
}

function flickr_post_photo($albumid, $photo, $photo_file) {
    include(dirname(__FILE__) . "/flickr_header.php");
    // upload the photo
    $photoid = $flickr->sync_upload($photo_file, $title = $photo['caption'], $is_public = false);
    if ($albumid != '') {
        // attach it to the set
        $flickr->photosets_addPhoto($albumid, $photoid);
    }
    return $photoid;
}

function flickr_remove_placeholder_photo() {
    include(dirname(__FILE__) . "/flickr_header.php");
    $flickr->photos_delete($_SESSION['flickr_photo_id']);
    session_unregister("flickr_photo_id");
}

function flickr_create_set($title, $caption) {
    include(dirname(__FILE__) . "/flickr_header.php");
    // upload a dummy photo and use that as primary.
    $photoid = flickr_post_photo("",
                                 array("caption" => "This is a dummy image uploaded by Social Photos to get around a technical limitation in Flickr Sets."),
                                 dirname(dirname(__FILE__)) . "/static/images/flickr-icon-32.png");
    // TODO: investigate if the dummy photo can be removed once the transfer is complete
    $data = $flickr->photosets_create($title, $caption, $photoid);
    session_register("flickr_photo_id");
    $_SESSION['flickr_photo_id'] = $photoid;
    return array("albumid" => $data['id']);
}

?>
