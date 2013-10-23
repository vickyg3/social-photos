<?php

require_once(dirname(__FILE__) . "/social_network.php");

$id = $_GET['id'];
$sn = sn(intval($id));
$pane = $_GET['pane'];

?>
<br/>
Signed in as
<?php
$userinfo = $sn->basic_info();
if ($userinfo['link']) echo "<a href=\"{$userinfo['link']}\" target=\"_blank\">";
echo $userinfo['name'];
if ($userinfo['link']) echo "</a>";
?>
<?php
if ($sn->has_albums() && $sn->is_writable()) {
?>
  <br/><br/>
  <button class="btn" type="button" onClick="showCreateAlbum('<?php echo $pane; ?>');">Create an Album </button>
<?php
}
?>
<hr/>
