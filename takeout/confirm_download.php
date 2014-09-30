<?php
  require_once(dirname(dirname(__FILE__)) . "/social_network.php");
  $_SESSION['takeout_album_ids'] = file_get_contents("php://input");
  $ids = array_unique(json_decode($_SESSION['takeout_album_ids'], true));
  $album_count = count($ids);
  $network_count = 0;
  for ($i = 0; $i < 3; $i++) {
  	$network_count += intval($_SESSION["takeout_selection_{$i}"]);
  }
  $album_count .= ($album_count == 1) ? " Album" : " Albums";
  $network_count .= ($network_count == 1) ? " Social Network" : " Social Networks";

?>

<p><center>
  You have requested to download <?php echo $album_count; ?> from <?php echo $network_count; ?>. Please enter an E-Mail address and click on the button below
  to start the download process. Once the download is complete, We will send you an E-Mail containing a link to the downloadable zip file
  containing your albums.
  <br/><br/>
  <input type="email" name="email" id="email" placeholder="E-Mail Address"><br/>
  <button class="btn btn-primary" onclick="startDownload();">Start Download!</button><br/><br/>
</center></p>
