var redeventCart = (function($){

	var addSession = function(sessionId, sessionPriceGroupId) {
		$.ajax({
			url: "index.php?option=com_redeventcart&format=json&task=cart.addsession&id=" + sessionId + "&spg_id=" + sessionPriceGroupId,
			dataType: "json"
		})
		.done(function(response){
			if (!response.success == true)
			{
				alert(response.message);
				return;
			}

			if (typeof ModRedeventcartCart !== 'undefined') {
				ModRedeventcartCart.addedParticipant(sessionId);
			}
			else {
				alert('added to cart');
			}
		})
		.fail(function(data){
			alert('failed');
		});
	};

	$(function(){
		$('.redeventcart-addsession').click(function(){
			var sessionId = $(this).attr('session_id');
			var sessionPriceGroupId = $(this).attr('spg_id') ? $(this).attr('spg_id') : 0;
			addSession(sessionId, sessionPriceGroupId);
		});
	});

	return {
		addSession: addSession
	};
})(jQuery);
