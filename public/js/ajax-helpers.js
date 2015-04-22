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