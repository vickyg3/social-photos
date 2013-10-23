<?php require_once(dirname(__FILE__) . "/social_network.php"); ?>

<!DOCTYPE html>
<html lang="en">
  <?php include('head.html'); ?>
  <body>
    <?php include('header.html'); ?>

    <div class="container">

      <div class="hero-unit" style="height: 40px;">
        <span id="placeholderHeader">Social Photos Takeout</span>
      </div>
      <br/>

      <div class="row-fluid">
        <div class="span10">
          <ul class="nav nav-tabs">
            <li id="ltab1" class="active">
              <a id="ttab1" href="#tab1" data-toggle="tab">Takeout</a>
            </li>
            <li id="ltab2" id="selectNetworks">
              <a id="ttab2" href="#tab2" data-toggle="tab">Select Social Networks</a>
            </li>
            <li id="ltab3" class="disabled" id="selectAlbums">
              <a id="ttab3" href="#tab3" data-toggle="tab">Select Albums</a>
            </li>
            <li id="ltab4" class="disabled" id="startDownloading">
              <a id="ttab4" href="#tab4" data-toggle="tab">Start Downloading</a>
            </li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab1">
              <p>Social Photos Takeout can help you download your favorite photos albums from various Social Networks as a single zip file. Follow three simple steps:</p>
              <p>
                <ol>
                  <li>Select Social Networks</li>
                  <li>Select Albums</li>
                  <li>Start Downloading (Once the download is complete, we will send you an email with a link to the photos as a zip file).</li>
                </ol>
              </p>
              <center><p><button onclick="changeTab(2); showTab2();" class="btn btn-primary">Get Started</button></p></center>
            </div>
            <div class="tab-pane" id="tab2">
            </div>
            <div class="tab-pane" id="tab3">
            </div>
            <div class="tab-pane" id="tab4">
            </div>
          </div>
        </div>
      </div>

      <hr>
      <?php include('footer.html'); ?>

      <!-- modal used by pretty alert -->
      <div id="modalAlert" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-body">
          <p id="modalAlertBody"></p>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" data-dismiss="modal">Okay</button>
        </div>
      </div>

    </div> <!-- /container -->

    <!-- Le javascript -->
    <script src="static/bootstrap/js/jquery.js"></script>
    <script src="static/bootstrap/js/bootstrap.js"></script>
    <script src="static/bootstrap/js/bootstrap-tooltip.js"></script>
    <script src="static/utils.js"></script>
    <script src="static/takeout.js"></script>
    <script>
    <?php
      if (session_is_registered("takeout_tab")) {
          for($i = 2; $i <= intval($_SESSION['takeout_tab']); $i++) {
              echo "showTab{$i}();";
          }
      }
    ?>
    </script>

  </body>
</html>
