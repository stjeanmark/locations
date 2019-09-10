//This is the code that updates the page as the user uses it

(function($) {
$(document).ready(function() {
	
	//when making a change to the category selector
	$("select.locations_category_selector").change(function() {
		//automatically disable it every time its changed
		//$("input.locations_zip_input").prop('disabled', true);
		
		//not sure what this section does, I will find out
		$('select.locations_state_selector').prop('selectedIndex',0);
		$('div.mod_locations_list').each(function(i, cte) {
				var module = $(this);
				var selector = module.find('select.locations_state_selector');
				module.find('div.state').hide();
			  });
			  
		//if a category is selected, enabled ZIP input
		if ($(this).val() != '') {
			$("input.locations_zip_input").prop('disabled', false);
		}
		//if no category selected, keep ZIP disabled	
		else {
			$("input.locations_zip_input").prop('disabled', true);
		
			//need to investigate more
			  $('div.mod_locations_list').each(function(i, cte) {
				var module = $(this);
				var selector = module.find('select.locations_state_selector');
				module.find('div.state').hide();
			  });
		}
			
	});
	
	
	//when changing zip
	$("input.locations_zip_input").keyup(function(){
	
		// go through each listing and check if category AND zip match
		alert(this.value);
	});

	
	//this is the big one, showing or now showing locations
	
	
	/*
  $('div.mod_locations_list').each(function(i, cte) {
	var module = $(this);
	var selector = module.find('select.locations_state_selector');
	var catSelector = module.find('select.locations_category_selector');
	module.find('div.state').hide();
	selector.change(function() {
		module.find('div.state').hide();		
		state = selector.find('option:selected').val();
		cat = catSelector.find('option:selected').val();
		module.find('div.location_full').hide();
		var catL = 'div.cat_' + cat;
		module.find(catL).show();
		var showEl = module.find('div.state_' + state);
		if (showEl.length > 0) {
			showEl.show();
		} else {
			module.find('div.state_not_found').show();
		}
	});
  });
  $('div.mod_locations_list select.locations_state_selector').first().change();
  */
});
})(jQuery);

