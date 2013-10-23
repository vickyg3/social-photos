<?php

require_once(dirname(dirname(__FILE__)) . "/social_network.php");
require_once(dirname(dirname(__FILE__)) . '/_SplClassLoader.php');
$loader = new SplClassLoader('Instagram', dirname(".."));
$loader->register();

function instagram_get_userinfo() {
    $instagram = new Instagram\Instagram($_SESSION['instagram_access_token']);
    $user = $instagram->getCurrentUser();
    return array("name" => $user->getFullName(), "link" => "http://instagram.com/" . $user->getUserName());
}

function instagram_get_photo_list() {
    $instagram = new Instagram\Instagram($_SESSION['instagram_access_token']);
    $user = $instagram->getCurrentUser();
    $media = $user->getMedia();
    $data = $media->getData();
    $photo_list = array();
    foreach($data as $photo) {
        $photo_list[] = array(
                                'photo_id' => $photo->getMediaId(),
                                'photo_title' => $photo->getCaption()->getText(),
                                'photo_thumbnail' => $photo->getThumbnail()->url,
                                'photo_url' => $photo->getStandardRes()->url
                             );
    }
    return $photo_list;
}

function instagram_get_photo($photoid) {
    // TODO : consider storing this in the db instead of making this additional request
    $instagram = new Instagram\Instagram($_SESSION['instagram_access_token']);
    $data = $instagram->getMedia($photoid);
    $photo = array(
                    'url' => $data->getStandardRes()->url,
                    'caption' => $data->getCaption()->getText()
                  );
    return $photo;
}

?>