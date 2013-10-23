<?php

require_once(dirname(dirname(__FILE__)) . '/social_network.php');
require_once(dirname(__FILE__) . '/http_utils.php');

define('G_DOMAIN', 'https://picasaweb.google.com/data/feed/api/user/');
define('GP_DOMAIN', 'https://www.googleapis.com/plus/v1/people/me?access_token=');

function gp_atoken($url, $post = false, $imgmax = false)
{
    if($post)
        return $url . "?access_token=" . $_SESSION['google_access_token'];
    elseif ($imgmax)
        return $url . "?access_token=" . $_SESSION['google_access_token'] . "&alt=json&projection=api&imgmax=d";
    else
        return $url . "?access_token=" . $_SESSION['google_access_token'] . "&alt=json&projection=api";
}

function gp_get_userinfo()
{
    $data = json_decode(http_get(GP_DOMAIN . $_SESSION['google_access_token']) ,true);
    return array('name' => $data['displayName'], 'link' => $data['url'], 'userid' => $data['id']);
}

function gp_get_albums_list()
{
    $data = json_decode(http_get(gp_atoken(G_DOMAIN . "default")), true);
    $data = $data['feed']['entry'];
    $album_list = array();
    foreach($data as $album) {
        $album_list[] = array(
                                'album_id' => $album['gphoto$id']['$t'],
                                'album_title' => $album['title']['$t'],
                                'album_description' => $album['summary']['$t'],
                                'album_thumbnail' => $album['media$group']['media$thumbnail'][0]['url'],
                                'photos_count' => $album['gphoto$numphotos']['$t']
                             );
    }
    return $album_list;
}

function gp_get_photos($albumid)
{
    $data = json_decode(http_get(gp_atoken(G_DOMAIN . "default/albumid/" . $albumid)), true);
    $photo_list = array();
    foreach($data['feed']['entry'] as $photo) {
        if (count($photo['media$group']['media$thumbnail']) > 1) {
            $thumbnail = $photo['media$group']['media$thumbnail'][1]['url'];
        } else {
            $thumbnail = $photo['media$group']['media$thumbnail'][0]['url'];
        }
        $photo_list[] = array(
                                'photo_id' => $photo['gphoto$id']['$t'],
                                'photo_title' => $photo['summary']['$t'],
                                'photo_thumbnail' => $thumbnail,
                                'photo_url' => $photo['content']['src']
                             );
    }
    return array(
                'album_name' => $data['feed']['title']['$t'],
                'album_link' => "https://plus.google.com/photos/{$_SESSION['google_id']}/albums/{$albumid}",
                'list' => $photo_list
                );
}

function gp_get_photo($photoid)
{
    $data = json_decode(http_get(gp_atoken(G_DOMAIN . "default/photoid/" . $photoid, false, true)), true);
    $photo = array(
                    'url' => $data['feed']['media$group']['media$content'][0]['url'],
                    'caption' => $data['feed']['subtitle']['$t'],
                  );
    return $photo;
}

function gp_post_photo($albumid, $photo, $photo_file)
{
    $params = file_get_contents($photo_file);
    $data = http_post(gp_atoken(G_DOMAIN . "default/albumid/" . $albumid, true), $params, true);
    $xml = simplexml_load_string($data);
    foreach($xml->link as $link) {
        if($link['rel'] == "edit") {
            $put_url = $link['href'];
            break;
        }
    }
    $update_str = "<entry xmlns='http://www.w3.org/2005/Atom'>
                    <title>" . basename($photo['url']) . "</title>
                    <summary>" . $photo['caption'] . "</summary>
                    <category scheme=\"http://schemas.google.com/g/2005#kind\"
                                term=\"http://schemas.google.com/photos/2007#photo\"/>
                    </entry>";
    $data = json_decode(http_put(gp_atoken($put_url, true) . "&alt=json", $update_str), true);
    $data = $data['entry'];
    if (count($data['media$group']['media$thumbnail']) > 1) {
        $thumbnail = $data['media$group']['media$thumbnail'][1]['url'];
    } else {
        $thumbnail = $data['media$group']['media$thumbnail'][0]['url'];
    }
    $photo = array(
                    'id' => $data['gphoto$id']['$t'],
                    'url' => $data['media$group']['media$content'][0]['url'],
                    'caption' => $data['summary']['$t'],
                    'thumbnail' => $thumbnail
                  );
    return $photo;
}

function gp_create_album($name, $caption, $privacy = "private")
{
    $create_str = "<entry xmlns='http://www.w3.org/2005/Atom'
                        xmlns:media='http://search.yahoo.com/mrss/'
                        xmlns:gphoto='http://schemas.google.com/photos/2007'>
                      <title type='text'>" . $name . "</title>
                      <summary type='text'>" . $caption . "</summary>
                      <gphoto:access>" . $privacy . "</gphoto:access>
                      <category scheme='http://schemas.google.com/g/2005#kind'
                        term='http://schemas.google.com/photos/2007#album'></category>
                    </entry>";
    $data = http_post(gp_atoken(G_DOMAIN . "default", true) . "&kind=album", $create_str, false, true);
    $xml = simplexml_load_string($data);
    return array("albumid" => basename($xml->id));
}

?>
