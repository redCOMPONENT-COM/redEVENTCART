var redeventCart = (function($){
	var baseUrl = '';

	var addSession = function(sessionId, sessionPriceGroupId) {
		$.ajax({
			url: baseUrl + "index.php?option=com_redeventcart&format=json&task=cart.addsession&id=" + sessionId + "&spg_id=" + sessionPriceGroupId,
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

	var empty = function() {
		$.ajax({
			url: baseUrl + "index.php?option=com_redeventcart&format=json&task=cart.emptyCart",
			dataType: "json"
		})
			.done(function(response){
				if (!response.success == true)
				{
					alert(response.message);
					return;
				}

				if (typeof ModRedeventcartCart !== 'undefined') {
					ModRedeventcartCart.refresh();
				}
				else {
					alert('Cart emptied');
				}
			})
			.fail(function(data){
				alert('failed');
			});
	};

	$(function(){
		if (typeof siteBaseUrl !== 'undefined'){
			baseUrl = siteBaseUrl;
		};

		$('.redeventcart-addsession').click(function(){
			var sessionId = $(this).attr('session_id');
			var sessionPriceGroupId = $(this).attr('spg_id') ? $(this).attr('spg_id') : 0;
			addSession(sessionId, sessionPriceGroupId);
		});
	});

	return {
		addSession: addSession,
		empty: empty
	};
})(jQuery);
