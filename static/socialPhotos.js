var n = 10.0;
var paneItems = [0, 0];
var panePage = [1, 1];
var slideShowing = false;
var paneConfig = [{loggedIn: 0}, {loggedIn: 0}];
var previewPhotoId = ["", ""];

function paginateHelper(event, num) {
    var eventId = event.currentTarget.id + "";
    var pane = eventId.charAt(eventId.length - 1) + "";
    var paneId = "#pane" + pane + "_polaroids";
    panePage[parseInt(pane)] = parseInt(num);
    num--;
    var start = num * n;
    var end = (start + n > paneItems[parseInt(pane)]) ? paneItems[parseInt(pane)] : start + n;
    $(paneId).children('li').each(function(i) {
        if (i >= start && i < end) {
            $(this).show();
        }
        else {
            $(this).hide();
        }
    });
}

function paginateAlbums(pane) {
    var paneId = "#pane" + pane + "_polaroids";
    paneItems[parseInt(pane)] = $(paneId).children().length;
    var pages = Math.ceil(paneItems[parseInt(pane)] / n);
    var paginationId = "#pagination_pane" + pane;
    $(paginationId).bootpag({
        total: pages,
        page: 1,
        maxVisible: 10
    }).on('page', paginateHelper);
    paginateHelper({currentTarget: {id: 'pagination_pane' + pane}}, 1);
}

function loadUserInfo(paneId, networkId) {
    var destId = "#paneUserInfo" + paneId;
    $.get("user_info.php?id=" + networkId + "&pane=" + paneId, function(data, status) {
        $(destId).html(data);
    });
}

function loadAlbum(paneId, networkId, albumId) {
    var destId = "#socialNetworksPane" + paneId + "Contents";
    var albumName = $('#' + paneId + '_a' + albumId).attr('title');
    if (!albumName) {
        albumName = "";
    } else {
        albumName = "\"<b>" + albumName.split("(")[0] + "</b>\"";
    }
    var loadingMsg = paneConfig[parseInt(paneId) - 1].hasAlbums ? "Album " + albumName : "List of Photos ";
    $(destId).html("Loading " + loadingMsg + "<br/><br/><img src=\"static/images/loading.gif\"><br/>Please be patient as it may take some time depending on the number of photos in the album!<br/><br/>");
    $.get("photos_list.php?id=" + networkId + "&pane=" + paneId + "&albumid=" + albumId, function(data, status) {
        $(destId).html(data);
        paginateAlbums(paneId);
        makeDraggable();
        paneConfig[parseInt(paneId) - 1].albumId = albumId;
    });
}

function loadAlbumList(paneId, networkId) {
    paneConfig[parseInt(paneId) - 1].albumId = "-1";
    var destId = "#socialNetworksPane" + paneId + "Contents";
    $(destId).html("<br/><br/>Loading list of Albums. <br/>Please be patient as it may take some time depending on the number of albums you have!<br/><br/><img src=\"static/images/loading.gif\"><br/><br/>");
    $.get("album_list.php?id=" + networkId + "&pane=" + paneId, function(data, status) {
        $(destId).html(data);
        paginateAlbums(paneId);
        makeDraggable();
    });
}

function showCreateAlbum(paneId) {
    $("#createAlbumStatus").html("");
    $("#createAlbumName").removeAttr("disabled");
    $("#createAlbumCaption").removeAttr("disabled");
    $("#modalCreateAlbumPaneId").val(paneId);
    $("#createAlbumNetwork").html(paneConfig[parseInt(paneId) - 1].networkName);
    $("#modalCreateAlbum").modal('show');
}

function createAlbum() {
    var albumName = $("#createAlbumName").val();
    if (!albumName) {
        $("#createAlbumStatus").html("Please fill in the album name!");
        return;
    }
    var albumCaption = $("#createAlbumCaption").val();
    var paneId = $("#modalCreateAlbumPaneId").val();
    $("#createAlbumName").attr("disabled", "disabled");
    $("#createAlbumCaption").attr("disabled", "disabled");
    $("#createAlbumStatus").html("Please wait while we create the album!");
    $.get("create_album.php?id=" + paneConfig[parseInt(paneId) - 1].networkId + "&albumtitle=" + urlencode(albumName) + "&albumcaption=" + urlencode(albumCaption), function (albumData, albumStatus) {
        albumData = JSON.parse(albumData);
        $("#modalCreateAlbum").modal('hide');
        loadAlbum(paneId, paneConfig[parseInt(paneId) - 1].networkId, albumData.albumid);
    });
}

$('#modalSlideShow').on('hidden', function () {
    slideShowing = false;
});
$('#modalSlideShow').on('shown', function () {
    slideShowing = true;
});

// Keyboard Handler for slideshow left and right navigation
$(document).keydown(function(e){
    if (!slideShowing || (e.which != 37 && e.which !=39)) {
        return;
    }
    var idx = (e.which == 37) ? 0 : 1;
    previewImage(previewPhotoId[idx]);
    e.preventDefault();
});


function previewImage(photoId) {
    // set the url and title
    var url = $("#h" + photoId).val();
    var title = $("#" + photoId).attr("alt");
    $("#slideShowTitle").html(title);
    $("#slideShowImage").attr('src', url);
    $("#slideShowImage").attr('alt', title);

    // set the prev and next links
    var prevPhotoId = $("#l" + photoId).prev().attr("id");
    if (prevPhotoId) {
        $("#slideShowPrev").attr("onclick", "previewImage('" + prevPhotoId.substring(1) + "');");
        previewPhotoId[0] = prevPhotoId.substring(1);
    }
    var nextPhotoId = $("#l" + photoId).next().attr("id");
    if (nextPhotoId) {
        $("#slideShowNext").attr("onclick", "previewImage('" + nextPhotoId.substring(1) + "');");
        previewPhotoId[1] = nextPhotoId.substring(1);
    }

    // show the pop up
    $("#modalSlideShow").modal("show");
}

function makeDraggable() {
    var dragIcon = document.createElement('img');
    dragIcon.src = 'static/images/fb_icon.gif';

    var dragItems = document.querySelectorAll('a');
    var i;
    for (i = 0; i < dragItems.length; i++) {
        addEvent(dragItems[i], 'dragstart', function (event) {
        // store the ID of the element, and collect it on the drop later on
        event.dataTransfer.setData('Text', this.id);
        event.dataTransfer.setDragImage(dragIcon, -10, -10);
      });
    }
}
