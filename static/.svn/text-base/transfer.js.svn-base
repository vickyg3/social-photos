var drop = document.querySelector('#pane1');
addEvent(drop, 'dragover', cancel);
addEvent(drop, 'dragenter', cancel);
addEvent(drop, 'drop', drophandler);
drop = document.querySelector('#pane2');
addEvent(drop, 'dragover', cancel);
addEvent(drop, 'dragenter', cancel);
addEvent(drop, 'drop', drophandler);
var transferQueue = [];
var transferHappening = false;
var modalNoHide = false;

function drophandler(event) {
    if (event.preventDefault) {
        event.preventDefault();
    }
    var destPaneId = this.id;
    var srcId = event.dataTransfer.getData('Text');
    var srcPane = parseInt(srcId.charAt(0)) - 1;
    var destPane = parseInt("" + destPaneId.charAt(destPaneId.length - 1)) - 1;
    // Ignore drag and drops within the same pane
    if (srcPane == destPane) {
        return;
    }
    // Make sure we are logged in on the destination pane
    if (!paneConfig[destPane].loggedIn) {
        prettyAlert("Please sign in to " + paneConfig[destPane].networkName + " before transferring photos to it.");
        return;
    }
    // Make sure destination network is writable
    if (!paneConfig[destPane].isWritable) {
        prettyAlert("Sorry, you cannot transfer photos to " + paneConfig[destPane].networkName + "! Either it's a technical impossibility, or we don't think that feature is worth it. Please <a href=\"http://goo.gl/QKZYu\" target=\"_blank\">let us know</a> if you think otherwise!");
        return;
    }
    var srcType = (paneConfig[srcPane].albumId == "-1") ? (paneConfig[srcPane].hasAlbums ? 1 : 0) : 0; // 0 - photo; 1 - album
    // If source is a photo, destination should be inside an album
    if (srcType == 0 && (paneConfig[destPane].albumId == "-1" && paneConfig[destPane].hasAlbums)) {
        prettyAlert("Please select a " + paneConfig[destPane].networkName + " album to transfer the photo to!");
        return;
    }
    // If source is an album, destination should be outside any album
    if (srcType == 1 && paneConfig[destPane].albumId != "-1") {
        prettyAlert("Please go back to the list of albums on both panes before transferring albums.");
        return;
    }
    if (srcType == 0) { // transfer one photo
        queueForTransfer(srcPane, destPane, srcId.substring(3), '', '', '', false);
    } else { // transfer an entire album
        transferAlbum(srcPane, destPane, srcId.substring(3));
    }
    $("#placeholderHeader").html("");
}

function cancel(event)
{
    if (event.preventDefault)
    {
        event.preventDefault();
    }
    return false;
}

function urlencode(str) {
    str = (str + '').toString();
    return encodeURIComponent(str).replace(/!/g, '%21').replace(/'/g, '%27').replace(/\(/g, '%28').
    replace(/\)/g, '%29').replace(/\*/g, '%2A').replace(/%20/g, '+');
}

function transferAlbum(srcPane, destPane, albumId) {
    modalNoHide = true;
    var albumTitle = getCaption(srcPane + 1, albumId);
    var albumCaption = getDescription(srcPane + 1, albumId);
    if (!albumTitle) albumTitle = "";
    if (!albumCaption) albumCaption = "";
    $("#modalBody").html("Creating album \"" + albumTitle + "\" on " + paneConfig[destPane].networkName + ". Please wait!");
    $("#modalPopUp").modal('show');
    $.get("create_album.php?id=" + paneConfig[destPane].networkId + "&albumtitle=" + urlencode(albumTitle) + "&albumcaption=" + urlencode(albumCaption), function (albumData, albumStatus) {
        albumData = JSON.parse(albumData);
        $("#modalBody").html("Album created successfully. Now fetching the list of photos from " + paneConfig[srcPane].networkName + ". Please wait!");
        if (!albumData.albumid)
            return;
        $.get("photos_list.php?id=" + paneConfig[srcPane].networkId + "&pane=" + (srcPane + 1) + "&albumid=" + albumId + "&format=json", function(data, status) {
            data = JSON.parse(data);
            for (var i = 0; i < data.length; i++) {
                queueForTransfer(srcPane, destPane, data[i].photo_id, data[i].photo_title, albumData.albumid, data[i].photo_thumbnail, i == data.length - 1);
            }
            modalNoHide = false;
            $("#modalBody").html("Photos from the Album Queued for transfer successfully! Please see the progress pane to monitor the transfer status. <br/><br/>Please note that the new album that has been created is private by default. Change the privacy settings as you wish manually.<br/><br/><button class=\"btn btn-primary\" data-dismiss=\"modal\" aria-hidden=\"true\">Okay, Sweet!</button>");
        });
    });
}

function appendToTransferQueueTable(q) {
    var wstr = "";
    wstr += "<tr id=\"t" + q.photoId + "\">";
    wstr += "<td>" + q.srcConfig.networkName + "</td>";
    wstr += "<td>" + q.dstConfig.networkName + "</td>";
    wstr += "<td><img src=\"" + q.photoThumbnail + "\" alt=\"" + q.photoCaption + "\" /></td>";
    wstr += "<td id=\"tstatus" + q.photoId + "\">Queued</td>";
    wstr += "</tr>";
    $("#transferQueueBody").append(wstr);
}

function dismissCompletedTransfers() {
    $("#transferQueueBody").children('tr').each(function(index) {
        var status = $("#tstatus" + $(this).attr('id').substring(1)).html();
        if (status == "Done") {
            $(this).remove();
        }
    });
}

function queueForTransfer(srcPane, destPane, photoId, photoCaption, destAlbumId, photoThumbnail, cleanUpRequired) {
    var caption = photoCaption == "" ? getCaption(srcPane + 1, photoId) : photoCaption;
    if (!caption) caption = "";
    caption = (caption.length < 20) ? caption : caption.substring(0, 20) + "...";
    // for album transfers, destAlbumId is passed explicitly, use that instead of config
    var dstConfig = $.extend({}, paneConfig[destPane]);
    if (destAlbumId != "") {
        dstConfig.albumId = destAlbumId;
    }
    var thumbnail = (photoThumbnail != '') ? photoThumbnail : getThumbnail(photoId);
    var q = { srcConfig: paneConfig[srcPane],
              dstConfig: dstConfig,
              photoId: photoId,
              photoCaption: caption,
              photoThumbnail: thumbnail,
              cleanUpRequired: cleanUpRequired };
    transferQueue.push(q);
    appendToTransferQueueTable(q);
    updateQueueLength();
    if (!transferHappening) { // trigger if not processing already
        doTransfer();
    }
}

function updateQueueLength() {
    var wstr = "";
    wstr += "<a href=\"javascript:void(0);\" onclick=\"$('#modalTransferQueue').modal('show');\">";
    wstr += "Number of photos remaining in the transfer queue: " + transferQueue.length;
    wstr += "</a>";
    $("#queuelength").html(wstr);
}

function getCaption(paneId, objectId) {
    return $("#" + paneId + "_a" + objectId).attr("title");
}

function getDescription(paneId, albumId) {
    return $("#" + albumId).attr("alt");
}

function getThumbnail(photoId) {
    return $("#" + photoId).attr("src");
}

function updateDestinationView(q, data) {
    // check if update is still relevant
    var paneId = parseInt(q.dstConfig.paneId) - 1;
    if (q.dstConfig.networkId != paneConfig[paneId].networkId ||
        q.dstConfig.albumId != paneConfig[paneId].albumId) {
        return;
    }
    var head = panePage[paneId] == 1 ? data.show : data.noshow;
    $("#pane" + q.dstConfig.paneId + "_polaroids").prepend(head + data.body);
    paneItems[paneId]++;
    makeDraggable();
}

function doTransfer() {
    if (transferQueue.length > 0) {
        transferHappening = true;
        window.onbeforeunload = function() {
            return 'There are transfers that are still pending.';
        };
        var q = transferQueue.shift();
        updateQueueLength();
        var caption = "photo " + "\"<b>" + q.photoCaption + "</b>\"";
        if (q.photoCaption == "") {
            caption = "<b>an awesome photo</b>";
        }
        $("#progressbar").html("Currently transferring " + caption + " from " + q.srcConfig.networkName + " to " + q.dstConfig.networkName + "!<br/><img src=\"static/images/loader_bar.gif\" /><br/>");
        $("#tstatus" + q.photoId).html("In Progress");
        var url = "transfer.php?";
        url += "src=" + q.srcConfig.networkId;
        url += "&dst=" + q.dstConfig.networkId;
        url += "&photoid=" + q.photoId;
        url += "&albumid=" + q.dstConfig.albumId;
        url += "&pane=" + q.dstConfig.paneId;
        $.get(url , function(data, status) {
            if (q.cleanUpRequired) {
                $.get("clean_up.php?id=" + q.dstConfig.networkId, function(cleanUpData, cleanUpStatus) {});
            }
            $("#tstatus" + q.photoId).html("Done");
            updateDestinationView(q, JSON.parse(data));
            doTransfer();
        });
    } else {
        transferHappening = false;
        window.onbeforeunload = null;
        $("#progressbar").html("All done! :-)");
    }
}

$('#modalPopUp').on('hidden', function () {
    if (modalNoHide) {
        $('#modalPopUp').modal('show');
    }
});
