//This is the code that updates the page as the user uses it
(function($) {
$(document).ready(function() {

    $("input.locations_zip_input").hide();
	$("input.locations_zip_input").val("");
	$("p.enter_zip").hide();
	$(".filter_by_state").hide();

	//the page is fully loaded, show our search boxes
	$("div.mod_locations_list").fadeIn();

	//hide all divs by default
	$(".location_full").each(function(){
		//$(this).hide();
		$(this).fadeOut();
	});

	//when making a change to the category selector
	$("select.locations_category_selector").change(function() {
		//hide all divs again
		$(".location_full").each(function(){
			//$(this).hide();
			$(this).fadeOut();
		});
	
		//if a category is selected, enabled ZIP input
		if ($(this).val() !== '') {
			$("input.locations_zip_input").show();
			$("p.enter_zip").show();
			$(".filter_by_state").show();
			
			
			
		// if it contains leters its canadian, if not its american
		var regExp = /^\d+$/;
		if(regExp.test($("input.locations_zip_input").val())){
			//console.log("American");
			
			//if the zip is the right characters in length or longer
			if($("input.locations_zip_input").val().length >=5 )
			{
				//get the category selector's value
				var catVal = $("select.locations_category_selector").val();
				var zipVal = $("input.locations_zip_input").val();
			
		
				var cat_found = 0;
				var zip_found = 0;
				var counter = 0;
				var wasFound = 0;
		
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
						if(cat_found == 1 && zip_found == 1)
						{
							//make parent div visible
							//$(this).parent().show();
							wasFound = 1;
							$(this).parent().fadeIn();
							//alert($(this).parent().html());
						}
						counter = 0;
						cat_found = 0;
						zip_found = 0;
					}
					/*
					if(counter == 4)
					{
						if(cat_found == 1 && zip_found == 1)
						{
							//make parent div visible
							//$(this).parent().show();
							$(this).parent().fadeIn();
							wasFound = 1;
							//alert($(this).parent().html());
						}
						counter = 0;
						cat_found = 0;
						zip_found = 0;
					}
					*/

				});
					if(wasFound == 0)
						$("div.state_not_found").fadeIn();
					else
						$("div.state_not_found").hide();
			}
			
		}
		else {
			//console.log("Canadian");
			
			//if the zip is the right characters in length or longer
			if($("input.locations_zip_input").val().length >=3 )
			{
				//get the category selector's value
				var catVal = $("select.locations_category_selector").val();
				var zipVal = $("input.locations_zip_input").val();
			
		
				var cat_found = 0;
				var zip_found = 0;
				var counter = 0;
				var wasFound = 0;
		
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
						if(innerDivText.includes("all_of_canada"))
						{
							zip_found = 1;
							//alert("found_2");
						}
						if(cat_found == 1 && zip_found == 1)
						{
							//make parent div visible
							//$(this).parent().show();
							wasFound = 1;
							$(this).parent().fadeIn();
							//alert($(this).parent().html());
						}
						counter = 0;
						cat_found = 0;
						zip_found = 0;
					}
					/*
					if(counter == 4)
					{
						if(cat_found == 1 && zip_found == 1)
						{
							//make parent div visible
							//$(this).parent().show();
							$(this).parent().fadeIn();
							wasFound = 1;
							//alert($(this).parent().html());
						}
						counter = 0;
						cat_found = 0;
						zip_found = 0;
					}
					*/

				});
					if(wasFound == 0)
						$("div.state_not_found").fadeIn();
					else
						$("div.state_not_found").hide();
			}
			
			
			
		}
		
			
			
			
			
			
			
		}
		//if no category selected, keep ZIP disabled	
		else {
			$("input.locations_zip_input").hide();
			$("input.locations_zip_input").val("");
			$("p.enter_zip").hide();
			$(".filter_by_state").hide();
		}	
	});
	
	
	//when changing zip
	$("input.locations_zip_input").keyup(function(){
	
		//first hide everything
		//hide all divs by default
		$(".location_full").each(function(){
			//$(this).hide();
			$(this).fadeOut();
		});
		
		// if it contains leters its canadian, if not its american
		var regExp = /^\d+$/;
		if(regExp.test($(this).val())){
			//console.log("American");
			
			//if the zip is the right characters in length or longer
			if($(this).val().length >=5 )
			{
				//get the category selector's value
				var catVal = $("select.locations_category_selector").val();
				var zipVal = $("input.locations_zip_input").val();
			
				var cat_found = 0;
				var zip_found = 0;
				var counter = 0;
				var wasFound = 0;
		
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
						if(cat_found == 1 && zip_found == 1)
						{
							//make parent div visible
							//$(this).parent().show();
							wasFound = 1;
							$(this).parent().fadeIn();
							//alert($(this).parent().html());
						}
						counter = 0;
						cat_found = 0;
						zip_found = 0;
					}
					/*
					if(counter == 4)
					{
						if(cat_found == 1 && zip_found == 1)
						{
							//make parent div visible
							//$(this).parent().show();
							$(this).parent().fadeIn();
							wasFound = 1;
							//alert($(this).parent().html());
						}
						counter = 0;
						cat_found = 0;
						zip_found = 0;
					}
					*/

				});
					if(wasFound == 0)
						$("div.state_not_found").fadeIn();
					else
						$("div.state_not_found").hide();
					
			}

			
		} else {
			//console.log("Canadian");

			//if the zip is the right characters in length or longer
			if($(this).val().length >=3 )
			{
				//get the category selector's value
				var catVal = $("select.locations_category_selector").val();
				var zipVal = $("input.locations_zip_input").val();
			
				var cat_found = 0;
				var zip_found = 0;
				var counter = 0;
				var wasFound = 0;
		
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
						// special "all_of_canada" trigger
						if(innerDivText.includes("all_of_canada"))
						{
							zip_found = 1;
							//alert("found_2");
						}
						if(cat_found == 1 && zip_found == 1)
						{
							//make parent div visible
							//$(this).parent().show();
							wasFound = 1;
							$(this).parent().fadeIn();
							//alert($(this).parent().html());
						}
						counter = 0;
						cat_found = 0;
						zip_found = 0;
					}
					/*
					if(counter == 4)
					{
						if(cat_found == 1 && zip_found == 1)
						{
							//make parent div visible
							//$(this).parent().show();
							$(this).parent().fadeIn();
							wasFound = 1;
							//alert($(this).parent().html());
						}
						counter = 0;
						cat_found = 0;
						zip_found = 0;
					}
					*/

				});
					if(wasFound == 0)
						$("div.state_not_found").fadeIn();
					else
						$("div.state_not_found").hide();
			}

		}

		//alert(catVal);
	});

	//when changing zip
	$("select.filter_by_state").change(function() {
	
		//first hide everything
		//hide all divs by default
		$(".location_full").each(function(){
			//$(this).hide();
			$(this).fadeOut();
		});
		
		//get the category selector's value
		var state_val = $(this).val();
		var cat_val = $("select.locations_category_selector").val();
        
	        var counter = 0;
	        var cat_found = 0;
        
		//loop through each listing, and their children divs
		$('.location_full').each(function(){
			counter = counter + 1;
			var listing_state = $(this).data('state');
			var listing_cat = $(this).find('.hidden_cat_id').html();
			if(listing_cat.includes(cat_val))
			{
				if(state_val == listing_state) {
				    $(this).fadeIn();
				}
			}

		});

	});


});
})(jQuery);
