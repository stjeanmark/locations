(function($) {
$(document).ready(function() {
  $('div.mod_categories_list').each(function(i, cte) {
	var module = $(this);
	var selector = module.find('select.categories_selector');
	module.find('div.category').hide();
	selector.change(function() {
		module.find('div.category').hide();		
		category = selector.find('option:selected').val();
		var showEl = module.find('div.category_' + category);
		if (showEl.length > 0) {
			showEl.show();
		} else {
			module.find('div.category_not_found').show();
		}
	});
  });
  $('div.mod_categories_list select.categories_selector').first().change();
});
})(jQuery);