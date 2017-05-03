(function($){
	var baseUrl = '';

	var toggleChevron = function() {
		$(this).closest('.panel-heading').find('span.indicator').toggleClass('icon-chevron-down icon-chevron-right');
	};

	var updatePrice = function() {
		$.ajax({
			url: baseUrl + 'index.php?option=com_redeventcart&format=json&task=cart.priceitems'
		})
		.done(function(response){
			if (!(response.success == true))
			{
				alert(response.message);
			}

			$('.redeventcart.review .total-price').text(response.data.totalVatIncl);

			response.data.sessions.forEach(function(sessionData){
				var $session = $('.redeventcart.review .session[session_id=' + sessionData.sessionId + ']');
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
		$('.redeventcart.review').on('click', '.panel-title a', toggleChevron);

		updatePrice();
	});
})(jQuery);
