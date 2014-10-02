<?php

require_once(dirname(dirname(__FILE__)) . "/social_network.php");
require_once(dirname(dirname(__FILE__)) . "/instagram.class.php");

function get_instagram_api() {
    $instagram = new Instagram(array(
        'apiKey'      => Config::get("instagram_api_key"),
        'apiSecret'   => Config::get("instagram_api_secret"),
        'apiCallback' => Config::get("domain") . "/callbacks/instagram.php"
    ));
    $sn = sn(3);
    if (isset($_SESSION[$sn->session_variable()])) {
        $instagram->setAccessToken($_SESSION[$sn->session_variable()]);
    }
    return $instagram;
}

function instagram_get_photo_list() {
    $instagram = get_instagram_api();
    $media = $instagram->getUserMedia('self', 100);
    $data = $media->data;
    $photo_list = array();
    foreach($data as $photo) {
        if ($photo->type != "image") {
            // only images are supported as of now.
            continue;
        }
        $photo_list[] = array(
                                'photo_id' => $photo->id,
                                'photo_title' => $photo->caption->text,
                                'photo_thumbnail' => $photo->images->thumbnail->url,
                                'photo_url' => $photo->images->standard_resolution->url,
                                'photo_likes' => $photo->likes->count,
                                'photo_link' => $photo->link
                             );
    }
    return $photo_list;
}

function instagram_get_photo($photoid) {
    // TODO: This could be cached somehow. This URL and Caption are being
    // returned on the call in the above function.
    $instagram = get_instagram_api();
    $data = $instagram->getMedia($photoid);
    $data = $data->data;
    $photo = array(
                    'url' => $data->images->standard_resolution->url,
                    'caption' => $data->caption->text
                  );
    return $photo;
}

?>