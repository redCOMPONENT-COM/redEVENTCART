var redeventCart = (function($){

	var addSession = function(id) {
		$.ajax({
			url: "index.php?option=com_redeventcart&format=json&task=cart.addsession&id=" + id,
			dataType: "json"
		})
		.done(function(data){
			alert('success');
		})
		.fail(function(data){
			alert('failed');
		});
	};

	$(function(){
		$('.redeventcart-addsession').click(function(){
			var sessionId = $(this).attr('session_id');
			addSession(sessionId);
		});

		$('form.participant-form .participant-submit').click(function(){
			var $form = $(this).closest('form');

			document.redformvalidator.isValid($form);

			if (!document.redformvalidator.isValid($form)) {
				return
			}

			$.ajax({
				url: 'index.php?option=com_redeventcart&task=participant.save',
				type: 'POST',
				data: $form.serialize()
			})
			.done(function(response){
				alert('done');
			});
		});
	});

	return {
		addSession: addSession
	};
})(jQuery);
