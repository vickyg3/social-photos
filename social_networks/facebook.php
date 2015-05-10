<?php

require_once(dirname(dirname(__FILE__)) . "/utils/fb_utils.php");

class Facebook implements social_network {

    private $oauth_endpoint = "https://graph.facebook.com/oauth/authorize";
    private $api_scope = "publish_actions,read_stream,user_photos";
    private $session_variable = "facebook_access_token";

    public static $callback_url;

    public static function init() {
        self::$callback_url  = Config::get("domain") . "/callbacks/facebook.php";
    }

    public function oauth_url() {
        $api_key = Config::get("facebook_api_key");
        $callback_url = self::$callback_url;
        return "{$this->oauth_endpoint}?client_id={$api_key}&redirect_uri={$callback_url}&scope={$this->api_scope}&type=user_agent";
    }

    public function session_variable() {
        return $this->session_variable;
    }

    public function name() {
        return "Facebook";
    }

    public function sign_in_button() {
        return "static/images/facebook-sign-in.png";
    }

    public function drop_down_icon() {
        return "static/images/facebook-icon-32.png";
    }

    public function is_writable() {
        return true;
    }

    public function has_albums() {
        return true;
    }

    public function fetch_basic_info_from_network() {
        $info = fb_get_userinfo();
        $_SESSION['facebook_name'] = $info['name'];
        $_SESSION['facebook_link'] = $info['link'];
    }

    public function basic_info() {
        return array("name" => $_SESSION['facebook_name'], "link" => $_SESSION['facebook_link']);
    }

    public function album_list() {
        return fb_get_albums();
    }

    public function photos_list($albumid) {
        return fb_get_photos($albumid);
    }

    public function photo($photoid) {
        return fb_get_photo($photoid);
    }

    public function post_photo($albumid, $photo, $photo_file) {
        $photoid = fb_post_photo($albumid, $photo, $photo_file);
        return $this->photo($photoid['id']);
    }

    public function create_album($title, $caption) {
        return fb_create_album($title, $caption);
    }

    public function clean_up_after_album_creation() {
        return;
    }

}

Facebook::init();

?>
