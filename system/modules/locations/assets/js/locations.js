(function($) {
$(document).ready(function() {
	
	$("select[value='locations_category_selector']").change(function() {
		$("select[value='locations_state_selector']").prop('disabled', true);
		if ($(this).val() != 'Select Option...') {
			$("select[value='locations_state_selector']").prop('disabled', false);
		}
	});

	
  $('div.mod_locations_list').each(function(i, cte) {
	var module = $(this);
	var selector = module.find('select.locations_state_selector');
	module.find('div.state').hide();
	selector.change(function() {
		module.find('div.state').hide();		
		state = selector.find('option:selected').val();
		var showEl = module.find('div.state_' + state);
		if (showEl.length > 0) {
			showEl.show();
		} else {
			module.find('div.state_not_found').show();
		}
	});
  });
  $('div.mod_locations_list select.locations_state_selector').first().change();
});
})(jQuery);

