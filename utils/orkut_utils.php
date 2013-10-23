<?php

require_once(dirname(dirname(__FILE__)) . "/social_network.php");
require_once(dirname(dirname(__FILE__)) . "/utils/db_utils.php");

function json_rpc($data, $is_list) {
    $url = "https://www.orkut.com/social/rpc";
    $headers = array(
                    "Content-type: application/json",
                    "Authorization: Bearer {$_SESSION['orkut_access_token']}"
                    );
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($curl);
    curl_close($curl);
    $response = json_decode($response, true);
    if (isset($response['error']['message'])) {
        return false;
    }
    return $is_list ? $response['data']['list'] : $response['data'];
}

function orkut_get_userinfo() {
    $rpc_request = array(
                        "method" => "people.get",
                        "id" => "myself",
                        "params" => array(
                                          "userId" => "@me",
                                          "groupId" => "@self"
                                         )
                        );
    $data = json_rpc($rpc_request, false);
    if (!$data)
        return false;
    $name = $data['name']['givenName'] . " " . $data['name']['familyName'];
    $link = "http://www.orkut.com/Main#Profile?id=" . $data['id'];
    // $data['thumbnailUrl'] contains the profile pic thumbnail just in case
    return array('name' => $name, 'link' => $link);
}

function orkut_get_albums_list() {
    $rpc_request = array(
                        "method" => "albums.get",
                        "id" => "myself",
                        "params" => array(
                                          "userId" => "@me",
                                          "groupId" => "@self",
                                          "count" => 500,
                                         )
                        );
    $data = json_rpc($rpc_request, true);
    if (!$data)
        return false;
    $album_list = array();
    foreach($data as $album) {
        $album_list[] = array(
                                'album_id' => $album['id'],
                                'album_title' => $album['title'],
                                'album_description' => $album['description'],
                                'album_thumbnail' => $album['thumbnailUrl'],
                                'photos_count' => ''
                             );
    }
    return $album_list;
}

function orkut_get_photos($albumid) {
    $rpc_request = array(
                        "method" => "mediaitems.get",
                        "id" => "myself",
                        "params" => array(
                                          "userId" => "@me",
                                          "groupId" => "@self",
                                          "albumId" => $albumid,
                                          "count" => 500
                                         )
                        );
    $data = json_rpc($rpc_request, true);
    if (!$data)
        return false;
    $photo_list = array();
    foreach($data as $photo) {
        orkut_store($photo['id'], $photo['url'], $photo['title']);
        $photo_list[] = array(
                                'photo_id' => $photo['id'],
                                'photo_title' => $photo['title'],
                                'photo_thumbnail' => $photo['thumbnailUrl'],
                                'photo_url' => $photo['url']
                             );
    }
    return $photo_list;
}

function orkut_get_photo($photoid) {
    return orkut_fetch($photoid);
}

?>
