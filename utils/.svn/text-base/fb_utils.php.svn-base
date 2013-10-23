<?php

require_once(dirname(dirname(__FILE__)) . '/social_network.php');

function curl_request($url, $limit = false)
{
    $limit = false;
    $curl = curl_init();
    if($limit)
        curl_setopt($curl, CURLOPT_URL, $url . "?limit=2&access_token=" . $_SESSION['facebook_access_token']);
    else
        curl_setopt($curl, CURLOPT_URL, $url . "?limit=200&access_token=" . $_SESSION['facebook_access_token']);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $json_data = curl_exec($curl);
    curl_close($curl);
    return json_decode($json_data, true);
}

function get_redirect_url($url)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url . "?access_token=" . $_SESSION['facebook_access_token']);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $data = curl_exec($curl);
    $final_url = curl_getinfo($curl, CURLINFO_EFFECTIVE_URL);
    curl_close($curl);
    return $final_url;
}

function fb_get_cover_photo($id)
{
    $album_data = curl_request("https://graph.facebook.com/" . $id);
    return $album_data['picture'];
}

function fb_get_albums()
{
    $albums = curl_request("https://graph.facebook.com/me/albums", true);
    $albums = $albums['data'];
    $album_list = array();
    foreach($albums as $album)
    {
        $album_list[] = array(
                                'album_id'=>$album['id'],
                                'album_title'=>$album['name'],
                                'album_thumbnail'=> fb_get_cover_photo($album['cover_photo']),
                                'album_description' => '',
                                'photos_count' => $album['count']
                             );
    }
    return $album_list;
}

function fb_get_photos($albumid)
{
    $album = curl_request("https://graph.facebook.com/" . $albumid);
    $photos = curl_request("https://graph.facebook.com/" . $albumid . "/photos", true);
    $photos = $photos['data'];
    $photos_list = array();
    foreach($photos as $photo)
    {
        $photos_list[] = array(
                                'photo_id'=>$photo['id'],
                                'photo_title'=>$photo['name'],
                                'photo_thumbnail'=>$photo['picture'],
                                'photo_url'=>$photo['source']
                              );
    }
    return array(
                'album_name' => $album['name'],
                'album_link' => $album['link'],
                'list' => $photos_list
                );
}

function fb_get_photo($photoid)
{
    $data = curl_request("https://graph.facebook.com/" . $photoid);
    $photo = array(
                    'id' => $data['id'],
                    'url' => $data['source'],
                    'caption' => $data['name'],
                    'thumbnail' => $data['picture']
                  );
    return $photo;
}

function fb_get_userinfo()
{
    $userdata = curl_request("https://graph.facebook.com/me");
    return array('name' => $userdata['name'], 'link' => $userdata['link']);
}

function fb_post_photo($albumid, $photo, $photo_file)
{
    $upload_url = "https://graph.facebook.com/" . $albumid . "/photos";
    $params = array(
        'source' => "@$photo_file",
        'access_token' => $_SESSION['facebook_access_token'],
        'message' => $photo['caption']
    );
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $upload_url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($curl);
    curl_close($curl);
    return json_decode($response, true);;
}

function fb_create_album($title, $caption, $privacy = "SELF")
{
    $upload_url = "https://graph.facebook.com/me/albums";
    $params = array(
        'access_token' => $_SESSION['facebook_access_token'],
        'message' => "$caption",
        'name' => "$title",
        'privacy' => "{'value':'" . $privacy . "'}"
    );
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $upload_url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($curl);
    $response = json_decode($response, true);
    curl_close($curl);
    return array("albumid" => $response[id]);
}

?>
