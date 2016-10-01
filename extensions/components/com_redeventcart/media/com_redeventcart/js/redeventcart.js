var redeventCart = (function($){

	var addSession = function(id) {
		$.ajax({
			url: "index.php?option=com_redeventcart&format=json&task=cart.addsession&id=" + id,
			dataType: "json"
		})
		.done(function(data){
			console.dir(data);
			alert('success');
		})
		.fail(function(data){
			console.dir(data);
			alert('failed');
		});
	};

	$(function(){
		$('.redeventcart-addsession').click(function(){
			var sessionId = $(this).attr('session_id');
			addSession(sessionId);
		});
	});

	return {
		addSession: addSession
	};
})(jQuery);
