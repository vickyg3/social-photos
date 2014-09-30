<?php

require_once(dirname(dirname(__FILE__)) . "/social_network.php");
require_once(dirname(dirname(__FILE__)) . "/utils/db_utils.php");

$job = array('album_ids' => array_unique(json_decode($_SESSION['takeout_album_ids'], true)), 'email' => urldecode($_GET['email']));
$job['access_tokens'] = array();
for ($i = 0; $i < 3; $i++) {
    $sn = sn($i);
    $job['access_tokens'][$i] = $_SESSION[$sn->session_variable()];
}

add_takeout_job($job);

?>

Your download has been added to our queue successfully!
You should receive an email shortly with a link to your high resolution photos
albums as a zip file.
<br/><br/>
<a href="takeout.php">Want to request another download?</a>

<?php

unset($_SESSION['takeout_tab']);
unset($_SESSION['takeout_selection_0']);
unset($_SESSION['takeout_selection_1']);
unset($_SESSION['takeout_selection_2']);
unset($_SESSION['takeout_selection_1']);
unset($_SESSION['taking_out']);
unset($_SESSION['takeout_album_ids']);

?>
