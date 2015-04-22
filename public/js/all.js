/*
 * jQuery Tiny Pub/Sub
 * https://github.com/cowboy/jquery-tiny-pubsub
 *
 * Copyright (c) 2013 "Cowboy" Ben Alman
 * Licensed under the MIT license.
 */

(function($) {

  var o = $({});

  $.subscribe = function() {
    o.on.apply(o, arguments);
  };

  $.unsubscribe = function() {
    o.off.apply(o, arguments);
  };

  $.publish = function() {
    o.trigger.apply(o, arguments);
  };

}(jQuery));
(function(){

	var submitAjaxRequest = function submitAjaxRequest(evt)
	{
		var $form = $(this);
		var type = $form.find('input[name=_method]').val() || 'POST';

		evt.preventDefault();

		$.ajax({
			type: type,
			url: $form.prop('action'),
			data: $form.serialize(),
		}).done(function(data, textStatus, jqXHR)
		{
			$.publish('form.submitted', $form);
		});
	};

	$("form[data-remote]").on('submit', submitAjaxRequest);
	$("[data-change-submit-form]").on('change', function(){
		$(this).closest('form').submit();
	});

})();
(function(){

	$.subscribe('form.submitted', function()
	{
		$('.flash').fadeIn(500).delay(1000).fadeOut(500);
	});

})();
//# sourceMappingURL=all.js.map