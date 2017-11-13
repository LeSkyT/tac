var current_state = false;
setInterval("StatusRoutine()", 5000);


function StatusPrepare () {
	$("#topBar").append('<img src="/img/loader.png" class="loader align-self-center ml-auto" height="50" width="50" />');
}

function StatusSuccess(response) {
	if (current_state == JSON.stringify(response)) {
		return;
	} else {
		current_state = JSON.stringify(response);
	}
	
	if (response['online']) {

		$('#StatusIcon').attr('src', '/img/green_light.png');

		$("#maxplayers").html(response['playerInfo']['max']);
		$("#numplayers").html(response['playerInfo']['count']);
		$("#players").html("");
		response['playerInfo']['list'].forEach(function(item, index) {
			var insert = $("<li class=\"list-group-item\"></li>");
			insert.append("<img src=\"/minecraft/getface/" + item + "\">");
			insert.append("<span class=\"player-name\">" + item + "</span>");
			$("#players").append(insert);
		});
	} else {
		$('#StatusIcon').attr('src', '/img/red_light.png');
	}
}

function StatusComplete() {
	$(".loader").remove();
}

function StatusRoutine() {
	$.ajax({
		dataType : "json",
		timeout : 4000,
		url : "/minecraft/status",
		beforeSend : function () {
			StatusPrepare();
		},
		success : function (data) {
			StatusSuccess(data);
		},
		complete : function () {
			StatusComplete();
		}
	});
}