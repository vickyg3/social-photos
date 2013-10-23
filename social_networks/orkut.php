<?php

require_once(dirname(dirname(__FILE__)) . "/utils/orkut_utils.php");

class Orkut implements social_network {

    private $oauth_endpoint = "https://accounts.google.com/o/oauth2/auth";
    private $api_key = ""; // key filled up in production deployment
    private $api_scope = "http://orkut.gmodules.com/social";
    private $session_variable = "orkut_access_token";

    public static $callback_url = "http://socialphotos.net/callbacks/orkut.php";

    public function oauth_url() {
        $callback_url  = Orkut::$callback_url;
        return "{$this->oauth_endpoint}?client_id={$this->api_key}&redirect_uri={$callback_url}&scope={$this->api_scope}&response_type=code";
    }

    public function session_variable() {
        return $this->session_variable;
    }

    public function name() {
        return "Orkut";
    }

    public function sign_in_button() {
        return "static/images/orkut-sign-in.png";
    }

    public function drop_down_icon() {
        return "static/images/orkut-icon-32.png";
    }

    public function is_writable() {
        return false;
    }

    public function has_albums() {
        return true;
    }

    public function fetch_basic_info_from_network() {
        $info = orkut_get_userinfo();
        session_register("orkut_name");
        session_register("orkut_link");
        $_SESSION['orkut_name'] = $info['name'];
        $_SESSION['orkut_link'] = $info['link'];
    }

    public function basic_info() {
        return array('name' => $_SESSION['orkut_name'], 'link' => $_SESSION['orkut_link']);
    }

    public function album_list() {
        return orkut_get_albums_list();
    }

    public function photos_list($albumid) {
        return orkut_get_photos($albumid);
    }

    public function photo($photoid) {
        return orkut_get_photo($photoid);
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
