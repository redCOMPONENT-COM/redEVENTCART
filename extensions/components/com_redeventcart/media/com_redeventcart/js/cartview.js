(function($){
	var baseUrl = '';

	var toggleChevron = function() {
		$(this).closest('.panel-heading').find('span.indicator').toggleClass('icon-chevron-down icon-chevron-right');
	};

	var updateCheckout = function() {

	};

	var updatePrice = function() {
		$.ajax({
			url: 'index.php?option=com_redeventcart&format=json&task=cart.priceitems'
		})
		.done(function(response){
			if (!(response.success == true))
			{
				alert(response.message);
			}

			$('.redeventcart.cart .total-price').text(response.data.totalVatIncl);

			response.data.sessions.forEach(function(sessionData){
				var $session = $('.redeventcart.cart .session[session_id=' + sessionData.sessionId + ']');
				var $tbody = $session.find('table.items-table tbody');
				$tbody.empty();

				sessionData.items.forEach(function(item){
					var $row = $('<tr></tr>');
					$('<td></td>').text(item.label).appendTo($row);
					$('<td></td>').text(item.count).appendTo($row);
					$('<td></td>').text(item.priceVatIncl).appendTo($row);
					$('<td></td>').text(item.totalVatIncl).appendTo($row);
					$row.appendTo($tbody);
				});
			});
		});
	};

	$(function(){
		if (typeof siteBaseUrl !== 'undefined'){
			baseUrl = siteBaseUrl;
		};

		/**
		 * Toggle accordion chevron
		 */
		// $('.redeventcart .panel-collapse').on('hide.bs.collapse show.bs.collapse', toggleChevron);
		$('.redeventcart.cart').on('click', '.panel-title a', toggleChevron);

		/**
		 * Submit participant
		 */
		$('.redeventcart.cart').on('click', '.participant-submit', function(){
			var $form = $(this).closest('form');

			document.redformvalidator.isValid($form);

			if (!document.redformvalidator.isValid($form)) {
				alert(Joomla.JText._('COM_REDEVENTCART_CART_PARTICIPANT_SAVE_FORM_IS_INVALID'));
				return;
			}

			$.ajax({
				url: baseUrl + 'index.php?option=com_redeventcart&format=json&task=participant.save',
				type: 'POST',
				data: $form.serialize()
			})
			.done(function(response){
				if (!response.success == true)
				{
					alert(response.message);
					return;
				}

				Joomla.removeMessages();
				var $panel = $form.closest('.panel');
				$panel.find('span.participant-state').removeClass('hidden');
				$panel.find('.panel-collapse').collapse();
				$panel.find('.panel-heading').addClass('submitted')
				updatePrice();
			})
			.fail(function(){
				alert(Joomla.JText._('COM_REDEVENTCART_CART_PARTICIPANT_SAVE_ERROR'));
			});
		});

		/**
		 * Add participant
		 */
		$('.participant-add').click(function(){
			var sessionId = $(this).attr('session_id');
			var sessionPriceGroupId = $(this).attr('spg_id') ? $(this).attr('spg_id') : 0;
			var $panel = $(this).closest('.panel');
			var index = $panel.index() + 1;

			var url = baseUrl + 'index.php?option=com_redeventcart&format=json&task=cart.addparticipant&session_id=' + sessionId + '&index=' + index;

			if (sessionPriceGroupId) {
				url += '&spg_id=' + sessionPriceGroupId;
			}

			$.ajax({
				url: url
			})
			.done(function(response){
				if (response.success) {
					$panel.before(response.data);
					updatePrice();
				}
				else {
					alert(response.message);
				}
			})
			.fail(function(){
				alert(Joomla.JText._('COM_REDEVENTCART_CART_ADD_PARTICIPANT_ERROR'));
			});
		});

		/**
		 * Remove participant
		 */
		$('.redeventcart.cart').on('click', '.participant-delete', function(){
			var $panel = $(this).closest('.panel');
			var id = $panel.find('input[name="id"]').val();

			if ($(this).closest('.panel').find('.panel-heading.submitted').length) {
				if (!confirm(Joomla.JText._('COM_REDEVENTCART_CART_DELETE_PARTICIPANT_CONFIRM'))){
					return false;
				}
			}

			$.ajax({
				url: baseUrl + 'index.php?option=com_redeventcart&format=json&task=participant.delete&id=' + id
			})
			.done(function(response){
				if (response.success) {
					$session = $panel.closest('.session')
					$panel.remove();
					updatePrice();

					if ($session.find('.panel').length == 1)
					{
						$session.remove();

						if ($('.redeventcart.cart').find('.session').length == 0)
						{
							$('#no-items, .cart-footer').toggleClass('hide');
						}
					}
				}
				else {
					alert(Joomla.JText._('COM_REDEVENTCART_CART_DELETE_PARTICIPANT_ERROR'));
				}
			})
			.fail(function(){
				alert(Joomla.JText._('COM_REDEVENTCART_CART_DELETE_PARTICIPANT_ERROR'));
			});
		});

		$('.redeventcart.cart .emptycart').click(function(){
			var url = baseUrl + 'index.php?option=com_redeventcart&format=json&task=cart.emptyCart';

			$.ajax({
				url: url
			})
				.done(function(response){
					if (response.success) {
						$('.redeventcart.cart .session').remove();
						$('#no-items, .cart-footer').toggleClass('hide');
					}
					else {
						alert(response.message);
					}
				})
				.fail(function(){
					alert(Joomla.JText._('COM_REDEVENTCART_CART_ADD_PARTICIPANT_ERROR'));
				});
		});

		/**
		 * Make sure all participants are submitted before going to checkout
		 */
		$('.checkout a').click(function(e){
			var valid = true;

			$('.session .panel-heading').each(function(index, element){
				var $element = $(element);

				if ($element.attr('id') && !$element.hasClass('submitted')) {
					valid = false;
				}
			});

			if (!valid) {
				e.preventDefault();
				alert(Joomla.JText._('COM_REDEVENTCART_ERROR_INVALID_STATE_PARTICIPANTS_NOT_SUBMITTED'));
			}

			return valid;
		});

		updatePrice();
		updateCheckout();
	});
})(jQuery);
