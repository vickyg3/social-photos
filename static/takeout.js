var albumIds = [];

function takeoutSelectNetwork() {
	var networkId = (this.id + "").split("_")[1];
	var wstr = "Not Selected";
	if ($(this).is(':checked')) {
		wstr = "Selected";
		if (!parseInt($("#loggedIn_" + networkId).val())) {
			wstr += " (Please Sign In!)";
		}
	}
	$("#text_" + networkId).html(wstr);
	$.get("takeout/change_state.php?type=selection&id=" + networkId + "&value=" + ($("#network_" + networkId).is(':checked') ? 1 : 0), function(data, status) {});
}

function takeoutSelectAlbum() {
	if ($(this).is(':checked')) {
		albumIds.push("" + this.id);
	} else {
		albumIds.splice(albumIds.indexOf("" + this.id), 1);
	}
	if (albumIds.length > 0) {
		$("#ltab4").removeClass("disabled");
	} else {
		$("#ltab4").addClass("disabled");
	}
}

function changeTab(tab) {
	$.get("takeout/change_state.php?type=tab&tab=" + tab, function(data, status) {});
}

function gotoAuth(networkId) {
	var wstr = [];
	for(var i = 0; i < 3; i++) {
		wstr[i] = "n" + i + "=" + ($("#network_" + i).is(':checked') ? 1 : 0);
	}
	wstr.push("id=" + networkId);
	window.location = "takeout/auth.php?" + wstr.join("&");
}

function switchToTab(index) {
	var prevIndex = index - 1;
	$('#tab' + prevIndex).removeClass('active');
	$('#tab' + index).addClass('active');
	$('#ltab' + prevIndex).removeClass('active');
	$('#ltab' + index).addClass('active');
}

function showTab2() {
	$("#tab2").html("<center>Please Wait! <br/><br/><img src=\"static/images/loading.gif\"><br/></center>");
	switchToTab(2);
	$.get("takeout/select_networks.php", function (data, status) {
		$("#tab2").html(data);
	});
}

function showTab3() {
	var validated = true;
	var at_least_one_network_selected = false;
	for (var i = 0; i < 3; i++) {
		if ($("#network_" + i).is(':checked') && !parseInt($("#loggedIn_" + i).val())) {
			validated = false;
		}
		if ($("#network_" + i).is(':checked')) {
			at_least_one_network_selected = true;
		}
	}
	if (!validated) {
		changeTab(2);
		prettyAlert("Please sign in to selected Social Networks before proceeding!");
		return;
	}
	if (!at_least_one_network_selected) {
		changeTab(2);
		prettyAlert("Please select atleast one Social Network before proceeding");
		return;
	}
	$("#ltab3").removeClass("disabled");
	$("#tab3").html("<center>Please Wait! <br/><br/><img src=\"static/images/loading.gif\"><br/></center>");
	switchToTab(3);
	$.get("takeout/select_albums.php", function (data, status) {
		$("#tab3").html(data);
	});
}

function showTab4() {
	if (albumIds.length == 0) {
		changeTab(3);
		prettyAlert("Please select atleast one album before proceeding!");
		return;
	}
	$("#ltab4").removeClass("disabled");
	$("#tab4").html("<center>Please Wait! <br/><br/><img src=\"static/images/loading.gif\"><br/></center>");
	switchToTab(4);
	$.ajax('takeout/confirm_download.php',{
    'data': JSON.stringify(albumIds),
    'type': 'POST',
    'processData': false,
    'contentType': 'application/json',
    'success': function (data, status, xhr) {$("#tab4").html(data);}
	});
}

function startDownload() {
	var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	var email = $("#email").val();
  if (!regex.test(email)) {
  	prettyAlert("Please enter a valid E-Mail Address!");
  	return;
  }
  $("#tab4").html("<center>Please Wait! <br/><br/><img src=\"static/images/loading.gif\"><br/></center>");
	$.get("takeout/download.php?email=" + email, function (data, status) {
		$("#tab2").html("");
		$("#tab3").html("");
		$("#tab4").html(data);
	});
}

$('#ttab2').on('shown', function (e) {
  changeTab(2);
  showTab2();
});
$('#ttab3').on('shown', function (e) {
  changeTab(3);
  showTab3();
});
$('#ttab4').on('shown', function (e) {
  changeTab(4);
  showTab4();
});