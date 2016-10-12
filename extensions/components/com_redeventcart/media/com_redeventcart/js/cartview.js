(function($){
	var toggleChevron = function() {
		$(this).prev('.panel-heading').find('span.indicator').toggleClass('icon-chevron-down icon-chevron-right');
	}

	$(function(){
		/**
		 * Toggle accordion chevron
		 */
		$('.redeventcart .panel-collapse').on('hide.bs.collapse show.bs.collapse', toggleChevron);

		/**
		 * Submit participant
		 */
		$('form.participant-form .participant-submit').click(function(){
			var $form = $(this).closest('form');

			document.redformvalidator.isValid($form);

			if (!document.redformvalidator.isValid($form)) {
				alert('invalid form');
				return;
			}

			$.ajax({
				url: 'index.php?option=com_redeventcart&format=json&task=participant.save',
				type: 'POST',
				data: $form.serialize()
			})
			.done(function(response){
				var $panel = $form.closest('.panel');
				$panel.find('span.participant-state').removeClass('hidden');
				$panel.find('.panel-collapse').collapse();
				$panel.find('.panel-heading').addClass('submitted')
			})
			.fail(function(){
				alert('Sorry, something went wrong');
			});
		});

		/**
		 * Remove participant
		 */
		$('.participant-delete').click(function(){
			var $panel = $(this).closest('.panel');
			var id = $panel.find('input[name="id"]').val();

			if ($(this).closest('.panel').find('.panel-heading.submitted').length) {
				if (!confirm(Joomla.JText._('COM_REDEVENTCART_CART_DELETE_PARTICIPANT_CONFIRM'))){
					return false;
				}
			}

			$.ajax({
				url: 'index.php?option=com_redeventcart&format=json&task=participant.delete&id=' + id,
			})
			.done(function(response){
				if (response.success) {
					$panel.remove();
				}
				else {
					alert(Joomla.JText._('COM_REDEVENTCART_CART_DELETE_PARTICIPANT_CONFIRM'));
				}
			})
			.fail(function(){
				alert('Sorry, something went wrong');
			});
		});
	});
})(jQuery);
