var redeventCart = (function($){

	var addSession = function(id) {
		$.ajax({
			url: "index.php?option=com_redevencart&format=json&task=cart.addsession&id=" + id,
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

	return {
		addSession: addSession
	};
})(jQuery);
