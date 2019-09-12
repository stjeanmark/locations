//This is the code that updates the page as the user uses it

(function($) {
$(document).ready(function() {
	

		//hide all divs by default
		$(".location_full").each(function(){
			$(this).hide();
		});
	
	//when making a change to the category selector
	$("select.locations_category_selector").change(function() {
		//hide all divs again
		$(".location_full").each(function(){
			$(this).hide();
		});
	
		//if a category is selected, enabled ZIP input
		if ($(this).val() !== '') {
			$("input.locations_zip_input").prop('disabled', false);
			
			
		}
		//if no category selected, keep ZIP disabled	
		else {
			$("input.locations_zip_input").prop('disabled', true);
		}	
	});
	
	
	//when changing zip
	$("input.locations_zip_input").keyup(function(){
		//if the zip is the right characters in length or longer
		if($(this).val().length >=5 )
		{
		//get the category selector's value
		var catVal = $("select.locations_category_selector").val();
		var zipVal = $("input.locations_zip_input").val();
		
		var cat_found = 0;
		var zip_found = 0;
		var counter = 0;
		
		//loop through each listing, and their children divs
		$('.location_full').find('div').each(function(){
			counter = counter + 1;
			var innerDivId = $(this).attr('class');	
			var innerDivText = $(this).html();
			if(innerDivId == "hidden_cat_id")
			{
					if(innerDivText.includes(catVal))
					{
						// something
						cat_found = 1;
					}
			}
			if(innerDivId == "hidden_zip")
			{
				if(innerDivText.includes(zipVal))
				{
					zip_found = 1;
					//alert("found_2");
				}
			}
			if(counter == 4)
			{
				if(cat_found == 1 && zip_found == 1)
				{
					//make parent div visible
					$(this).parent().show();
					alert($(this).parent().html());
				}
				counter = 0;
				cat_found = 0;
				zip_found = 0;
			}

		});
		}
		
		//alert(catVal);
	});


});
})(jQuery);
