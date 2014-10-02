<?php

require_once(dirname(dirname(__FILE__)) . "/utils/instagram_utils.php");

// This class is named InstagramSN because Instagram collides with the PHP
// Instagram API (instagram.class.php)
class InstagramSN implements social_network {

    private $session_variable = "instagram_access_token";

    public function oauth_url() {
        $instagram = get_instagram_api();
        return $instagram->getLoginUrl(array('basic'));
    }

    public function session_variable() {
        return $this->session_variable;
    }

    public function name() {
        return "Instagram";
    }

    public function sign_in_button() {
        return "static/images/instagram-sign-in.png";
    }

    public function drop_down_icon() {
        return "static/images/instagram-icon-32.png";
    }

    public function is_writable() {
        return false;
    }

    public function has_albums() {
        return false;
    }

    public function fetch_basic_info_from_network() {
        // for instagram, this is done in the OAuth Callback.
        // see callbacks/instagram.php
        return;
    }

    public function basic_info() {
        return array('name' => $_SESSION['instagram_name'], 'link' => $_SESSION['instagram_link']);
    }

    public function album_list() {
        return;
    }

    public function photos_list($albumid) {
        return instagram_get_photo_list();
    }

    public function photo($photoid) {
        return instagram_get_photo($photoid);
    }

    public function post_photo($albumid, $photo, $photo_file) {
        return;
    }

    public function create_album($title, $caption) {
        return;
    }

    public function clean_up_after_album_creation() {
        return;
    }

}

?>
