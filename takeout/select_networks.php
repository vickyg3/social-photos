<p><center>
<?php
  require_once(dirname(dirname(__FILE__)) . "/social_network.php");

  echo "<table class=\"table table-bordered\">";
  echo "<thead><tr><th>Select Network</th><th>Social Network</th><th>Signed In As</th></tr></thead><tbody>";
  for ($i = 0 ; $i < $num_social_networks; $i++) {
      if ($i == 3 || $i == 4) { // exceptions for photo downloads
        continue;
      }
      $sn = sn($i);
      echo "<tr>";
      echo "<td>";
      echo "<label class=\"checkbox\">";
      $checked = "";
      $label = "Not Selected";
      if (session_is_registered("takeout_selection_{$i}") && intval($_SESSION["takeout_selection_{$i}"])) {
          $checked = "checked";
          $label = "Selected";
          if (!session_is_registered($sn->session_variable())) $label .= " (Please Sign In!)";
      }
      echo "<input type=\"checkbox\" id=\"network_{$i}\" {$checked}/><span id=\"text_{$i}\">{$label}</span>";
      echo "<script>$(\"#network_{$i}\").change(takeoutSelectNetwork);</script>";
      echo "</label>";
      echo "</td>";
      echo "<td>{$sn->name()}</td>";
      echo "<td>";
      if (session_is_registered($sn->session_variable())) {
          $userinfo = $sn->basic_info();
          if ($userinfo['link']) echo "<a href=\"{$userinfo['link']}\" target=\"_blank\">";
          echo $userinfo['name'];
          if ($userinfo['link']) echo "</a>";
          echo "<input type=\"hidden\" name=\"loggedIn_{$i}\" id=\"loggedIn_{$i}\" value=\"1\" />";
      } else {
          echo "<a href=\"javascript:void(0);\" onclick=\"gotoAuth('{$i}');\" title=\"Sign in to {$sn->name()}\">";
          echo "<img src=\"{$sn->sign_in_button()}\" alt=\"Sign in to {$sn->name()}\" />";
          echo "</a>";
          echo "<input type=\"hidden\" name=\"loggedIn_{$i}\" id=\"loggedIn_{$i}\" value=\"0\" />";
      }
      echo "</td>";
      echo "</li>";
  }
  echo "</tbody></table>";
  echo "<button onclick=\"changeTab(3); showTab3();\" class=\"btn btn-primary\">Proceed to Next Step</button>";
?>
</center></p>
