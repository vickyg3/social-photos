<?php
    require_once(dirname(dirname(__FILE__)) . "/social_network.php");
    require_once(dirname(dirname(__FILE__)) . "/utils/db_utils.php");
    $show_network = array(false, false, false);
    $sn = array(0, 0, 0);
    for ($i = 0; $i < 3; $i++) {
        if (session_is_registered("takeout_selection_{$i}") && intval($_SESSION["takeout_selection_{$i}"])) {
            $show_network[$i] = true;
            $sn[$i] = sn($i);
        }
    }
    $ids = array();
    if (session_is_registered("takeout_album_ids")) {
      $ids = array_unique(json_decode($_SESSION['takeout_album_ids'], true));
    }
?>

<p>
<ul class="nav nav-tabs">
  <?php
  $is_activated = false;
  for ($i = 0; $i < 3; $i++) {
      if ($show_network[$i]) {
          $active = !$is_activated ? "class=\"active\"" : "";
          $is_activated = true;
          echo "<li {$active}><a href=\"#albumtab{$i}\" data-toggle=\"tab\">{$sn[$i]->name()}</a></li>";
      }
  }
  ?>
</ul>
<div class="tab-content">
  <?php
  $is_activated = false;
  for ($i = 0; $i < 3; $i++) {
      if ($show_network[$i]) {
          $active = !$is_activated ? "active" : "";
          $is_activated = true;
          echo "<div class=\"tab-pane {$active}\" id=\"albumtab{$i}\">";
          echo "<p>";
          $start_time = time();
          $album_list = $sn[$i]->album_list();
          log_api_call($i, 'album_list', time() - $start_time);
          echo "<ul style=\"list-style-type: none;\">";
          foreach ($album_list as $album) {
              echo "<li>";
              $checked = in_array("a_{$i}_{$album['album_id']}", $ids) ? "checked" : "";
              echo "<label class=\"checkbox\">";
              echo "<input type=\"checkbox\" id=\"a_{$i}_{$album['album_id']}\" {$checked}/>";
              $popover = $album['album_thumbnail'] ? "<img src='{$album['album_thumbnail']}' alt='{$album['album_title']}' /\>" : "No Thumbnail Available :(";
              echo "<a class=\"tooltipselector\" href=\"javascript:void(0);\" data-toggle=\"popover\" data-content=\"{$popover}\">{$album['album_title']}</a>";
              echo " ({$album['photos_count']} Photos)";
              echo "</label>";
              echo "<script>$(\"#a_{$i}_{$album['album_id']}\").change(takeoutSelectAlbum);</script>";
              echo "</li>";
          }
          echo "</ul>";
          echo "<center><button onclick=\"changeTab(4); showTab4();\" class=\"btn btn-primary\">Proceed to Next Step</button></center>";
          echo "</p>";
          echo "</div>";
      }
  }
  ?>
<script>$(".tooltipselector").popover({trigger: 'hover focus', animation: true, html: true});</script>
</div>
</p>
