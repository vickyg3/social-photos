<?php

require_once(dirname(dirname(__FILE__)) . "/utils/flickr_utils.php");

class Flickr implements social_network {

    private $session_variable = "phpFlickr_auth_token";

    public static $callback_url = "http://socialphotos.net/callbacks/flickr.php";

    public function oauth_url() {
        return "http://socialphotos.net/callbacks/flickr_oauth.php";
    }

    public function session_variable() {
        return $this->session_variable;
    }

    public function name() {
        return "Flickr";
    }

    public function sign_in_button() {
        return "static/images/flickr-sign-in.png";
    }

    public function drop_down_icon() {
        return "static/images/flickr-icon-32.png";
    }

    public function is_writable() {
        return true;
    }

    public function has_albums() {
        return true;
    }

    public function fetch_basic_info_from_network() {
        $userinfo = flickr_get_userinfo();
        session_register("flickr_name");
        session_register("flickr_link");
        $_SESSION['flickr_name'] = $userinfo['realname'] . " (" . $userinfo['username'] . ")";
        $_SESSION['flickr_link'] = $userinfo['profileurl'];
    }

    public function basic_info() {
        return array('name' => $_SESSION['flickr_name'], 'link' => $_SESSION['flickr_link']);
    }

    public function album_list() {
        return flickr_get_album_list();
    }

    public function photos_list($albumid) {
        return flickr_get_photos_list($albumid);
    }

    public function photo($photoid) {
        return flickr_get_photo($photoid);
    }

    public function post_photo($albumid, $photo, $photo_file) {
        $photoid = flickr_post_photo($albumid, $photo, $photo_file);
        return $this->photo($photoid);
    }

    public function create_album($title, $caption) {
        return flickr_create_set($title, $caption);
    }

    public function clean_up_after_album_creation() {
        flickr_remove_placeholder_photo();
    }

}

?>
