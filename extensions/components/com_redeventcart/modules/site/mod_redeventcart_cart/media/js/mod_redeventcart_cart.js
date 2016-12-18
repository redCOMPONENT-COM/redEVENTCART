var ModRedeventcartCart = (function($){
	var refresh = function () {
		$.ajax({
			url: 'index.php?option=com_redeventcart&format=json&task=cart.cartsummary',
			type: 'get'
		})
			.done(function(response){
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
			url: 'index.php?option=com_redeventcart&format=json&task=cart.sessionLabel&id=' + sessionId,
			type: 'get'
		})
			.done(function(response){
				if (!response.success == true)
				{
					alert(response.message);
					return;
				}

				// Todo: Make it work with Bootstrap popover instead
				$('.redeventcart-module-alert').html(response.data).show().fadeOut(6000);
			});
		refresh();
	};

	return {
		refresh: refresh,
		addedParticipant: addedParticipant
	}
})(jQuery);
