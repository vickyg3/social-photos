<?php

session_start();
define("DOMAIN", "http://socialphotos.net/");

interface social_network {

    // returns the oauth url
    public function oauth_url();

    // returns name of the session variable
    public function session_variable();

    // returns printable name of the social network
    public function name();

    // returns absolute path of the sign in image
    public function sign_in_button();

    // returns absolute path of drop down icon
    public function drop_down_icon();

    // returns true if writing to the network is allowed
    public function is_writable();

    // returns true if the network has the concept of albums
    public function has_albums();

    // fetches basic info of the user from the social network
    // and stores it in a session variable
    public function fetch_basic_info_from_network();

    // returns the basic info of the user
    public function basic_info();

    // returns a list of albums
    public function album_list();

    // returns list of photos by albumid
    public function photos_list($albumid);

    // returns photo url and metadata. strives to get the best available quality.
    public function photo($photoid);

    // posts a photo into the network
    // arguments are a $photo array with metadata and a $photo_file which is a local file to post
    public function post_photo($albumid, $photo, $photo_file);

    // creates an album
    public function create_album($title, $caption);

    // cleans up after album creation if required
    public function clean_up_after_album_creation();

}

require_once('social_networks/google.php');
require_once('social_networks/facebook.php');
require_once('social_networks/flickr.php');
require_once('social_networks/instagram.php');
require_once('social_networks/orkut.php');

$num_social_networks = 5;

function sn($id) {
    switch ($id) {
        case 0:
            return new Google();
        case 1:
            return new Facebook();
        case 2:
            return new Flickr();
        case 3:
            return new Instagram();
        case 4:
            return new Orkut();
    }
}

?>
