
$(document).ready(function() {
	getBackground();
	
	$(window).resize(function() {
		getBackground();
	});
	
});

$(document).ready(function() {
	$(".effect-toggle").each(function() {
		var targetId = $(this).attr("data-target");
		var target = $("#"+targetId);
		
		// get the effect.
		var effect = target.attr("data-effect");
		if (typeof effect === typeof undefined || effect === false)
			effect = "fade";

		// get the effect.
		var duration = target.attr("data-duration");
		if (typeof duration === typeof undefined || duration === false)
			duration = 500;
		
		var options = {};
		
		$(this).on('click', function (){
			target.toggle(effect, options, duration);
		});
	});
});


$(function () {
	var state = true;
	
	setInterval(function() {
		$(".loader").each(function(index) {
			if (state) {
				$(this).rotate({
					startDeg: 0,
					endDeg : 45,
					duration : 0.8,
					easing: 'ease-in'
				});
			} else {
				$(this).rotate({
					startdeg: 45,
					endDeg : 0,
					duration : 0.8,
					easing: 'ease-out'
				});
			}
			state = !state;
		});
	}, 800);
});

function getBackground() {
	var bg_url = "/background/get/" + $(window).width() + "x"
			+ $(window).height();

	$.ajax({
		dataType : "json",
		url : bg_url,
		success : function(data) {
			$("body").css("background", "no-repeat top url(" + data.url + ")");
		}
	});
}