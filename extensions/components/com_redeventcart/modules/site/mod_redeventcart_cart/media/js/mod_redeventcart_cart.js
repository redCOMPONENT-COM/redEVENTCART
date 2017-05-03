var ModRedeventcartCart = (function($){
	var baseUrl = '';

	var refresh = function () {
		$.ajax({
			url: baseUrl + 'index.php?option=com_redeventcart&format=json&task=cart.cartsummary',
			type: 'get'
		})
			.done(function refreshResponse(response){
				if (!response.success == true)
				{
					alert(response.message);
					return;
				}

				$('.redeventcart-module span.count').html(' (' + response.data.length + ')');
			})
			.fail(function(){
				alert(Joomla.JText._('COM_REDEVENTCART_CART_PARTICIPANT_SAVE_ERROR'));
			});
	};

	var addedParticipant = function (sessionId){
		$.ajax({
			url: baseUrl + 'index.php?option=com_redeventcart&format=json&task=cart.sessionLabel&id=' + sessionId,
			type: 'get'
		})
			.done(function addResponse(response){
				if (!response.success == true)
				{
					alert(response.message);
					return;
				}

				// Todo: Make it work with Bootstrap popover instead
				$('.redeventcart-module-alert .cart-alert-content').html(response.data);
				$('.redeventcart-module-alert').show();
			});
		refresh();
	};

	$(function(){
		if (typeof siteBaseUrl !== 'undefined'){
			baseUrl = siteBaseUrl;
		};

		$('.redeventcart-module-alert .button-close').click(function closePopup(){
			$('.redeventcart-module-alert').hide();
		});
	});

	return {
		refresh: refresh,
		addedParticipant: addedParticipant
	}
})(jQuery);
