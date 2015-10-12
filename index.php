<!DOCTYPE html>
<html lang="en">
  <?php include('head.html'); ?>
  <body>
    <?php include('header.html'); ?>

    <div class="container">

      <!-- Main hero unit for a primary marketing message or call to action -->
      <div class="hero-unit" style="height: 40px;">
        <span id="placeholderHeader">Choose a Social Network for both the panes and simply Drag n Drop to migrate photos or albums. You can monitor the progress here!</span>
        <span style="width: 555px; float: left;" id="progressbar"></span>
        <span style="width: 355px; float: right;" id="queuelength"></span>
      </div>
      <br/>
      <div class="alert alert-info">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><a href="/takeout.php">Social Photos Takeout - </strong> You can download your photos from various Social Networks with Takeout. Try it out!</a>
      </div>
      <div class="alert alert-info">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Note:</strong> Facebook integration has been <a href="https://github.com/vickyg3/social-photos/issues/52" target="_blank">resolved</a>. Thanks for your patience!
      </div>
      <div class="row-fluid">
        <div class="span6" id="pane1">
          <center> <!-- i know, evil! but it works! -->
            <div id="socialNetworksPane1"></div>
            <div id="paneUserInfo1"></div>
          </center>
          <div id="socialNetworksPane1Contents">
            <br/>
          </div>
        </div>
        <div class="span6"  id="pane2">
          <center>
            <div id="socialNetworksPane2"></div>
            <div id="paneUserInfo2"></div>
          </center>
          <div id="socialNetworksPane2Contents">
            <br/>
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
      <!-- modal used for showing creating album -->
      <div id="modalPopUp" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-body">
          <p id="modalBody"></p>
        </div>
      </div>
      <!-- modal used for slideshow -->
      <div id="modalSlideShow" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 id="slideShowTitle"></h3>
          <center>
            <h5>
              <a id="slideShowPrev" href="javascript:void(0);" onclick="">Previous</a> |
               <a id="slideShowNext" href="javascript:void(0);" onclick="">Next</a>
            </h5>
          </center>
        </div>
        <div class="modal-body">
          <img id="slideShowImage" src="" alt="" />
        </div>
      </div>
      <!-- modal used for showing transfer queue -->
      <div id="modalTransferQueue" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3>Transfer Queue</h3>
          <h5><a href="javascript:void(0);" onclick="dismissCompletedTransfers();">[Remove Completed Transfers]</a><h5>
        </div>
        <div class="modal-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>From</th>
                <th>To</th>
                <th>Thumbnail</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody id="transferQueueBody">
            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
      </div>
      <!-- modal used to create album -->
      <div id="modalCreateAlbum" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4>Create a new album on <span id="createAlbumNetwork"></span></h4>
        </div>
        <div class="modal-body">
          <p>Album Name: <input type="text" name="createAlbumName" id="createAlbumName" /></p>
          <p>Album Caption: <input type="text" name="createAlbumCaption" id="createAlbumCaption" /></p>
          <button type="button" class="btn btn-primary" onClick="createAlbum();">Create</button>
          <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button> <span id="createAlbumStatus"></span>
          <input type="hidden" name="modalCreateAlbumPaneId" id="modalCreateAlbumPaneId" value="0" />
        </div>
      </div>

    </div> <!-- /container -->

    <!-- Le javascript -->
    <script src="static/bootstrap/js/jquery.js"></script>
    <script src="static/bootstrap/js/bootstrap.js"></script>
    <script src="static/bootstrap/js/pagination.js"></script>
    <script src="static/ddslick.js"></script>
    <script src="static/h5utils.js"></script>
    <script src="static/utils.js"></script>
    <script src="static/socialPhotos.js"></script>
    <script src="static/socialPhotos.js.php"></script>
    <script src="static/transfer.js"></script>

  </body>
</html>
